<?php

namespace App\Http\Controllers;

use App\DTOs\CreateFuelSupplierDTO;
use App\DTOs\FuelSupplierResponseDTO;
use App\Http\Requests\StoreFuelSupplierRequest;
use App\Models\FuelSupplier;
use App\Services\FuelSupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FuelSupplierController extends Controller
{
    public function __construct(protected FuelSupplierService $service)
    {
    }
    public function index(): JsonResponse
    {
        $fuelSuppliers = $this->service->index();
        return response()->json(
            $fuelSuppliers->map(fn(FuelSupplier $fuelSupplier) => FuelSupplierResponseDTO::fromEntity($fuelSupplier)),
            200
        );
    }
    public function store(StoreFuelSupplierRequest $request): JsonResponse
    {
        $dto = CreateFuelSupplierDTO::fromRequest($request);
        $fuelSupplier = $this->service->createFuelSupplier($dto);
        return response()->json(
            FuelSupplierResponseDTO::fromEntity($fuelSupplier),
            201
        );
    }
    public function update(StoreFuelSupplierRequest $request, $id): JsonResponse
    {
        $dto = CreateFuelSupplierDTO::fromRequest($request);
        $fuelSupplier = $this->service->updateFuelSupplier($id, $dto);
        return response()->json(
            FuelSupplierResponseDTO::fromEntity($fuelSupplier),
            200
        );
    }
    public function destroy($id): JsonResponse
    {
        $this->service->destroyFuelSupplier($id);
        return response()->json(null, 204);
    }
    public function show($id): JsonResponse
    {
        $fuelSupplier = $this->service->showFuelSupplier($id);
        return response()->json(
            FuelSupplierResponseDTO::fromEntity($fuelSupplier),
            200
        );
    }
}
