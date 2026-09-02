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
        $secretariasId = $request->input('secretaria_id');
        if (!$secretariasId) {
            return response()->json(['message' => 'Secretaria não informada'], 400);
        }
        $this->vehicleService->addSyncSecretaria($vehicleId, (int) $secretariasId);
        return response()->json(['message' => 'Veículo sincronizado com a secretaria com sucesso'], 201);
    }
    public function removeSyncSecretaria(int $vehicleId, int $secretariasId): JsonResponse
    {
        $this->vehicleService->removeSyncSecretaria($vehicleId, $secretariasId);
        return response()->json(['message' => 'Veículo desincronizado com a secretaria com sucesso'], 204);
    }
}