<?php

namespace App\Services;

use App\DTOs\CreateDriverDTO;
use App\Models\Driver;
use App\Repositories\Contracts\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DriverService
{
    public function __construct(protected DriverRepositoryInterface $driverRepository)
    {
    }
    public function index(): Collection
    {
        return $this->driverRepository->index();
    }
    public function createDriver(CreateDriverDTO $dto): Driver
    {
        return $this->driverRepository->createDriver($dto);
    }
    public function updateDriver(int $id, CreateDriverDTO $dto): Driver
    {
        return $this->driverRepository->updateDriver($id, $dto);
    }
    public function destroyDriver(int $id): void
    {
        $this->driverRepository->destroyDriver($id);
    }
    public function showDriver(int $id): Driver
    {
        return $this->driverRepository->showDriver($id);
    }
}