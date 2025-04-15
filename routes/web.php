<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/checkout', [OrderController::class, 'checkout']);

    Route::get('/category/all', [CategoryController::class, 'getAll']);
    Route::get('/warehouse/all', [WarehouseController::class, 'getAll']);
    Route::get('/product/all', [ProductController::class, 'getAll']);
    Route::get('/customer/all', [CustomerController::class, 'getAll']);
    Route::get('/employee/all', [EmployeeController::class, 'getAll']);

    Route::get('/customer/search/{phone}', [CustomerController::class, 'search']);
    Route::get('/product/search/{name}', [ProductController::class, 'search']);

    Route::post('/transaction/store', [TransactionController::class, 'addProductToTrans']);
    Route::get('/product/add', [ProductController::class, 'addProductView']);
    Route::get('/product/edit/{id}', [ProductController::class, 'editProductView']);

    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('transaction', TransactionController::class);
});

Route::group(['middleware' => 'employee'], function () {
    Route::get('/employee/dashboard', [DashboardController::class, 'dashboard']);
});

Route::get('/logout', [LoginController::class, 'logout']);
