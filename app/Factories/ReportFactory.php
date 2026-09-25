<?php

namespace App\Factories;

use App\Contracts\ReportContract;
use App\Reports\ActiveVehicles;
use App\Reports\ConsuptionByVehicle;
use App\Reports\ConsuptionByDriver;
use App\Reports\DriverGeneralReport;
use App\Reports\MonthlyFuelCost;
use App\Reports\TotalCostByVehicle;
use App\Reports\VehicleHigherCost;
use App\Reports\DriverWithFineVehicles;
use App\Reports\VehiclesTravels;
use App\Reports\ConsumptionGeneralReport;
use App\Reports\VehicleMaintenanceReport;

class ReportFactory
{
    protected static array $reports = [
        'total_cost' => TotalCostByVehicle::class,
        'consumption_by_vehicle' => ConsuptionByVehicle::class,
        'consumption_by_driver' => ConsuptionByDriver::class,
        'active_vehicles' => ActiveVehicles::class,
        'vehicle_higher_cost' => VehicleHigherCost::class,
        'monthly_fuel_cost' => MonthlyFuelCost::class,
        'driver_with_fine_vehicles' => DriverWithFineVehicles::class,
        'driver_general_report' => DriverGeneralReport::class,
        'vehicles_travels' => VehiclesTravels::class,
        'usage-report' => VehiclesTravels::class,
        'consumption_general_report' => ConsumptionGeneralReport::class,
        'vehicle_maintenance_report' => VehicleMaintenanceReport::class,
    ];
    public static function make(string $id): ReportContract
    {
        if (!isset(self::$reports[$id])) {
            throw new \Exception('Report type not found');
        }
        return new self::$reports[$id];
    }
}