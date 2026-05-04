<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class PageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Page', only: ['index']),
            new Middleware('permission:Create Page', only: ['store', 'create']),
            new Middleware('permission:Edit Page', only: ['update', 'edit']),
            new Middleware('permission:Delete Page', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::all();

        return view('admin.pages.settings.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.settings.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $page = new Page();
        $page->title = $request->title;
        $page->slug =  Str::slug($request->title ?? 'default') . uniqid();
        $page->content = $request->content;
        $page->custom_css = $request->custom_css;
        $page->custom_js = $request->custom_js;
        $page->status = $request->status;
        $page->type = $request->type;

        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->meta_keywords = $request->meta_keywords;
        $page->google_schema = $request->google_schema;

        if ($request->hasFile('meta_image')) {

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/page/', $filename);
            $page->meta_image = 'public/admin/upload/page/' . $filename;
        }

        $page->save();

        return redirect()->route('admin.page.index')->with('success', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.settings.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {

        $page->title = $request->title;
        $page->slug =  Str::slug($request->title ?? 'default') . uniqid();
        $page->content = $request->content;
        $page->custom_css = $request->custom_css;
        $page->custom_js = $request->custom_js;

        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->meta_keywords = $request->meta_keywords;
        $page->google_schema = $request->google_schema;
        $page->status = $request->status;
        $page->type = $request->type;

        if ($request->hasFile('meta_image')) {

            if ($page->meta_image && file_exists($page->meta_image)) {
                unlink($page->meta_image);
            }

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/page/', $filename);
            $page->meta_image = 'public/admin/upload/page/' . $filename;
        }

        $page->save();

        return redirect()->route('admin.page.index')->with('success', 'Page created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.page.index')->with('success', 'Page deleted successfully');
    }
}
