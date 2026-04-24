<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function dashboard()
{
    $user = auth()->user();

    $delivery = $user->deliveryProfile;

    $orders = \App\Models\Order::where('delivery_person_id', $delivery->id)->get();

    return view('delivery.dashboard', compact('orders'));
}

public function markOnTheWay($id)
{
    $order = Order::findOrFail($id);
    $order->delivery_status = 'on_the_way';
    $order->save();

    return back();
}

public function accept($id)
{
    $order = Order::findOrFail($id);

    $delivery = auth()->user()->deliveryProfile;

    if (!$delivery) {
        return response()->json([
            'message' => 'No delivery profile'
        ], 403);
    }

    // 🔒 1. إذا الطلب مأخوذ من دليفري ثاني
    if ($order->delivery_person_id && $order->delivery_person_id != $delivery->id) {
        return response()->json([
            'message' => 'Order already taken by another delivery'
        ], 409);
    }

    // 🔒 2. إذا الطلب مش مخصص إله (اختياري حسب نظامك)
    // (إذا بدك نظام توزيع مسبق احذف هالشرط)
    if ($order->delivery_person_id && $order->delivery_person_id != $delivery->id) {
        return response()->json([
            'message' => 'Not allowed'
        ], 403);
    }

    // 🚀 تحديث الطلب
    $order->update([
        'delivery_person_id' => $delivery->id,
        'delivery_status' => 'on_the_way'
    ]);

    // 🚫 تعطيل الدليفري (مشغول)
    $delivery->update([
        'is_available' => false
    ]);

    return response()->json([
        'message' => 'Order accepted successfully',
        'order' => $order->fresh()
    ]);
}

public function reject($id)
{
    $order = Order::findOrFail($id);

    $delivery = auth()->user()->deliveryProfile;

    // إذا الطلب مو إله
    if ($order->delivery_person_id != $delivery->id) {
        return response()->json([
            'message' => 'Not allowed'
        ], 403);
    }

    // 🔓 رجّع الطلب لحالة انتظار
    $order->update([
        'delivery_person_id' => null,
        'delivery_status' => 'pending'
    ]);

    // 🔓 خلّي الدليفري متاح مرة ثانية
    $delivery->update([
        'is_available' => true
    ]);

    // 🔁 إعادة توزيع تلقائي
    $this->reassignOrder($order);

    return response()->json([
        'message' => 'Order rejected and reassigned',
        'order' => $order->fresh()
    ]);
}

private function reassignOrder($order)
{
    $delivery = \App\Models\DeliveryPerson::where('is_available', true)
        ->where('id', '!=', $order->delivery_person_id)
        ->first();

    if (!$delivery) {
        return; // ما في دليفري فاضي
    }

    $order->update([
        'delivery_person_id' => $delivery->id,
        'delivery_status' => 'assigned'
    ]);

    $delivery->update([
        'is_available' => false
    ]);

    // إشعار جديد
    $delivery->user->notify(new \App\Notifications\NewOrderNotification($order));
}
}
