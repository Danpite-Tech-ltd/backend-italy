<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Implements_;
use Yajra\DataTables\Facades\DataTables;

class VariantController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Variant', only: ['index']),
            new Middleware('permission:Create Variant', only: ['store', 'create']),
            new Middleware('permission:Edit Variant', only: ['update', 'edit']),
            new Middleware('permission:Delete Variant', only: ['destroy']),
            new Middleware('permission:Status Variant', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {

            $variants = Variant::query();

            return DataTables::eloquent($variants)
                ->addColumn('status', function ($admin) {
                if(Auth::user()->can('Status Variant')) {
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
                }

                return '';

                })
//                }
                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Variant')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="' . $admin->id . '" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->can('Delete Variant')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }

                    return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'front_status', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.variant.index');
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
        $variant = new Variant();

        $variant->name = $request->name;
        $variant->slug = Str::slug($request->name ?? 'default') . uniqid();
        $variant->status = $request->status;

        $variant->save();

        return response()->json(['status' => 'success', 'message' => 'Variant created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Variant $variant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant $variant)
    {
        return response()->json(['status' => 'success', 'data' => $variant], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Variant $variant)
    {
        $variant->name = $request->name;
        $variant->status = $request->status;

        $variant->save();

        return response()->json(['status' => 'success', 'message' => 'Variant Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variant)
    {
        $variant->delete();

        return response()->json(['status' => 'success', 'message' => 'Variant deleted successfully'], 200);
    }

    public function changeVariantStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Variant::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }
}
