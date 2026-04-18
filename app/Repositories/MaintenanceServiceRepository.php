<?php

namespace App\Repositories;

use App\DTOs\CreateMaintenanceServiceDTO;
use App\Models\MaintenanceControlService;
use App\Repositories\Contracts\MaintenanceServiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MaintenanceServiceRepository implements MaintenanceServiceRepositoryInterface
{
    public function __construct(private MaintenanceControlService $model){}

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
            return $query->where('maintenance_control_service_name', 'like', "%$search%")
                ->orWhere('maintenance_service_description', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createMaintenanceService(CreateMaintenanceServiceDTO $dto): MaintenanceControlService
    {
        return $this->model->create($dto->toArray());
    }
    public function updateMaintenanceService(int $id, CreateMaintenanceServiceDTO $dto): MaintenanceControlService
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroyMaintenanceService(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showMaintenanceService(int $id): MaintenanceControlService
    {
        return $this->model->find($id);
    }
}