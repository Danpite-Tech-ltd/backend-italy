<?php


use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WcustomerController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BasicInfoController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\VendorOrderStatusController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PixelController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\VendorController;

use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SmsGatewayController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TaxVatController;

use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WpaymentController;
use App\Http\Controllers\Admin\WsaleController;
use App\Http\Controllers\Admin\WsalestockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TicketController;

Route::middleware('admin')->get('/admin/edit-product-variant/{id}', [ProductController::class, 'editProductVariant'])->name('edit-product-variant');

Route::prefix('admin')->name('admin.')->group(function () {

    //Auth
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');


    Route::post('/login', [AdminAuthController::class, 'store']);
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    //Logout
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Profile
    Route::resource('/profiles', ProfileController::class)->names('profile');

    //Admin
    Route::resource('/admins', AdminController::class)->names('admin');
    Route::post('/change-admin-status', [AdminController::class, 'changeAdminStatus'])->name('admin.status');

    //Role
    Route::resource('/roles', RoleController::class)->names('role');
    Route::get('/assign-permission-page/{id}', [RoleController::class, 'assignPermissionsToRolePage'])->name('role.assign-permissions-page');
    Route::put('role/{id}/permission/update', [RoleController::class, 'assignPermissionsToRole'])->name('role.assign-permission-update');

    //Permission
    Route::resource('/permissions', PermissionController::class)->names('permission');

    //Affiliates
    Route::resource('/affiliates', AffiliateController::class)->names('affiliate');
    Route::post('/affiliate/change-status', [AffiliateController::class, 'changeAffiliateStatus'])->name('affiliate.status');

    Route::get('/affiliate/pending/withdraw/list', [AffiliateController::class, 'affiliateWithdrawList'])->name('affiliate.pending.withdraw.list');
    Route::get('/affiliate/withdraw/store', [AffiliateController::class, 'affiliateWithdrawListstore'])->name('affiliate.withdraw.store');
    Route::get('/affiliate/approved/withdraw/list', [AffiliateController::class, 'affiliateWithdrawApproveList'])->name('affiliate.approved.withdraw.list');
    Route::get('/affiliate/approve/withdraw/store', [AffiliateController::class, 'affiliateApprovedWithdrawListstore'])->name('affiliate.withdraw.approved.store');
    Route::post('/affiliate/affiliate-withdraw/change-status', [AffiliateController::class, 'changeAffiliateWithdrawStatus'])->name('affiliate-withdraw.status');
    Route::get('/affiliate/affiliate-withdraw/show/{id}', [AffiliateController::class, 'affiliateWithdrawShow'])->name('affiliate-withdraw.show');

    //Vendors
    Route::get('/vendor/create', [VendorController::class, 'create_vendor'])->name('vendor.create');
    Route::post('/vendor/store', [VendorController::class, 'vendor_store'])->name('vendor.store');

    Route::get('/pending/vendors/list', [VendorController::class, 'pending_vendor_list'])->name('pending.vendor.list');
    Route::post('/pending/vendors/status', [VendorController::class, 'pending_vendor_status'])->name('pending.vendor.status');
    Route::get('/pending/vendors/delete/{id}', [VendorController::class, 'pending_vendor_delete'])->name('pending.vendor.delete');

    Route::get('/approved/vendors/list', [VendorController::class, 'approved_vendor_list'])->name('approved.vendor.list');
    Route::post('/approved/vendors/status', [VendorController::class, 'approved_vendor_status'])->name('approved.vendor.status');
    Route::get('/approved/vendors/edit/{id}', [VendorController::class, 'approved_vendor_edit'])->name('approved.vendor.edit');
    Route::post('/approved/vendors/update/{id}', [VendorController::class, 'approved_vendor_update'])->name('approved.vendor.update');

    //Users
    Route::resource('/users', UserController::class)->names('user');

    //Subscriptions
    Route::resource('/subscriptions', SubscriptionController::class)->names('subscription');

    //Category
    Route::resource('/categories', CategoryController::class)->names('category');
    Route::post('/class/change-status', [CategoryController::class, 'changeCategoryStatus'])->name('category.status');
    Route::post('/class/change-front-status', [CategoryController::class, 'changeFrontCategoryStatus'])->name('front-category.status');

    //Subcategory
    Route::resource('/subcategories', SubCategoryController::class)->names('subcategory');
    Route::post('/subcategory/change-status', [SubCategoryController::class, 'changeSubcategoryStatus'])->name('subcategory.status');

    //child Categories
    Route::resource('/child-categories', ChildCategoryController::class)->names('child-category');
    Route::post('/child-category/change-status', [ChildCategoryController::class, 'changeChildCategoryStatus'])->name('child-category.status');

    //Brand
    Route::resource('/brands', BrandController::class)->names('brand');
    Route::post('/brand/change-status', [BrandController::class, 'changeBrandStatus'])->name('brand.status');

    //Product Type
    Route::resource('/product-types', ProductTypeController::class)->names('product-type');
    Route::post('/product-type/change-status', [ProductTypeController::class, 'changeProductTypeStatus'])->name('product-type.status');

    //Product
    Route::resource('/products', ProductController::class)->names('product');
    Route::get('/subcategory-by-category/{id}', [SubCategoryController::class, 'getSubCategoryByCategory'])->name('subcategory-by-category');
    Route::get('/child-category-by-subcategory/{id}', [ChildCategoryController::class, 'getChildCategoryBySubCategory'])->name('child-category-by-subcategory');
    Route::post('/product/change-status', [ProductController::class, 'changeProductStatus'])->name('product.status');
    Route::post('product-variant/store', [ProductController::class, 'storeVariant'])->name('product-variant.store');

    Route::get('/products/create/variant', [ProductController::class, 'createVariant'])->name('product.create.variant');
    Route::get('/product-colors', [ProductController::class, 'productColors'])->name('product.color');
    Route::get('/product-variants', [ProductController::class, 'productVariants'])->name('product.variant');
    Route::get('/variant-products/{id}', [ProductController::class, 'variantProducts'])->name('variant.productlist');
    Route::get('/pro-variant-page/{id}', [ProductController::class, 'proVariantPage'])->name('pro-variant-page');


    Route::get('/edit-product-variant/{id}', [ProductController::class, 'editProductVariant'])->name('edit-product-variant');
    Route::post('/product-variant/{id}/update', [ProductController::class, 'updateProductVariant'])->name('product-variant.update');
    Route::delete('/delete-product-variant/{id}', [ProductController::class, 'deleteProductVariant'])->name('delete-product-variant');

    //color & variant
    Route::resource('/colors', ColorController::class)->names('color');
    Route::post('/color/change-status', [ColorController::class, 'changeColorStatus'])->name('color.status');

    Route::resource('/variants', VariantController::class)->names('variant');
    Route::post('/variant/change-status', [VariantController::class, 'changeVariantStatus'])->name('variant.status');


    //slider & banner
    Route::resource('/sliders', SliderController::class)->names('slider');
    Route::resource('/banners', BannerController::class)->names('banner');

    //Blog
    Route::resource('/blogs', BlogController::class)->names('blog');

    //Orders
    Route::resource('/orders', OrderController::class)->names('order');
    Route::get('/order-by-status/{id}', [OrderController::class, 'orderByStatus'])->name('order.status');
    Route::post('/order-status-change', [OrderController::class, 'orderStatusChange'])->name('order.status-change');
    Route::post('/steadfast-order-submit', [OrderController::class, 'steadFastOrderSubmit'])->name('steadfast.order-submit');

    //pathao
    Route::post('order-pathao', [OrderController::class, 'pathaoOrderSubmit'])->name('pathao.order-submit');
    Route::get('/pathao-zone', [OrderController::class, 'pathaoGetZone'])->name('pathaocity');
    Route::get('/pathao-area', [OrderController::class, 'pathaoGetArea'])->name('pathaozone');


    //Coupon
    Route::resource('/coupons', CouponController::class)->names('coupon');
    Route::post('/coupon/change-status', [CouponController::class, 'changeCouponStatus'])->name('coupon.status');

    //Discount
    Route::resource('/discounts', DiscountController::class)->names('discount');
    Route::post('/discount/change-status', [DiscountController::class, 'changeDiscountStatus'])->name('discount.status');

    //Voucher
    Route::resource('/vouchers', VoucherController::class)->names('voucher');
    Route::post('/voucher/change-status', [VoucherController::class, 'changeVoucherStatus'])->name('voucher.status');

    //Landing pages
    Route::resource('/landing-pages', LandingPageController::class)->names('landing-page');

    //Settings
    Route::resource('/basic-infos', BasicInfoController::class)->names('basic-info');
    Route::resource('/pixels', PixelController::class)->names('pixel');
    Route::resource('/pages', PageController::class)->names('page');
    Route::resource('/vendor-order-statuses', VendorOrderStatusController::class)->names('vendor-order-status');
    Route::resource('/order-statuses', OrderStatusController::class)->names('order-status');
    Route::resource('shipping-charges', ShippingChargeController::class)->names('shipping-charge');
    Route::resource('/tags', TagController::class)->names('tag');

    //API
    Route::resource('/couriers', CourierController::class)->names('courier');
    Route::resource('/sms-gateways', SmsGatewayController::class)->names('sms');
    Route::resource('/payment-gateways', PaymentGatewayController::class)->names('payment');

    //Supplier
    Route::resource('/suppliers', SupplierController::class)->names('supplier');
    Route::post('/supplier/change-status', [SupplierController::class, 'changeSupplierStatus'])->name('supplier.status');

    //Purchase
    Route::resource('/purchases', PurchaseController::class)->names('purchase');
    Route::get('/products-for-purchase', [PurchaseController::class, 'productsForPurchase'])->name('products-for-purchase');

    //Inventory
    Route::resource('/inventories', InventoryController::class)->names('inventory');

    //Sales Reports
    Route::resource('/sales-reports', SalesReportController::class)->names('sales-report');

    //wholesale customer
    Route::resource('wcustomers', WcustomerController::class)->names('wcustomers');
    Route::post('admin_wcustomer/store', [WcustomerController::class, 'store']);
    Route::post('wcustomer/{id}', [WcustomerController::class, 'update']);
    Route::put('wcustomer/status', [WcustomerController::class, 'updatestatus']);
    Route::get('admin/wcustomer', [WcustomerController::class, 'wcustomerdata'])->name('wcustomer.info');
    Route::get('wcustomer/ledger/{id}', [WcustomerController::class, 'wcustomerLedger'])->name('wsale.ledger');

    Route::post('wcustomer-payment', [WpaymentController::class, 'store'])->name('wcustomerpayment.store');

    //wholesale
    Route::resource('wsales', WsaleController::class)->names('wsales');
    Route::post('admin_wsale/store', [WsaleController::class, 'store']);
    Route::post('wsale/{id}', [WsaleController::class, 'update']);
    Route::get('admin/wsale', [WsaleController::class, 'wsaledata'])->name('wsale.info');
    Route::get('admin/wsale-create', [WsaleController::class, 'create']);
    Route::get('admin_get/wcustomers', [WsaleController::class, 'wcustomers']);

    Route::get('/products-for-sale', [WsaleController::class, 'productsForSale'])->name('products-for-sale');

    //wholesale stock
    Route::resource('wsalestocks', WsalestockController::class)->names('wsalestocks');
    Route::get('admin/wsalestock', [WsalestockController::class, 'wsalestockdata'])->name('wsalestock.info');

    // Tax and VAT Settings
    Route::get('/taxes', [TaxVatController::class, 'tax'])->name('tax');
    Route::post('/tax/update', [TaxVatController::class, 'updateTax'])->name('tax.update');
    Route::post('/tax/change-status', [TaxVatController::class, 'changeTaxStatus'])->name('tax.status');

    Route::get('/vats', [TaxVatController::class, 'vat'])->name('vat');
    Route::post('/vat/update', [TaxVatController::class, 'updateVat'])->name('vat.update');
    Route::post('/vat/change-status', [TaxVatController::class, 'changeVatStatus'])->name('vat.status');

    // Warehouse Setup
    Route::resource('warehouses', WarehouseController::class)->names('warehouse');
    Route::post('/warehouse/change-status', [WarehouseController::class, 'changeWarehouseStatus'])->name('warehouse.status');

    // Branch Setup
    Route::resource('branches', BranchController::class)->names('branch');
    Route::post('/branch/change-status', [BranchController::class, 'changeBranchStatus'])->name('branch.status');

        // ticket route
    Route::get('ticket/manage', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('ticket/edit/{ticket_id}', [TicketController::class, 'edit'])->name('ticket.edit');
    Route::post('ticket/replay/{ticketdetails_id}', [TicketController::class, 'ticketdetails_replay'])->name('ticket.replay');
    
    Route::post('ticket/inactive', [TicketController::class, 'inactive'])->name('ticket.inactive');
    Route::post('ticket/active', [TicketController::class, 'active'])->name('ticket.active');

});
