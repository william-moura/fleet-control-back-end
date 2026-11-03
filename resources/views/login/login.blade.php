<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Painel Administrativo</title>
    <style>
        /* RESET & BASE STYLES */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        html, body {
            height: 100%;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        /* LAYOUT CONTAINER */
        .login-container {
            display: flex;
            min-height: 100%;
        }

        /* LADO ESQUERDO: FORMULÁRIO */
        .form-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 1;
            padding: 3rem 2rem;
            background-color: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            z-index: 10;
        }
        .form-wrapper {
            margin: 0 auto;
            width: 100%;
            max-width: 380px;
        }

        /* LOGO */
        .logo-area {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .logo-box {
            display: flex;
            height: 40px;
            width: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: bold;
            font-size: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #0f172a;
        }
        .logo-text span {
            color: #4f46e5;
        }

        /* CABEÇALHO */
        .header-title {
            margin-top: 2rem;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #0f172a;
        }
        .header-subtitle {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        /* FORMULÁRIO & INPUTS */
        .login-form {
            margin-top: 2.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.5rem;
        }
        .form-link {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4f46e5;
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .form-link:hover {
            color: #4338ca;
        }
        .form-input {
            display: block;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.65rem 0.85rem;
            font-size: 0.875rem;
            color: #0f172a;
            background-color: rgba(248, 250, 252, 0.5);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.15s ease-in-out;
            outline: none;
        }
        .form-input:focus {
            border-color: #4f46e5;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        .form-input::placeholder {
            color: #94a3b8;
        }

        /* CHECKBOX */
        .remember-row {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .form-checkbox {
            height: 16px;
            width: 16px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            accent-color: #4f46e5;
            cursor: pointer;
        }
        .checkbox-label {
            margin-left: 0.75rem;
            font-size: 0.875rem;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }

        /* BOTÃO SUBMIT */
        .btn-submit {
            display: flex;
            width: 100%;
            justify-content: center;
            border-radius: 8px;
            background-color: #4f46e5;
            border: none;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn-submit:hover {
            background-color: #4338ca;
        }
        .btn-submit:active {
            transform: scale(0.98);
        }

        /* RODAPÉ ESQUERDO */
        .footer-text {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* LADO DIREITO: BANNER (Escondido no mobile, ativo via Media Query) */
        .banner-section {
            display: none;
            position: relative;
            flex: 1;
            background-color: #0f172a;
            overflow: hidden;
        }
        .banner-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 50%, #111827 100%);
            opacity: 0.95;
        }
        .banner-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.05;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 16px 16px;
        }
        .banner-content {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            padding: 4rem;
            color: #ffffff;
            z-index: 20;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            background-color: rgba(79, 70, 229, 0.15);
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #818cf8;
            border: 1px solid rgba(79, 70, 229, 0.3);
            width: fit-content;
        }
        .banner-title {
            margin-top: 1.5rem;
            font-size: 2.25rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.025em;
        }
        .banner-desc {
            margin-top: 1rem;
            font-size: 1rem;
            color: #94a3b8;
            line-height: 1.6;
        }
        .metrics-grid {
            display: grid;
            grid-cols: 2;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
            border-top: 1px solid #1e293b;
            padding-top: 2rem;
        }
        .metric-title {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .metric-sub {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 0.25rem;
        }

        /* RESPONSIVIDADE (Telas maiores que 1024px ganham o split-screen) */
        @media (min-width: 1024px) {
            .form-section {
                flex: none;
                width: 550px;
                padding: 0 5rem;
            }
            .banner-section {
                display: block;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <!-- LADO ESQUERDO: Formulário de Login -->
        <div class="form-section">
            <div class="form-wrapper">
                
                <!-- Logo e Cabeçalho -->
                <div class="logo-area">
                    <div class="logo-box">Fleet</div>
                    <span class="logo-text">Fleet<span>Control</span></span>
                </div>
                
                <h2 class="header-title">Acesse sua conta</h2>
                <p class="header-subtitle">Bem-vindo de volta! Insira suas credenciais abaixo.</p>

                <!-- Formulário -->
                <form action="{{ route('admin.login.authenticate') }}" method="POST" class="login-form">
                    @csrf <!-- Adiciona o token CSRF para proteção contra ataques -->

                    <!-- Campo Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">E-mail corporativo</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="form-input" placeholder="nome@empresa.com">
                    </div>

                    <!-- Campo Senha -->
                    <div class="form-group">
                        <div class="form-label-row">
                            <label for="password" class="form-label">Senha</label>
                            <a href="#" class="form-link">Esqueceu a senha?</a>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            class="form-input" placeholder="••••••••">
                    </div>

                    <!-- Lembrar-me -->
                    <div class="remember-row">
                        <input id="remember_me" name="remember" type="checkbox" class="form-checkbox">
                        <label for="remember_me" class="checkbox-label">Lembrar deste dispositivo</label>
                    </div>

                    <!-- Botão de Entrar -->
                    <button type="submit" class="btn-submit">
                        Entrar no painel
                    </button>
                </form>

                <!-- Rodapé -->
            </div>
        </div>
    </div>
</body>
</html>