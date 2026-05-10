<?php

namespace App\Http\Controllers;

use App\DTOs\BrandResponseDTO;
use App\DTOs\CreateBrandDTO;
use App\Http\Requests\CreateBrandRequest;
use App\Models\VehicleBrand;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(protected BrandService $service)
    {
    }
    public function index(BrandService $service): JsonResponse
    {
        $brands = $service->index();
        return response()->json(
            $brands->map(fn(VehicleBrand $brand) => BrandResponseDTO::fromEntity($brand)),
            200
        );
    }

    public function store(CreateBrandRequest $request): JsonResponse
    {
        $dto = CreateBrandDTO::fromRequest($request);
        $brand = $this->service->createBrand($dto);
        return response()->json($brand, 201);
    }
    public function show($id): JsonResponse
    {
        $brand = $this->service->showBrand($id);
        return response()->json($brand, 200);
    }
}
