<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'viewLogin'])->name('login');
Route::post('/auth/login', [App\Http\Controllers\Auth\LoginController::class, 'doLogin'])->name('login.post');
Route::get('/auth/logout', [App\Http\Controllers\Auth\LoginController::class, 'doLogout'])->name('logout');

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'viewLogin'])->name('login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/list', [App\Http\Controllers\UserController::class, 'listUser'])->name('user.list');
    Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/create', [App\Http\Controllers\UserController::class, 'doCreate'])->name('user.create.post');
    Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('/edit', [App\Http\Controllers\UserController::class, 'doUpdate'])->name('user.edit.post');
    Route::post('/delete/{id}', [App\Http\Controllers\UserController::class, 'doDelete'])->name('user.delete.post');
});

Route::prefix('role')->group(function () {
    Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');
    Route::post('/save', [App\Http\Controllers\RoleController::class, 'doSave'])->name('role.save.post');
    Route::get('/list', [App\Http\Controllers\RoleController::class, 'listRole'])->name('role.list');
    Route::post('/delete/{id}', [App\Http\Controllers\RoleController::class, 'doDelete'])->name('role.delete.post');
});

Route::prefix('satuan')->group(function () {
    Route::get('/', [App\Http\Controllers\SatuanController::class, 'index'])->name('satuan.index');
    Route::post('/save', [App\Http\Controllers\SatuanController::class, 'doSave'])->name('satuan.save.post');
    Route::get('/list', [App\Http\Controllers\SatuanController::class, 'listSatuan'])->name('satuan.list');
    Route::get('/list-active', [App\Http\Controllers\SatuanController::class, 'listActive'])->name('satuan.list.active');
    Route::post('/delete/{id}', [App\Http\Controllers\SatuanController::class, 'doDelete'])->name('satuan.delete.post');
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::post('/save', [App\Http\Controllers\CategoryController::class, 'doSave'])->name('category.save.post');
    Route::get('/list', [App\Http\Controllers\CategoryController::class, 'listCategory'])->name('category.list');
    Route::get('/list-active', [App\Http\Controllers\CategoryController::class, 'listActive'])->name('category.active');
    Route::post('/delete/{id}', [App\Http\Controllers\CategoryController::class, 'doDelete'])->name('category.delete.post');
});

Route::prefix('sub-kategori')->group(function () {
    Route::get('/', [App\Http\Controllers\SubCategoryController::class, 'index'])->name('subcategory.index');
    Route::post('/save', [App\Http\Controllers\SubCategoryController::class, 'doSave'])->name('subcategory.save.post');
    Route::get('/list', [App\Http\Controllers\SubCategoryController::class, 'listSubCategory'])->name('subcategory.list');
    Route::post('/delete/{id}', [App\Http\Controllers\SubCategoryController::class, 'doDelete'])->name('subcategory.delete.post');
    Route::get('/list-active', [App\Http\Controllers\SubCategoryController::class, 'listActive'])->name('subcategory.list.active');
});

Route::prefix('barang')->group(function () {
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::post('/create', [App\Http\Controllers\ProductController::class, 'doCreate'])->name('product.create.post');
    Route::get('/list', [App\Http\Controllers\ProductController::class, 'listProduct'])->name('product.list');
    Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::post('/update', [App\Http\Controllers\ProductController::class, 'doUpdate'])->name('product.edit.post');
    Route::get('/list-active', [App\Http\Controllers\ProductController::class, 'listActive'])->name('product.list.active');
    Route::get('/findbyid/{id}', [App\Http\Controllers\ProductController::class, 'findById'])->name('product.findbyid');
    Route::post('/delete/{id}', [App\Http\Controllers\ProductController::class, 'doDelete'])->name('product.delete.post');
    Route::get('/product-satuan/{id}', [App\Http\Controllers\ProductController::class, 'getProductSatuan'])->name('product.satuan');
});

