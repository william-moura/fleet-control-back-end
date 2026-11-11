{{-- resources/views/tenants/create.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cadastrar Novo Cliente - Realiza Informática</title>

    {{-- Tipografia --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    {{-- Tailwind CSS via CDN (sem necessidade de Vite) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#041d1a',
                            deep: '#022c22',
                            button: '#064e3b',
                            buttonHover: '#043e2f',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased bg-[#022c22] text-slate-100">
    <div class="relative min-h-screen flex flex-col lg:flex-row overflow-hidden bg-[#041d1a]">
        
        {{-- ============================================== --}}
        {{-- LADO ESQUERDO: BANNER E INFORMAÇÕES            --}}
        {{-- ============================================== --}}
        <div class="relative lg:w-7/12 p-8 lg:p-16 flex flex-col justify-between overflow-hidden">
            {{-- Imagem de Fundo com Overlay Verde Escuro --}}
            <div class="absolute inset-0 z-0">
                {{-- Imagem de Fundo com maior brilho e opacidade --}}
                <img 
                    src="{{ asset('images/prefeitura-bg.jpg') }}" 
                    alt="Prefeitura Fundo" 
                    class="w-full h-full object-cover object-center opacity-65 mix-blend-screen filter contrast-110 brightness-125"
                >
                
                {{-- Tonalizador Verde Esmeralda Suavizado --}}
                <div class="absolute inset-0 bg-[#041d1a]/55 mix-blend-multiply"></div>

                {{-- Degradê Inferior para manter o contraste dos ícones --}}
                <div class="absolute inset-0 bg-gradient-to-t from-[#021311]/90 via-[#041d1a]/40 to-transparent"></div>

                {{-- Sombra lateral suave para garantir a leitura do título --}}
                <div class="absolute inset-0 bg-gradient-to-r from-[#041d1a]/70 via-transparent to-transparent"></div>
            </div>

            {{-- Conteúdo sobreposto --}}
            <div class="relative z-10 flex flex-col justify-between h-full space-y-12">
                {{-- Header / Logótipo --}}
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2">
                            <div class="border-2 border-white rounded-lg p-1.5 flex items-center justify-center font-black text-xl leading-none">
                                R
                            </div>
                            <div>
                                <span class="font-extrabold tracking-wider text-xl uppercase block leading-none">Realiza</span>
                                <span class="text-[9px] uppercase tracking-[0.25em] text-emerald-300 block font-light">Informática</span>
                            </div>
                        </div>

                        <div class="h-6 w-px bg-emerald-700/60 mx-1"></div>

                        {{-- Distintivo Sistema de Frotas --}}
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-950/70 border border-emerald-600/40 text-xs font-medium text-emerald-200">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8m-8 5h8m-5 5h5M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Sistema de Frotas
                        </div>
                    </div>
                </div>

                {{-- Título Principal e Descrição --}}
                <div class="max-w-xl my-auto">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.15]">
                        Expanda a gestão <br>
                        <span class="text-emerald-400">da sua frota pública.</span>
                    </h1>
                    <p class="mt-6 text-sm lg:text-base text-emerald-100/70 leading-relaxed font-normal">
                        A partir deste painel central, você controla veículos, condutores, manutenções, abastecimentos e muito mais, com eficiência, segurança e transparência.
                    </p>
                </div>

                {{-- Destaques das Funcionalidades --}}
                <div class="grid grid-cols-3 gap-4 pt-6 max-w-lg">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 rounded-xl border border-emerald-500/40 bg-emerald-900/30 flex items-center justify-center mb-2 shadow-inner">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-200">Controle <br> da Frota</span>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 rounded-xl border border-emerald-500/40 bg-emerald-900/30 flex items-center justify-center mb-2 shadow-inner">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-200">Relatórios <br> e Indicadores</span>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 rounded-xl border border-emerald-500/40 bg-emerald-900/30 flex items-center justify-center mb-2 shadow-inner">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-slate-200">Manutenções <br> e Custos</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================== --}}
        {{-- LADO DIREITO: FORMULÁRIO                       --}}
        {{-- ============================================== --}}
        <div class="relative lg:w-5/12 bg-white text-slate-800 lg:rounded-l-[40px] px-8 py-12 lg:px-14 lg:py-16 flex flex-col justify-center shadow-2xl z-20">
            <div class="w-full max-w-md mx-auto">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">Cadastrar Novo Cliente</h2>
                    <p class="text-xs text-slate-500 mt-1">Preencha os dados abaixo para criar um novo Tenant.</p>
                </div>

                <form action="/admin/store" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nome da Empresa --}}
                    <div>
                        <label for="company_name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nome da Empresa
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="company_name" 
                                id="company_name" 
                                value="{{ old('company_name') }}"
                                placeholder="Ex.: Prefeitura Municipal de Exemplo"
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition"
                                required
                            >
                            
                        </div>
                        @error('company_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Endereço do Sistema --}}
                    <div>
                        <label for="subdomain" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Endereço do sistema
                        </label>
                        <div class="flex rounded-lg shadow-sm">
                            <div class="relative flex-grow focus-within:z-10">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    name="domain" 
                                    id="domain" 
                                    value="{{ old('domain') }}"
                                    placeholder="exemplo"
                                    class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-l-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition"
                                    required
                                >
                            </div>
                            <span class="inline-flex items-center px-3.5 rounded-r-lg border border-l-0 border-slate-200 bg-slate-50 text-slate-500 text-xs font-medium">
                                .{{ config('app.domain') }}
                            </span>
                        </div>
                        <p class="mt-1.5 text-[11px] text-slate-400 leading-normal">
                            Endereço exclusivo para este cliente acessar o sistema, não pode ter espaços e caracteres especiais.
                        </p>
                        @error('subdomain')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Período Ativo --}}
                    <div>
                        <label for="expires_at" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Período Ativo (Expiração)
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input 
                                type="date" 
                                name="expires_at" 
                                id="expires_at" 
                                value="{{ old('expires_at') }}"
                                class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition"
                            >
                        </div>
                        <p class="mt-1.5 text-[11px] text-slate-400">
                            Data limite em que o ambiente do tenant ficará ativo no sistema.
                        </p>
                        @error('expires_at')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botão de Submissão --}}
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-[#064e3b] hover:bg-[#043e2f] active:bg-[#022c22] text-white text-sm font-semibold tracking-wide shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Provisionar Instância
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html>