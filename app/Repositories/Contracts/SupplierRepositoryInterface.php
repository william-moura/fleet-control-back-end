<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateSupplierDTO;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;

interface SupplierRepositoryInterface
{
    public function index(int $supplierType = 1): Collection;
    public function createSupplier(CreateSupplierDTO $dto): Supplier;
    public function updateSupplier(int $id, CreateSupplierDTO $dto): Supplier;
    public function destroySupplier(int $id): void;
    public function showSupplier(int $id): Supplier;
}