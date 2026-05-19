<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;

class VendorController extends Controller
{
    public function vendor_store($id)
    {
        $vendor = Vendor::select('id', 'first_name', 'last_name', 'email', 'phone', 'company_name', 'company_address', 'country', 'city', 'profile_image', 'avg_rating')->find($id);

        $products = Product::where('vendor_id', $id)
            ->select('id', 'name', 'slug', 'thumbnail_img')
            ->with([
                'productvariants' => function ($query) {
                    $query->select('id', 'product_id', 'regular_price', 'sale_price')
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

    public function vendor_review_submit(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string']
        ]);

        $data['user_id'] = auth()->id();

        $exists = VendorReview::where('vendor_id', $request->vendor_id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You already reviewed this vendor'
            ], 409);
        }

        $review = VendorReview::create($data);

        // average rating
        $avgRating = VendorReview::where('vendor_id', $request->vendor_id)
            ->avg('rating');

        // convert to percentage
        $avgPercentage = ($avgRating / 5) * 100;

        // update vendor
        $vendor = Vendor::find($request->vendor_id);

        $vendor->avg_rating = round($avgPercentage, 2);

        $vendor->save();

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully',
            'data' => $review,
            'avg_rating' => $vendor->avg_rating
        ], 201);
    }

    public function vendor_review($id)
    {
        $reviews = VendorReview::where('vendor_id', $id)->with('user', function($q){
            $q->select('id', 'name', 'email', 'phone', 'profile_image');
        })->get();

        return response()->json([
            'success' => true,
            'message' => 'Vendor Reviews',
            'data' => $reviews,
        ], 200);
    }
}
