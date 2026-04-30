<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
    <title>Pipol - Ingreso</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            
            html {
            scroll-behavior: smooth;
            }
            
            /* .hero-gradient {
            background: linear-gradient(135deg, #2D5F5D 0%, #1A4644 100%);
            } */
            
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
                        <span class="text-white">Restablecé tu contraseña en</span>
                        <a href="{{ route('home') }}" class="gradient-text"><img style="display: inline-block;height: 32px;" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" /></a>
                    </h1>

                    <p class="text-md font-normal text-auth-tabs leading-relaxed max-w-xl pb-0">
                        Ingresá tu nueva contraseña para recuperar el acceso a tu cuenta.
                    </p>
                </div>

                <!-- Card -->
                <div class="relative">
                    <div class="bg-[#140A24] backdrop-blur-sm rounded-3xl p-3 md:py-4 md:px-10 border border-gray-700/50">

                        <h2 class="text-2xl font-bold text-white mb-2">Nueva contraseña</h2>
                        <p class="text-auth-tabs mb-6 text-sm">Elegí una contraseña segura para tu cuenta.</p>

                        {{-- Errores generales --}}
                        @if ($errors->any())
                            <div class="mb-4 p-4 rounded-lg bg-red-900/30 border border-red-700/50">
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="15" y1="9" x2="9" y2="15"/>
                                        <line x1="9" y1="9" x2="15" y2="15"/>
                                    </svg>
                                    <div>
                                        @foreach ($errors->all() as $error)
                                            <p class="text-red-400 text-sm">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div>
                                <label for="email" class="block text-xs font-normal text-auth-tabs text-uppercase mb-2">Correo electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $email) }}"
                                    class="w-full px-4 py-3 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                    placeholder="tu@email.com" required autofocus>
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-xs font-normal text-auth-tabs text-uppercase mb-2">Nueva contraseña</label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                    placeholder="••••••••" required>
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-normal text-auth-tabs text-uppercase mb-2">Confirmar contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-3 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                    placeholder="••••••••" required>
                            </div>

                            <button type="submit"
                                class="w-full btn-primary text-white font-semibold py-3 rounded-xl cursor-pointer text-sm">
                                Restablecer contraseña
                            </button>
                        </form>

                        <div class="mt-6 text-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-[#8B5CF6] hover:underline text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Volver a Iniciar Sesión
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

