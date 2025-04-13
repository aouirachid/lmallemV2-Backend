<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HandyManController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->group(function () {});

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::middleware(['role:Administrator|cs - dispatch|Manager|Onboarding'])->group(function () {
        Route::resource('admin-panels', AdminPanelController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('services', ServiceController::class);
        Route::post('/services/{id}', [ServiceController::class, 'update']);
    });
    Route::middleware(['role:Administrator'])->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', roleController::class);
        Route::post('roles/{roleId}/give-permissions', [roleController::class, 'addPermissionToRole']);
        Route::get('roles-with-permissions', [RoleController::class, 'getRolesWithPermissions']);
    });
    Route::middleware(['role:cs - dispatch'])->group(function () {});
    Route::middleware(['role:Manager'])->group(function () {});
    Route::middleware(['role:Onboarding'])->group(function () {});
});
Route::resource('clients', ClientController::class);
Route::resource('handy-men', HandyManController::class);
Route::resource('orders', OrderController::class);
Route::post('/handy-men/{id}', [HandyManController::class, 'update']);

