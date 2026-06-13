<?php

namespace App\Http\Controllers\Admin;

use Adrianorosa\GeoLocation\GeoLocation;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Courierapi;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\VendorOrder;
use App\Models\VendorCommission;
use App\Models\Vendor;
use App\Models\ShippingCharge;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Order', only: ['index']),
            new Middleware('permission:Create Order', only: ['store', 'create']),
            new Middleware('permission:Edit Order', only: ['update', 'edit']),
            new Middleware('permission:Delete Order', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (\request()->ajax()) {

            $orderStatus = OrderStatus::where('status', 1)->get();

            $status = $request->query('status', 'all'); // default 'all'

            $orders = Order::with(['orderStatus', 'orderProducts', 'customer', 'admin'])
                ->when($status != 'all', fn($q) => $q->where('order_status_id', $status))
                ->latest();

            return DataTables::eloquent($orders)
                ->addColumn('invoice_info', function ($order) {
                    return '<span class="mb-2 text-center badge bg-dark"><p class="imgcbtn">' . $order->invoiceID . '</p></span>
                            <br>
                            <p>' . $order->created_at->format('d M Y') . '</p>
                            <br>
                            <p">' . $order->created_at->format('h:i A') . '</p>
                            <br>
                            <p>' . $order->created_at->diffForHumans() . '</p>';
                })
                ->addColumn('product_info', function ($order) {

                    $productInfo = '';

                    foreach ($order->orderProducts as $product) {

                        $productInfo .= '<div class="mb-2">
                                       <div class="gap-3 d-flex">
                                        <a target="_blank" href="' . route('product-details', $product->slug) . '">
                                            <img src="' . asset($product->thumbnail_img) . '" width="60" height="60">
                                        </a>

                                        <br>
                                        <div>
                                        <p>' . $product->quantity . ' x ' . $product->product_name . '</p>

                                        <p style="color:blue;font-size: 18px;"> Colour: ' . $product->color . ' </p>

                                        <p style="font-size: 18px;color:red;font-weight:bold;"> Variant: ' . $product->variant . '</p>
                                        </div>
                                        </div>
                                        <br>';
                    }

                    return $productInfo;
                })
                ->addColumn('customer_info', function ($order) {
                    return '<p style="font-weight:bold;">' . $order->customer->name . '</p>
                            <br>
                            <p>' . $order->customer->email . '</p>
                            <br>
                            <p>' . $order->customer->phone . '</p>
                            <br>
                            <p>' . $order->customer->address . '</p>';
                })
                ->addColumn('status_select', function ($order) use ($orderStatus) {
                    $html = '';
                    if (Auth::user()->can('Status Order')) {
                        $html .= "<select class='form-select order-status-change' data-id='{$order->id}'>";

                        foreach ($orderStatus as $status) {
                            $selected = $order->order_status_id == $status->id ? 'selected' : '';
                            $html .= '<option value="' . $status->id . '" ' . $selected . '>' . $status->status_name . '</option>';
                        }
                        $html .= '</select>';
                        return $html;
                    }
                    return $html;
                })
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Order')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="' . route('admin.order.edit', $admin->id) . '">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Order')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }


                    return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['invoice_info', 'product_info', 'customer_info', 'status_select', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        //

        $steadfastStatus = Courier::where('type', 'steadfast')->where('status', 1)->first();
        $pathaoStatus = Courier::where('type', 'pathao')->where('status', 1)->first();


        // Pathao courier data
        if ($pathaoStatus) {
            //            $response = Http::get($pathaoStatus->url . '/api/v1/countries/1/city-list');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $pathaoStatus->token,
            ])->get($pathaoStatus->url . '/aladdin/api/v1/city-list');

            $pathaocities = $response->json();

            //            dd($response);

            $response2 = Http::withHeaders([
                'Authorization' => 'Bearer ' . $pathaoStatus->token,
                'Content-Type' => 'application/json',
            ])->get($pathaoStatus->url . '/aladdin/api/v1/stores');

            $pathaostore = $response2->json();

            //            dd($pathaostore);
        } else {
            $pathaocities = [];
            $pathaostore = [];
        }

        $statuses = OrderStatus::where('status', 1)->with('orders')->get();

        return view('admin.pages.order.index', compact(
            'statuses',
            'steadfastStatus',
            'pathaoStatus',
            'pathaostore',
            'pathaocities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orderStatus = OrderStatus::where('status', 1)->get();

        return view('admin.pages.order.create', compact('orderStatus'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $products = $request['data']['products'];

        $total = $request['data']['total'] - $request['data']['discountCharge'] ?? 0;

        DB::beginTransaction();

        try {
            //          Create Customer
            $customer = new Customer();
            $customer->name = $request['data']['customerName'];
            $customer->phone = $request['data']['customerPhone'];
            $customer->address = $request['data']['customerAddress'];
            $customer->piva = $request['data']['piva'];
            $customer->codice_fiscal = $request['data']['codice_fiscal'];
            $customer->cap = $request['data']['cap'];
            $customer->pec = $request['data']['pec'];
            $customer->catasto_destinatario = $request['data']['catasto_destinatario'];
            $customer->save();


            //          Create Order
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->invoiceID = $order->invoiceGenerator();
            $order->payment_method = $request['data']['payment_type'];
            $order->customer_note = $request['data']['customerNote'];
            $order->subtotal = $total - $request['data']['deliveryCharge'];
            $order->total = $total;

            $order->delivery_charge = $request['data']['deliveryCharge'];
            $order->discount_charge = $request['data']['discountCharge'];
            $order->order_date = today();
            $order->order_status_id = $request['data']['status'];
            $order->save();

            //          Create Order Products
            foreach ($products as $product) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product['productID'];
                $orderProduct->productvariant_id = $product['sizeID'];
                $orderProduct->product_name = $product['productName'];
                $orderProduct->product_SKU = $product['productCode'];
                $orderProduct->product_price = $product['productPrice'];
                $orderProduct->quantity = $product['productQuantity'];
                $orderProduct->color = $product['productColor'];
                $orderProduct->variant = $product['productSize'];
                $orderProduct->save();
            }

            DB::commit();


            $response['status'] = 'success';
            $response['message'] = 'Successfully Add Order';

            return json_encode($response);

        } catch (Exception $exception) {
            DB::rollBack();

            dd($exception->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $couriers = Courier::where('status', 1)->get();

        $admins = User::role('admin')->get();

        $orderStatus = OrderStatus::where('status', 1)->get();

        $order->load('orderProducts', 'customer', 'admin', 'courier');

        return view('admin.pages.order.edit', compact('orderStatus', 'order', 'couriers', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //        dd($request->all());

        $products = $request['data']['products'];
        $total = $request['data']['total'] ?? 0;

        DB::beginTransaction();

        try {
            //  Update Customer
            $customer = $order->customer;
            $customer->update([
                'name' => $request['data']['customerName'],
                'phone' => $request['data']['customerPhone'],
                'address' => $request['data']['customerAddress'],
                'piva' => $request['data']['piva'],
                'codice_fiscal' => $request['data']['codice_fiscal'],
                'cap' => $request['data']['cap'],
                'pec' => $request['data']['pec'],
                'catasto_destinatario' => $request['data']['catasto_destinatario']
            ]);

            //  Update Order
            $order->update([
                'payment_method' => $request['data']['payment_type'],
                'customer_note' => $request['data']['customerNote'],
                'subtotal' => $request['data']['subtotal'],
                'total' => $total,
                'delivery_charge' => $request['data']['deliveryCharge'],
                'discount_charge' => $request['data']['discountCharge'],
                'order_status_id' => $request['data']['order_status_id'],
                'order_date' => today(),
                'courier_id' => $request['data']['courierID'],
                'user_id' => $request['data']['userID'],
            ]);

            // Refresh Order Products (delete old & insert new)
            $order->orderProducts()->delete();

            foreach ($products as $product) {
                $order->orderProducts()->create([
                    'product_id' => $product['productID'],
                    'productvariant_id' => $product['sizeID'],
                    'product_name' => $product['productName'],
                    'product_SKU' => $product['productCode'],
                    'product_price' => $product['productPrice'],
                    'quantity' => $product['productQuantity'],
                    'color' => $product['productColor'],
                    'variant' => $product['productSize'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order updated successfully',
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        OrderProduct::where('order_id', $order->id)->delete();

        Order::where('id', $order->id)->delete();

        Customer::where('id', $order->customer_id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Successfully Deleted Order'], 200);
    }

    public function orderByStatus(string $id)
    {
        $count = Order::where('order_status_id', $id)->count();

        return $count;
    }

    public function orderStatusChange(Request $request)
    {
        $order_status_id = $request->order_status_id;

        $order_status = OrderStatus::find($order_status_id)->status_name;
        $order_id = $request->order_id;


        $order = Order::find($order_id);


        //        $previousStatus = $order->getOriginal('order_status_id');

        if ($order_status_id == 4) {

            // এই order এর সব vendor order
            $vendorOrders = VendorOrder::where('order_id', $order->id)->get();

            foreach ($vendorOrders as $vendorOrder) {

                $vendorId = $vendorOrder->vendor_id;

                $subtotal = $vendorOrder->subtotal;

                // commission
                $vendor_commission = Vendor::where('id', $vendorId)->first()->commission_value;
                $commissionPercentage = $vendor_commission;

                $commissionValue = ($subtotal * $commissionPercentage) / 100;

                // vendor পাবে
                $vendorAmount = $subtotal - $commissionValue;

                // commission save
                VendorCommission::create([
                    'vendor_id' => $vendorId,
                    'vendor_order_id' => $vendorOrder->id,
                    'commission_percentage' => $commissionPercentage,
                    'commission_value' => $commissionValue,
                    'subtotal' => $subtotal,
                    'amount' => $vendorAmount,
                ]);

                // vendor balance increment
                Vendor::where('id', $vendorId)
                    ->increment('balance', $vendorAmount);
            }
            // reward point
            // add reward points to customer
            $user = User::find($order->user_id);
            if ($user) {
                $user->reward_point += $order->reward_point;
                $user->save();
            }
        }

        // If delivered & has affiliate, calculate commission
        if ($order->order_status_id == 4 && $order->affiliate_id) {
            $affiliateId = $order->affiliate_id;

            // Track order products with affiliate commission
            $totalCommission = $order->orderProducts()->with('product')->get()->sum(function ($orderProduct) {
                $commissionPerUnit = $orderProduct->product->affiliate_commission ?? 0;
                return $commissionPerUnit * $orderProduct->quantity;

            });

            if ($totalCommission > 0) {
                // Update affiliate account balance
                $affiliate = User::find($affiliateId);

                if ($affiliate) {
                    $affiliate->increment('account_balance', $totalCommission);
                }
            }
        }

        $order->order_status_id = $order_status_id;
        $order->save();

        return response()->json(['message' => 'Order Status Changed to ' . $order_status], 200);
    }

    public function steadFastOrderSubmit(Request $request)
    {
        $courier = Courier::where(['status' => 1, 'type' => 'steadfast'])->first();

        if (!$courier) {
            return response()->json([
                'status' => 'error',
                'message' => 'Courier information not found.'
            ], 404);
        }

        $orders = Order::with('customer')->whereIn('id', $request->order_ids ?? [])
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No valid orders found.'
            ], 404);
        }


        foreach ($orders as $key => $order) {
            try {
                $response = Http::withHeaders([
                    'Api-Key' => $courier->api_key,
                    'Secret-Key' => $courier->secret_key,
                    'Content-Type' => 'application/json'
                ])->post('https://portal.packzy.com/api/v1/create_order', [
                            'invoice' => $order->invoiceID,
                            'recipient_name' => $order->customer->name ?? '',
                            'recipient_phone' => $order->customer->phone ?? '',
                            'recipient_address' => $order->customer->address ?? '',
                            'cod_amount' => $order->total,
                            'note' => $order->customer_note ?? '',
                        ]);

                if ($response->ok() && ($response->json('status') == 200)) {

                    //
                    $data = $response->json();

                    //                    dd($data);

                    $order->update([
                        'courier_id' => $courier->id,
                        'order_status_id' => 7,
                        'consignmentID' => $data['consignment']['consignment_id'] ?? null,
                        'trackingID' => $data['consignment']['tracking_code']
                    ]);

                    // update directly


                    $responses[] = $data;


                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => $response->json('message'),
                        'data' => $response
                    ]);
                }
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);

            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Consignments Created successfully.',
            'data' => $responses
        ]);

    }

    public function pathaoOrderSubmit(Request $request)
    {
        //        dd($request->all());
        $orders_id = json_decode($request->order_ids, true);

        foreach ($orders_id as $order_id) {
            $order = Order::with('customer')->find($order_id);

            // return $request->all();
            // pathao
            $pathao_info = Courier::where(['status' => 1, 'type' => 'pathao'])->first();
            if ($pathao_info) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $pathao_info->token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($pathao_info->url . '/aladdin/api/v1/orders', [
                            'store_id' => $request->pathaostore,
                            'merchant_order_id' => $order->invoiceID,
                            'sender_name' => 'Test',
                            'sender_phone' => $order->customer ? $order->customer->phone : '',
                            'recipient_name' => $order->customer ? $order->customer->name : '',
                            'recipient_phone' => $order->customer ? $order->customer->phone : '',
                            'recipient_address' => $order->customer ? $order->customer->address : '',
                            'recipient_city' => $request->pathaocity,
                            'recipient_zone' => $request->pathaozone,
                            'recipient_area' => $request->pathaoarea,
                            'delivery_type' => 48,
                            'item_type' => 2,
                            'special_instruction' => 'Special note- product must be check after delivery',
                            'item_quantity' => 1,
                            'item_weight' => 0.5,
                            'amount_to_collect' => round($order->total),
                            'item_description' => 'Special note- product must be check after delivery',
                        ]);
            }
            if ($response->status() == '200') {

                $order->update([
                    'courier_id' => $pathao_info->id,
                    'order_status_id' => 7,
                    'consignmentID' => $response['data']['consignment_id'] ?? null,
                ]);

            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $response['message'] ?? 'Courier Order Failed',
                ], $response->status());
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Consignments Created successfully.',
        ]);
    }

    public function pathaoGetZone(Request $request)
    {
        $pathao_info = Courier::where(['status' => 1, 'type' => 'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
        if ($pathao_info) {
            $response = Http::get($pathao_info->url . '/aladdin/api/v1/cities/' . $request->city_id . '/zone-list');

            $pathaozones = $response->json();
            return response()->json($pathaozones);
        } else {
            return response()->json([]);
        }

    }

    public function pathaoGetArea(Request $request)
    {
        $pathao_info = Courier::where(['status' => 1, 'type' => 'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
        if ($pathao_info) {
            $response = Http::get($pathao_info->url . '/aladdin/api/v1/zones/' . $request->zone_id . '/area-list');
            $pathaoareas = $response->json();
            return response()->json($pathaoareas);
        } else {
            return response()->json([]);
        }

    }


}
