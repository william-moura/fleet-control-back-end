<?php

namespace App\Repositories;

use App\DTOs\CreateSupplierDTO;
use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function __construct(private Supplier $model){}
    public function index(
        ?int $supplierType = null,
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): Collection
    {
        return $this->model->when($supplierType, function($query) use ($supplierType){
            return $query->where('supplier_type', $supplierType);
        })->when($search, function($query) use ($search){
            return $query->where('supplier_fantasy_name', 'like', "%$search%")
                ->orWhere('supplier_corporate_name', 'like', "%$search%")
                ->orWhere('supplier_cnpj', 'like', "%$search%")
                ->orWhere('supplier_ie', 'like', "%$search%")
                ->orWhere('supplier_address', 'like', "%$search%")
                ->orWhere('supplier_number', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->get();
    }
    public function createSupplier(CreateSupplierDTO $dto): Supplier
    {
        return $this->model->create($dto->toArray());
    }
    public function updateSupplier(int $id, CreateSupplierDTO $dto): Supplier
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroySupplier(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showSupplier(int $id): Supplier
    {
        return $this->model->find($id);
    }
}