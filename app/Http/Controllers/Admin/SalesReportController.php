<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class SalesReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:Sales Report', only: ['index']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

//            dd(request()->all());

            if (request('filter') === 'all') {
                $orders = Order::with(['orderProducts.product', 'customer', 'orderStatus', 'admin', 'courier'])->latest();
            }
            else {

                $orders = Order::with(['orderProducts.product', 'customer', 'orderStatus', 'admin', 'courier'])
                    ->when(request()->start_date, function ($q) {
                        $q->whereDate('created_at', '>=', request()->start_date);
                    })
                    ->when(request()->end_date, function ($q) {
                        $q->whereDate('created_at', '<=', request()->end_date);
                    })
                    ->when(request()->courier_id && request()->courier != 'all', function ($q) {
                        $q->where('courier_id', request()->courier_id);
                    })
                    ->when(request()->admin_id && request()->admin_id != 'all', function ($q) {
                        $q->where('admin_id', request()->admin_id);
                    })
                    ->when(request()->status_id && request()->status_id != 'all', function ($q) {
                        $q->where('order_status_id', request()->status_id);
                    })
                    ->latest();
            }

            return DataTables::eloquent($orders)
                ->addColumn('product', function ($order) {
                    $proInfo = '';
                    foreach ($order->orderProducts as $product) {
                        $proInfo .= $product->product_name . ' (' . $product->quantity . ' x ' . $product->variant . ')<br>';
                    }

                    return rtrim($proInfo, '<br>');
                })
                ->addColumn('status', function ($order) {

                    return "<div class='badge bg-success'>{$order->orderStatus->status_name}</div>";

                })
                ->rawColumns(['status', 'product'])
                ->addIndexColumn()
                ->make(true);
        }

        $couriers = Courier::where('status', 1)->get();

        $admins = User::role('admin')->get();

        $statuses = OrderStatus::where('status', 1)->get();

        return view('admin.pages.report.sales.index', compact('couriers', 'admins', 'statuses'));
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
}
