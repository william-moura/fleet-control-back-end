<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateMaintenanceControlDTO;
use App\Models\MaintenanceControl;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MaintenanceRepositoryInterface
{
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function createMaintenance(CreateMaintenanceControlDTO $dto): MaintenanceControl;
    public function updateMaintenance(int $id, CreateMaintenanceControlDTO $dto): MaintenanceControl;
    public function destroyMaintenance(int $id): void;
    public function showMaintenance(int $id): MaintenanceControl;
    public function nextMaintenances(): Collection;
    public function totalMaintenancesByMonth(): float;
    public function findUpcomingMaintenances(int $kmThreshold = 500, int $daysThreshold = 7): Collection;
}