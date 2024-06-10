<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

 


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class ,'login']);
    Route::post('logout', [AuthController::class ,'logout'] );
    Route::post('refresh', [AuthController::class ,'refresh'] );
    Route::post('me', [AuthController::class ,'me'] );

});





// I used guards to filter unauthenticated and some unauthorized requests,
// and I overrode some routes declared in "Route::apiResource" to avoid verbose code.
  
        Route::group(['middleware' => ['auth:admin']], function () {
        Route::apiResource('admins', AdminController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('attributes', AttributeController::class);
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
    
  
    Route::group(['middleware' => ['multiAuth'],], function ( ) {
        Route::apiResource('users', UserController::class);
        Route::apiResource('carts', CartController::class);
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('admins', [AdminController::class, 'index'])->name('admins.index');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
           
        });

   