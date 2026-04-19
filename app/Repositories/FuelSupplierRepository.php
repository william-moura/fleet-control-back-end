<?php

namespace App\Repositories;

use App\DTOs\CreateFuelSupplierDTO;
use App\Models\FuelSupplier;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FuelSupplierRepository implements FuelSupplierRepositoryInterface
{
    public function __construct(private FuelSupplier $model){}
    public function index(
        ?string $search = null,
            ?string $sort = null,
            ?string $sortDirection = null,
            ?int $page = 1,
            ?int $perPage = 5
        ): LengthAwarePaginator
    {
        return $this->model->query()
        ->when($search, function($query) use ($search){
            return $query->where('fuel_supplier_name', 'like', "%$search%")
                ->orWhere('fuel_supplier_cnpj', 'like', "%$search%")
                ->orWhere('fuel_supplier_ie', 'like', "%$search%")
                ->orWhere('fuel_supplier_address', 'like', "%$search%")
                ->orWhere('fuel_supplier_number', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createFuelSupplier(CreateFuelSupplierDTO $dto): FuelSupplier
    {
        return $this->model->create($dto->toArray());
    }
    public function updateFuelSupplier(int $id, CreateFuelSupplierDTO $dto): ?FuelSupplier
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroyFuelSupplier(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showFuelSupplier(int $id): FuelSupplier
    {
        return $this->model->find($id);
    }

    public function lastsFuelSuppliers(): Collection
    {
        return $this->model->orderBy('fuel_supplier_date', 'desc')->take(5)->get();
    }
    public function totalFuelSuppliers(): float
    {
        return $this->model->sum('fuel_supplier_total');
    }
    public function totalFuelSuppliersByMonth(): float
    {
        return $this->model->whereMonth('fuel_supplier_date', now()->month)->sum('fuel_supplier_total');
    }
}