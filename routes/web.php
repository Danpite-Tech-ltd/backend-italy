<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    // home route
    // Route::get('/', [HomeController::class, 'index'])->name('home');

    // Route::get('/', function () {
    //     return redirect()->route('admin.login');
    // });

    Route::get('/', [HomeController::class, 'index'])->name('home');

    //Products
    Route::get('/category/{slug}', [HomeController::class, 'categoryproduct'])->name('categoryproduct');
    Route::get('/subcategory/{slug}', [HomeController::class, 'subcategoryproduct'])->name('subcategoryproduct');
    Route::get('/child-category/{slug}', [HomeController::class, 'childCategoryProduct'])->name('childcategoryproduct');
    Route::get('/product-details/{slug}', [HomeController::class, 'productDetails'])->name('product-details');
    Route::get('/chnage-color', [HomeController::class, 'changecolor'])->name('change-color');
    Route::get('/chnage-varient', [HomeController::class, 'changevarient'])->name('change-variant');
    Route::get('/recommendation', [HomeController::class, 'recommendation'])->name('recommendation');
    Route::get('/add-to-cart', [HomeController::class, 'addtocart'])->name('add-to-cart');
    Route::post('/order-now', [HomeController::class, 'orderNow'])->name('order-now');
    Route::get('/add-to-wishlist', [HomeController::class, 'addtowishlist'])->name('add-to-wishlist');
    Route::get('/wish-list', [HomeController::class, 'wishlist'])->name('wishlist');
    Route::post('/remove-wish', [HomeController::class, 'removeWish'])->name('remove-wish');
    Route::get('/load-cart', [HomeController::class, 'loadcart'])->name('loadcart');
    Route::get('/remove-cart', [HomeController::class, 'removecart'])->name('remove-cart');
    Route::get('/view-cart', [HomeController::class, 'viewcart'])->name('viewcart');
    Route::get('/loadlist', [HomeController::class, 'loadlist'])->name('loadlist');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::get('/buynow/checkout', [HomeController::class, 'buynowcheckout'])->name('buynowcheckout');
    Route::get('/set-coupon', [HomeController::class, 'setcoupon'])->name('set-coupon');
    Route::get('/track-order', [HomeController::class, 'trackorder'])->name('trackorder');
    Route::post('/order-place', [HomeController::class, 'orderPlace'])->name('order-place');
    Route::post('/buynow-order-place', [HomeController::class, 'buynoworderPlace'])->name('buynow-order-place');
    Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription');
    Route::post('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/get-shipping-charge', [HomeController::class, 'getShippingCharge']);

    Route::get('page/{slug}', [HomeController::class, 'pagedata']);
    Route::get('blogs', [HomeController::class, 'blogdata']);
    Route::get('blog/{slug}', [HomeController::class, 'blogdetails']);
    Route::get('shop-by-category', [HomeController::class, 'shopbycategory']);

    require __DIR__ . '/admin.php';
});
//User Dashboard
Route::group(['middleware' => ['user']], function () {

    Route::get('/user-dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user-orders', [DashboardController::class, 'userOrders'])->name('user-orders');
    Route::get('/user-wishlist', [DashboardController::class, 'userWishlist'])->name('user-wishlist');
    Route::get('/user-profile', [DashboardController::class, 'userProfile'])->name('user-profile');
    Route::post('/user-profile-update', [DashboardController::class, 'userProfileUpdate'])->name('user-profile-update');
    Route::get('/user-settings', [DashboardController::class, 'userSettings'])->name('user-settings');
    Route::post('/user-settings-update', [DashboardController::class, 'userSettingsUpdate'])->name('user-settings-update');
    Route::get('/delete-account', [DashboardController::class, 'deleteAccount'])->name('delete-account');

    //Affiliate
    Route::get('/affiliate-shop', [DashboardController::class, 'affiliateShop'])->name('affiliate-shop');
    Route::get('/affiliate-order/{id}/{status_id?}', [DashboardController::class, 'affiliateOrder'])->name('affiliate-order');
    Route::get('/affiliate-withdrawal-history/{id}', [DashboardController::class, 'withdrawHistory'])->name('affiliate-withdrawal-history');
    Route::get('/affiliate-withdrawal', [DashboardController::class, 'withdrawalRequestPage'])->name('affiliate-withdrawal-page');
    Route::post('/withdrawal-request', [DashboardController::class, 'withdrawalRequest'])->name('withdrawal-request');

    //POS Order
    Route::get('/pos-order', [DashboardController::class, 'posOrder'])->name('pos-order');
    Route::get('/products-for-purchase', [DashboardController::class, 'productsForPurchase'])->name('products-for-purchase');
    Route::post('/pos-order/store', [DashboardController::class, 'posOrderStore'])->name('pos-order-store');
});

//Affiliate
Route::post('/add-product-affiliate', [HomeController::class, 'addProductAffiliate'])->name('add-product-affiliate');


Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('image-upload', [ImageController::class, 'index']);
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');

Route::resource('/cart', CartController::class)->names('cart')->middleware(['auth', 'verified']);


//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::view('/birthday', 'emails.birthday_wish');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/vendor.php';
