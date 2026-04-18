<?php

namespace App\Services;

use App\DTOs\CreateDriverDTO;
use App\DTOs\DriverResponseDTO;
use App\Models\Driver;
use App\Repositories\Contracts\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DriverService
{
    public function __construct(protected DriverRepositoryInterface $driverRepository)
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
        $drivers = $this->driverRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $drivers->through(fn(Driver $driver) => DriverResponseDTO::fromEntity($driver));

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