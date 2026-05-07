<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

            return DataTables::of(Branch::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <a href="' . route('admin.branch.edit', $row->id) . '" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                    <button class="btn btn-sm btn-danger deleteBranch" data-id="' . $row->id . '">
                        Delete
                    </button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.branch.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:branches',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:branches',
            'address' => 'nullable|string'
        ]);

        Branch::create($request->all());

        return redirect()->route('admin.branch.index')->with('success', 'Branch created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return response()->json([
                'status' => false,
                'message' => 'Branch not found'
            ], 404);
        }

        $branch->delete();

        return response()->json([
            'status' => true,
            'message' => 'Branch deleted successfully'
        ]);
    }
}
