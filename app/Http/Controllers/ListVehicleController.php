<?php

namespace App\Http\Controllers;

use App\DTOs\VehicleResponseDTO;
use App\Models\Vehicle;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListVehicleController extends Controller
{
    public function __invoke(VehicleService $service): JsonResponse
    {
        $vehicles = $service->index();
        // dd($vehicles);
        return response()->json(
            $vehicles->map(fn(Vehicle $vehicle) => VehicleResponseDTO::fromEntity($vehicle)),
            200
        );
    }
}
