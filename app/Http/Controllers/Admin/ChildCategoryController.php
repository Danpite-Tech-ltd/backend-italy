<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ChildCategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Child Category', only: ['index']),
            new Middleware('permission:Create Child Category', only: ['store', 'create']),
            new Middleware('permission:Edit Child Category', only: ['update', 'edit']),
            new Middleware('permission:Delete Child Category', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::select('id', 'name')->get();

        if (\request()->ajax()) {
            $categories = ChildCategory::with(['subcategory' => function ($query) {
                $query->select('id', 'name');
            }]);

            return DataTables::eloquent($categories)
                ->addColumn('action', function ($admin) {
                    $editAction= '';
                    $deleteAction= '';

//                    $subcategoriesAction = '<a class="editButton btn btn-sm btn-danger" href="'.route('admin.subcategory.index',$admin->id).'">
//                                   <i class="fas fa-edit"></i></a>';


                    if (Auth::user()->can('Edit Child Category')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Child Category')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="'.$admin->id.'" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="d-flex gap-3"> '.$editAction.$deleteAction.'</div>';
                })
                ->rawColumns(['action', 'status',])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.child-category.index',compact('subcategories'));
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
        $childCategory = new childCategory();

        $childCategory->name = $request->name;
        $childCategory->slug =Str::slug($request->name).uniqid() ;
        $childCategory->subcategory_id = $request->subcategory_id;
        $childCategory->status = $request->status;

        $childCategory->meta_title       = $request->meta_title;
        $childCategory->meta_description = $request->meta_description;
        $childCategory->meta_keywords    = $request->meta_keywords;
        $childCategory->google_schema    = $request->google_schema;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time().uniqid().'.'.$file->getClientOriginalExtension();
            $file->move('public/admin/upload/childCategory/', $filename);
            $childCategory->image ='public/admin/upload/childCategory/'. $filename;

        }

        if ($request->hasFile('meta_image')) {

            $file = $request->file('meta_image');
            $filename = time().uniqid().'.'.$file->getClientOriginalExtension();
            $file->move('public/admin/upload/childCategory/', $filename);
            $childCategory->meta_image ='public/admin/upload/childCategory/'. $filename;

        }

        $childCategory->save();

        return response()->json(['status' => 'success', 'message' => 'Subcategory created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildCategory $childCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildCategory $childCategory)
    {
        return response()->json(['status' => 'success','message' => 'ChildCategory fetched successfully', 'data' => $childCategory], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChildCategory $childCategory)
    {

        $childCategory->name = $request->name;
//      $childCategory->slug =Str::slug($request->name).uniqid() ;
        $childCategory->subcategory_id = $request->subcategory_id;
        $childCategory->status = $request->status;

        $childCategory->meta_title       = $request->meta_title;
        $childCategory->meta_description = $request->meta_description;
        $childCategory->meta_keywords    = $request->meta_keywords;
        $childCategory->google_schema    = $request->google_schema;

        if ($request->hasFile('image')) {

            if ($childCategory->image && file_exists($childCategory->image))
            {
                unlink($childCategory->image);
            }


            $file = $request->file('image');
            $filename = time().uniqid().'.'.$file->getClientOriginalExtension();
            $file->move('public/admin/upload/childCategory/', $filename);
            $childCategory->image ='public/admin/upload/childCategory/'. $filename;

        }

        if ($request->hasFile('meta_image')) {

            if ($childCategory->meta_image && file_exists($childCategory->meta_image))
            {
                unlink($childCategory->meta_image);
            }


            $file = $request->file('meta_image');
            $filename = time().uniqid().'.'.$file->getClientOriginalExtension();
            $file->move('public/admin/upload/childCategory/', $filename);
            $childCategory->meta_image ='public/admin/upload/childCategory/'. $filename;

        }

        $childCategory->save();

        return response()->json(['status' => 'success', 'message' => 'Subcategory created successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildCategory $childCategory)
    {
        $childCategory->delete();

        return response()->json(['status' => 'success', 'message' => 'Child Category deleted successfully'], 200);
    }

    public function changeChildCategoryStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = ChildCategory::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }

    public function getChildCategoryBySubCategory(string $id)
    {
        $childCategories = ChildCategory::where('subcategory_id', $id)->where('status', 1)->get();

        return response()->json(['status' => 'success', 'message' => 'Child Categories fetched successfully', 'data' => $childCategories], 200);
    }



}
