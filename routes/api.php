<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CreateVehicleController;
use App\Http\Controllers\DestroyVehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FuelSupplierController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\ListVehicleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MaintenanceServicesController;
use App\Http\Controllers\ShowVehicleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UpdateVehicleController;
use App\Http\Controllers\VechicleSyncDriverController;
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
    Route::get('/', ListVehicleController::class)->name('vehicles.index')->middleware('role:admin|operador|administrador');
    Route::post('/', [CreateVehicleController::class, 'store'])->name('vehicles.create');
    Route::put('/{id}', UpdateVehicleController::class)->name('vehicles.update');
    Route::delete('/{id}', DestroyVehicleController::class)->name('vehicles.destroy');
    Route::get('/brands', [BrandController::class, 'index'])->name('vehicles.brands');
    Route::get('/fuel-types', [FuelTypeController::class, 'index'])->name('vehicles.fuelTypes');
    Route::get('/{id}', ShowVehicleController::class)->name('vehicles.show');
    Route::get('/{id}/synced-drivers', [VechicleSyncDriverController::class, 'showSyncedDrivers']);
    Route::post('/{id}/sync-driver', [VechicleSyncDriverController::class, 'sync']);
    Route::delete('/{id}/detach-driver', [VechicleSyncDriverController::class, 'detach']);
    Route::get('/{id}/drivers', [VechicleSyncDriverController::class, 'showSyncedDrivers']);
})->middleware(['auth:sanctum']);

Route::resource('drivers', DriverController::class)->middleware('auth:sanctum');
Route::resource('fuel-suppliers', FuelSupplierController::class)->middleware('auth:sanctum');
Route::resource('suppliers', SupplierController::class)->middleware('auth:sanctum');
Route::resource('maintenance-controls', MaintenanceController::class)->middleware('auth:sanctum');
Route::resource('maintenance-services', MaintenanceServicesController::class)->middleware('auth:sanctum');
Route::group(['prefix' => 'auth'], function () {
    Route::post('/create-role', [AuthController::class, 'createRole']);
    Route::post('/assign-role', [AuthController::class, 'assignRole']);
    Route::post('/remove-role', [AuthController::class, 'removeRole']);
    Route::get('/roles', [AuthController::class, 'getRoles']);
    Route::get('/permissions', [AuthController::class, 'getPermissions']);
    Route::post('/create-permission', [AuthController::class, 'createPermission']);
    Route::post('/assign-permission', [AuthController::class, 'assignPermission']);
    Route::post('/remove-permission', [AuthController::class, 'removePermission']);
    Route::get('/permissions-for-user', [AuthController::class, 'getPermissionsForUser']);
});