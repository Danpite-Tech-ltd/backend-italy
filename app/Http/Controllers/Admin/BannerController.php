<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Banner', only: ['index']),
            new Middleware('permission:Create Banner', only: ['store', 'create']),
            new Middleware('permission:Edit Banner', only: ['update', 'edit']),
            new Middleware('permission:Delete Banner', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = Banner::select('id', 'image', 'title_1', 'type', 'status');

            return DataTables::eloquent($banners)
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Banner')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('Delete Banner')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        //
        return view('admin.pages.banner.index');
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
        $banner = new Banner();
//        $banner->text       = $request->text;
        $banner->title_1 = $request->title_1;
//        $banner->btn_name   = $request->btn_name;
//        $banner->btn_link   = $request->btn_link;
        $banner->type = $request->type;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/banner/', $filename);
            $banner->image = 'public/admin/upload/banner/' . $filename;
        }

        $banner->save();

        return response()->json(['status' => 'success', 'message' => 'Banner created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return response()->json(['status' => 'success', 'message' => 'Slider fetched successfully', 'data' => $banner], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
//        $banner->text       = $request->text;
        $banner->title_1 = $request->title_1;
//        $banner->btn_name   = $request->btn_name;
//        $banner->btn_link   = $request->btn_link;

        $banner->type = $request->type;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {

            if ($banner->image && file_exists($banner->image)) {
                unlink($banner->image);
            }


            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/banner/', $filename);
            $banner->image = 'public/admin/upload/banner/' . $filename;
        }

        $banner->save();

        return response()->json(['status' => 'success', 'message' => 'Banner Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json(['status' => 'success', 'message' => 'Banner Deleted successfully'], 200);
    }
}
