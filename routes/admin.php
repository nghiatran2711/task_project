<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('login', [AuthController::class, 'getLogin'])->middleware('guest')->name('admin.login');
Route::post('login', [AuthController::class, 'postLogin'])->middleware('guest')->name('admin.login.handle');
Route::post('logout', [AuthController::class, 'logout'])->middleware('guest')->name('admin.logout');

Route::group(['middleware' => ['adminauth', 'auth:admin'] , 'as' => 'admin.'], function () {
	// echo 'helloooo admin';exit;
	
	// Admin Dashboard
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');	
});