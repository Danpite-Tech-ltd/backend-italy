<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Order;
use App\Models\Page;
use App\Models\Pixel;
use App\Models\ShippingCharge;
use App\Models\Slider;
use App\Models\Subcategory;
use App\Models\Tag;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;

class FrontendController extends Controller
{
    use ApiResponse;
    public function settings()
    {
        $settings = BasicInfo::first();

        return $this->success(
            message: 'All basic info data.',
            data: $settings
        );
    }

    public function main_sliders()
    {
        $sliders = Slider::where('status', 1)->get();

        return $this->success(
            message: 'All slider image.',
            data: $sliders
        );
    }

    // categories data
    public function brands()
    {   
        $brands = Brand::where('status', 1)->get();

        return $this->success(
            message: 'All brands data.',
            data: $brands
        );
    }
    public function categories()
    {   
        $categories = Category::where('status', 1)->where('front_status', 1)->get();

        return $this->success(
            message: 'All categories data.',
            data: $categories
        );
    }

    public function subcategoriesByCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $subCategories = Subcategory::where('category_id', $category->id)
            ->where('status', 1)->get();

        return $this->success(
            message: 'All subcategories data',
            data: $subCategories
        );
    }

    public function childcategoriesBySubCategory($slug)
    {
        $subCategory = SubCategory::where('slug', $slug)->first();
        $childCategories = ChildCategory::where('subcategory_id', $subCategory->id)
            ->where('status', 1)->get();

        return $this->success(
            message: 'All child categories data.',
            data: $childCategories
        );
    }

    // footer pages
    public function customerPages()
    {
        $pages = Page::where('status', 1)->where('type', 1)->get();

        return $this->success(
            message: 'All customer pages data',
            data: $pages
        );
    }

    public function legalPages(){
        $pages = Page::where('status', 1)->where('type', 0)->get();

        return $this->success(
            message: 'All legal pages data.',
            data: $pages
        );
    }

    // pixel and gtm
    public function pixel(){
        $pixel = Pixel::first();

        return $this->success(
            message: 'Pixel code data.',
            data: $pixel
        );
    }

    public function gtm(){
        $gtm = Tag::first();

        return $this->success(
            message: 'GTM code',
            data: $gtm
        );
    }

    // shipping charge
    public function shippingCharge(){
        $shipping = ShippingCharge::all();

        return $this->success(
            message: 'All shipping charge data.',
            data: $shipping
        );
    }

    // order track
    public function orderTrack($invoice_id){
        $order = Order::where('invoiceID', $invoice_id)->with(['orderProducts', 'customer'])->get();

        return $this->success(
            message: 'Order Track data.',
            data: $order
        );
    }

}
