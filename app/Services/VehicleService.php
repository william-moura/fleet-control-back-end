<?php

namespace App\Services;

use App\DTOs\CreateKilometerDTO;
use App\DTOs\CreateVehicleDTO;
use App\DTOs\KilometerResponseDTO;
use App\DTOs\VehicleResponseDTO;
use App\Models\Kilometer;
use App\Models\Media;
use App\Models\Vehicle;
use App\Repositories\Contracts\KilometerRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VehicleService
{
    public function __construct(protected VehicleRepositoryInterface $vehicleRepository, protected KilometerRepositoryInterface $kilometerRepository){}
    public function createVehicle(CreateVehicleDTO $dto): Vehicle
    {
        return DB::transaction(function () use ($dto) {
            $veiculo = $this->vehicleRepository->createVehicle($dto);
            if (!empty($dto->photosIds)) {
                $medias =Media::whereIn('id', $dto->photosIds)->get();
                $veiculo->media()->saveMany($medias);
            }
            return $veiculo;
        });
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $vehicles = $this->vehicleRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $vehicles->through(fn(Vehicle $vehicle) => VehicleResponseDTO::fromEntity($vehicle));
    }
    public function destroyVehicle($id): void
    {
        $this->vehicleRepository->destroyVehicle($id);
    }

    public function showVehicle(int $id): Vehicle
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
        return DB::transaction(function () use ($id, $dto) {
            $vehicle = $this->vehicleRepository->updateVehicle($id, $dto);
            if (!empty($dto->photosIds)) {
                $medias = Media::whereIn('id', $dto->photosIds)->get();
                $vehicle->media()->saveMany($medias);
            }
            return $vehicle;
        });
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
    public function storeKilometer(CreateKilometerDTO $dto): KilometerResponseDTO
    {
        return DB::transaction(function () use ($dto) {
            $kilometer = $this->kilometerRepository->storeKilometer($dto);
            return KilometerResponseDTO::fromEntity($kilometer);
        });
    }
}