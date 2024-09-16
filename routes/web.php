<?php

use App\Http\Controllers\Admin\CashflowController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExcelController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Order\ReceiptController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Guest\CartController as GuestCartController;
use App\Http\Controllers\Guest\GuestHomeController;
use App\Http\Controllers\Guest\ShopController as GuestShopController;
use App\Models\Setting;

Route::get('/', function(){
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/shop', [ShopController::class, 'index'])->name('shop')->middleware('check_permission:shop');
Route::get('/search-product', [ShopController::class, 'searchProduct'])->name('search.product');
Route::get('/pagination/paginate-products', [ShopController::class, 'paginateProduct']);
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove.from.cart');
Route::post('/change-qty', [CartController::class, 'changeQty'])->name('change.qty');
Route::post('/change-discount', [CartController::class, 'changeDiscount'])->name('change.discount');
Route::get('/add-checkout-method', [CartController::class, 'addCheckoutMethod'])->name('add.checkout.method');
Route::get('/create-new-tab', [CartController::class, 'createNewTab'])->name('create.new.tab');
Route::post('/tab-request', [CartController::class, 'tabRequest'])->name('tab.request');
Route::get('/add-buyer-name', [CartController::class, 'addBuyerName'])->name('add.buyer.name');
Route::post('/add-buyer-info', [CartController::class, 'addBuyerInfo'])->name('add.buyer.info');
// RECEIPT
Route::get('/generate-receipt/{id}', [ShopController::class, 'generateReceipt'])->name('generate.receipt');
Route::get('/view-receipt/{id}', [ReceiptController::class, 'viewReceipt'])->name('view.receipt')->middleware('check_permission:view-receipt');

// Guest pages
Route::group(['prefix' => 'guest', 'as' => 'guest.'], function(){
    Route::get('/shop', [GuestShopController::class, 'index'])->name('shop');
    Route::get('/cart', [GuestCartController::class, 'index'])->name('cart');
    Route::get('/contact', [GuestHomeController::class, 'contactForm'])->name('contact.form');
});

// Admin privileges
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // User
    Route::get('/edit-user', [UserController::class, 'index'])
        ->name('user.list')
        ->middleware('check_permission:edit-user');
        
    Route::get('/edit-user-view', [UserController::class, 'userEditView'])
        ->name('user.edit.view')
        ->middleware('check_permission:edit-user');

    Route::post('/save-user-changes', [UserController::class, 'saveUserChanges'])
        ->name('save.user.changes')
        ->middleware('check_permission:edit-user');

    Route::get('/delete-user/{id}', [UserController::class, 'deleteUser'])
        ->name('delete.user')
        ->middleware('check_permission:delete-user');

    // Roles and Permission
    Route::get('/edit-role', [RolePermissionController::class, 'index'])
        ->name('role.list')
        ->middleware('check_permission:edit-role');
    
    Route::get('/edit-role-view', [RolePermissionController::class, 'roleEditView'])
        ->name('role.edit.view')
        ->middleware('check_permission:edit-role');

    Route::post('/save-role-changes', [RolePermissionController::class, 'saveRoleChanges'])
        ->name('save.role.changes')
        ->middleware('check_permission:edit-role');

    Route::get('/delete-role/{id}', [RolePermissionController::class, 'deleteRole'])
        ->name('delete.role')
        ->middleware('check_permission:delete-role');

    Route::get('/role-add-view', [RolePermissionController::class, 'roleAddView'])
        ->name('role.add.view')
        ->middleware('check_permission:create-role');

    Route::post('/add-role', [RolePermissionController::class, 'addRole'])
        ->name('add.role')
        ->middleware('check_permission:create-role');

    // Product
    Route::get('/create-product', [ProductController::class, 'index'])
        ->name('product.list')
        ->middleware('check_permission:create-product');

    Route::get('/edit-product-view', [ProductController::class, 'productEditView'])
        ->name('product.edit.view')
        ->middleware('check_permission:edit-product');

    Route::get('/product-add-view', [ProductController::class, 'productAddView'])
        ->name('product.add.view')
        ->middleware('check_permission:create-product');

    Route::get('/product-add-multiple-view', [ProductController::class, 'productAddMultipleView'])
        ->name('product.add.multiple.view')
        ->middleware('check_permission:create-product');

    Route::post('/save-product-changes', [ProductController::class, 'saveProductChanges'])
        ->name('save.product.changes')
        ->middleware('check_permission:edit-product');

    Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct'])
        ->name('delete.product')
        ->middleware('check_permission:delete-product');

    Route::post('/add-product', [ProductController::class, 'addProduct'])
        ->name('add.product')
        ->middleware('check_permission:create-product');

    // Product categories
    Route::get('/create-category', [ProductController::class, 'listCategories'])
        ->name('list.categories')
        ->middleware('check_permission:create-product-category');
        
     Route::get('/edit-category-view', [ProductController::class, 'categoryEditView'])
        ->name('category.edit.view')
        ->middleware('check_permission:edit-product-category');

    Route::get('/category-add-view', [ProductController::class, 'categoryAddView'])
        ->name('category.add.view')
        ->middleware('check_permission:create-product-category');
    
    Route::post('/add-category', [ProductController::class, 'addCategory'])
        ->name('add.category')
        ->middleware('check_permission:create-product-category');
    
    Route::post('/save-category-changes', [ProductController::class, 'saveCategoryChanges'])
        ->name('save.category.changes')
        ->middleware('check_permission:edit-product-category');

    Route::get('/delete-category/{id}', [ProductController::class, 'deleteCategory'])
        ->name('delete.category')
        ->middleware('check_permission:delete-product-category');

    // Stock
    Route::get('/request-stock-list', [StockController::class, 'userStockRequestList'])
        ->name('stock.request.list')
        ->middleware('check_permission:request-stock');

    Route::get('/request-stock-view', [StockController::class, 'stockRequestView'])
        ->name('stock.request.view')
        ->middleware('check_permission:request-stock');

    Route::get('/stock-add-product-view', [StockController::class, 'stockAddProductView'])
        ->name('stock.add.product.view')
        ->middleware('check_permission:request-stock');

    Route::get('/edit-stock-product-view', [StockController::class, 'stockEditProductView'])
        ->name('stock.edit.product.view')
        ->middleware('check_permission:request-stock');

    Route::post('/send-request-stock', [StockController::class, 'sendStockRequest'])
        ->name('send.stock.request')
        ->middleware('check_permission:request-stock');

    Route::post('/save-request-stock-changes', [StockController::class, 'saveStockRequestChanges'])
        ->name('save.stock.request.changes')
        ->middleware('check_permission:request-stock');

    Route::get('/delete-stock/{id}', [StockController::class, 'deleteStock'])
        ->name('delete.stock')
        ->middleware('check_permission:request-stock');
        // Stock approval
    Route::get('/request-stock-approval-list', [StockController::class, 'userStockRequestApprovalList'])
        ->name('stock.request.approval.list')
        ->middleware('check_permission:approve-stock');

    Route::get('/stock-approval-logs', [StockController::class, 'stockApprovalLogs'])
        ->name('stock.approval.logs')
        ->middleware('check_permission:approve-stock');
    
    Route::post('/approve-checked-stock', [StockController::class, 'approveCheckedStock'])
        ->name('approve.checked.stock')
        ->middleware('check_permission:approve-stock');

    Route::get('/approve-all-stock', [StockController::class, 'approveAllStock'])
        ->name('approve.all.stock')
        ->middleware('check_permission:approve-stock');

        // Orders
    Route::get('/order-list', [OrderController::class, 'orderList'])
        ->name('order.list')
        ->middleware('check_permission:generate-receipt');

    Route::get('/refunded-orders', [OrderController::class, 'refundedOrderList'])
        ->name('refunded-order.list')
        ->middleware('check_permission:generate-receipt');
    
    Route::get('/search-refunded-order', [OrderController::class, 'searchRefundedOrder'])
        ->name('search.refunded.order')
        ->middleware('check_permission:general-report');

    // Sales
    Route::get('/sales-report', [OrderController::class, 'salesReport'])
        ->name('sales.report')
        ->middleware('check_permission:generate-receipt');
    
    Route::get('/search-sales', [OrderController::class, 'searchSales'])
        ->name('search.sales')
        ->middleware('check_permission:general-report');

    Route::get('/sales-pdf/{startDate}/{endDate}', [PdfController::class, 'salesPdf'])->name('sales.pdf');

    // Refund order
    Route::get('/refund-order-view', [OrderController::class, 'refundOrderView'])
        ->name('refund.order.view')
        ->middleware('check_permission:generate-receipt');

    Route::post('/refund-order', [OrderController::class, 'refundOrder'])
        ->name('refund.order')
        ->middleware('check_permission:order-report');
        
    
    // Revoke order view
    Route::get('/revoke-order-view', [OrderController::class, 'revokeOrderView'])
        ->name('revoke.order.view')
        ->middleware('check_permission:generate-receipt');

    // Revoke Order
    Route::post('/revoke-order', [OrderController::class, 'revokeOrder'])
        ->name('revoke.order')
        ->middleware('check_permission:order-report');

    // Revoke single order
    Route::get('/revoke-single-order/{order_id}/{combined_order_id}', [OrderController::class, 'revokeSingleOrder'])
        ->name('revoke.single.order')
        ->middleware('check_permission:order-report');

    Route::get('/search-order', [OrderController::class, 'searchOrder'])
        ->name('search.order')
        ->middleware('check_permission:general-report');

    Route::get('/order-pdf/{startDate}/{endDate}', [PdfController::class, 'orderPdf'])->name('order.pdf');
    
    
    // Cashflow
    Route::get('/cashflow', [CashflowController::class,'viewCashFlow'])->name('cashflow')->middleware('check_permission:general-report');
    Route::get('/search-cashflow', [CashflowController::class, 'searchCashflow'])
        ->name('search.cashflow')
        ->middleware('check_permission:general-report');
    Route::get('/cashflow-pdf/{startDate}/{endDate}', [PdfController::class, 'cashflowPdf'])->name('cashflow.pdf');

    // Settings
    Route::get('/company-info', [SettingsController::class, 'index'])
        ->name('company.info')
        ->middleware('check_permission:settings');

    Route::post('/save-company-info', [SettingsController::class, 'saveCompanyInfo'])
        ->name('save.company.info')
        ->middleware('check_permission:settings');
    
    // Excel 
    Route::get('/export-products', [ExcelController::class, 'exportProducts'])
        ->name('export.products')
        ->middleware('check_permission:create-product');
    
    Route::get('/export-orders/{startDate}/{endDate}', [ExcelController::class, 'downloadReport'])
        ->name('export.orders')
        ->middleware('check_permission:order-report');

    Route::post('/import-products', [ExcelController::class, 'importProducts'])
        ->name('import.products')
        ->middleware('check_permission:create-product');

    Route::get('/test-barcode', [BarcodeController::class, 'runBarcode']);
});