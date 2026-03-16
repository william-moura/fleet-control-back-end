<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CreateVehicleController;
use App\Http\Controllers\FuelTypeController;
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
Route::group(['prefix' => 'vehicles'], function () {
    Route::get('/', [CreateVehicleController::class, 'index'])->name('vehicles.index');
    Route::post('/', [CreateVehicleController::class, 'store'])->name('vehicles.create');
    Route::put('/{id}', [CreateVehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/{id}', [CreateVehicleController::class, 'destroy'])->name('vehicles.destroy');
    Route::get('/brands', [BrandController::class, 'index'])->name('vehicles.brands');
    Route::get('/fuel-types', [FuelTypeController::class, 'index'])->name('vehicles.fuelTypes');
    Route::get('/{id}', [CreateVehicleController::class, 'show'])->name('vehicles.show');
})->middleware('auth:sanctum');