<?php

namespace App\Services;

use App\DTOs\CreateSupplierDTO;
use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SupplierService
{
    public function __construct(protected SupplierRepositoryInterface $supplierRepository)
    {
    }
    public function index(?int $supplierType = null): Collection
    {
        return $this->supplierRepository->index($supplierType);
    }
    public function createSupplier(CreateSupplierDTO $dto): Supplier
    {
        return $this->supplierRepository->createSupplier($dto);
    }
    public function updateSupplier(int $id, CreateSupplierDTO $dto): Supplier
    {
        return $this->supplierRepository->updateSupplier($id, $dto);
    }
    public function destroySupplier(int $id): void
    {
        $this->supplierRepository->destroySupplier($id);
    }
    public function showSupplier(int $id): Supplier
    {
        return $this->supplierRepository->showSupplier($id);
    }
}