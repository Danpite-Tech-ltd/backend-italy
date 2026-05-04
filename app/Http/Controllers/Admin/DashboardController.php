<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCount = Product::where('status', 1)->count();

        $categoryCount = Category::where('status', 1)->count();

        $orderCount = Order::count();

        $brandCount = Brand::where('status', 1)->count();


        $productTodayCount = Product::where('status', 1)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $categoryTodayCount = Category::where('status', 1)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $orderTodayCount = Order::whereDate('created_at', Carbon::today())
            ->count();

        $brandTodayCount = Brand::where('status', 1)
            ->whereDate('created_at', Carbon::today())
            ->count();

        return view('admin.pages.dashboard',
            compact('productCount', 'categoryCount', 'orderCount', 'brandCount',
            'productTodayCount', 'categoryTodayCount', 'orderTodayCount', 'brandTodayCount'

            ));

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
