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
        return $this->model->with('brand', 'fuelType', 'drivers')->get();
    }

    public function destroyVehicle($id): void
    {
        $this->model->find($id)->delete();
    }

    public function showVehicle($id): Vehicle
    {
        return $this->model->with('brand', 'fuelType')->find($id);
    }

    /**
     * Summary of updateVehicle
     * @param mixed $id
     * @param CreateVehicleDTO $dto
     * @throws \Exception
     * @return Collection<int, Vehicle>|Vehicle|\stdClass
     */
    public function updateVehicle($id, CreateVehicleDTO $dto): Vehicle
    {
        $vehicle = $this->model->find($id);
        if (!$vehicle) {
            throw new \Exception('Vehicle not found');
        }
        $vehicle->update([
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
        return $vehicle;
    }
}