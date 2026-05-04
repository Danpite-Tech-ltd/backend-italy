<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Slider', only: ['index']),
            new Middleware('permission:Create Slider', only: ['store', 'create']),
            new Middleware('permission:Edit Slider', only: ['update', 'edit']),
            new Middleware('permission:Delete Slider', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $sliders = Slider::query();

            return DataTables::eloquent($sliders)
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';
                    if (Auth::user()->can('Edit Slider')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->can('Delete Slider')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'status',])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.slider.index');
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
        $slider = new Slider();

        $slider->link = $request->link;
        $slider->title = $request->title;
        $slider->status = $request->status;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/slider/', $filename);
            $slider->image = 'public/admin/upload/slider/' . $filename;

        }

        $slider->save();

        return response()->json(['status' => 'success', 'message' => 'Slider created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return response()->json(['status' => 'success', 'message' => 'Slider fetched successfully', 'data' => $slider], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {

        $slider->link = $request->link;
        $slider->title = $request->title;
        $slider->status = $request->status;

        if ($request->hasFile('image')) {

            if ($slider->image && file_exists($slider->image)) {
                unlink($slider->image);
            }

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/slider/', $filename);
            $slider->image = 'public/admin/upload/slider/' . $filename;

        }

        $slider->save();

        return response()->json(['status' => 'success', 'message' => 'Slider created successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return response()->json(['status' => 'success', 'message' => 'Slider Deleted successfully'], 200);
    }
}
