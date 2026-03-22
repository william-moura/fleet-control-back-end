<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateDriverDTO;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Collection;

interface DriverRepositoryInterface
{
    public function index(): Collection;
    public function createDriver(CreateDriverDTO $dto): Driver;
    public function updateDriver(int $id, CreateDriverDTO $dto): Driver;
    public function destroyDriver(int $id): void;
    public function showDriver(int $id): Driver;
}