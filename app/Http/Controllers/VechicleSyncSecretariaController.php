<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleSyncSecretariaRequest;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class VechicleSyncSecretariaController extends Controller
{
    public function __construct(protected VehicleService $vehicleService)
    {
    }
    public function addSyncSecretaria(int $vehicleId, VehicleSyncSecretariaRequest $request): JsonResponse
    {
        $this->vehicleService->addSyncSecretaria($vehicleId, $request->input('secretaria_id'));
        return response()->json(['message' => 'Veículo sincronizado com a secretaria com sucesso'], 201);
    }
    public function removeSyncSecretaria(int $vehicleId, int $secretariasId): JsonResponse
    {
        $this->vehicleService->removeSyncSecretaria($vehicleId, $secretariasId);
        return response()->json(['message' => 'Veículo desincronizado com a secretaria com sucesso'], 204);
    }
}