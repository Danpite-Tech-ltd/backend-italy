<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pixel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PixelController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Pixel', only: ['index','store','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pixel = Pixel::first();

        return view('admin.pages.settings.pixel', compact('pixel'));
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
        $pixel = new Pixel();

        $pixel->pixel_code = $request->pixel_code;

        $pixel->save();

        return redirect()->back()->with('success', 'Pixel created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pixel $pixel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pixel $pixel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pixel $pixel)
    {
        $pixel = Pixel::first();

        $pixel->pixel_code = $request->pixel_code;

        $pixel->save();

        return redirect()->back()->with('success', 'Pixel Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pixel $pixel)
    {
        //
    }
}
