<?php

namespace App\Http\Controllers;

use App\DTOs\CreateMaintenanceControlDTO;
use App\DTOs\MaintenanceResponseDTO;
use App\Http\Requests\StoreMaintenanceControlRequest;
use App\Models\MaintenanceControl;
use App\Services\MaintenanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct(protected MaintenanceService $service)
    {
    }
    public function index(Request $request): JsonResponse
    {
        $maintenances = $this->service->index(
            $request->search??null,
            $request->sort??null,
            $request->sortDirection??null,
            $request->page??1,
            $request->per_page??5
        );
        return response()->json(
            $maintenances,
            200
        );
    }
    public function store(StoreMaintenanceControlRequest $request): JsonResponse
    {
        $dto = CreateMaintenanceControlDTO::fromRequest($request);
        $maintenance = $this->service->createMaintenanceControl($dto);
        return response()->json(
            MaintenanceResponseDTO::fromEntity($maintenance),
            201
        );
    }
    public function show($id): JsonResponse
    {
        $maintenance = $this->service->showMaintenanceControl($id);
        return response()->json(
            MaintenanceResponseDTO::fromEntity($maintenance),
            200
        );
    }

    public function update(StoreMaintenanceControlRequest $request, $id): JsonResponse
    {
        $dto = CreateMaintenanceControlDTO::fromRequest($request);
        $maintenance = $this->service->updateMaintenanceControl($id, $dto);
        return response()->json(
            MaintenanceResponseDTO::fromEntity($maintenance),
            200
        );
    }
    public function destroy($id): JsonResponse
    {
        $this->service->destroyMaintenanceControl($id);
        return response()->json(null, 204);
    }
}
