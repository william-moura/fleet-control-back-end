<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Central — Fleet Control</title>
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Nativo Embutido Avançado -->
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body, html { height: 100%; font-family: 'Inter', sans-serif; background-color: #ffffff; color: #0f172a; }
        
        .flex-container { display: flex; min-height: 100vh; }
        
        /* Lado Esquerdo: Painel de Informações */
        .left-side { 
            position: relative; 
            display: none; 
            flex: 1; 
            background: linear-gradient(135deg, #1e1b4b 0%, #020617 50%, #022c22 100%);
            padding: 3rem;
            color: #ffffff;
            flex-direction: column;
            justify-content: space-between;
        }
        @media (min-width: 1024px) { .left-side { display: flex; } }
        
        /* Grid de fundo sutil */
        .left-side::before {
            content: ""; position: absolute; inset: 0;
            background-image: linear-gradient(to right, rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 32px 32px; pointer-events: none;
        }

        .logo-area { display: flex; items-center: center; gap: 0.5rem; font-weight: 700; font-size: 1.25rem; z-index: 10; }
        .logo-highlight { color: #818cf8; }
        .badge-central { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; background: rgba(99, 102, 241, 0.2); color: #a5b4fc; padding: 0.125rem 0.5rem; border-radius: 4px; margin-left: 0.5rem; }
        .intro-text { max-width: 28rem; margin-bottom: 4rem; z-index: 10; }
        .intro-text h1 { font-size: 2.25rem; font-weight: 700; line-height: 1.2; margin-bottom: 1rem; tracking: -0.025em; }
        .intro-text p { color: #94a3b8; line-height: 1.6; }
        .footer-left { color: #475569; font-size: 0.875rem; z-index: 10; }

        /* Lado Direito: Formulário */
        .right-side { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 3rem 1.5rem; background-color: #f8fafc; }
        @media (min-width: 1024px) { .right-side { flex: none; width: 480px; padding: 3rem 4rem; } }
        
        .form-container { width: 100%; max-width: 24rem; margin: 0 auto; }
        .header-form h2 { font-size: 1.5rem; font-weight: 700; letter-spacing: -0.025em; color: #0f172a; }
        .header-form p { margin-top: 0.5rem; font-size: 0.875rem; color: #475569; }
        
        .form-group { margin-top: 1.25rem; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.375rem; }
        
        .input-control { width: 100%; border-radius: 0.375rem; border: 1px solid #cbd5e1; padding: 0.625rem 0.875rem; font-size: 0.875rem; color: #0f172a; background-color: #ffffff; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.15s ease-in-out; }
        .input-control:focus { outline: none; border-color: #4f46e5; ring: 2px solid #4f46e5; box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        
        /* Grupo de Input com Sufixo (Subdomínio) */
        .input-addon-group { display: flex; border-radius: 0.375rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .input-addon-group .input-control { border-top-right-radius: 0; border-bottom-right-radius: 0; flex: 1; }
        .addon-text { display: inline-flex; align-items: center; border-radius: 0 0.375rem 0.375rem 0; border: 1px solid #cbd5e1; border-left: 0; background-color: #f1f5f9; px: 0.75rem; padding: 0 0.875rem; color: #64748b; font-size: 0.875rem; font-weight: 500; }
        
        .help-text { margin-top: 0.375rem; font-size: 0.75rem; color: #64748b; }
        
        /* Botão */
        .btn-submit { margin-top: 1.5rem; width: 100%; display: flex; justify-content: center; border-radius: 0.375rem; background-color: #4f46e5; padding: 0.625rem 0.875rem; font-size: 0.875rem; font-weight: 600; color: #ffffff; border: none; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: background-color 0.15s; }
        .btn-submit:hover { background-color: #4338ca; }
        
        /* Alertas */
        .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.875rem; display: flex; gap: 0.75rem; border: 1px solid transparent; }
        .alert-success { background-color: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .alert-error { background-color: #fff1f2; border-color: #fecdd3; color: #9f1239; }
        .alert ul { padding-left: 1.25rem; margin-top: 0.25rem; font-size: 0.75rem; }
    </style>
</head>
<body>

    <div class="flex-container">
        <!-- Lado Esquerdo -->
        <div class="left-side">
            <div class="logo-area">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                <span>Fleet<span class="logo-highlight">Control</span><span class="badge-central">Central</span></span>
            </div>

            <div class="intro-text">
                <h1>Expanda seu ecossistema de frotas.</h1>
                <p>A partir deste painel central landlord, você provisiona novos ambientes isolados, define tempos de expiração e gerencia o ciclo de vida de cada cliente.</p>
            </div>

            <div class="footer-left">
                &copy; {{ date('Y') }} Fleet Control Platform.
            </div>
        </div>

        <!-- Lado Direito -->
        <div class="right-side">
            <div class="form-container">
                
                <div class="header-form">
                    <h2>Cadastrar Novo Cliente</h2>
                    <p>Preencha os dados abaixo para criar um novo Tenant.</p>
                </div>

                <div class="form-group" style="margin-top: 2rem;">
                    <!-- Mensagens de Sucesso -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            <strong>✓</strong> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mensagens de Erro -->
                    @if($errors->any())
                        <div class="alert alert-error">
                            <strong>✕</strong>
                            <div>
                                <strong>Verifique os erros:</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Formulário -->
                    <form action="/admin/store" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="company_name">Nome da Empresa</label>
                            <input type="text" name="company_name" id="company_name" required value="{{ old('company_name') }}" class="input-control" placeholder="Ex: Logística Brasil S.A.">
                        </div>

                        <div class="form-group">
                            <label for="domain">Subdomínio de Acesso</label>
                            <div class="input-addon-group">
                                <input type="text" name="domain" id="domain" required value="{{ old('domain') }}" class="input-control" placeholder="empresa">
                                <span class="addon-text">.fleetcontrol.com</span>
                            </div>
                            <p class="help-text">Endereço exclusivo para este tenant acessar a plataforma.</p>
                        </div>

                        <div class="form-group">
                            <label for="expires_at">Período Ativo (Expiração)</label>
                            <input type="date" name="expiration_date" id="expires_date" value="{{ old('expiration_date') }}" min="{{ date('Y-m-d') }}" class="input-control">
                            <p class="help-text">Data limite em que o ambiente do tenant ficará ativo no sistema.</p>
                        </div>

                        <button type="submit" class="btn-submit">
                            Provisionar Instância
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
