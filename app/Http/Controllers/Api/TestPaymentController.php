<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class TestPaymentController extends Controller
{
   public function confirm(Request $request)
{
    $request->validate([
        'payment_intent_id' => 'required|string'
    ]);

    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);

    $intent->confirm([
        'payment_method' => 'pm_card_visa'
    ]);

    return response()->json([
        'message' => 'Payment confirmed'
    ]);
}
}