Route::prefix('pelanggan')->group(function () {
    Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::get('/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
    Route::post('/create', [App\Http\Controllers\CustomerController::class, 'doCreate'])->name('customer.create.post');
    Route::get('/list', [App\Http\Controllers\CustomerController::class, 'listCustomer'])->name('customer.list');
    Route::get('/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('/update', [App\Http\Controllers\CustomerController::class, 'doUpdate'])->name('customer.edit.post');
    Route::post('/delete/{id}', [App\Http\Controllers\CustomerController::class, 'doDelete'])->name('customer.delete.post');
});

Route::prefix('supplier')->group(function () {
    Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/create', [App\Http\Controllers\SupplierController::class, 'doCreate'])->name('supplier.create.post');
    Route::get('/list', [App\Http\Controllers\SupplierController::class, 'listSupplier'])->name('supplier.list');
    Route::get('/list-active', [App\Http\Controllers\SupplierController::class, 'listActive'])->name('supplier.list.active');
    Route::get('/edit/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('/update', [App\Http\Controllers\SupplierController::class, 'doUpdate'])->name('supplier.edit.post');
    Route::post('/delete/{id}', [App\Http\Controllers\SupplierController::class, 'doDelete'])->name('supplier.delete.post');
});

Route::prefix('beli')->group(function () {
    Route::get('/', [App\Http\Controllers\PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/create', [App\Http\Controllers\PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/create', [App\Http\Controllers\PurchaseController::class, 'doCreate'])->name('purchase.create.post');
    Route::get('/list', [App\Http\Controllers\PurchaseController::class, 'listPurchase'])->name('purchase.list');
    Route::get('/edit/{id}', [App\Http\Controllers\PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::get('/list-detail/{id}', [App\Http\Controllers\PurchaseController::class, 'listDetail'])->name('purchase.list.detail');
    Route::post('/update', [App\Http\Controllers\PurchaseController::class, 'doUpdate'])->name('purchase.edit.post');
    Route::post('/delete/{id}', [App\Http\Controllers\PurchaseController::class, 'doDelete'])->name('purchase.delete.post');
});

Route::prefix('order')->group(function () {
    Route::get('/', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
    Route::get('/list', [App\Http\Controllers\OrderController::class, 'listOrder'])->name('order.list');
    Route::get('/list-detail/{id}', [App\Http\Controllers\OrderController::class, 'listDetail'])->name('order.list.detail');
    Route::post('/cancel/{id}', [App\Http\Controllers\OrderControler::class, 'doCancel'])->name('order.cancel.post');
});

Route::prefix('pos')->group(function() {
    Route::get('/', [App\Http\Controllers\POSController::class, 'index'])->name('pos.index');
    Route::get('/list-product', [App\Http\Controllers\POSController::class, 'listProduct'])->name('pos.list.product');
    Route::post('/add-item', [App\Http\Controllers\POSController::class, 'addItem'])->name('pos.add.item');
    Route::get('/get-price-list', [App\Http\Controllers\POSController::class, 'productPriceList'])->name('pos.price-list');
    Route::get('/view-cart', [App\Http\Controllers\POSController::class, 'cartIndex'])->name('pos.cart');
    Route::get('/detail-cart/{id}', [App\Http\Controllers\POSController::class, 'detailCart'])->name('pos.cart.detail');
    Route::post('/set-satuan', [App\Http\Controllers\POSController::class, 'setSatuan'])->name('pos.cart.set-satuan');
    Route::post('/set-discount', [App\Http\Controllers\POSController::class, 'setDiscount'])->name('pos.cart.set-discount');
    Route::post('/set-qty', [App\Http\Controllers\POSController::class, 'setQty'])->name('pos.cart.set-qty');
    Route::post('/remove-item', [App\Http\Controllers\POSController::class, 'removeItem'])->name('pos.cart.remove-item');
    Route::post('/beli', [App\Http\Controllers\POSController::class, 'doCreateOrder'])->name('pos.beli');
});

Route::get('clear/session/{key}', [App\Http\Controllers\Controller::class, 'clearSession']);
