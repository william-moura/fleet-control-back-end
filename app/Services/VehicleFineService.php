<?php

namespace App\Services;

use App\DTOs\CreateVehicleFineDTO;
use App\DTOs\VehicleFineResponseDTO;
use App\Models\VehicleFine;
use App\Repositories\Contracts\VehicleFineRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class VehicleFineService
{
    public function __construct(protected VehicleFineRepositoryInterface $vehicleFineRepository)
    {
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $vehicleFines = $this->vehicleFineRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $vehicleFines->through(fn(VehicleFine $vehicleFine) => VehicleFineResponseDTO::fromEntity($vehicleFine));
    }
    public function createVehicleFine(CreateVehicleFineDTO $dto): VehicleFineResponseDTO
    {
        $vehicleFine = $this->vehicleFineRepository->createVehicleFine($dto);
        return VehicleFineResponseDTO::fromEntity($vehicleFine);
    }
    public function updateVehicleFine(int $id, CreateVehicleFineDTO $dto): VehicleFineResponseDTO
    {
        $vehicleFine = $this->vehicleFineRepository->updateVehicleFine($id, $dto);
        return VehicleFineResponseDTO::fromEntity($vehicleFine);
    }
    public function destroyVehicleFine(int $id): void
    {
        $this->vehicleFineRepository->destroyVehicleFine($id);
    }
    public function showVehicleFine(int $id): VehicleFineResponseDTO
    {
        $vehicleFine = $this->vehicleFineRepository->showVehicleFine($id);
        return VehicleFineResponseDTO::fromEntity($vehicleFine);
    }
}