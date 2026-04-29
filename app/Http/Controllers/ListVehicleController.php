<?php

namespace App\Http\Controllers;

use App\DTOs\VehicleResponseDTO;
use App\Models\Vehicle;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListVehicleController extends Controller
{
    public function __invoke(Request $request, VehicleService $service): JsonResponse
    {
        $vehicles = $service->index(
            $request->search??null,
            $request->sort??null,
            $request->sortDirection??null,
            $request->page??1,
            $request->per_page??5
        );
        return response()->json(
            $vehicles,
            200
        );
    }
}
