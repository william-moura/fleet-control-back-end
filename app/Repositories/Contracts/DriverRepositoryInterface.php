<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateDriverDTO;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DriverRepositoryInterface
{
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function createDriver(CreateDriverDTO $dto): Driver;
    public function updateDriver(int $id, CreateDriverDTO $dto): Driver;
    public function destroyDriver(int $id): void;
    public function showDriver(int $id): Driver;
}