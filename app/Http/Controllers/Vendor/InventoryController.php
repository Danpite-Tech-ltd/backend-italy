<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{
     public function index()
    {

        if (request()->ajax()) {

            $products = Product::where('vendor_id', Auth::guard('vendor')->user()->id)->with('productvariants:id,product_id,productcolor_id,sale_price,total_stock,available_stock,sold_stock,variant_name',
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
        
        $categories = Category::withCount([
            'products' => function ($q) {
                $q->where('vendor_id', Auth::guard('vendor')->user()->id);
            }
        ])->get();

        return view('vendor.pages.inventory.index', compact('categories'));
    }

}
