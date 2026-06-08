<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CreateVehicleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestroyVehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FuelSupplierController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\KilometerController;
use App\Http\Controllers\ListVehicleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MaintenanceServicesController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShowVehicleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UpdateVehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VechicleSyncDriverController;
use App\Http\Controllers\VehicleFineController;
use App\Http\Controllers\VehicleHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/dashboard', DashboardController::class)->middleware(['auth:sanctum', 'permission:acessar_dashboards']);
Route::middleware(['auth:sanctum'])->prefix('vehicles')->group(function () {
    Route::get('/', ListVehicleController::class)->middleware(['permission:listar_veiculos']);
    Route::post('/', [CreateVehicleController::class, 'store'])->name('vehicles.create')->middleware(['permission:adicionar_veiculo']);
    Route::put('/{id}', UpdateVehicleController::class)->name('vehicles.update')->middleware(['permission:editar_veiculo']);
    Route::delete('/{id}', DestroyVehicleController::class)->name('vehicles.destroy')->middleware(['permission:excluir_veiculo']);    
    Route::resource('brands', BrandController::class);
    Route::get('/fuel-types', [FuelTypeController::class, 'index'])->name('vehicles.fuelTypes');
    Route::get('/{id}', ShowVehicleController::class)->name('vehicles.show');
    Route::get('/{id}/synced-drivers', [VechicleSyncDriverController::class, 'showSyncedDrivers']);
    Route::post('/{id}/sync-driver', [VechicleSyncDriverController::class, 'sync']);
    Route::delete('/{id}/detach-driver', [VechicleSyncDriverController::class, 'detach']);
    Route::get('/{id}/drivers', [VechicleSyncDriverController::class, 'showSyncedDrivers']);
    Route::get('/{id}/history', VehicleHistoryController::class);
    Route::post('/{id}/kilometers', [KilometerController::class, 'store']);
});

Route::resource('kilometers', KilometerController::class)->middleware(['auth:sanctum', 'permission:listar_quilometragem']);
Route::resource('drivers', DriverController::class)->middleware(['auth:sanctum', 'permission:listar_motoristas']);
Route::resource('fuel-suppliers', FuelSupplierController::class)->middleware(['auth:sanctum', 'permission:listar_abastecimento']);
Route::resource('suppliers', SupplierController::class)->middleware(['auth:sanctum', 'permission:listar_fornecedores']);
Route::resource('maintenance-controls', MaintenanceController::class)->middleware(['auth:sanctum', 'permission:listar_manutencoes']);
Route::resource('maintenance-services', MaintenanceServicesController::class)->middleware(['auth:sanctum']);
Route::middleware(['auth:sanctum'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware(['permission:listar_usuarios']);
    Route::post('/', [UserController::class, 'create'])->middleware(['permission:adicionar_usuarios']);
    Route::put('/{id}', [AuthController::class, 'updateUser'])->middleware(['permission:editar_usuarios']);
    Route::delete('/{id}', [AuthController::class, 'deleteUser'])->middleware(['permission:excluir_usuarios']);
    Route::get('/{id}', [AuthController::class, 'getUser'])->middleware(['permission:visualizar_usuarios']);
    Route::get('/{id}/roles', [AuthController::class, 'getUserRoles']);
    Route::get('/{id}/permissions', [AuthController::class, 'getUserPermissions']);
    Route::post('/assign-role', [AuthController::class, 'assignRole']);
    Route::post('/{id}/remove-role', [AuthController::class, 'removeRoleFromUser']);
    Route::post('/{id}/assign-permission', [AuthController::class, 'assignPermissionToUser']);
    Route::post('/{id}/remove-permission', [AuthController::class, 'removePermissionFromUser']);
    // Route::get('/roles', [AuthController::class, 'getRoles']);
    Route::get('/permissions', [AuthController::class, 'getPermissions']);
    Route::put('/{id}/password', [AuthController::class, 'updatePassword']);
});
Route::post('/assign-permissions-to-role', [AuthController::class, 'assignPermissionsToRole']);
Route::post('/upload', [MediaController::class, 'upload']);
Route::delete('/upload/{id}', [MediaController::class, 'destroy']);
Route::get('/reports/{id}', [ReportController::class, 'generateReport']);
Route::get('/reports/{id}/pdf', [ReportController::class, 'generatePdfReport']);
Route::get('/reports/{id}/excel', [ReportController::class, 'generateExcelReport']);
Route::resource('vehicle-fines', VehicleFineController::class)->middleware(['auth:sanctum', 'permission:listar_multas_veiculos']);
Route::post('/assign-role', [AuthController::class, 'assignRole']);
Route::middleware(['auth:sanctum'])->prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('/all-permissions', [AuthController::class, 'getPermissions']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
    Route::post('/assign-permission', [RoleController::class, 'assignPermissionToRole']);
    Route::post('/remove-permission', [RoleController::class, 'removePermissionFromRole']);
    Route::get('/permissions', [RoleController::class, 'getPermissionsForRole']);
    Route::post('/permissions', [AuthController::class, 'createPermission']);
});

