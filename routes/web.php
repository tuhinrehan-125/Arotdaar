<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\CollectionController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');



Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index');

// category api router
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category-store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category-edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category-update', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category-delete/{id}', [CategoryController::class, 'softDelete'])->name('category.delete');

// sub-category api router
Route::get('/subcategory', [SubCategoryController::class, 'index'])->name('subcategory.index');
Route::post('/subcategory-store', [SubCategoryController::class, 'store'])->name('subcategory.store');
Route::get('/subcategory-edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
Route::post('/subcategory-update', [SubCategoryController::class, 'update'])->name('subcategory.update');
Route::get('/subcategory-delete/{id}', [SubCategoryController::class, 'softDelete'])->name('subcategory.delete');

// product api router
Route::get('/product', [ProductsController::class, 'create'])->name('addproduct.index');
Route::post('/product-store', [ProductsController::class, 'store'])->name('product.store');
Route::get('/productIndex-edit/', [ProductsController::class, 'editIndex'])->name('productIndex.edit');
Route::put('/product-update', [ProductsController::class, 'update'])->name('product.update');
Route::get('/product-delete/{id}', [ProductsController::class, 'softDelete'])->name('product.delete');

// Customer api router 
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/customer-store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer-edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/customer-update', [CustomerController::class, 'update'])->name('customer.update');
Route::get('/customer-delete/{id}', [CustomerController::class, 'softDelete'])->name('customer.delete');


// Client api router 
Route::get('/client', [ClientController::class, 'index'])->name('client.index');
Route::post('/client-store', [ClientController::class, 'store'])->name('client.store');
Route::get('/client-edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
Route::post('/client-update', [ClientController::class, 'update'])->name('client.update');
Route::get('/client-delete/{id}', [ClientController::class, 'softDelete'])->name('client.delete');


// Payment api router 
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment-create', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/payment-store', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment-edit/{id}', [PaymentController::class, 'edit'])->name('payment.edit');
Route::post('/payment-update', [PaymentController::class, 'update'])->name('payment.update');
Route::get('/payment-delete/{id}', [PaymentController::class, 'softDelete'])->name('payment.delete');


// Advance api router 
Route::get('/advance', [AdvanceController::class, 'index'])->name('advance.index');
Route::get('/advance-create', [AdvanceController::class, 'create'])->name('advance.create');
Route::post('/advance-store', [AdvanceController::class, 'store'])->name('advance.store');
Route::get('/advance-edit/{id}', [AdvanceController::class, 'edit'])->name('advance.edit');
Route::post('/advance-update', [AdvanceController::class, 'update'])->name('advance.update');
Route::get('/advance-delete/{id}', [AdvanceController::class, 'softDelete'])->name('advance.delete');


// Collection api router 
Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection-create', [CollectionController::class, 'create'])->name('collection.create');
Route::post('/collection-store', [CollectionController::class, 'store'])->name('collection.store');
Route::get('/collection-edit/{id}', [CollectionController::class, 'edit'])->name('collection.edit');
Route::post('/collection-update', [CollectionController::class, 'update'])->name('collection.update');
Route::get('/collection-delete/{id}', [CollectionController::class, 'softDelete'])->name('collection.delete');
