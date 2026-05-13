<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateKilometerDTO;
use App\Models\Kilometer;
use Illuminate\Pagination\LengthAwarePaginator;

interface KilometerRepositoryInterface
{
    public function storeKilometer(CreateKilometerDTO $dto): Kilometer;
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
}