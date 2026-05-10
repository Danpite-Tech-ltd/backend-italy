<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::where('status', 'pending')->latest()->get();

        return view('admin.review.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ratting' => 'required|numeric|min:1|max:5',
                'review' => 'required|string|max:1000',
                'product_id' => 'required|integer|exists:products,id',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ]);

            $user  = auth()->user();

            $review = new Review();
            $review->user_id = $user->id;
            $review->name = $user->name;
            $review->phone = $user->phone;
            $review->email = $user->email;
            $review->profile_image = $user->profile_image;
            $review->ratting = $request->ratting;
            $review->review = $request->review;
            $review->product_id = $request->product_id;

            // image upload
            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'public/uploads/review/';
                $image->move($imagePath, $imageName);

                $review->image = $imagePath . $imageName;
            }

            $review->status = 'pending';
            $review->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Product Review added successfully',
                'data' => $review,
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    
}
