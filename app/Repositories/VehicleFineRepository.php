<?php

namespace App\Repositories;

use App\DTOs\CreateVehicleFineDTO;
use App\Models\VehicleFine;
use App\Repositories\Contracts\VehicleFineRepositoryInterface;
use App\VehicleFineStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class VehicleFineRepository implements VehicleFineRepositoryInterface
{
    public function __construct(private VehicleFine $model)
    {
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        return $this->model->query()->with('vehicle', 'driver')->when( $search, function($query) use ($search){
            return $query->where('vehicle_fine_amount', 'like', "%$search%")
                ->orWhere('vehicle_fine_date', 'like', "%$search%")
                ->orWhere('vehicle_fine_level', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createVehicleFine(CreateVehicleFineDTO $dto): VehicleFine
    {
        return $this->model->create($dto->toArray());
    }
    public function updateVehicleFine(int $id, CreateVehicleFineDTO $dto): VehicleFine
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroyVehicleFine(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showVehicleFine(int $id): VehicleFine
    {
        return $this->model->find($id);
    }
    public function totalFinesByMonth(): float
    {
        return $this->model->whereYear('vehicle_fine_date', Carbon::now()->year)->whereMonth('vehicle_fine_date', Carbon::now()->month)->sum('vehicle_fine_amount');
    }
    public function nextFinesToPay(): Collection
    {
        return $this->model
            ->with(['vehicle', 'driver'])
            ->where('vehicle_fine_paid_date', '>=', now())
            ->where('vehicle_fine_status', VehicleFineStatusEnum::PENDING)
            ->orderBy('vehicle_fine_date', 'asc')
            ->take(5)
            ->get();
    }
}