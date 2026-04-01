<?php

namespace App\Providers;

use App\Repositories\BrandRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\DriverRepositoryInterface;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use App\Repositories\Contracts\FuelTypeRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use App\Repositories\DriverRepository;
use App\Repositories\FuelSupplierRepository;
use App\Repositories\FuelTypeRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\VehicleRepository;
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
