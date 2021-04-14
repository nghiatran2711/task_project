<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function(){
	Route::middleware('guest:admin')->group(function(){
		Route::get('login', [AuthController::class, 'getLogin'])->name('login');
		Route::post('login', [AuthController::class, 'postLogin'])->name('login.handle');
		
	});
	Route::middleware('auth:admin')->group(function(){
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');	
		Route::post('logout', [AuthController::class, 'logout'])->name('logout');
	});
	
});
