<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\Api\StripePaymentController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\CompareController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/send-birthday-emails', [APIController::class, 'sendBirthdayEmails']);

Route::post('/register', [AuthController::class, 'userRegister'])->name('user.register');
Route::post('/login', [AuthController::class, 'userLogin'])->name('user.login');

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::post('/logout', [AuthController::class, 'userLogout'])->name('user.logout');

    // checkout
    Route::post('/order-place', [CheckoutController::class, 'orderPlace']);
    Route::get('/order-success/{invoice_id}', [CheckoutController::class, 'orderSuccess']);
    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon']);

    // ticket
    Route::post('/ticket-store', [TicketController::class, 'ticket_store'])->name('ticket.store');
    Route::get('/ticket-list', [TicketController::class, 'ticket_list'])->name('ticket.list');
    Route::get('/ticket-replay-list/{ticket_id}', [TicketController::class, 'ticket_reply_list'])->name('ticket.replay.list');
    Route::post('/ticket-replay-submit', [TicketController::class, 'ticket_reply_submit'])->name('ticket.replay.submit');

    //User Dashboard
    Route::get('/dashboard-overview', [DashboardController::class, 'dashboardOverview']);
    Route::get('/user-profile', [DashboardController::class, 'userProfile']);
    Route::post('/profile-update', [AuthController::class, 'profileUpdate']);
    Route::post('/user-update-password', [AuthController::class, 'userUpdatePassword']);
    Route::get('/order-status', [DashboardController::class, 'orderStatus']);
    Route::get('/orders', [DashboardController::class, 'orders']);
    Route::get('/order-details/{invoiceID}', [DashboardController::class, 'orderDetails']);


    // vendor review and rating
    Route::post('/vendor-review', [VendorController::class, 'vendor_review_submit']);

    // product review
    Route::post('/review', [ReviewController::class, 'store']);

    // my review
    Route::get('/my-reviews', [ReviewController::class, 'myReview']);

    // wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/store', [WishlistController::class, 'store']);
    Route::post('/wishlist/remove', [WishlistController::class, 'delete']);

    // Compare
    Route::get('/compare', [CompareController::class, 'index']);
    Route::post('/compare/store', [CompareController::class, 'store']);
    Route::post('/compare/remove', [CompareController::class, 'destroy']);

    // customer notification
    Route::get('/customer-notification',[FrontendController::class,'customerNotification']);

    // refund & Cancel
    Route::get('/refund-cancel/list',[CheckoutController::class,'refundCancelList']);
    Route::post('/refund-cancel/{order_id}',[CheckoutController::class,'refundCancelSubmit']);
});

Route::name('api.')->group(function () {
    // basics info data
    Route::get('/settings', [FrontendController::class, 'settings']);

    // category & brand data
    Route::get('/categories', [FrontendController::class, 'categories']);
    Route::get('/subcategories-by-category/{slug}', [FrontendController::class, 'subcategoriesByCategory']);
    Route::get('/childcategories-by-subcategory/{slug}', [FrontendController::class, 'childcategoriesBySubCategory']);
    Route::get('/brands', [FrontendController::class, 'brands']);

    // slider & banner
    Route::get('/mainslider', [FrontendController::class, 'main_sliders']);
    Route::get('/banner', [FrontendController::class, 'banner']);

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
    Route::get('/brand-products/{slug}', [ProductController::class, 'brandProducts']);
    Route::get('/product-tags', [ProductController::class, 'productTags']);

    // branch
    Route::get('/branch', [FrontendController::class, 'branch']);

    // Vendor Registration
    Route::get('/vendor-login', [AuthController::class, 'vendorLogin'])->name('vendor.register');

    // vendor store
    Route::get('/vendor-store/{id}', [VendorController::class, 'vendor_store']);
    Route::get('/vendor-review/{id}', [VendorController::class, 'vendor_review']);

    // stripe payment gateway
    Route::post('/stripe-payment', [StripePaymentController::class, 'stripePayment']);
    // vat & tax
    Route::get('/vat', [CheckoutController::class, 'vat']);
    Route::get('/tax', [CheckoutController::class, 'tax']);

    // coupon
    Route::get('/coupon-list', [CheckoutController::class, 'couponList']);

    // blog
    Route::get('/blogs', [FrontendController::class, 'blogs']);
    Route::get('/blog-details/{slug}', [FrontendController::class, 'blogDetails']);
});
