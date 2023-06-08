<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: *');
// header('Access-Control-Allow-Headers: *');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::controller(\App\Http\Controllers\FrontEnd\AuthController::class)->group(function(){
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::resource('product', \App\Http\Controllers\BackEnd\ProductController::class);
        Route::get('get_category_size_color_list', [\App\Http\Controllers\BackEnd\ProductController::class, 'get_category_size_color_list']);
    });
    Route::middleware('auth:api')->group(function(){
        Route::post('logout', [\App\Http\Controllers\FrontEnd\AuthController::class, 'logout']);
        Route::resource('category', \App\Http\Controllers\BackEnd\CategoryController::class);
        Route::resource('size', \App\Http\Controllers\BackEnd\SizeController::class);
        Route::resource('color', \App\Http\Controllers\BackEnd\ColorController::class);
        // Route::resource('product', \App\Http\Controllers\BackEnd\ProductController::class);
        // Route::get('get_category_size_color_list', [\App\Http\Controllers\BackEnd\ProductController::class, 'get_category_size_color_list']);
    });

    Route::get('login', function(){
        return ('Unauthorized action!');
    });
});
