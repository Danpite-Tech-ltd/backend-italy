<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Str;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Blog', only: ['index']),
            new Middleware('permission:Create Blog', only: ['store', 'create']),
            new Middleware('permission:Edit Blog', only: ['update', 'edit']),
            new Middleware('permission:Delete Blog', only: ['destroy']),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();

        return view('admin.pages.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title ?? 'default') . uniqid();
        $blog->short_description = $request->short_description;
        $blog->long_description = $request->long_description;
        $blog->author = $request->author;
        $blog->published_date = $request->published_date;
        $blog->status = $request->status;

        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->google_schema = $request->google_schema;

        if ($request->hasFile('meta_image')) {

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/blog/', $filename);
            $blog->meta_image = 'public/admin/upload/blog/' . $filename;
        }


        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/blog/', $filename);
            $blog->image = 'public/admin/upload/blog/' . $filename;
        }

        if ($request->hasFile('author_image')) {

            $file = $request->file('author_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/blog/', $filename);
            $blog->author_image = 'public/admin/upload/blog/' . $filename;
        }

        $blog->save();

        return redirect()->route('admin.blog.index')->with('success', 'Blog Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.pages.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Blog $blog)
    {
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title ?? 'default') . uniqid();
        $blog->short_description = $request->short_description;
        $blog->long_description = $request->long_description;
        $blog->author = $request->author;
        $blog->published_date = $request->published_date;
        $blog->status = $request->status;

        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->google_schema = $request->google_schema;

        if ($request->hasFile('meta_image')) {

            if ($blog->meta_image && file_exists($blog->meta_image)) {
                unlink($blog->meta_image);
            }

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/blog/', $filename);
            $blog->meta_image = 'public/admin/upload/blog/' . $filename;
        }

        if ($request->hasFile('image')) {

            if ($blog->image && file_exists($blog->image)) {
                unlink($blog->image);
            }

            $file = $request->file('image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/blog/', $filename);
            $blog->image = 'public/admin/upload/blog/' . $filename;
        }

        if ($request->hasFile('author_image')) {

            if ($blog->author_image && file_exists($blog->author_image)) {
                unlink($blog->author_image);
            }

            $file = $request->file('author_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/blog/', $filename);
            $blog->author_image = 'public/admin/upload/blog/' . $filename;
        }

        $blog->save();

        return redirect()->route('admin.blog.index')->with('success', 'Blog Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->back()->with('success', 'Blog Deleted Successfully');
    }
}
