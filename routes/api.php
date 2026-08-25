<?php

use App\Http\Controllers\AlertSettingsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CompanyRegistrationController;
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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrgaoController;
use App\Http\Controllers\PrefeituraController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\ShowVehicleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UpdateVehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VechicleSyncDriverController;
use App\Http\Controllers\VehicleFineController;
use App\Http\Controllers\VehicleHistoryController;
use App\Http\Controllers\VehicleNotificationController;
use App\Http\Controllers\ViagemController;
use App\Jobs\SendNotificationDue;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register-company', [CompanyRegistrationController::class, 'register'])->name('register-company');