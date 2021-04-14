<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\Users;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::group(['middleware' => 'auth:api', 'prefix' => 'task'], function () {
    
// });
// Route::get('/', [TaskController::class, 'index']);
// Route::get('/show/{id}', [TaskController::class, 'show']);


// Route::group([
//     'module' => 'Api',
//     'prefix'=>'api/v1',
//     'middleware' => ['jwt.auth'], // thêm middleware jwt.auth để kiểm tra xem token có hợp lệ hay không
//     'namespace' => $namespace
// ], function () {
//     Route::get('/products/decode', 'Products@decode');
//     Route::get('/products', 'Products@index');
//     Route::get('/product/{id}', 'Products@show');
//     Route::post('/product', 'Products@store');
//     Route::put('/product/{id}', 'Products@update');
//     Route::delete('/product/{id}', 'Products@destroy');

// });

Route::group(['middleware' => ['jwt.auth','auth:api'], 'prefix' => 'task'], function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/show/{id}', [TaskController::class, 'show']);
    Route::post('/store',[TaskController::class,'store']);
    Route::put('/update/{id}',[TaskController::class,'update']);
    Route::delete('/delete/{id}',[TaskController::class,'destroy']);
    
});
// Route::group(['middleware' => ['jwt.auth','auth:api'], 'prefix' => 'auth'], function () {
//     Route::post('logout', [Users::class, 'logout']);
// });

// auth/register và auth/login không cần chạy qua middleware nên tách riêng
Route::prefix('auth')->group(function () {
    Route::post('register', [Users::class, 'register']);
    Route::post('login', [Users::class, 'login']);
    Route::post('logout', [Users::class, 'logout']);
});
    