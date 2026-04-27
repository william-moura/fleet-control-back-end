<?php

namespace App\Providers;

use App\Repositories\BrandRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\DriverRepositoryInterface;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use App\Repositories\Contracts\FuelTypeRepositoryInterface;
use App\Repositories\Contracts\KilometerRepositoryInterface;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use App\Repositories\DriverRepository;
use App\Repositories\FuelSupplierRepository;
use App\Repositories\FuelTypeRepository;
use App\Repositories\KilometerRepository;
use App\Repositories\MaintenanceRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\MaintenanceServiceRepository;
use App\Repositories\Contracts\MaintenanceServiceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(FuelTypeRepositoryInterface::class, FuelTypeRepository::class);
        $this->app->bind(DriverRepositoryInterface::class, DriverRepository::class);
        $this->app->bind(FuelSupplierRepositoryInterface::class, FuelSupplierRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(MaintenanceRepositoryInterface::class, MaintenanceRepository::class);
        $this->app->bind(MaintenanceServiceRepositoryInterface::class, MaintenanceServiceRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(KilometerRepositoryInterface::class, KilometerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
