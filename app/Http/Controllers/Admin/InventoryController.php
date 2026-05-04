<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cr;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Inventory', only: ['index']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->ajax()) {

            $products = Product::with('productvariants:id,product_id,productcolor_id,sale_price,total_stock,available_stock,sold_stock,variant_name',
                'productvariants.productcolor:id,color_name')->latest();

        return DataTables::eloquent($products)
            ->addColumn('status', function ($admin) {
//                if(Auth::guard('admin')->user()->can('Status Admin')) {
                if ($admin->status == 1) {
                    return ' <a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-on fa-2x"></i>
                                            </a>';
                } else {
                    return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                            </a>';
                }
//                }

            })

            ->addColumn('stock', function ($admin) {
                $stock = '';

                foreach ($admin->productvariants as $product) {
                    $stock .= '<div class="d-flex">
                            <p style="width:80px;float:left;">Color: ' . $product->productcolor->color_name . '</p>
                            <p style="width:80px;float:left;">Variant: ' . $product->variant_name . '</p>
                            <p style="width:80px;float:left;"> Total: ' . $product->total_stock . '</p>
                            <p style="width:80px;float:left;"> Sold: ' . $product->sold_stock . '</p>
                            <p style="width:120px;float:left;"> Available: ' . $product->available_stock . '</p>
                        </div>';
                }

                return $stock;


            })

            ->addColumn('proImg', function ($admin) {

                return '<img class="img-fluid rounded-circle" src="' . asset($admin->thumbnail_img) . '" style="width: 100px; height: 100px;">';
            })
//                }

            ->rawColumns(['status', 'stock', 'proImg'])
            ->addIndexColumn()
            ->make(true);
    }

        $productByCategory = Product::with('category')->get();

        return view('admin.pages.inventory.index', compact('productByCategory'));
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
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }
}
