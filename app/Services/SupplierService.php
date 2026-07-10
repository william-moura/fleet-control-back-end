<?php

namespace App\Services;

use App\DTOs\CreateSupplierDTO;
use App\DTOs\SupplierResponseDTO;
use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator;

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
    ): LengthAwarePaginator
    {
        $suppliers = $this->supplierRepository->index($supplierType, $search, $sort, $sortDirection, $page, $perPage);
        return $suppliers->through(fn(Supplier $supplier) => SupplierResponseDTO::fromEntity($supplier));
    }
    public function createSupplier(CreateSupplierDTO $dto): Supplier
    {
        $existingSupplier = $this->supplierRepository->getSupplierByCnpj($dto->supplier_cnpj);
        if ($existingSupplier) {
            throw new HttpResponseException(response()->json(['message' => 'Fornecedor com CNPJ '.$dto->supplier_cnpj.' já cadastrado'], 422));
        }
        return $this->supplierRepository->createSupplier($dto);
    }
    public function updateSupplier(int $id, CreateSupplierDTO $dto): Supplier
    {
        return $this->supplierRepository->updateSupplier($id, $dto);
    }
    public function destroySupplier(int $id): void
    {
        $supplier = $this->supplierRepository->showSupplier($id);
        if ($supplier->fuelSuppliers) {
            throw new HttpResponseException(response()->json(['message' => 'Fornecedor possui abastecimentos cadastrados'], 422));
        }
        if ($supplier->maintenances) {
            throw new HttpResponseException(response()->json(['message' => 'Fornecedor possui manutenções cadastradas'], 422));
        }
        $this->supplierRepository->destroySupplier($id);
    }
    public function showSupplier(int $id): Supplier
    {
        return $this->supplierRepository->showSupplier($id);
    }
}