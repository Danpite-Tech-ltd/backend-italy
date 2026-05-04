<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SubcategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Subcategory', only: ['index']),
            new Middleware('permission:Create Subcategory', only: ['store', 'create']),
            new Middleware('permission:Edit Subcategory', only: ['update', 'edit']),
            new Middleware('permission:Delete Subcategory', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('status', 1)->get();

        if (\request()->ajax()) {
            $subcategories = Subcategory::with(['category' => function ($query) {
                $query->select('id', 'name');
            }]);

            return DataTables::eloquent($subcategories)
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
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Subcategory'))
                    {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Subcategory'))
                    {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.subcategory.index',compact('categories'));
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
        $subcategory = new Subcategory();
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name ?? 'default') . uniqid();
        $subcategory->category_id = $request->category_id;

        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        $subcategory->meta_keywords = $request->meta_keywords;
        $subcategory->google_schema = $request->google_schema;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/subcategory/', $filename);
            $subcategory->image = 'public/admin/upload/subcategory/' . $filename;

        }

        if ($request->hasFile('meta_image')) {

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/subcategory/', $filename);
            $subcategory->meta_image = 'public/admin/upload/subcategory/' . $filename;

        }

        $subcategory->save();

        return response()->json(['status' => 'success', 'message' => 'Subcategory created successfully'], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        return response()->json(['status' => 'success', 'message' => 'Category fetched successfully', 'data' => $subcategory], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name ?? 'default') . uniqid();
        $subcategory->category_id = $request->category_id;

        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        $subcategory->meta_keywords = $request->meta_keywords;
        $subcategory->google_schema = $request->google_schema;

        if ($request->hasFile('image')) {

            if ($subcategory->image && file_exists($subcategory->image)) {
                unlink($subcategory->image);
            }

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/subcategory/', $filename);
            $subcategory->image = 'public/admin/upload/subcategory/' . $filename;

        }

        if ($request->hasFile('meta_image')) {

            if ($subcategory->meta_image && file_exists($subcategory->meta_image)) {
                unlink($subcategory->meta_image);
            }

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/subcategory/', $filename);
            $subcategory->meta_image = 'public/admin/upload/subcategory/' . $filename;

        }

        $subcategory->save();

        return response()->json(['status' => 'success', 'message' => 'Subcategory Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return response()->json(['status' => 'success', 'message' => 'Subcategory deleted successfully'], 200);
    }

    public function changeSubcategoryStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Subcategory::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }


    public function getSubCategoryByCategory(string $id)
    {
        $subcategories = Subcategory::where('category_id', $id)->where('status', 1)->get();

        return response()->json(['status' => 'success', 'message' => 'Subcategories fetched successfully', 'data' => $subcategories], 200);
    }


}
