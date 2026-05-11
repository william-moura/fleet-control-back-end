<?php

namespace App\Http\Controllers;

use App\DTOs\CreateVehicleFineDTO;
use App\DTOs\VehicleFineResponseDTO;
use App\Http\Requests\VehicleFineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleFineController extends Controller
{
    public function __construct(protected VehicleFineService $vehicleFineService)
    {
    }
    public function index(Request $request): JsonResponse
    {
        $vehicleFines = $this->vehicleFineService->index($request);
        return response()->json($vehicleFines, 200);
    }

    public function store(VehicleFineRequest $request): JsonResponse
    {
        $dto = CreateVehicleFineDTO::fromRequest($request);
        $vehicleFine = $this->vehicleFineService->createVehicleFine($dto);
        return response()->json(
            VehicleFineResponseDTO::fromEntity($vehicleFine),
            201
        );
    }

    public function show($id): JsonResponse
    {
        $vehicleFine = $this->vehicleFineService->showVehicleFine($id);
        return response()->json(
            VehicleFineResponseDTO::fromEntity($vehicleFine),
            200
        );
    }
    
    public function update(VehicleFineRequest $request, $id): JsonResponse
    {
        $dto = CreateVehicleFineDTO::fromRequest($request);
        $vehicleFine = $this->vehicleFineService->updateVehicleFine($id, $dto);
        return response()->json(
            VehicleFineResponseDTO::fromEntity($vehicleFine),
            200
        );
    }

    public function destroy($id): JsonResponse
    {
        $this->vehicleFineService->destroyVehicleFine($id);
        return response()->json(null, 204);
    }
}
