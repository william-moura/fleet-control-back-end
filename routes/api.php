<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CreateVehicleController;
use App\Http\Controllers\DestroyVehicleController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\ListVehicleController;
use App\Http\Controllers\ShowVehicleController;
use App\Http\Controllers\UpdateVehicleController;
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
    Route::get('/', ListVehicleController::class)->name('vehicles.index');
    Route::post('/', [CreateVehicleController::class, 'store'])->name('vehicles.create');
    Route::put('/{id}', UpdateVehicleController::class)->name('vehicles.update');
    Route::delete('/{id}', DestroyVehicleController::class)->name('vehicles.destroy');
    Route::get('/brands', [BrandController::class, 'index'])->name('vehicles.brands');
    Route::get('/fuel-types', [FuelTypeController::class, 'index'])->name('vehicles.fuelTypes');
    Route::get('/{id}', ShowVehicleController::class)->name('vehicles.show');
})->middleware('auth:sanctum');