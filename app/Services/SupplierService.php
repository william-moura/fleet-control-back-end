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
    public function index(
        ?int $supplierType = null, 
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): Collection
    {
        return $this->supplierRepository->index($supplierType, $search, $sort, $sortDirection, $page, $perPage);
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