<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CreateVehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', function() {
    echo 'ok';
});
Route::post('/vehicles', [CreateVehicleController::class, 'create'])->name('vehicles.create')->middleware('auth:sanctum');
Route::get('/vehicles', [CreateVehicleController::class, 'index'])->name('vehicles.index')->middleware('auth:sanctum');