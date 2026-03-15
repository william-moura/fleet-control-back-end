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
}