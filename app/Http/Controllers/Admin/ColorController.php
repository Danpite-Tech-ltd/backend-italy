<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ColorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Admin', only: ['index']),
            new Middleware('permission:Create Admin', only: ['store', 'create']),
            new Middleware('permission:Edit Admin', only: ['update', 'edit']),
            new Middleware('permission:Delete Admin', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

            $colors = Color::query();

            return DataTables::eloquent($colors)

                ->addColumn('status', function ($admin) {
                if(Auth::user()->can('Status Color')) {
                    if ($admin->status == 1) {
                        return ' <a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="'.$admin->id.'" data-status="'.$admin->status.'"> <i
                                                        class="fa-solid fa-toggle-on fa-2x"></i>
                                            </a>';
                    } else {
                        return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="'.$admin->id.'" data-status="'.$admin->status.'"> <i
                                                        class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                            </a>';
                    }
                }
                return '';

                })
//                }

                ->addColumn('action', function ($admin) {
                    $editAction= '';
                    $deleteAction= '';

                    if (Auth::user()->can('Edit Color')) {
                    $editAction = '<a class="editButton btn btn-sm btn-info" href="javascript:void(0)"
                                  data-id="'.$admin->id.'" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                   <i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->can('Delete Color')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }



                    return '<div class="d-flex gap-3"> '.$editAction.$deleteAction.'</div>';
                })
                ->rawColumns(['action','front_status','status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.color.index');
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
        $color = new Color();

        $color->name = $request->name;
        $color->slug = Str::slug($request->name ?? 'default').uniqid();
        $color->code = $request->code;
        $color->status = $request->status;

        $color->save();

        return response()->json(['status' => 'success', 'message' => 'Color created successfully'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return response()->json(['status' => 'success', 'data' => $color], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $color->name = $request->name;
        $color->code = $request->code;
        $color->status = $request->status;

        $color->save();

        return response()->json(['status' => 'success', 'message' => 'Color Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();

        return response()->json(['status' => 'success', 'message' => 'Color deleted successfully'], 200);
    }

    public function changeColorStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Color::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }


}
