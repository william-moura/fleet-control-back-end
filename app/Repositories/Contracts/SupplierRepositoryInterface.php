<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateSupplierDTO;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;

interface SupplierRepositoryInterface
{
    public function index(
        ?int $supplierType = null,
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): Collection;
    public function createSupplier(CreateSupplierDTO $dto): Supplier;
    public function updateSupplier(int $id, CreateSupplierDTO $dto): Supplier;
    public function destroySupplier(int $id): void;
    public function showSupplier(int $id): Supplier;
}