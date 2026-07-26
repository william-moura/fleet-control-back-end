<?php

namespace App\Http\Controllers;

use App\DTOs\CreatePrefeituraDTO;
use App\Services\PrefeituraService;
use Illuminate\Http\Request;

class PrefeituraController extends Controller
{    

    public function __construct(private PrefeituraService $prefeituraService)
    {
        $this->prefeituraService = $prefeituraService;
    }

    public function createPrefeitura(Request $request)
    {
        return $this->prefeituraService->createPrefeitura(CreatePrefeituraDTO::fromRequest($request));
    }
}
