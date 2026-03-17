<?php

namespace App\Http\Controllers;

use App\DTOs\FuelTypeResponseDTO;
use App\Models\FuelType;
use App\Services\FuelTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FuelTypeController extends Controller
{
    public function index(FuelTypeService $service): JsonResponse
    {
        $fuelTypes = $service->index();
        return response()->json(
            $fuelTypes->map(fn(FuelType $fuelType) => FuelTypeResponseDTO::fromEntity($fuelType)),
            200
        );
    }
}
