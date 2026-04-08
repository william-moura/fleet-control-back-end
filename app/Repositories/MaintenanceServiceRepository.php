<?php

namespace App\Repositories;

use App\DTOs\CreateMaintenanceServiceDTO;
use App\Models\MaintenanceControlService;
use App\Repositories\Contracts\MaintenanceServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MaintenanceServiceRepository implements MaintenanceServiceRepositoryInterface
{
    public function __construct(private MaintenanceControlService $model){}

    public function index(): Collection
    {
        return $this->model->all();
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