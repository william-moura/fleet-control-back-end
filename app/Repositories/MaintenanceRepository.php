<?php

namespace App\Repositories;

use App\DTOs\CreateMaintenanceControlDTO;
use App\Models\MaintenanceControl;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
class MaintenanceRepository implements MaintenanceRepositoryInterface
{
    public function __construct(private MaintenanceControl $model){}
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
            return $query->where('maintenance_control_name', 'like', "%$search%")
                ->orWhere('maintenance_control_description', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createMaintenance(CreateMaintenanceControlDTO $dto): MaintenanceControl
    {
        return DB::transaction(function () use ($dto) {
            $maintenance = $this->model->create($dto->toArray());
            $maintenance->maintenanceRelationServices()->createMany($dto->toMaintenanceServicesArray());
            return $maintenance->load('maintenanceRelationServices');
        });
    }
    public function updateMaintenance(int $id, CreateMaintenanceControlDTO $dto): MaintenanceControl
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroyMaintenance(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showMaintenance(int $id): MaintenanceControl
    {
        return $this->model->with('maintenanceRelationServices')->find($id);
    }

    public function nextMaintenances(): Collection
    {
        return $this->model->where('maintenance_control_next_date', '>=', now())->orderBy('maintenance_control_next_date', 'asc')->take(5)->get();
    }
}