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
        ]);
        dd($request->all());
        $tenant = Tenant::create($request->all());
        $tenant->domains()->create([
            'domain' => $request->domain,
        ]);

        return response()->json([
            'message' => 'Cliente e Banco de Dados criados com sucesso!',
            'tenant' => $tenant
        ], 201);
    }

    public function index(Request $request)
    {
        $tenants = Tenant::paginate(10);
        $tenants = Tenant::when($request->search, function ($query, $search) {
            return $query->where('company_name', 'like', '%' . $search . '%')
                ->orWhere('domain', 'like', '%' . $search . '%')
                ->orWhere('company_id', 'like', '%' . $search . '%');
        })->paginate(10);
        return view('admin.index', [
            'tenants' => $tenants
        ]);
    }

    public function create()
    {
        return view('admin.admin');
    }
    public function edit(int $id)
    {
        $tenant = Tenant::find($id);
        return view('admin.edit', compact('tenant'));
    }
}
