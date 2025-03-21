<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard']);
    Route::get('/category/all', [App\Http\Controllers\CategoryController::class, 'getAll']);
    Route::get('/product/all', [App\Http\Controllers\ProductController::class, 'getAll']);
    Route::get('/product/add', [App\Http\Controllers\ProductController::class, 'addProductView']);
    Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'editProductView']);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
});

Route::group(['middleware' => 'employee'], function () {
    Route::get('/employee/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard']);
});

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
