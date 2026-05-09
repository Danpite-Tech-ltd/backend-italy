<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;

class VendorController extends Controller
{
    public function vendor_store($id)
    {
        $vendor = Vendor::select('id', 'first_name', 'last_name', 'email', 'phone', 'company_name', 'company_address', 'country', 'city', 'profile_image')->find($id);

        $products = Product::where('vendor_id', $id)
            ->select('id', 'name', 'slug', 'thumbnail_img')
            ->with([
                'productvariants' => function ($query) {
                    $query->select('id', 'product_id', 'price', 'sku')
                        ->limit(1);
                }
            ])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Vendor Store Data',
            'vendor' => $vendor,
            'products' => $products
        ]);
    }
}
