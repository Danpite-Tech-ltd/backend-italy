<?php


use App\Http\Controllers\Vendor\AuthController;
use App\Http\Controllers\Vendor\BankSetupController;
use App\Http\Controllers\Vendor\InventoryController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\PurchaseController;
use App\Http\Controllers\Vendor\SupplierController;
use App\Http\Controllers\Vendor\SalesReportController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('vendor')->name('vendor.')->group(function () {
    // vendor register
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/get-city', [AuthController::class, 'getCity'])->name('get-city');
    Route::post('/register_submit', [AuthController::class, 'register_submit'])->name('register_submit');

    // vendor login
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login_submit', [AuthController::class, 'login_submit'])->name('login.submit');

    Route::middleware('vendor')->group(function () {
        //vendor logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // vendor profile
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/profile/update/{id}', [AuthController::class, 'profile_update'])->name('profile.update');

        // vendor dashboard
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

        //Supplier
        Route::resource('/suppliers', SupplierController::class)->names('supplier');
        Route::post('/supplier/change-status', [SupplierController::class, 'changeSupplierStatus'])->name('supplier.status');

        //Purchase
        Route::resource('/purchases', PurchaseController::class)->names('purchase');
        Route::get('/products-for-purchase', [PurchaseController::class, 'productsForPurchase'])->name('products-for-purchase');

        //Inventory
        Route::resource('/inventories', InventoryController::class)->names('inventory');

        //Sales Reports
        Route::resource('/sales-reports', SalesReportController::class)->names('sales-reports');
        Route::get('/sales/report', [SalesReportController::class, 'salesreport'])->name('salesreport');

        // product Review
        Route::get('/review', [ReviewController::class, 'vendorReview'])->name('review.index');
        Route::get('/review/edit/{id}', [ReviewController::class, 'vendorEdit'])->name('review.edit');
        Route::post('/review/update/{id}', [ReviewController::class, 'vendorUpdate'])->name('review.update');

        //Orders
        Route::resource('/orders', OrderController::class)->names('order');
        Route::get('/order-by-status/{id}', [OrderController::class, 'orderByStatus'])->name('order.status');
        Route::post('/order-status-change', [OrderController::class, 'orderStatusChange'])->name('order.status-change');

        // Bank Setup
        Route::resource('/banks', BankSetupController::class)->names('bank');
        Route::put('/vendor/bank', [BankSetupController::class, 'update'])
            ->name('vendor.bank.update');
        Route::get('/vendor/withdraw', [BankSetupController::class, 'withdraw'])
            ->name('bank.withdraw');
        Route::post('/vendor/withdraw/submit', [BankSetupController::class, 'withdrawSubmit'])->name('bank.withdraw.submit');
        Route::get('/pending-withdraw', [BankSetupController::class, 'pendingWithdraw'])->name('pendingWithdraw');
        Route::get('/approved-withdraw', [BankSetupController::class, 'approvedWithdraw'])->name('approvedWithdraw');
        Route::get('/rejected-withdraw', [BankSetupController::class, 'rejectedWithdraw'])->name('rejectedWithdraw');
    });

    Route::resource('/products', ProductController::class)->names('product');
    Route::get('/pending-products', [ProductController::class, 'pendingProduct'])->name('pending-products');
    Route::get('/pro-variant-page/{id}', [ProductController::class, 'proVariantPage'])->name('pro-variant-page');

    Route::get('/edit-product-variant/{id}', [ProductController::class, 'editProductVariant'])->name('edit-product-variant');
    Route::post('/product-variant/{id}/update', [ProductController::class, 'updateProductVariant'])->name('product-variant.update');
    Route::delete('/delete-product-variant/{id}', [ProductController::class, 'deleteProductVariant'])->name('delete-product-variant');

    Route::get('/subcategory-by-category/{id}', [ProductController::class, 'getSubCategoryByCategory'])->name('subcategory-by-category');
    Route::post('product-variant/store', [ProductController::class, 'storeVariant'])->name('product-variant.store');
    Route::get('/product-colors', [ProductController::class, 'productColors'])->name('product.color');
    Route::get('/product-variants', [ProductController::class, 'productVariants'])->name('product.variant');
    Route::get('/variant-products/{id}', [ProductController::class, 'variantProducts'])->name('variant.productlist');
});
