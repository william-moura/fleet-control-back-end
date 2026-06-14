<?php

namespace App\Repositories;

use App\DTOs\CreateVehicleDTO;
use App\Models\Vehicle;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class VehicleRepository implements VehicleRepositoryInterface
{
    private $model;

    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    public function createVehicle(CreateVehicleDTO $dto): Vehicle
    {
        dd($dto);
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
            'vehicle_chassis_number' => $dto->vehicleChassisNumber,
            'vehicle_renavam_number' => $dto->vehicleRenavamNumber,
            'vehicle_color' => $dto->vehicleColor,
            'vehicle_transmission_type' => $dto->vehicleTransmissionType,
            'vehicle_model_year' => $dto->vehicleModelYear,
        ]);

    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        return $this->model->query()->with(['brand', 'fuelType', 'drivers', 'media', 'maxKilometer', 'fines', 'maintenances', 'fuelSuppliers'])
        ->when($search, function($query) use ($search){
            return $query->where('vehicle_plate', 'like', "%$search%")
                ->orWhere('vehicle_model', 'like', "%$search%")
                ->orWhere('vehicle_year', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }

    public function destroyVehicle($id): void
    {
        $vehicle = $this->model->find($id);
        if (!$vehicle) {
            throw new \Exception('Vehicle not found');
        }
        DB::table('vehicle_relationship_drivers')
        ->where('vehicle_id', $id)        
        ->delete();

        DB::table('fuel_suppliers')
        ->where('vehicle_id', $id)        
        ->delete();        
        $vehicle->media()->delete();
        $vehicle->maxKilometer()->delete();
        $vehicle->delete();
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
    public function count(): int
    {
        return $this->model->where('vehicle_status', 1)->count();
    }
    public function checkVechicleHasRelationship(int $id): bool
    {
        $vehicle = $this->model->where('id', $id)->with(['maintenances', 'fuelSuppliers'])->first();        
        if ($vehicle->maintenances->count() > 0 || $vehicle->fuelSuppliers->count() > 0) {
            return true;
        }
        return false;
    }
}