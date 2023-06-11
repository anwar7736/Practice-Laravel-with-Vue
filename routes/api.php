<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){

    Route::controller(AuthController::class)->group(function(){

        Route::get('login', 'unauthenticate')->name('login');

        Route::post('login', 'login');

        Route::post('register', 'register');

        Route::middleware('auth:api')->group(function(){

            Route::post('update-profile/{id}', 'updateProfile');

            Route::post('logout', 'logout');

        });

    });

});