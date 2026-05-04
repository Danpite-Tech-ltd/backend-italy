<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/send-birthday-emails', [APIController::class, 'sendBirthdayEmails']);

Route::post('/register', [AuthController::class, 'userRegister'])->name('user.register');
Route::post('/login', [AuthController::class, 'userLogin'])->name('user.login');

Route::middleware('auth:sanctum')->name('api.')->group(function(){
    Route::post('/logout', [AuthController::class, 'userLogout'])->name('user.logout');
});

Route::name('api.')->group(function(){
    // basics info data
    Route::get('/settings', [FrontendController::class, 'settings']);

    // category data
    Route::get('/categories', [FrontendController::class, 'categories']);
    Route::get('/subcategories-by-category/{slug}', [FrontendController::class, 'subcategoriesByCategory']);
    Route::get('/childcategories-by-subcategory/{slug}', [FrontendController::class, 'childcategoriesBySubCategory']);

    // slider
    Route::get('/mainslider', [FrontendController::class, 'main_sliders']);

    // pages
    Route::get('/customer-pages', [FrontendController::class, 'customerPages']);
    Route::get('/legal-pages', [FrontendController::class, 'legalPages']);

    // pixel & gtm
    Route::get('/pixel', [FrontendController::class, 'pixel']);
    Route::get('gtm', [FrontendController::class, 'gtm']);

    // shipping charge
    Route::get('/shipping-charge', [FrontendController::class, 'shippingCharge']);

    // order track
    Route::get('order-track/{invoice_id}', [FrontendController::class, 'orderTrack']);

    // products data
    Route::get('/front-category-products', [ProductController::class, 'frontCategoriesProducts']);
    Route::get('/search-product/{keyword}', [ProductController::class, 'searchProduct']);
    Route::get('/product-details/{slug}', [ProductController::class, 'productDetails']);
    Route::get('/related-products/{slug}', [ProductController::class, 'relatedProducts']);
    Route::get('/category-products/{slug}', [ProductController::class, 'categoryProducts']);
    Route::get('/subcategory-products/{slug}', [ProductController::class, 'subcategoryProducts']);
    Route::get('/child-category-products/{slug}', [ProductController::class, 'childcategoryProducts']);
    Route::get('/flash-sale', [ProductController::class, 'flashSale']);
    Route::get('/daily-deals', [ProductController::class, 'dailyDeals']);

    // checkout
    Route::post('/order-place', [CheckoutController::class, 'orderPlace']);
    Route::get('/order-success/{invoice_id}', [CheckoutController::class, 'orderSuccess']);

    // Vendor Registration
    Route::get('/vendor-login', [AuthController::class, 'vendorLogin'])->name('vendor.register');
});
