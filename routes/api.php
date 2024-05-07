<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthControllerAlias;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationControllerAlias;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorityController;
use App\Http\Controllers\LawsuitCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LawsuitController;
use App\Http\Controllers\LawsuitEventCategoryController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TaskTagController;
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
        Route::prefix('/user')->group(function () {
            Route::get('/', [UserController::class, 'user']);
            Route::delete('/', [UserController::class, 'destroy']);
            Route::put('/', [UserController::class, 'update']);
            Route::put('/update-password', [UserController::class, 'updatePassword']);
        });
        Route::apiResource('customer', CustomerController::class)
            ->only('index', 'show', 'store', 'destroy', 'update');
        Route::apiResource('lawsuit-category', LawsuitCategoryController::class)
            ->only('index', 'show', 'store', 'destroy', 'update');
        Route::apiResource('lawsuit', LawsuitController::class)
            ->only('index', 'show', 'store', 'destroy', 'update');
        Route::get('/lawsuit/{lawsuit}/authorities', [LawsuitController::class, 'authorities']);
        Route::apiResource('authority', AuthorityController::class)
            ->only('show', 'store', 'destroy', 'update');
        Route::apiResource('task-tag', TaskTagController::class)
            ->only('index', 'show', 'store', 'destroy', 'update');
        Route::apiResource('lawsuit-event-category', LawsuitEventCategoryController::class)
            ->only('index', 'show', 'store', 'destroy', 'update');
    });
});
