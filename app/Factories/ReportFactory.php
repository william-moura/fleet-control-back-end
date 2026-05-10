<?php

namespace App\Factories;

use App\Contracts\ReportContract;
use App\Reports\ActiveVehicles;
use App\Reports\ConsuptionByVehicle;
use App\Reports\ConsuptionByDriver;
use App\Reports\MonthlyFuelCost;
use App\Reports\TotalCostByVehicle;
use App\Reports\VehicleHigherCost;

class ReportFactory
{
    protected static array $reports = [
        'total_cost' => TotalCostByVehicle::class,
        'consumption_by_vehicle' => ConsuptionByVehicle::class,
        'consumption_by_driver' => ConsuptionByDriver::class,
        'active_vehicles' => ActiveVehicles::class,
        'vehicle_higher_cost' => VehicleHigherCost::class,
        'monthly_fuel_cost' => MonthlyFuelCost::class,
    ];
    public static function make(string $id): ReportContract
    {
        if (!isset(self::$reports[$id])) {
            throw new \Exception('Report type not found');
        }
        return new self::$reports[$id];
    }
}