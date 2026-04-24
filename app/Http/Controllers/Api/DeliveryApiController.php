<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DeliveryPerson;
use Illuminate\Http\Request;

class DeliveryApiController extends Controller
{
    public function respond(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'action' => 'required|in:accept,reject'
        ]);

        $user = auth()->user();

        $delivery = DeliveryPerson::where('user_id', $user->id)->first();

        $order = Order::findOrFail($request->order_id);

        // 🟢 ACCEPT
        if ($request->action === 'accept') {

            $order->update([
                'delivery_person_id' => $delivery->id,
                'delivery_status' => 'on_the_way',
                'status' => 'assigned'
            ]);

            $delivery->update([
                'is_available' => false
            ]);

            return response()->json([
                'message' => 'Order accepted successfully'
            ]);
        }

        // 🔴 REJECT
        $order->update([
            'delivery_status' => 'rejected'
        ]);

        return response()->json([
            'message' => 'Order rejected'
        ]);
    }
}