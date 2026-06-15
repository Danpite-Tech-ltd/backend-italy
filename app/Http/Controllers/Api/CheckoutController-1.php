<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlace;
use App\Models\Coupon;
use App\Models\BasicInfo;
use App\Models\Customer;
use App\Models\CustomerNotification;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\RefundCancel;
use Illuminate\Support\Facades\Mail;
use App\Models\Productcolor;
use App\Models\Productvariant;
use App\Models\ShippingCharge;
use App\Models\Vat;
use App\Models\Tax;
use App\Models\User;
use App\Models\VendorOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Trait\ApiResponse;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    use ApiResponse;
    // public function orderPlace(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string',
    //         'email' => 'nullable|email',
    //         'address' => 'required|string|max:255',
    //         'customer_note' => 'nullable|string',
    //         'shipping_charge_id' => 'required|exists:shipping_charges,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->all()
    //         ], 422);
    //     }
    //     DB::beginTransaction();

    //     try {

    //         $shippingCharge = ShippingCharge::findOrFail($request->shipping_charge_id);

    //         /* ================= CUSTOMER ================= */
    //         $customer = Customer::create([
    //             'name' => $request->name,
    //             'phone' => $request->phone,
    //             'email' => $request->email,
    //             'address' => $request->address,
    //         ]);

    //         /* ================= ORDER ================= */
    //         $order = Order::create([
    //             'customer_id' => $customer->id,
    //             'user_id' => auth()->id() ?? null,
    //             'invoiceID' => (new Order())->invoiceGenerator(),
    //             'customer_note' => $request->customer_note,
    //             'shipping_charge_id' => $request->shipping_charge_id,
    //             'delivery_charge' => $shippingCharge->delivery_charge,
    //             'order_date' => now(),
    //             'order_status_id' => 1,
    //             'subtotal' => 0,
    //             'total' => 0,
    //         ]);

    //         $subtotal = 0;

    //         /* ================= ORDER PRODUCTS ================= */
    //         foreach ($request->products as $item) {

    //             $product = Product::findOrFail($item['id']);
    //             $variant = Productvariant::findOrFail($item['product_variant_id']);
    //             $color = Productcolor::findOrFail($item['product_color_id']);

    //             $price = $variant->sale_price;
    //             $lineTotal = $price * $item['qty'];

    //             $subtotal += $lineTotal;

    //             OrderProduct::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $product->id,
    //                 'productvariant_id' => $variant->id,
    //                 'product_name' => $product->name,
    //                 'product_SKU' => $product->SKU,
    //                 'product_price' => $price,
    //                 'quantity' => $item['qty'],
    //                 'color' => $color->color_name,
    //                 'variant' => $variant->variant_name,
    //             ]);
    //         }

    //         // total update
    //         $order->update([
    //             'subtotal' => $subtotal,
    //             'total' => $subtotal + $shippingCharge->delivery_charge,
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Order placed successfully',
    //             'invoice_id' => $order->invoiceID,
    //         ]);

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Order placement failed',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }



    public function orderPlace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'required|string|max:255',
            'customer_note' => 'nullable|string',
            'shipping_charge_id' => 'required|exists:shipping_charges,id',
            'products' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $shippingCharge = ShippingCharge::findOrFail($request->shipping_charge_id);
            $vat = Vat::firstOrFail();
            $tax = Tax::firstOrFail();

            //check affiliate code
            if ($request->ref_code) {
                $ref_code = $request->ref_code;
                $user = User::where('ref_code', $ref_code)->first();
                $affiliate_id = $user->id;
            }

            /* ================= CUSTOMER ================= */
            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            /* ================= MAIN ORDER ================= */
            $payment = $request->payment;
            if ($payment == 'cod') {
                $payment_method = "Cash on Delivery";
                }elseif($payment == 'stripe') {
                $payment_method = "Stripe";
            }
            $order = Order::create([
                'customer_id' => $customer->id,
                'user_id' => auth()->id() ?? null,
                'affiliate_id' => $affiliate_id ?? null,
                'invoiceID' => (new Order())->invoiceGenerator(),
                'customer_note' => $request->customer_note,
                'shipping_charge_id' => $request->shipping_charge_id,
                'delivery_charge' => $shippingCharge->delivery_charge,
                'order_date' => now(),
                'order_status_id' => 1,
                'payment' => $payment,
                'payment_method' => $payment_method ?? null,
                'vat_percentage' => $vat->rate,
                'tax_percentage' => $tax->rate,
                'subtotal' => 0,
                'total' => 0,
            ]);

            $totalSubtotal = 0;

            /* ================= GROUP PRODUCTS BY VENDOR ================= */
            $vendorGroups = [];

            $userRewardPoints = 0;

            foreach ($request->products as $item) {

                $product = Product::findOrFail($item['id']);
                $variant = Productvariant::findOrFail($item['product_variant_id']);
                $color = Productcolor::findOrFail($item['product_color_id']);
                $preOrder = $product->pre_order;
                $vendorId = $product->vendor_id;

                $price = $variant->sale_price;
                $lineTotal = $price * $item['qty'];

                $totalSubtotal += $lineTotal;

                $userRewardPoints += $product->reward_point * $item['qty'];

                $vendorGroups[$vendorId][] = [
                    'product' => $product,
                    'variant' => $variant,
                    'color' => $color,
                    'qty' => $item['qty'],
                    'price' => $price,
                    'lineTotal' => $lineTotal,
                    'preOrder' => $preOrder,
                ];
            }

            /* ================= CREATE VENDOR ORDERS ================= */
            foreach ($vendorGroups as $vendorId => $items) {

                $vendorSubtotal = collect($items)->sum('lineTotal');

                $vendorOrder = VendorOrder::create([
                    'order_id' => $order->id,
                    'vendor_id' => $vendorId,
                    'subtotal' => $vendorSubtotal,
                    'delivery_charge' => 0, // optional split later
                    'total' => $vendorSubtotal,
                    'vendor_order_status_id' => 1
                ]);

                /* ===== INSERT PRODUCTS ===== */
                foreach ($items as $item) {

                    OrderProduct::create([
                        'order_id' => $order->id,
                        'vendor_order_id' => $vendorOrder->id,
                        'vendor_id' => $vendorId,
                        'pre_order' => $item['preOrder'],
                        'product_id' => $item['product']->id,
                        'productvariant_id' => $item['variant']->id,
                        'product_name' => $item['product']->name,
                        'slug' => $item['product']->slug,
                        'thumbnail_img' => $item['product']->thumbnail_img,
                        'product_SKU' => $item['product']->SKU,

                        'product_price' => $item['price'],
                        'quantity' => $item['qty'],

                        'color' => $item['color']->color_name,
                        'variant' => $item['variant']->variant_name,
                    ]);
                }
            }

            /* ================= UPDATE MAIN ORDER ================= */

            // coupon
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            $coupon_discount = 0;

            if (!empty($request->coupon_code)) {

                $coupon = Coupon::where('code', $request->coupon_code)->first();

                if ($coupon) {

                    if ($coupon->type == 'flat') {
                        $coupon_discount = $coupon->discount;
                    } elseif ($coupon->type == 'percentage') {
                        $coupon_discount = ($totalSubtotal * $coupon->discount) / 100;
                    }
                }
            }

            $vat_amount = $totalSubtotal * ($vat->rate / 100);
            $tax_amount = $totalSubtotal * ($tax->rate / 100);
            $total = $totalSubtotal + $shippingCharge->delivery_charge + $vat_amount + $tax_amount - $coupon_discount;

            $rewardPoints = User::find(auth()->id())->reward_point ?? 0;
            $point_price  = BasicInfo::first()->per_reward_point_price ?? 0;

            $pointsUsed  = 0;
            $pointsValue = 0;

            if ($request->points_redeem == 1 && $point_price > 0) {

                // ইউজারের সব পয়েন্টের সমান টাকার পরিমাণ
                $pointsValueAvailable = $rewardPoints * $point_price;

                // total-এর বেশি কাটা যাবে না, তাই min() দিয়ে cap
                $pointsValue = min($pointsValueAvailable, $total);

                // total থেকে এই amount বাদ দেওয়া হলো
                $total -= $pointsValue;

                // কতটা পয়েন্ট actually use হলো (টাকা থেকে পয়েন্টে কনভার্ট)
                $pointsUsed = $pointsValue / $point_price;
            }
            $user = User::find(auth()->id());
            $user->reward_point = $rewardPoints - $pointsUsed;
            $user->save();

            $order->update([
                'vat' => $vat_amount,
                'tax' => $tax_amount,
                'subtotal' => $totalSubtotal,
                'total' => $total,
                'coupon_name' => $coupon->code ?? '',
                'coupon_type' => $coupon->type ?? '',
                'coupon_amount' => $coupon->discount ?? 0,
                'coupon_discount' => $coupon_discount ?? 0,
                'reward_point' => $userRewardPoints ?? 0,
                'points_amount' => $pointsValue ?? 0,
                'per_reward_point_price' => $point_price ?? 0,
                'points_used' => $pointsUsed ?? 0,
            ]);

            // email to customer
            if ($customer->email) {
                Mail::to($customer->email)->send(new OrderPlace($order,$customer));
            }
            // notification to cutomer
            $notify = new CustomerNotification();
            $notify->user_id = $order->user_id;
            $notify->title = $notify->title = 'Order Placed Successfully! #' . $order->invoiceID;
            $notify->message = $notify->message = 'Thank you for shopping with us! Your order #' . $order->invoiceID . ' has been successfully placed. Total Amount: ' . number_format($order->total, 2) . ' TK. We will process your order shortly.';
            $notify->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'invoice_id' => $order->invoiceID,
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Order placement failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function orderSuccess($invoice_id)
    {
        $order = Order::where('invoiceID', $invoice_id)->with(['orderProducts', 'customer'])->get();

        return $this->success(
            message: 'Order Success data.',
            data: $order
        );
    }


    public function vat()
    {
        $vat = Vat::select('id', 'rate')->first();

        return $this->success(
            message: 'Vat data.',
            data: $vat
        );
    }
    public function tax()
    {
        $tax = Tax::select('id', 'rate')->first();

        return $this->success(
            message: 'tax data.',
            data: $tax
        );
    }

    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string|exists:coupons,code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired coupon code.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully.',
            'data' => [
                'code' => $coupon->code,
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->discount,
            ]
        ]);
    }

    public function couponList()
    {
        $coupons = Coupon::where('status', 1)->where('expire_date', '>=', now())->where('active_date', '<=', now())->get();

        return $this->success(
            message: 'All active coupons.',
            data: $coupons
        );
    }

    public function refundCancelList()
    {
        // $order = Order::where('user_id',Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->whereIn('order_status_id', ["1", "2"])->get();

        return $this->success(
            message: 'Order List',
            data: $order,
        );
    }

    public function refundCancelSubmit(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        $refundCancel = new RefundCancel();
        $refundCancel->type = $request->type;
        $refundCancel->order_id = $order->id;
        $refundCancel->reason = $request->reason;
        $refundCancel->save();

        return $this->success(
            message: 'Refund/Cancel Order Sumit',
            data: $refundCancel,
        );
    }
}
