<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeService
{
   public function createPaymentIntent($amount)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    return PaymentIntent::create([
        'amount' => $amount * 100, // بالسنت
        'currency' => 'usd',

        // ✅ الحل الأساسي للمشكلة
        'automatic_payment_methods' => [
            'enabled' => true,
            'allow_redirects' => 'never'
        ],
    ]);
}
public function refund($paymentIntentId)
{
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    return \Stripe\Refund::create([
        'payment_intent' => $paymentIntentId,
    ]);
}
}