<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Illuminate\Support\Facades\Redirect;

class StripeController extends Controller
{
    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Use the Stripe API to create a Checkout Session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => 1000,
                        'product_data' => [
                            'name' => 'Example Product',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('cancel.payment'),
            'cancel_url' => route('cancel.payment'),
        ]);

        // Redirect the user to the Stripe Checkout page
        dd($session->url);
        return Redirect::to($session->url);
    }
}
