<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid'], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {

            $paymentIntent = $event->data->object;

            $orderId = $paymentIntent->metadata->order_id ?? null;

            $order = null;

            if ($orderId) {
                $order = Order::find($orderId);
            } else {
                $order = Order::where('payment_intent_id', $paymentIntent->id)->first();
            }

            if ($order) {
                $order->update([
                    'paid' => true,
                    'payment_status' => 'paid',
                    'status' => 'accepted'
                ]);
            }
        }

        if ($event->type === 'payment_intent.payment_failed') {

            $paymentIntent = $event->data->object;

            $order = Order::where('payment_intent_id', $paymentIntent->id)->first();

            if ($order) {
                $order->update([
                    'payment_status' => 'failed'
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}