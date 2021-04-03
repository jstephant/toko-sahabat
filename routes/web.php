<?php

use App\Http\Controllers\UserController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/create', [App\Http\Controllers\UserController::class, 'doCreate'])->name('user.create.post');
    Route::get('/list', [App\Http\Controllers\UserController::class, 'listUser'])->name('user.list');
    Route::get('/check-{field}/{keyword}', [App\Http\Controllers\UserController::class, 'checkData'])->name('user.check-data');
    Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('/update', [App\Http\Controllers\UserController::class, 'doUpdate'])->name('user.edit.post');
});

Route::prefix('role')->group(function () {
    Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');
    Route::post('/save', [App\Http\Controllers\RoleController::class, 'doSave'])->name('role.save.post');
    Route::get('/list', [App\Http\Controllers\RoleController::class, 'listRole'])->name('role.list');
    Route::get('/check-{field}/{keyword}', [App\Http\Controllers\RoleController::class, 'checkData'])->name('role.check-data');
});

Route::prefix('satuan')->group(function () {
    Route::get('/', [App\Http\Controllers\SatuanController::class, 'index'])->name('satuan.index');
    Route::post('/create', [App\Http\Controllers\SatuanController::class, 'doSave'])->name('satuan.save.post');
    Route::get('/list', [App\Http\Controllers\SatuanController::class, 'listSatuan'])->name('satuan.list');
    Route::get('/check-{field}/{keyword}', [App\Http\Controllers\SatuanController::class, 'checkData'])->name('satuan.check-data');
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::post('/create', [App\Http\Controllers\CategoryController::class, 'doSave'])->name('category.save.post');
    Route::get('/list', [App\Http\Controllers\CategoryController::class, 'listCategory'])->name('category.list');
    Route::get('/check-{field}/{keyword}', [App\Http\Controllers\CategoryController::class, 'checkData'])->name('category.check-data');
    Route::get('/active', [App\Http\Controllers\CategoryController::class, 'getActive'])->name('category.active');
});

Route::prefix('sub-kategori')->group(function () {
    Route::get('/', [App\Http\Controllers\SubCategoryController::class, 'index'])->name('subcategory.index');
    Route::post('/create', [App\Http\Controllers\SubCategoryController::class, 'doSave'])->name('subcategory.save.post');
    Route::get('/list', [App\Http\Controllers\SubCategoryController::class, 'listSubCategory'])->name('subcategory.list');
    Route::get('/check-{field}/{keyword}', [App\Http\Controllers\SubCategoryController::class, 'checkData'])->name('subcategory.check-data');
});

Route::prefix('barang')->group(function () {
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::post('/create', [App\Http\Controllers\ProductController::class, 'doCreate'])->name('product.create.post');
    Route::get('/list', [App\Http\Controllers\ProductController::class, 'listProduct'])->name('product.list');
    Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::post('/update', [App\Http\Controllers\ProductController::class, 'doUpdate'])->name('product.edit.post');
});

Route::prefix('pelanggan')->group(function () {
    Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::get('/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
    Route::post('/create', [App\Http\Controllers\CustomerController::class, 'doCreate'])->name('customer.create.post');
    Route::get('/list', [App\Http\Controllers\CustomerController::class, 'listCustomer'])->name('customer.list');
    Route::get('/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('/update', [App\Http\Controllers\CustomerController::class, 'doUpdate'])->name('customer.edit.post');
});

Route::prefix('supplier')->group(function () {
    Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/create', [App\Http\Controllers\SupplierController::class, 'doCreate'])->name('supplier.create.post');
    Route::get('/list', [App\Http\Controllers\SupplierController::class, 'listSupplier'])->name('supplier.list');
    Route::get('/edit/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('/update', [App\Http\Controllers\SupplierController::class, 'doUpdate'])->name('supplier.edit.post');
});


