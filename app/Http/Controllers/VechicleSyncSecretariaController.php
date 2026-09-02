<?php

namespace App\Http\Controllers;

use App\Services\VehicleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class VechicleSyncSecretariaController extends Controller
{
    public function __construct(protected VehicleService $vehicleService)
    {
    }
    public function addSyncSecretaria(int $vehicleId, Request $request): JsonResponse
    {
        $secretariasId = $request->input('secretarias_id');
        $this->vehicleService->addSyncSecretaria($vehicleId, $secretariasId);
        if (!$secretariasId) {
            return response()->json(['message' => 'Secretaria não encontrada'], 404);
        }
        return response()->json(['message' => 'Veículo sincronizado com a secretaria com sucesso'], 201);
    }
    public function removeSyncSecretaria(int $vehicleId, int $secretariasId): JsonResponse
    {
        $this->vehicleService->removeSyncSecretaria($vehicleId, $secretariasId);
        return response()->json(['message' => 'Veículo desincronizado com a secretaria com sucesso'], 204);
    }
}