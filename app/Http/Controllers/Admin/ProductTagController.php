<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductTag;

class ProductTagController extends Controller
{
    public function index()
    {
        $tags = ProductTag::latest()->get();
        return view('admin.pages.product_tag.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.pages.product_tag.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:product_tags,name'
            ]);

            $tag = ProductTag::create([
                'name' => $validated['name'],
                'status' => 1
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product tag created successfully',
                'data' => $tag
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $tag = ProductTag::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $tag
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tag not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tag = ProductTag::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:product_tags,name,' . $id
            ]);

            $tag->update([
                'name' => $validated['name']
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product tag updated successfully',
                'data' => $tag
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $tag = ProductTag::findOrFail($id);
            $tag->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product tag deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $tag = ProductTag::findOrFail($request->id);
            $tag->status = $tag->status == 1 ? 0 : 1;
            $tag->save();

            $icon = $tag->status == 1 ? '<i style="font-size: 17px;" class="fa-solid fa-thumbs-up"></i>' : '<i style="font-size: 17px;" class="fa-regular fa-thumbs-down"></i>';
            $badgeClass = $tag->status == 1 ? 'bg-success' : 'bg-danger';

            return response()->json([
                'status' => 'success',
                'message' => 'Status changed successfully',
                'new_status' => $tag->status,
                'icon' => $icon,
                'badgeClass' => $badgeClass
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
