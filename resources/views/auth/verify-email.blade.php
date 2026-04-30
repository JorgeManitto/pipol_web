<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pipol - Verificá tu email</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        html {
            scroll-behavior: smooth;
        }

        .text-balance {
            text-wrap: balance;
        }
    </style>
    @livewireStyles
</head>
<body style="background: #0F071A;">
    <div>
        <div class="min-h-dvh relative pt-4 pb-20 px-4 bg-[#0F071A]">
            <div class="max-w-xl mx-auto">
                <div class="grid lg:grid-cols-1 gap-4 items-center">

                    <!-- Branding -->
                    <div class="text-white space-y-4">
                        <div class="flex items-start flex-col gap-2 mb-0">
                            <a href="{{ route('home') }}" class="flex items-center py-2 rounded-full text-sm text-auth-tabs">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Volver al sitio principal
                            </a>
                        </div>

                        <h1 class="text-2xl font-black leading-tight mb-0">
                            <span class="text-white">Verificá tu email en</span>
                            <a href="{{ route('home') }}" class="gradient-text"><img style="display: inline-block;height: 32px;" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" /></a>
                        </h1>

                        <p class="text-md font-normal text-auth-tabs leading-relaxed max-w-xl pb-0">
                            Necesitamos confirmar tu dirección de correo electrónico antes de continuar.
                        </p>
                    </div>

                    <!-- Card -->
                    <div class="relative">
                        <div class="bg-[#140A24] backdrop-blur-sm rounded-3xl p-3 md:py-4 md:px-10 border border-gray-700/50">

                            <div class="flex items-center justify-center mb-4">
                                <div class="w-16 h-16 rounded-full bg-purple-900/40 border border-purple-700/50 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                    </svg>
                                </div>
                            </div>

                            <h2 class="text-2xl font-bold text-white mb-2 text-center">Revisá tu bandeja de entrada</h2>
                            <p class="text-auth-tabs mb-6 text-sm text-center">
                                Te enviamos un enlace de verificación a <span class="text-white font-medium">{{ Auth::user()->email }}</span>. Hacé clic en el enlace para activar tu cuenta.
                            </p>

                            {{-- Mensaje de éxito al reenviar --}}
                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-4 p-4 rounded-lg bg-green-900/30 border border-green-700/50">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#34D399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                        <p class="text-green-400 text-sm">¡Listo! Te enviamos un nuevo enlace de verificación.</p>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full btn-primary text-white font-semibold py-3 rounded-xl cursor-pointer text-sm">
                                    Reenviar enlace de verificación
                                </button>
                            </form>

                            <div class="mt-6 text-center">
                                <a href="{{ route('logout') }}"  type="submit" class="inline-flex items-center gap-1 text-[#8B5CF6] hover:underline text-sm bg-transparent border-none cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 18l-6-6 6-6" />
                                    </svg>
                                    Cerrar sesión
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>