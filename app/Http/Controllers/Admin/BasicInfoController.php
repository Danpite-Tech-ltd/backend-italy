<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BasicInfoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Basic Info', only: ['index','store','update']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $basicInfo = BasicInfo::first();

        return view('admin.pages.settings.basicInfo', compact('basicInfo'));
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
        $basicInfo = new Basicinfo();
        $basicInfo->site_name = $request->site_name;
        $basicInfo->phone_1 = $request->phone_1;
        $basicInfo->phone_2 = $request->phone_2;
        $basicInfo->mail = $request->mail;
        $basicInfo->address = $request->address;
        $basicInfo->fb_link = $request->fb_link;
        $basicInfo->insta_link = $request->insta_link;
        $basicInfo->twitter_link = $request->twitter_link;
        $basicInfo->youtube_link = $request->youtube_link;
        $basicInfo->vimeo_link = $request->vimeo_link;
        $basicInfo->linkedin_link = $request->linkedin_link;
        $basicInfo->skype_link = $request->skype_link;
        $basicInfo->about_text = $request->about_text;
        $basicInfo->copyright_text = $request->copyright_text;

        $basicInfo->product_sku_prefix = $request->product_sku_prefix;
        $basicInfo->order_invoice_prefix = $request->order_invoice_prefix;

        $basicInfo->meta_title = $request->meta_title;
        $basicInfo->meta_description = $request->meta_desc;
        $basicInfo->meta_keywords = $request->meta_keyword;
        $basicInfo->opening_hours_text = $request->opening_hours_text;

        if ($request->hasFile('newsletter_bgImage')) {

            $file = $request->file('newsletter_bgImage');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->newsletter_bgImage = 'public/admin/upload/settings/' . $filename;
        }

        if ($request->hasFile('dark_logo')) {

            $file = $request->file('dark_logo');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->dark_logo = 'public/admin/upload/settings/' . $filename;
        }

        if ($request->hasFile('light_logo')) {

            $file = $request->file('light_logo');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->light_logo = 'public/admin/upload/settings/' . $filename;
        }

        if ($request->hasFile('meta_image')) {

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->meta_image = 'public/admin/upload/settings/' . $filename;
        }

        if ($request->hasFile('fav_icon')) {

            $file = $request->file('fav_icon');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->fav_icon = 'public/admin/upload/settings/' . $filename;
        }

        $save = $basicInfo->save();

        if ($save) {

//            Toastr::success('message', 'title', 'Basic Info Added Successfully');

            return redirect()->back()->with('success', 'Basic Info Added Successfully');
        }

        return redirect()->back()->with('error', 'Basic Info Not Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(BasicInfo $basicInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BasicInfo $basicInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $basicInfo = BasicInfo::first();

        $basicInfo->site_name = $request->site_name;
        $basicInfo->phone_1 = $request->phone_1;
        $basicInfo->phone_2 = $request->phone_2;
        $basicInfo->mail = $request->mail;
        $basicInfo->address = $request->address;
        $basicInfo->fb_link = $request->fb_link;
        $basicInfo->insta_link = $request->insta_link;
        $basicInfo->twitter_link = $request->twitter_link;
        $basicInfo->youtube_link = $request->youtube_link;
        $basicInfo->vimeo_link = $request->vimeo_link;
        $basicInfo->linkedin_link = $request->linkedin_link;
        $basicInfo->skype_link = $request->skype_link;
        $basicInfo->about_text = $request->about_text;
        $basicInfo->copyright_text = $request->copyright_text;
        $basicInfo->meta_title = $request->meta_title;
        $basicInfo->meta_description = $request->meta_desc;
        $basicInfo->meta_keywords = $request->meta_keyword;
        $basicInfo->opening_hours_text = $request->opening_hours_text;
        $basicInfo->google_schema = $request->google_schema;

        $basicInfo->product_sku_prefix = $request->product_sku_prefix;
        $basicInfo->order_invoice_prefix = $request->order_invoice_prefix;

        if ($request->hasFile('dark_logo')) {

            if ($basicInfo->dark_logo && file_exists(($basicInfo->dark_logo))) {

                unlink($basicInfo->dark_logo);
            }

            $file = $request->file('dark_logo');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->dark_logo = 'public/admin/upload/settings/' . $filename;
        }

        if ($request->hasFile('newsletter_bgImage')) {

            $file = $request->file('newsletter_bgImage');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->newsletter_bgImage = 'public/admin/upload/settings/' . $filename;
        }


        if ($request->hasFile('light_logo')) {

            if ($basicInfo->light_logo && file_exists(($basicInfo->light_logo))) {

                unlink($basicInfo->light_logo);
            }

            $file = $request->file('light_logo');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->light_logo = 'public/admin/upload/settings/' . $filename;
        }

        if ($request->hasFile('meta_image')) {

            if ($basicInfo->meta_image && file_exists(($basicInfo->meta_image))) {

                unlink($basicInfo->meta_image);
            }

            $file = $request->file('meta_image');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->meta_image = 'public/admin/upload/settings/' . $filename;
        }

        if ($request->hasFile('fav_icon')) {

            if ($basicInfo->fav_icon && file_exists(($basicInfo->fav_icon))) {

                unlink($basicInfo->fav_icon);
            }

            $file = $request->file('fav_icon');
            $filename = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('public/admin/upload/settings/', $filename);
            $basicInfo->fav_icon = 'public/admin/upload/settings/' . $filename;
        }

        $save = $basicInfo->save();

        if ($save) {

            return redirect()->back()->with('success', 'Basic Info Added Successfully');
        }

        return redirect()->back()->with('error', 'Basic Info Not Added');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BasicInfo $basicInfo)
    {
        //
    }
}
