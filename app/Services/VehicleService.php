<?php

namespace App\Services;

use App\DTOs\CreateVehicleDTO;
use App\Models\Vehicle;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VehicleService
{
    public function __construct(protected VehicleRepositoryInterface $vehicleRepository){}
    public function createVehicle(CreateVehicleDTO $dto): Vehicle
    {
        return DB::transaction(function () use ($dto) {
            return $this->vehicleRepository->createVehicle($dto);
        });
    }
    public function index(): Collection
    {
        return $this->vehicleRepository->index();
    }
    public function destroyVehicle($id): void
    {
        $this->vehicleRepository->destroyVehicle($id);
    }

    public function showVehicle($id): Vehicle
    {
        return $this->vehicleRepository->showVehicle($id);
    }

    /**
     * Summary of updateVehicle
     * @param mixed $id
     * @param CreateVehicleDTO $dto
     * @return Collection<int, Vehicle>|Vehicle|\stdClass
     */
    public function updateVehicle($id, CreateVehicleDTO $dto): Vehicle
    {
        return $this->vehicleRepository->updateVehicle($id, $dto);
    }

    public function syncDriver(int $vehicleId, array $driversId): void
    {
        $vehicle = Vehicle::findOrFail($vehicleId);        
        $vehicle->drivers()->attach($driversId);
    }
    public function detachDriver(int $vehicleId, array $driversId): void
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->drivers()->detach($driversId);
    }
    public function showSyncedDrivers(int $vehicleId): Collection
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        return $vehicle->drivers;
    }
}