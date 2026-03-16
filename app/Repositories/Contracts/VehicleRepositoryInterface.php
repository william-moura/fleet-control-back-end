<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateVehicleDTO;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

interface VehicleRepositoryInterface
{
    public function createVehicle(CreateVehicleDTO $to): Vehicle;
    public function index(): Collection;
}