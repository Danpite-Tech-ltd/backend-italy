<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\VendorOrder;
use App\Models\VendorOrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalesReportController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            $vendorId = auth()->guard('vendor')->id();

            if (request('filter') === 'all') {

                $orders = VendorOrder::with([
                    'order.customer',
                    'orderProducts.product',
                    'status'
                ])
                ->where('vendor_id', $vendorId)
                ->latest();

            } else {

                $orders = VendorOrder::with([
                    'order.customer',
                    'orderProducts.product',
                    'status'
                ])
                ->where('vendor_id', $vendorId)

                ->when(request()->start_date, function ($q) {
                    $q->whereDate('created_at', '>=', request()->start_date);
                })

                ->when(request()->end_date, function ($q) {
                    $q->whereDate('created_at', '<=', request()->end_date);
                })

                ->when(request()->status_id && request()->status_id != 'all', function ($q) {
                    $q->where('vendor_order_status_id', request()->status_id);
                })

                ->latest();
            }

            return DataTables::eloquent($orders)

                // 📅 Date
                ->addColumn('order_date', function ($order) {
                    return $order->created_at->format('d M Y');
                })

                // 🧾 Invoice
                ->addColumn('invoiceID', function ($order) {
                    return $order->order->invoiceID;
                })

                // 👤 Customer
                ->addColumn('customer', function ($order) {

                    return [
                        'name' => $order->order->customer->name ?? '',
                        'phone' => $order->order->customer->phone ?? '',
                    ];
                })

                // 🛍️ Products
                ->addColumn('product', function ($order) {

                    $proInfo = '';

                    foreach ($order->orderProducts as $product) {

                        $proInfo .=
                            $product->product_name .
                            ' (' .
                            $product->quantity .
                            ' x ' .
                            $product->variant .
                            ')<br>';
                    }

                    return rtrim($proInfo, '<br>');
                })

                // 💰 Total
                ->addColumn('total', function ($order) {
                    return $order->total . ' ৳';
                })

                // 🔄 Status
                ->addColumn('status', function ($order) {

                    return "<div class='badge bg-success'>
                                {$order->status->status_name}
                            </div>";
                })

                ->rawColumns(['status', 'product'])

                ->addIndexColumn()

                ->make(true);
        }

        $statuses = VendorOrderStatus::where('status', 1)->get();

        return view('vendor.pages.sales_report.index', compact('statuses'));
    }
}
