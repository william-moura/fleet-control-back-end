<?php

namespace App\Factories;

use App\Contracts\ReportContract;
use App\Reports\ConsuptionByVehicle;
use App\Reports\TotalCostByVehicle;

class ReportFactory
{
    protected static array $reports = [
        'total_cost' => TotalCostByVehicle::class,
        'consumption_by_vehicle' => ConsuptionByVehicle::class,
    ];
    public static function make(string $id): ReportContract
    {
        if (!isset(self::$reports[$id])) {
            throw new \Exception('Report type not found');
        }
        return new self::$reports[$id];
    }
}