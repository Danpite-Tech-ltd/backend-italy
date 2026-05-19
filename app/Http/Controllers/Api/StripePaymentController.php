<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\DB;

class StripePaymentController extends Controller
{
    public function stripePayment(Request $request)
    {
        DB::beginTransaction();

        try {

            // Validation
            $request->validate([
                'stripeToken' => 'required',
                'amount' => 'required|numeric',
            ]);

            // ORDER SAVE


            // Stripe Secret
            Stripe::setApiKey(env('STRIPE_SECRET'));
            // Payment
            $charge = Charge::create([
                'source' => $request->stripeToken,
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'description' => 'Product Payment',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment Successful',
                'order_id' => '',
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
