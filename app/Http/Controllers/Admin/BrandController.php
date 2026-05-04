<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Brand', only: ['index']),
            new Middleware('permission:Create Brand', only: ['store', 'create']),
            new Middleware('permission:Edit Brand', only: ['update', 'edit']),
            new Middleware('permission:Delete Brand', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $brands = Brand::query();

            return DataTables::eloquent($brands)
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

                    if (Auth::user()->can('Edit Brand')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->can('Delete Brand')) {
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

        return view('admin.pages.brand.index');
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
        $brand = new Brand();

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name ?? 'default') . uniqid();
        $brand->status = $request->status;

        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        $brand->meta_keywords = $request->meta_keywords;
        $brand->google_schema = $request->google_schema;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/brand/', $filename);
            $brand->image = 'public/admin/upload/brand/' . $filename;
        }

        if ($request->meta_image) {
            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/brand/', $filename);
            $brand->meta_image = 'public/admin/upload/brand/' . $filename;
        }

        $brand->save();

        return response()->json(['status' => 'success', 'message' => 'Brand created successfully'], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return response()->json(['status' => 'success', 'message' => 'Brand fetched successfully', 'data' => $brand], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);

        $brand->name = $request->name;
//      $brand->slug = Str::slug($request->name ?? 'default').uniqid();
        $brand->status = $request->status;

        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        $brand->meta_keywords = $request->meta_keywords;
        $brand->google_schema = $request->google_schema;

        if ($request->hasFile('image')) {

            if ($brand->image && file_exists($brand->image)) {
                unlink($brand->image);
            }

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/brand/', $filename);
            $brand->image = 'public/admin/upload/brand/' . $filename;
        }

        if ($request->meta_image) {
            if ($brand->meta_image && file_exists($brand->meta_image)) {
                unlink($brand->meta_image);
            }

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/brand/', $filename);
            $brand->meta_image = 'public/admin/upload/brand/' . $filename;
        }

        $brand->save();

        return response()->json(['status' => 'success', 'message' => 'Brand created successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {

        $brand->delete();

        return response()->json(['status' => 'success', 'message' => 'Brand Deleted successfully'], 200);

    }

    public function changeBrandStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Brand::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }
}
