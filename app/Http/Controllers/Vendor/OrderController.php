<?php

namespace App\Http\Controllers\Vendor;

use Adrianorosa\GeoLocation\GeoLocation;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Courierapi;
use App\Models\Customer;
use App\Models\CustomerNotification;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\VendorOrder;
use App\Models\VendorOrderStatus;
use App\Models\ShippingCharge;
use App\Models\User;
use App\Models\Vendor;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $vendorId = Auth::guard('vendor')->id();

            $orderStatus = VendorOrderStatus::where('status', 1)->get();

            $status = $request->query('status', 'all');

            $orders = VendorOrder::with([
                'order.customer',
                'orderProducts.product'
            ])
                ->where('vendor_id', $vendorId)
                ->when($status != 'all', fn($q) => $q->where('vendor_order_status_id', $status))
                ->latest();

            return DataTables::eloquent($orders)

                // 🧾 Invoice Info
                ->addColumn('invoice_info', function ($order) {

                    return '<span class="mb-2 badge bg-dark">'
                        . $order->order->invoiceID .
                        '</span><br>

                    <p>' . $order->order->created_at->format('d M Y') . '</p>
                    <p>' . $order->order->created_at->format('h:i A') . '</p>
                    <p>' . $order->order->created_at->diffForHumans() . '</p>';
                })

                // 🛍️ Product Info (ONLY THIS VENDOR PRODUCTS)
                ->addColumn('product_info', function ($order) {

                    $html = '';

                    foreach ($order->orderProducts as $product) {
                        $preOrderText = '';

                        if ($product->pre_order == 1) {
                            $preOrderText = "<p style='color:red;font-size:18px;font-weight:bold;'>Pre Order</p>";
                        }

                        $html .= '<div class="mb-3">
                                <div class="gap-3 d-flex">
                                    <a target="_blank" href="' . route('product-details', $product->slug) . '">
                                        <img src="' . asset($product->thumbnail_img) . '" width="60" height="60">
                                    </a>

                                    <div>
                                        <p><b>' . $product->quantity . ' x ' . $product->product_name . '</b></p>
                                        <p style="color:blue;">Colour: ' . $product->color . '</p>
                                        <p style="color:green;">Variant: ' . $product->variant . '</p>
                                        ' . $preOrderText . '
                                    </div>
                                </div>
                            </div>';
                    }

                    return $html;
                })

                // 👤 Customer Info
                ->addColumn('customer_info', function ($order) {

                    $customer = $order->order->customer;

                    return '<p><b>' . $customer->name . '</b></p>
                        <p>' . $customer->phone . '</p>
                        <p>' . $customer->address . '</p>';
                })
                // 👤 Customer note
                ->addColumn('customer_note', function ($order) {

                    return '<p><b>' . $order->order->customer_note . '</b></p>';
                })

                // 🔄 Status Dropdown (Vendor Order Status)
                ->addColumn('status_select', function ($order) use ($orderStatus) {

                    $html = "<select class='form-select order-status-change' data-id='{$order->id}'>";

                    foreach ($orderStatus as $status) {
                        $selected = optional($order->status)->id == $status->id ? 'selected' : '';
                        $html .= "<option value='{$status->id}' {$selected}>{$status->status_name}</option>";
                    }

                    $html .= '</select>';

                    return $html;
                })

                ->rawColumns(['invoice_info', 'product_info', 'customer_info', 'status_select', 'customer_note'])
                ->addIndexColumn()
                ->make(true);
        }

        $allOrderCount = VendorOrder::where('vendor_id', Auth::guard('vendor')->id())->count();
        // 🔢 Status Count (Vendor wise)
        $statuses = VendorOrderStatus::where('status', 1)
            ->withCount([
                'vendororders' => function ($q) {
                    $q->where('vendor_id', Auth::guard('vendor')->user()->id);
                }
            ])
            ->get();

        return view('vendor.pages.order.index', compact('statuses', 'allOrderCount'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function orderByStatus(string $id)
    {
        $count = Order::where('order_status_id', $id)->count();

        return $count;
    }

    public function orderStatusChange(Request $request)
    {
        $vendorOrderId = $request->order_id; // এটা actually vendor_order id
        $statusId = $request->order_status_id;

        // VendorOrder খুঁজে বের করো
        $vendorOrder = VendorOrder::with('order.orderProducts.product')->findOrFail($vendorOrderId);

        // status update
        $vendorOrder->vendor_order_status_id = $statusId;
        $vendorOrder->save();

        // status name
        $statusName = VendorOrderStatus::find($statusId)?->status_name;

        // customer notification
        $notify = new CustomerNotification();
        $notify->user_id = Order::find($vendorOrder->order_id)->user_id;
        $notify->title = 'Order Notification';
        $notify->message = 'Your order has been updated to ' . $statusName .  ' by '. Vendor::find($vendorOrder->vendor_id)->company_name;
        $notify->save();

        //        $previousStatus = $order->getOriginal('order_status_id');

        // If delivered & has affiliate, calculate commission
        // if ($order->order_status_id == 4 && $order->affiliate_id) {
        //     $affiliateId = $order->affiliate_id;

        //     // Track order products with affiliate commission
        //     $totalCommission = $order->orderProducts()->with('product')->get()->sum(function ($orderProduct) {
        //         $commissionPerUnit = $orderProduct->product->affiliate_commission ?? 0;
        //         return $commissionPerUnit * $orderProduct->quantity;

        //     });

        //     if ($totalCommission > 0) {
        //         // Update affiliate account balance
        //         $affiliate = User::find($affiliateId);

        //         if ($affiliate) {
        //             $affiliate->increment('account_balance', $totalCommission);
        //         }
        //     }
        // }

        return response()->json(['message' => 'Order Status Changed to ' . $statusName], 200);
    }
}
