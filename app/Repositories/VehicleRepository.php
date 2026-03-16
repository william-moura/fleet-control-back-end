<?php

namespace App\Repositories;

use App\DTOs\CreateVehicleDTO;
use App\Models\Vehicle;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class VehicleRepository implements VehicleRepositoryInterface
{
    private $model;

    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    public function createVehicle(CreateVehicleDTO $dto): Vehicle
    {
        return $this->model->create([
            'vehicle_plate' => $dto->vehiclePlate,
            'brand_id' => $dto->brandId,
            'vehicle_model' => $dto->vehicleModel,
            'vehicle_year' => $dto->vehicleYear,
            'fuel_type_id' => $dto->fuelTypeId,
            'vehicle_tank_capacity' => $dto->vehicleTankCapacity,
            'vehicle_current_mileage' => $dto->vehicleCurrentMileage,
            'vehicle_status' => $dto->vehicleStatus,
            'vehicle_purchase_date' => $dto->vehiclePurchaseDate,
            'vehicle_notes' => $dto->vehicleNotes,
        ]);

    }
    public function index(): Collection
    {
        return $this->model->all();
    }
}