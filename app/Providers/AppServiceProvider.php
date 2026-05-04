<?php

namespace App\Providers;

use App\Models\BasicInfo;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Page;
use App\Models\Pixel;
use App\Models\Tag;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View()->composer('*', function ($view) {

            $settings = BasicInfo::first();
            $gtmCode = Tag::first()->gtm_code ?? null;
            $pixelCode = Pixel::first()->pixel_code ?? null;

            $view->with([
                'settings' => $settings,
                'gtmCode' => $gtmCode
            ]);
        });

        View()->composer('frontend.content.cart.loadcart', function ($view) {
            if (Auth::id()) {
                $user = User::where('id', Auth::user()->id)->first();
                if ($user && $user->hasRole('user')) {
                    $carts = Cart::where('user_id', $user->id)->get();
                } else {
                    $carts = Cart::where('ip', \Request::ip())->get();
                }
            } else {
                $carts = Cart::where('ip', \Request::ip())->get();
            }

            $view->with([
                'carts' => $carts
            ]);
        });

        View()->composer('frontend.includes.header', function ($view) {
            if (Auth::id()) {
                $user = User::where('id', Auth::user()->id)->first();
                if ($user && $user->hasRole('user')) {
                    $count = Cart::where('user_id', $user->id)->count();
                    $wishcount = Wishlist::where('user_id', $user->id)->count();
                } else {
                    $count = Cart::where('ip', \Request::ip())->count();
                    $wishcount = Wishlist::where('ip', \Request::ip())->count();
                }
            } else {
                $count = Cart::where('ip', \Request::ip())->count();
                $wishcount = Wishlist::where('ip', \Request::ip())->count();
            }


            $categories = Category::where('status', 1)->get();
            $pages = Page::where('status', 1)->get();

            $view->with([
                'categories' => $categories,
                'pages' => $pages,
                'count' => $count,
                'wishcount' => $wishcount
            ]);
        });

        View()->composer('frontend.includes.footer', function ($view) {

            $usefulls = Page::where('status', 1)->where('type', 1)->get();
            $services = Page::where('status', 1)->where('type', 0)->get();

            $view->with([
                'services' => $services,
                'usefulls' => $usefulls
            ]);
        });
    }
}