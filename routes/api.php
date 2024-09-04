<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\ServiceController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('permissions',PermissionController::class);
Route::resource('roles',roleController::class);
Route::post('roles/{roleId}/give-permissions',[roleController::class,'addPermissionToRole']);
Route::resource('categories',CategoryController::class);
Route::resource('services',ServiceController::class);
Route::post('/services/{id}',[ServiceController::class,'update']);

