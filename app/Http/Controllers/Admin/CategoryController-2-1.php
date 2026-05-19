<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Category', only: ['index']),
            new Middleware('permission:Create Category', only: ['store', 'create']),
            new Middleware('permission:Edit Category', only: ['update', 'edit']),
            new Middleware('permission:Delete Category', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $categories = Category::query();

            return DataTables::eloquent($categories)
                ->addColumn('front_status', function ($admin) {
                    if ($admin->front_status == 1) {
                        return ' <a class="status" id="adminFrontStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->front_status . '"> <i
                                                        class="fa-solid fa-toggle-on fa-2x"></i>
                                            </a>';
                    } else {
                        return '<a class="status" id="adminFrontStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->front_status . '"> <i
                                                        class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                            </a>';
                    }

                })
                ->addColumn('status', function ($admin) {
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

                })

                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Category')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Category')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }




                    return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'front_status', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.category.index');
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
        $category = new Category();

        $category->name = $request->name;
        $category->slug = Str::slug($request->name ?? 'default') . uniqid();
        $category->description = $request->description;

        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->google_schema = $request->google_schema;
        $category->SKU_prefix = $request->SKU_prefix;

        $category->front_status = $request->front_status;
        $category->status = $request->status;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/category/', $filename);
            $category->image = 'public/admin/upload/category/' . $filename;
        }

        if ($request->hasFile('banner_image')) {

            $file1 = $request->file('image');
            $filename1 = time() . uniqid() . '.' . $file1->getClientOriginalExtension();
            $file->move('public/admin/upload/category/', $filename1);
            $category->banner_image = 'public/admin/upload/category/' . $filename1;
        }

        if ($request->hasFile('meta_image')) {

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/category/', $filename);
            $category->meta_image = 'public/admin/upload/category/' . $filename;
        }

        $category->save();

        return response()->json(['status' => 'success', 'message' => 'Category created successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return response()->json(['status' => 'success', 'message' => 'Category fetched successfully', 'data' => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {


        $category->name = $request->name;
        //        $category->slug = Str::slug($request->name ?? 'default').uniqid();
        $category->description = $request->description;

        $category->meta_title =       $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords =    $request->meta_keywords;
        $category->google_schema =    $request->google_schema;
        $category->SKU_prefix =       $request->SKU_prefix;

        $category->front_status = $request->front_status;
        $category->status = $request->status;

        if ($request->hasFile('image')) {

            if ($category->image && file_exists($category->image)) {
                unlink($category->image);
            }

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/category/', $filename);
            $category->image = 'public/admin/upload/category/' . $filename;
        }
        if ($request->hasFile('banner_image')) {

            if ($category->banner_image && file_exists($category->banner_image)) {
                unlink($category->banner_image);
            }

            $file1 = $request->file('banner_image');
            $filename1 = time() . uniqid() . '.' . $file1->getClientOriginalExtension();
            $file1->move('public/admin/upload/category/', $filename1);
            $category->banner_image = 'public/admin/upload/category/' . $filename1;
        }

        if ($request->hasFile('meta_image')) {

            if ($category->meta_image && file_exists($category->meta_image)) {
                unlink($category->meta_image);
            }

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/category/', $filename);
            $category->meta_image = 'public/admin/upload/category/' . $filename;
        }

        $category->save();

        return response()->json(['status' => 'success', 'message' => 'Category created successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Finally, delete the category itself
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
    }


    public function changeCategoryStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Category::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }

    public function changeFrontCategoryStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Category::findOrFail($id);
        $page->front_status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }


}
