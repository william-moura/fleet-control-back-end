<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenants Cadastrados — Fleet Control</title>
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body, html { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #0f172a; min-height: 100vh; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }
        
        /* Topo da Página */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .page-title h1 { font-size: 1.75rem; font-weight: 700; letter-spacing: -0.025em; color: #0f172a; }
        .page-title p { font-size: 0.875rem; color: #64748b; margin-top: 0.25rem; }
        
        /* Botão Adicionar */
        .btn-primary { display: inline-flex; align-items: center; gap: 0.5rem; background-color: #4f46e5; color: #ffffff; padding: 0.625rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: background-color 0.15s; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .btn-primary:hover { background-color: #4338ca; }
        
        /* Tabela e Card */
        .card { background-color: #ffffff; border-radius: 0.75rem; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; }
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem; }
        
        th { background-color: #f1f5f9; padding: 0.875rem 1.5rem; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
        td { padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f8fafc; }
        
        /* Componentes internos da Tabela */
        .tenant-name { font-weight: 600; color: #0f172a; }
        .tenant-domain { color: #64748b; font-size: 0.813rem; margin-top: 0.125rem; }
        
        /* Badges de Status (Ativo / Expirado) */
        .badge { display: inline-flex; items-center: center; padding: 0.25rem 0.625rem; rounded-radius: 9999px; font-size: 0.75rem; font-weight: 600; border-radius: 50px; }
        .badge-success { background-color: #dcfce7; color: #15803d; }
        .badge-danger { background-color: #fee2e2; color: #b91c1c; }
        
        /* Ações (Editar / Deletar) */
        .actions-cell { display: flex; gap: 0.75rem; }
        .btn-action { display: inline-flex; align-items: center; font-size: 0.875rem; font-weight: 500; text-decoration: none; border: none; background: none; cursor: pointer; }
        .btn-edit { color: #4f46e5; }
        .btn-edit:hover { color: #4338ca; text-decoration: underline; }
        .btn-delete { color: #ef4444; }
        .btn-delete:hover { color: #b91c1c; text-decoration: underline; }
        
        /* Paginação */
        .pagination-container { padding: 1rem 1.5rem; background-color: #ffffff; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; }
        .pagination-info { font-size: 0.875rem; color: #475569; }
        .pagination-nav { display: flex; gap: 0.25rem; }
        .pagination-link { display: inline-flex; align-items: center; justify-content: center; min-width: 2rem; height: 2rem; padding: 0 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem; text-decoration: none; color: #334155; background-color: #ffffff; }
        .pagination-link.active { background-color: #4f46e5; color: #ffffff; border-color: #4f46e5; font-weight: 600; }
        .pagination-link.disabled { color: #94a3b8; border-color: #e2e8f0; cursor: not-allowed; background-color: #f8fafc; }
        
        /* Alertas */
        .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.875rem; border: 1px solid #bbf7d0; background-color: #f0fdf4; color: #166534; }
    </style>
</head>
<body>

    <div class="container">
        
        {{-- Alerta de Sucesso --}}
        @if(session('success'))
            <div class="alert">
                <strong>✓</strong> {{ session('success') }}
            </div>
        @endif

        <!-- Topo da Página -->
        <div class="page-header">
            <div class="page-title">
                <h1>Ambientes (Tenants)</h1>
                <p>Gerencie as empresas e o tempo de expiração das instâncias ativas.</p>
            </div>
            <!-- Botão Adicionar -->
            <a href="/admin/create" class="btn-primary">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Novo Tenant
            </a>
        </div>

        <!-- Estrutura da Tabela -->
        <div class="card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Empresa / Domínio</th>
                            <th>Data de Expiração</th>
                            <th>Status</th>
                            <th style="text-align: right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                            <tr>
                                <td>
                                    <!-- Supondo que 'company_name' ou 'id' guarde o nome. Ajuste conforme suas colunas -->
                                    <div class="tenant-name">{{ $tenant->company_name ?? $tenant->id }}</div>
                                    <!-- Coletando o domínio atrelado ao tenant -->
                                    <div class="tenant-domain">
                                        {{ $tenant->domains->first()->domain ?? $tenant->id . '.fleetcontrol.com' }}
                                    </div>
                                </td>
                                <td>
                                    <!-- Formatação de data nativa do Blade/Carbon -->
                                    {{ $tenant->expires_at ? \Carbon\Carbon::parse($tenant->expires_at)->format('d/m/Y') : 'Ilimitado' }}
                                </td>
                                <td>
                                    <!-- Lógica de Status baseado na data atual -->
                                    @if($tenant->expires_at && \Carbon\Carbon::parse($tenant->expires_at)->isPast())
                                        <span class="badge badge-danger">Expirado</span>
                                    @else
                                        <span class="badge badge-success">Ativo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions-cell" style="justify-content: flex-end;">
                                        <!-- Botão Editar -->
                                        <a href="{{ route('admin.edit', $tenant->id) }}" class="btn-action btn-edit">
                                            Editar
                                        </a>
                                        
                                        <!-- Formulário de Deleção Seguro (Evita ataques CSRF) -->
                                        <form action="{{ route('admin.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este tenant? Todos os dados dele serão apagados permanentemente.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete">
                                                Deletar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748b; padding: 3rem 1.5rem;">
                                    Nenhum tenant cadastrado no momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação Integrada ao Estilo da Página -->
            @if($tenants->hasPages())
                <div class="pagination-container">
                    <div class="pagination-info">
                        Exibindo de <strong>{{ $tenants->firstItem() }}</strong> até <strong>{{ $tenants->lastItem() }}</strong> de um total de <strong>{{ $tenants->total() }}</strong> registros.
                    </div>
                    <div class="pagination-nav">
                        {{-- Link Anterior --}}
                        @if ($tenants->onFirstPage())
                            <span class="pagination-link disabled">&laquo;</span>
                        @else
                            <a href="{{ $tenants->previousPageUrl() }}" class="pagination-link">&laquo;</a>
                        @endif

                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>