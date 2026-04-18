<?php

namespace App\Http\Controllers;

use App\DTOs\CreateSupplierDTO;
use App\DTOs\SupplierResponseDTO;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $service)
    {
    }
    public function index(Request $request): JsonResponse
    {
        $suppliers = $this->service->index(
            $request->supplierType??null,
            $request->search??null,
            $request->sort??null,
            $request->sortDirection??null,
            $request->page??1,
            $request->perPage??5,
        );
        return response()->json($suppliers, 200);
    }
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $dto = CreateSupplierDTO::fromRequest($request);
        $supplier = $this->service->createSupplier($dto);
        return response()->json(
            SupplierResponseDTO::fromEntity($supplier),
            201
        );
    }
    public function update(StoreSupplierRequest $request, $id): JsonResponse
    {
        $dto = CreateSupplierDTO::fromRequest($request);
        $supplier = $this->service->updateSupplier($id, $dto);
        return response()->json(
            SupplierResponseDTO::fromEntity($supplier),
            200
        );
    }
    public function destroy($id): JsonResponse
    {
        $this->service->destroySupplier($id);
        return response()->json(null, 204);
    }
    public function show($id): JsonResponse
    {
        $supplier = $this->service->showSupplier($id);
        return response()->json(
            SupplierResponseDTO::fromEntity($supplier),
            200
        );
    }
    
}
