{{-- resources/views/backend/layout/fraccional.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pipol Fraccional')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [v-cloak], [x-cloak] { display: none !important; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }

        :root { --bg: #0A0B1A; }
        body { background: var(--bg); }

        .btn-gradient {
            background: linear-gradient(to right, #9333ea, #ec4899);
            color: white;
        }
        .btn-gradient:hover {
            background: linear-gradient(to right, #7e22ce, #db2777);
        }
        .btn-gradient-green {
            background: linear-gradient(to right, #16a34a, #059669);
            color: white;
        }
        .btn-gradient-green:hover {
            background: linear-gradient(to right, #15803d, #047857);
        }
        .text-gradient {
            background: linear-gradient(to right, #9333ea, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }
    </style>
    @stack('head')
</head>
<body class="min-h-screen" x-data="{ mobileMenu: false }">

@auth
@php
    $user = auth()->user();
    $isProfessional = $user->isFraccionalProfessional();
    $isCompany      = $user->isFraccionalCompany();
    $isAdmin        = $user->role === 'admin';
    $current        = Route::currentRouteName();

    // Helper para marcar activo el link según prefijo de ruta
    $isActive = fn($prefix) => str_starts_with($current ?? '', $prefix);
@endphp

{{-- ======================== --}}
{{-- NAVBAR AUTH --}}
{{-- ======================== --}}
<nav class="sticky top-0 z-40 backdrop-blur-lg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo + nav links --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('home.fraccional') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-white hidden sm:block">
                        Pipol Fraccional
                        @if($isAdmin)
                            <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-amber-500 text-amber-950">
                                ADMIN
                            </span>
                        @endif
                    </span>
                </a>

                {{-- ============================ --}}
                {{-- Menú desktop --}}
                {{-- ============================ --}}
                <div class="hidden md:flex items-center gap-1">

                    {{-- =========== EMPRESA =========== --}}
                    @if($isCompany)
                        <a href="{{ route('fraccional.index') }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg transition {{ $current === 'fraccional.index' ? 'text-purple-400 bg-white/5' : 'text-white hover:text-gray-300' }}">
                            Buscar profesionales
                        </a>
                        <a href="{{ route('fraccional.engagement.sent') }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg transition flex items-center gap-1.5 {{ $current === 'fraccional.engagement.sent' ? 'text-purple-400 bg-white/5' : 'text-white hover:text-gray-300' }}">
                            Mis solicitudes
                            @if(($menu_activeAsCompany ?? 0) > 0)
                                <span class="bg-purple-500 text-white text-xs font-medium px-1.5 py-0.5 rounded-full">
                                    {{ $menu_activeAsCompany }}
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- =========== PROFESIONAL =========== --}}
                    @if($isProfessional)
                        <a href="{{ route('fraccional.engagement.received') }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg transition flex items-center gap-1.5 {{ $current === 'fraccional.engagement.received' ? 'text-purple-400 bg-white/5' : 'text-white hover:text-gray-300' }}">
                            Solicitudes
                            @if(($menu_pendingReceived ?? 0) > 0)
                                <span class="bg-red-500 text-white text-xs font-medium px-1.5 py-0.5 rounded-full animate-pulse">
                                    {{ $menu_pendingReceived }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('fraccional.engagement.received', ['filter' => 'active']) }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg transition flex items-center gap-1.5 text-white hover:text-gray-300">
                            Mis trabajos
                            @if(($menu_activeAsPro ?? 0) > 0)
                                <span class="bg-green-500 text-white text-xs font-medium px-1.5 py-0.5 rounded-full">
                                    {{ $menu_activeAsPro }}
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- =========== ADMIN =========== --}}
                    @if($isAdmin)
                        <div x-data="{ adminOpen: false }" class="relative">
                            <button @click="adminOpen = !adminOpen" @click.outside="adminOpen = false"
                                    class="px-3 py-2 text-sm font-medium rounded-lg transition flex items-center gap-1.5 {{ $isActive('admin.fraccional') ? 'text-amber-400 bg-white/5' : 'text-white hover:text-gray-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                                Admin

                                @if(($menu_pendingMediation ?? 0) > 0)
                                    <span class="bg-red-500 text-white text-xs font-medium px-1.5 py-0.5 rounded-full animate-pulse">
                                        {{ $menu_pendingMediation }}
                                    </span>
                                @endif

                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="adminOpen ? 'rotate-180' : ''" class="transition">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                            <div x-show="adminOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">

                                <div class="p-3 border-b border-gray-100 bg-amber-50">
                                    <p class="text-xs font-medium text-amber-900 uppercase tracking-wide">Panel administrativo</p>
                                </div>

                                <div class="py-1">
                                    <a href="{{ route('admin.fraccional.mediation.index') }}"
                                       class="flex items-center justify-between px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                        <span class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600">
                                                <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1z"/>
                                                <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1z"/>
                                                <path d="M7 21h10"/>
                                                <path d="M12 3v18"/>
                                                <path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/>
                                            </svg>
                                            Mediación de disputas
                                        </span>
                                        @if(($menu_pendingMediation ?? 0) > 0)
                                            <span class="bg-red-100 text-red-700 text-xs font-medium px-1.5 py-0.5 rounded-full">
                                                {{ $menu_pendingMediation }}
                                            </span>
                                        @endif
                                    </a>

                                    <a href="{{ route('admin.fraccional.engagements.index') }}"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                        Contrataciones
                                    </a>

                                    <a href="{{ route('admin.fraccional.transactions.index') }}"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                            <rect width="20" height="14" x="2" y="5" rx="2"/>
                                            <line x1="2" x2="22" y1="10" y2="10"/>
                                        </svg>
                                        Transacciones
                                    </a>

                                    <a href="{{ route('admin.fraccional.users.index') }}"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                        Usuarios
                                    </a>

                                    <a href="{{ route('admin.fraccional.dashboard') }}"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                            <line x1="18" x2="18" y1="20" y2="10"/>
                                            <line x1="12" x2="12" y1="20" y2="4"/>
                                            <line x1="6" x2="6" y1="20" y2="14"/>
                                        </svg>
                                        Métricas
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Historial: visible para todos los roles autenticados de fraccional --}}
                    @if($isCompany || $isProfessional)
                        <a href="{{ route('fraccional.history') }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg transition {{ $current === 'fraccional.history' ? 'text-purple-400 bg-white/5' : 'text-white hover:text-gray-300' }}">
                            Historial
                        </a>
                    @endif
                </div>
            </div>

            {{-- ============================ --}}
            {{-- Right side --}}
            {{-- ============================ --}}
            <div class="flex items-center gap-3">
                @if($isCompany)
                    <a href="{{ route('home.nuevoDiagnostico') }}"
                       class="hidden md:inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white btn-gradient rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Nuevo diagnóstico
                    </a>
                @endif

                {{-- User dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 p-1 rounded-lg hover:bg-white/10 transition">
                        <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}"
                             class="w-8 h-8 rounded-full object-cover" alt="{{ $user->name }}">
                        <span class="hidden md:block text-sm font-medium text-white">{{ $user->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="m6 9 6 6 6-6"/></svg>
                    </button>

                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">

                        <div class="p-3 border-b border-gray-100">
                            <p class="text-sm font-medium truncate">{{ $user->name }} {{ $user->last_name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            @if($isAdmin)
                                <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-800">ADMIN</span>
                            @elseif($isCompany)
                                <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-purple-100 text-purple-800">EMPRESA</span>
                            @elseif($isProfessional)
                                <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-pink-100 text-pink-800">PROFESIONAL</span>
                            @endif
                        </div>

                        <div class="py-1">
                            @if($isProfessional)
                                <a href="{{ route('fraccional.profile.edit') }}"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Mi perfil
                                </a>

                                <a href="{{ route('fraccional.show', $user) }}" target="_blank"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Ver perfil público
                                </a>

                                @if(!$user->stripe_account_id || !$user->stripe_charges_enabled)
                                    <a href="{{ route('fraccional.stripe.connect') }}"
                                       class="flex items-center justify-between px-4 py-2 text-sm text-amber-700 hover:bg-amber-50">
                                        <span class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                                            Conectar pagos
                                        </span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    </a>
                                @else
                                    <a href="{{ route('fraccional.stripe.connect') }}"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                                        Cuenta de pagos
                                    </a>
                                @endif
                            @endif

                            @if($isCompany)
                                <a href="{{ route('fraccional.engagement.sent') }}"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    Mis contrataciones
                                </a>
                            @endif

                            @if($isCompany || $isProfessional)
                                <a href="{{ route('fraccional.history') }}"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                                    Historial
                                </a>
                            @endif

                            @if($isAdmin)
                                <a href="{{ route('admin.fraccional.dashboard') }}"
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-amber-700 hover:bg-amber-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Panel admin
                                </a>
                            @endif
                        </div>

                        <div class="border-t border-gray-100 py-1">
                            <form action="{{ route('fraccional.auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-900 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile toggle --}}
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg hover:bg-white/10 text-white">
                    <svg x-show="!mobileMenu" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    <svg x-show="mobileMenu" x-cloak xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- ============================ --}}
        {{-- Mobile menu --}}
        {{-- ============================ --}}
        <div x-show="mobileMenu" x-cloak
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden border-t border-white/10 py-3 space-y-1">

            @if($isCompany)
                <a href="{{ route('fraccional.index') }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                    Buscar profesionales
                </a>
                <a href="{{ route('fraccional.engagement.sent') }}" class="flex items-center justify-between px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                    <span>Mis solicitudes</span>
                    @if(($menu_activeAsCompany ?? 0) > 0)
                        <span class="bg-purple-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $menu_activeAsCompany }}</span>
                    @endif
                </a>
                <a href="{{ route('home.nuevoDiagnostico') }}" class="block px-3 py-2 text-sm rounded-lg text-purple-400 font-medium">
                    + Nuevo diagnóstico
                </a>
            @endif

            @if($isProfessional)
                <a href="{{ route('fraccional.engagement.received') }}" class="flex items-center justify-between px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                    <span>Solicitudes</span>
                    @if(($menu_pendingReceived ?? 0) > 0)
                        <span class="bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $menu_pendingReceived }}</span>
                    @endif
                </a>
                <a href="{{ route('fraccional.engagement.received', ['filter' => 'active']) }}" class="flex items-center justify-between px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                    <span>Mis trabajos</span>
                    @if(($menu_activeAsPro ?? 0) > 0)
                        <span class="bg-green-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $menu_activeAsPro }}</span>
                    @endif
                </a>
                <a href="{{ route('fraccional.profile.edit') }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                    Mi perfil
                </a>
            @endif

            @if($isAdmin)
                <div class="pt-2 mt-2 border-t border-white/10">
                    <p class="px-3 py-1 text-[10px] font-medium uppercase tracking-wide text-amber-400">Admin</p>
                    <a href="{{ route('admin.fraccional.mediation.index') }}" class="flex items-center justify-between px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                        <span>Mediación</span>
                        @if(($menu_pendingMediation ?? 0) > 0)
                            <span class="bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $menu_pendingMediation }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.fraccional.engagements.index') }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                        Contrataciones
                    </a>
                    <a href="{{ route('admin.fraccional.transactions.index') }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                        Transacciones
                    </a>
                    <a href="{{ route('admin.fraccional.users.index') }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                        Usuarios
                    </a>
                    <a href="{{ route('admin.fraccional.dashboard') }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                        Métricas
                    </a>
                </div>
            @endif

            @if($isCompany || $isProfessional)
                <a href="{{ route('fraccional.history') }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                    Historial
                </a>
            @endif
        </div>
    </div>
</nav>

@else
{{-- ======================== --}}
{{-- NAVBAR GUEST --}}
{{-- ======================== --}}
<nav x-data="{ mobileMenu: false }" class="sticky top-0 z-40 backdrop-blur-lg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <a href="{{ route('home.fraccional') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                    </svg>
                </div>
                <span class="font-semibold text-white hidden sm:block">Pipol Fraccional</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('fraccional.auth.show', ['tab' => 'login']) }}"
                   class="hidden md:inline-flex items-center px-3 py-2 text-sm font-medium text-white hover:text-gray-300 transition">
                    Iniciar sesión
                </a>
                <a href="{{ route('fraccional.auth.show', ['tab' => 'register']) }}"
                   class="hidden md:inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white btn-gradient rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="M12 5v14"/>
                    </svg>
                    Crear cuenta
                </a>

                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg hover:bg-white/10 text-white">
                    <svg x-show="!mobileMenu" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
                    </svg>
                    <svg x-show="mobileMenu" x-cloak xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenu" x-cloak class="md:hidden border-t border-white/10 py-3 space-y-1">
            <a href="{{ route('fraccional.auth.show', ['tab' => 'login']) }}" class="block px-3 py-2 text-sm rounded-lg text-white hover:bg-white/10">
                Iniciar sesión
            </a>
            <a href="{{ route('fraccional.auth.show', ['tab' => 'register']) }}" class="block px-3 py-2 text-sm rounded-lg text-center font-medium text-white btn-gradient">
                Crear cuenta
            </a>
        </div>
    </div>
</nav>
@endauth

{{-- Flash messages --}}
@if(session('success') || session('error') || session('info'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="fixed top-20 right-6 z-50 max-w-sm">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 shadow-lg flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                <span class="flex-1 text-sm">{{ session('success') }}</span>
                <button @click="show = false" class="text-green-600 hover:text-green-800">×</button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 shadow-lg flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                <span class="flex-1 text-sm">{{ session('error') }}</span>
                <button @click="show = false" class="text-red-600 hover:text-red-800">×</button>
            </div>
        @endif
        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 shadow-lg flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                <span class="flex-1 text-sm">{{ session('info') }}</span>
                <button @click="show = false" class="text-blue-600 hover:text-blue-800">×</button>
            </div>
        @endif
    </div>
@endif

{{-- Contenido --}}
<div style="min-height: calc(100vh - 4rem);" class="py-6">
    @yield('content')
</div>

{{-- Footer --}}
<footer class="border-t border-white/10 mt-12">
    <div class="max-w-7xl mx-auto px-6 py-6 text-center text-xs text-gray-500">
        © {{ date('Y') }} Pipol Fraccional · Conectamos empresas con talento fraccional.
    </div>
</footer>

@stack('scripts')
@vite(['resources/js/app.js'])
</body>
</html>