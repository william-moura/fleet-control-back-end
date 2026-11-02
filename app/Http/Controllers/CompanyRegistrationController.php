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
        
        $tenant = Tenant::create($request->all());
        $tenant->domains()->create([
            'domain' => $request->domain,
        ]);
        
        return redirect()->route('admin.index')->with('success', 'Cliente e Banco de Dados criados com sucesso!');
    }

    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 10;
        $search = $request->search ?? '';

        $tenants = Tenant::when($search !== '', function ($query, $search) {
            return $query->where('company_name', 'like', '%' . $search . '%')
                ->orWhere('domain', 'like', '%' . $search . '%')
                ->orWhere('company_id', 'like', '%' . $search . '%');
        })->paginate($perPage, ['*'], 'page', $page);
        return view('admin.index', [
            'tenants' => $tenants
        ]);
    }

    public function create()
    {
        return view('admin.admin');
    }
    public function edit(string $id)
    {
        $tenant = Tenant::with('domains')->find($id);
        return view('admin.edit', compact('tenant'));
    }
    public function update(Request $request, string $id)
    {
        $tenant = Tenant::find($id);
        $tenant->update($request->all());
        return redirect()->route('admin.index')->with('success', 'Tenant atualizado com sucesso');
    }
    public function destroy(string $id)
    {
        $tenant = Tenant::find($id);
        $tenant->delete();
        return redirect()->route('admin.index')->with('success', 'Tenant deletado com sucesso');
    }
}
