<?php

namespace App\Http\Controllers\Api;

use App\Events\NewOrderEvent;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StripeService;


class OrderController extends Controller
{

public function store(Request $request)
{
    $request->validate([
        'address' => 'required|string',
        'phone' => 'required|string',
        'notes' => 'nullable|string',
        'payment_method' => 'required|in:cash,online'
    ]);

   $user = auth()->user();

    // 🛒 جيب الكارت
    $cart = Cart::with(['items.addons', 'items.meal'])
        ->where('user_id', $user->id)
        ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return response()->json([
            'message' => 'Cart is empty'
        ], 400);
    }

    $stripeData = null;

    // 🚀 Transaction
    $order = DB::transaction(function () use ($cart, $request, $user, &$stripeData) {

        $total = 0;

        // 🧾 إنشاء الطلب
        $order = Order::create([
            'user_id' => $user->id,
            'restaurant_id' => $cart->restaurant_id,
            'total_price' => 0,
            'delivery_fee' => 5,
            'final_price' => 0,
            'status' => 'pending',
            'address' => $request->address,
            'phone' => $request->phone,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'paid' => false
        ]);

      $delivery = \App\Models\DeliveryPerson::where('is_available', true)->first();

if ($delivery) {

    $order->update([
        'delivery_person_id' => $delivery->id,
        'delivery_status' => 'assigned'
    ]);

    // خلي الدليفري غير متاح
    $delivery->update([
        'is_available' => false
    ]);

    // إرسال إشعار للدليفري (عن طريق user المرتبط فيه)
    $delivery->user->notify(new NewOrderNotification($order));
}
        event(new NewOrderEvent($order));
        $admin = User::first();

        $admin->notify(new NewOrderNotification($order));

        // 🔥 نقل العناصر
        foreach ($cart->items as $item) {

            $itemTotal = $item->price;

            // ➕ الإضافات
            foreach ($item->addons as $addon) {
                $itemTotal += $addon->pivot->price;
            }

            $itemTotal *= $item->quantity;

            $total += $itemTotal;

            // 🧾 Order Item
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'meal_id' => $item->meal_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);

            // 🔗 الإضافات
            $syncData = [];

            foreach ($item->addons as $addon) {
                $syncData[$addon->id] = ['price' => $addon->pivot->price];
            }

            $orderItem->addons()->sync($syncData);
        }

        // 💰 الحساب النهائي
        $delivery = 5;
        $final = $total + $delivery;

        $order->update([
            'total_price' => $total,
            'delivery_fee' => $delivery,
            'final_price' => $final
        ]);

        // 💳 Stripe (ONLINE PAYMENT)
        if ($request->payment_method === 'online') {

            $stripe = new StripeService();

            $intent = $stripe->createPaymentIntent($final * 100);
            $intent->metadata = [
            'order_id' => $order->id
               ];
         $intent->save();

            $order->update([
                'payment_intent_id' => $intent->id,
                'payment_status' => 'pending'
            ]);

            // نخزن client_secret برا برة الـ transaction
            $stripeData = $intent->client_secret;
        }

        // 🧹 حذف الكارت
        $cart->delete();

        // 🔔 إشعار
        $owner = $order->restaurant->resowner;
        //
         $owner->notify(new NewOrderNotification($order));

        return $order;

    });

    return response()->json([
        'order' => $order->load('items.addons'),
        'client_secret' => $stripeData
    ], 201);
}


public function index()
{
    $user = auth()->user(); // مؤقت للتجربة

    if ($user->type === 'admin') {
        return Order::with(['items.meal', 'items.addons', 'restaurant'])
            ->latest()
            ->get();
    }

    // 👤 user → طلباتو فقط
    if ($user->type === 'user') {
        return Order::with(['items.meal', 'items.addons'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }

    // 🍽️ owner → طلبات مطعمو
    if ($user->type === 'restaurant_owner') {
        return Order::with(['items.meal', 'items.addons', 'user'])
            ->whereHas('restaurant', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->get();
    }
}

public function show($id)
{
    $order = Order::with(['items.meal', 'items.addons', 'restaurant'])
        ->findOrFail($id);

    $this->authorize('view', $order);

    return response()->json($order);
}

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:accepted,preparing,delivered,cancelled'
    ]);

    $order = Order::with('restaurant')->findOrFail($id);

    // 🔐 Policy
    $this->authorize('update', $order);

    $order->update([
        'status' => $request->status
    ]);
    $order->user->notify(new OrderStatusNotification($order));

    return response()->json([
        'message' => 'Order status updated',
        'order' => $order
    ]);

    

}



public function refund($id)
{
    $order = Order::findOrFail($id);

    // 🔐 تأكد الصلاحيات (اختياري)
    // $this->authorize('refund', $order);

    if (!$order->payment_intent_id) {
        return response()->json([
            'message' => 'No payment found'
        ], 400);
    }

    if ($order->payment_status !== 'paid') {
        return response()->json([
            'message' => 'Order not paid'
        ], 400);
    }

    $stripe = new \App\Services\StripeService();

    $refund = $stripe->refund($order->payment_intent_id);

    $order->update([
        'refund_id' => $refund->id,
        'refund_status' => $refund->status,
        'status' => 'cancelled'
    ]);

    return response()->json([
        'message' => 'Refund successful',
        'refund' => $refund
    ]);
}
}
