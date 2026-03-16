<?php

namespace App\Http\Controllers;

use App\DTOs\BrandResponseDTO;
use App\Models\VehicleBrand;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(BrandService $service): JsonResponse
    {
        $brands = $service->index();
        return response()->json(
            $brands->map(fn(VehicleBrand $brand) => BrandResponseDTO::fromEntity($brand)),
            200
        );
    }
}
