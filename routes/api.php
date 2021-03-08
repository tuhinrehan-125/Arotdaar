<?php

use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentAccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
        'prefix'     => 'auth',
    ],
    function ($router) {
        Route::post('login', 'ApiAuthController@login');
        Route::post('signup', 'ApiAuthController@register');
        Route::post('logout', 'ApiAuthController@logout');
        Route::get('userinfo', 'ApiAuthController@me');
        Route::get('refresh', 'ApiAuthController@refresh');
    }
);

Route::resource('product', ProductsController::class);
Route::get('product-search', [ProductsController::class, 'productSearch']);
Route::get('customer-search', [CustomerController::class, 'customerSearch']);
Route::get('client-search', [ClientController::class, 'clientSearch']);

Route::resource('category', CategoryController::class);
Route::resource('sub-category', SubCategoryController::class);
Route::get('get-subcategories/{category}', [CategoryController::class, 'getSubcategories']);


Route::resource('advance', AdvanceController::class);
Route::resource('client', ClientController::class);
Route::resource('customer', CustomerController::class);
Route::resource('payment', PaymentController::class);
Route::resource('collection', CollectionController::class);
Route::resource('commission', CommissionController::class);

Route::resource('unit', UnitController::class);
Route::resource('expense', ExpenseController::class);
Route::get('expense-category', [ExpenseController::class, 'expenseCategory']);
Route::post('expense-category', [ExpenseController::class, 'storeExpenseCategory']);
Route::patch('expense-category/{id}', [ExpenseController::class, 'updateExpenseCategory']);
Route::delete('expense-category/{id}', [ExpenseController::class, 'deleteExpenseCategory']);

Route::get('customer-due', [CollectionController::class, 'customerDueMoney']);
Route::get('dashboard-data', [UserController::class, 'dashboardData']);


Route::post('order', [OrderController::class, 'store']);
Route::get('pos-prodcuts', [OrderController::class, 'posProducts']);
Route::get('banks', [BankController::class, 'index']);
Route::post('bulkcollection',[CollectionController::class, 'bulkCollection']);
Route::post('bulkpayment',[PaymentController::class, 'bulkPayment']);
Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
        'prefix'     => 'reports',
    ],
    function ($router) {
        Route::get('expense', 'ReportController@expenseReport');
        Route::get('collection', 'ReportController@collectionReport');
        Route::get('payment', 'ReportController@paymentReport');
        Route::get('sales', 'ReportController@salesReport');
    }
);
Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
        'prefix'     => 'history',
    ],
    function ($router) {
        Route::get('collection', 'CollectionController@customerCollectionHistory');
        Route::get('payment', 'PaymentController@clientPaymentHistory');
    }
);


Route::patch('user/{id}', [UserController::class, 'update']);
Route::post('update-settings', [SettingController::class, 'updateSettings']);
Route::get('settings', [SettingController::class, 'index']);
Route::resource('payment-account',PaymentAccountController::class);
Route::get('account-info',[PaymentAccountController::class,'accountTypeInfo']);
