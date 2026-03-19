<?php

namespace App\Http\Controllers;

use App\DTOs\VehicleResponseDTO;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowVehicleController extends Controller
{
    public function __invoke($id, VehicleService $service): JsonResponse
    {
        $vehicle = $service->showVehicle($id);
        return response()->json(
            VehicleResponseDTO::fromEntity($vehicle),
            200
        );
    }
}
