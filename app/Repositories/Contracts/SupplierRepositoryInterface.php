<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateSupplierDTO;
use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierRepositoryInterface
{
    public function index(
        ?int $supplierType = null,
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function createSupplier(CreateSupplierDTO $dto): Supplier;
    public function updateSupplier(int $id, CreateSupplierDTO $dto): Supplier;
    public function destroySupplier(int $id): void;
    public function showSupplier(int $id): Supplier;
}