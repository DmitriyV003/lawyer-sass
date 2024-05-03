<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthControllerAlias;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationControllerAlias;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {
    Route::post('/registration', [RegistrationController::class, 'registration']);
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::prefix('/admin')->group(function () {
        Route::post('/registration', [AdminRegistrationControllerAlias::class, 'registration']);
        Route::prefix('auth')->group(function () {
            Route::post('/login', [AdminAuthControllerAlias::class, 'login']);
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::prefix('/auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
        });
        Route::get('/user', [UserController::class, 'user']);
        Route::apiResource('customer', CustomerController::class)
            ->only('index', 'show', 'store', 'destroy', 'update');
        Route::apiResource('case-category', CaseCategoryController::class)
            ->only('index', 'show', 'store', 'destroy', 'update');
    });
});
