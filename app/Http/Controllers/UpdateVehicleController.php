<?php

namespace App\Http\Controllers;

use App\DTOs\CreateVehicleDTO;
use App\DTOs\VehicleResponseDTO;
use App\Http\Requests\StoreVehicleRequest;
use App\Services\VehicleService;
use Illuminate\Http\Request;

class UpdateVehicleController extends Controller
{
    /**
     * Summary of __invoke
     * @param mixed $id
     * @param StoreVehicleRequest $request
     * @param VehicleService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke($id, StoreVehicleRequest $request, VehicleService $service)
    {
        $dto = CreateVehicleDTO::fromRequest($request);
        $vehicle = $service->updateVehicle($id, $dto);
        return response()->json(
            VehicleResponseDTO::fromEntity($vehicle),
            200
        );
    }
}
