<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with(['items.meal', 'items.addons', 'user', 'restaurant'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function accept($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'accepted';
        $order->save();

        return redirect()->back()->with('success', 'تم قبول الطلب');
    }

    public function reject($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'rejected';
        $order->save();

        return redirect()->back()->with('success', 'تم رفض الطلب');
    }
}
