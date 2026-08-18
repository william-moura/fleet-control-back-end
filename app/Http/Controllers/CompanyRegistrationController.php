<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class CompanyRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'domain' => 'required|string',
            'company_id' => 'required|string|max:255|unique:tenants,id',
        ]);

        $tenant = Tenant::create($request->all());
        $tenant->domains()->create([
            'domain' => $request->domain,
        ]);

        return response()->json([
            'message' => 'Cliente e Banco de Dados criados com sucesso!',
            'tenant' => $tenant
        ], 201);
    }
}
