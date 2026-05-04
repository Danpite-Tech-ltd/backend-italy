<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\Productvariant;
use App\Models\ShippingCharge;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Trait\ApiResponse;

class CheckoutController extends Controller
{ 
    use ApiResponse;
    public function orderPlace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'required|string|max:255',
            'customer_note' => 'nullable|string',
            'shipping_charge_id' => 'required|exists:shipping_charges,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }
        DB::beginTransaction();

        try {
            // dd($request->all());

            $shippingCharge = ShippingCharge::findOrFail($request->shipping_charge_id);

            /* ================= CUSTOMER ================= */
            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
            ]);

            /* ================= ORDER ================= */
            $order = Order::create([
                'customer_id' => $customer->id,
                'user_id' => auth()->id() ?? null,
                'invoiceID' => (new Order())->invoiceGenerator(),
                'customer_note' => $request->customer_note,
                'shipping_charge_id' => $request->shipping_charge_id,
                'delivery_charge' => $shippingCharge->delivery_charge,
                'order_date' => now(),
                'order_status_id' => 1,
                'subtotal' => 0,
                'total' => 0,
            ]);

            $subtotal = 0;

            /* ================= ORDER PRODUCTS ================= */
            foreach ($request->products as $item) {

                $product = Product::findOrFail($item['id']);
                $variant = Productvariant::findOrFail($item['product_variant_id']);
                $color = Productcolor::findOrFail($item['product_color_id']);

                $price = $variant->sale_price;
                $lineTotal = $price * $item['qty'];

                $subtotal += $lineTotal;

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'productvariant_id' => $variant->id,
                    'product_name' => $product->name,
                    'product_SKU' => $product->SKU,
                    'product_price' => $price,
                    'quantity' => $item['qty'],
                    'color' => $color->color_name,
                    'variant' => $variant->variant_name,
                ]);
            }

            // total update
            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal + $shippingCharge->delivery_charge,
            ]);

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

}
