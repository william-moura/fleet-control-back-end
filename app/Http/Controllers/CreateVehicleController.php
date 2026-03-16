<?php

namespace App\Http\Controllers;

use App\DTOs\CreateVehicleDTO;
use App\DTOs\VehicleResponseDTO;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;

class CreateVehicleController extends Controller
{
    public function store(StoreVehicleRequest $request, VehicleService $service)
    {
        // 1. O Request já validou os dados automaticamente aqui
        // 2. Criamos o DTO a partir do Request
        $dto = CreateVehicleDTO::fromRequest($request);

        // 3. O Service processa a criação e retorna uma Model ou o DTO de Resposta
        $vehicle = $service->createVehicle($dto);

        return response()->json(
            VehicleResponseDTO::fromEntity($vehicle), 
            201
        );
    }
    public function index(VehicleService $service): JsonResponse
    {
        $vehicles = $service->index();
        return response()->json(
            $vehicles->map(fn(Vehicle $vehicle) => VehicleResponseDTO::fromEntity($vehicle)),
            200
        );
    }
}
