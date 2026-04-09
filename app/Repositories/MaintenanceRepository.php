<?php

namespace App\Repositories;

use App\DTOs\CreateMaintenanceControlDTO;
use App\Models\MaintenanceControl;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use DB;
use Illuminate\Database\Eloquent\Collection;

class MaintenanceRepository implements MaintenanceRepositoryInterface
{
    public function __construct(private MaintenanceControl $model){}
    public function index(): Collection
    {
        return $this->model->all();
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
}