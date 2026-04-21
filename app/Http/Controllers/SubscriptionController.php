<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Show the subscription plans.
     */
    public function index()
    {
        return view('subscribe');
    }

    /**
     * Redirect the user to the Stripe Checkout Session.
     */
    public function checkout(Request $request)
    {
        $priceId = env('STRIPE_PRICE_ID_BASIC');

        if (!$priceId) {
            abort(500, 'Stripe Price ID is not configured in .env');
        }

        return $request->user()
            ->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ]);
    }

    /**
     * Redirect the user to the Stripe Billing Portal.
     */
    public function billingPortal(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('dashboard'));
    }
}
