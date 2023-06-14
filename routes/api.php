<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){

    Route::controller(AuthController::class)->group(function(){

        Route::get('login', 'unauthenticate')->name('login');

        Route::post('login', 'login');

        Route::post('register', 'register');

        Route::post('password-reset-email', 'sendPasswordResetLink');

        Route::post('password-update', 'updatePassword');

        Route::middleware('auth:api')->group(function(){

            Route::post('update-profile/{id}', 'updateProfile');

            Route::post('logout', 'logout');

            Route::apiResource('product', ProductController::class)->except(['create', 'edit']);

        });

    });

});