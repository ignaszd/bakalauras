<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        // Enter Your Stripe Secret

        \Stripe\Stripe::setApiKey('sk_test_51KaGgxCc3mCpUx3hDOv7IcaNbnMpUe8dC4eBvMxfHNo3T5YS3cBk0YpPAGAaH6rfALHq6FUWF6td52yZfLbzALMd00YUyIQNBD');


        $amount = 100;
        $amount *= 100;
        $amount = (int) $amount;

        $payment_intent = \Stripe\PaymentIntent::create([
            'description' => 'Stripe Test Payment',
            'amount' => $amount,
            'currency' => 'AED',
            'description' => 'Payment From All About Laravel',
            'payment_method_types' => ['card'],
        ]);
        $intent = $payment_intent->client_secret;

        return view('checkout.credit-card',compact('intent'));

    }

    public function afterPayment()
    {
        echo 'Payment Received, Thanks you for using our services.';
    }
}
