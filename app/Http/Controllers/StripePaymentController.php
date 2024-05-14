<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => 100 * $request->amount,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from Ahsan"
        ]);

        return response()->json(['success'=>'Payment successful!']);
    }
}
