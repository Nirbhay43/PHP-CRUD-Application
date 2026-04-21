<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show the one-off payment page.
     */
    public function index()
    {
        return view('payment');
    }

    /**
     * Redirect to Stripe Checkout for a one-off payment.
     */
    public function checkout(Request $request)
    {
        // Dynamically create a checkout session for a simple $15 one-off charge.
        // The first argument is the amount in cents (1500 = $15.00)
        // The second argument is the product name shown on the checkout page
        return $request->user()->checkoutCharge(1500, 'Premium Support Ticket', 1, [
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);
    }
}
