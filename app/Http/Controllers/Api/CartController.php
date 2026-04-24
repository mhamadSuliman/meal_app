<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Meal;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
{
    $request->validate([
        'restaurant_id' => 'required|exists:restaurants,id',
        'meal_id' => 'required|exists:meals,id',
        'quantity' => 'required|integer|min:1',
        'addons' => 'array'
    ]);

    $user = auth()->user();

    $meal = Meal::findOrFail($request->meal_id);

    // ❗ تحقق إنو الوجبة لنفس المطعم
    if ($meal->restaurant_id != $request->restaurant_id) {
        return response()->json(['message' => 'Meal does not belong to this restaurant'], 400);
    }

    // 🛒 جيب أو أنشئ cart
    $cart = Cart::firstOrCreate(
        ['user_id' => $user->id],
        ['restaurant_id' => $request->restaurant_id]
    );

    // ❗ إذا الكارت لمطعم تاني
    if ($cart->restaurant_id != $request->restaurant_id) {
        return response()->json([
            'message' => 'You already have items from another restaurant'
        ], 400);
    }

    // 🧾 إنشاء cart item
    $item = CartItem::create([
        'cart_id' => $cart->id,
        'meal_id' => $meal->id,
        'quantity' => $request->quantity,
        'price' => $meal->price
    ]);

    // 🔥 ربط الإضافات
    if ($request->has('addons')) {

        $addons = Addon::whereIn('id', $request->addons)
            ->where('restaurant_id', $request->restaurant_id)
            ->get();

        $syncData = [];

        foreach ($addons as $addon) {
            $syncData[$addon->id] = ['price' => $addon->price];
        }

        $item->addons()->sync($syncData);
    }

    return response()->json($item->load('addons'), 201);
}

public function index()
{
    $cart = Cart::with(['items.meal', 'items.addons'])
        ->where('user_id', auth()->id())
        ->first();

    return response()->json($cart);
}

public function remove($id)
{
    $item = CartItem::where('id', $id)
        ->whereHas('cart', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->firstOrFail();

    $item->delete();

    return response()->json(['message' => 'Item removed']);
}

public function updateQuantity(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $item = CartItem::where('id', $id)
        ->whereHas('cart', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->firstOrFail();

    $item->update([
        'quantity' => $request->quantity
    ]);

    return response()->json($item);
}
}


//الامور كلا كويسة وشغالة بس في مشكلة انه السعر الاجمالي ماعم يكون صح يمكن لان غيرت الكمية وعملتا ارعة لازم يكون السعر ضرب 4 بس ماتغير 
