<?php

namespace App\Http\Controllers;

use App\DTOs\CreateMaintenanceServiceDTO;
use App\DTOs\MaintenanceServiceResponseDTO;
use App\Http\Requests\StoreMaintenanceServiceRequest;
use App\Models\MaintenanceControlService;
use App\Services\MaintenanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaintenanceServicesController extends Controller
{
    public function __construct(protected MaintenanceService $service)
    {
    }
    public function index(): JsonResponse
    {
        $maintenanceServices = $this->service->indexMaintenanceServices();
        return response()->json(
            $maintenanceServices->map(fn(MaintenanceControlService $maintenanceService) => MaintenanceServiceResponseDTO::fromEntity($maintenanceService)),
            200
        );
    }
    public function store(StoreMaintenanceServiceRequest $request): JsonResponse
    {
        $dto = CreateMaintenanceServiceDTO::fromRequest($request);
        $maintenanceService = $this->service->createMaintenanceService($dto);
        return response()->json(
            MaintenanceServiceResponseDTO::fromEntity($maintenanceService),
            201
        );
    }

    public function update(StoreMaintenanceServiceRequest $request, $id): JsonResponse
    {
        $dto = CreateMaintenanceServiceDTO::fromRequest($request);
        $maintenanceService = $this->service->updateMaintenanceService($id, $dto);
        return response()->json(
            MaintenanceServiceResponseDTO::fromEntity($maintenanceService),
            200
        );
    }
    public function destroy($id): JsonResponse
    {
        $this->service->destroyMaintenanceService($id);
        return response()->json(null, 204);
    }
    public function show($id): JsonResponse
    {
        $maintenanceService = $this->service->showMaintenanceService($id);
        return response()->json(
            MaintenanceServiceResponseDTO::fromEntity($maintenanceService),
            200
        );
    }
}
