<div>
    <div class="hero-section relative pt-6 pb-20 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="grid lg:grid-cols-1 gap-12 items-center">
                <!-- Left: Branding / Intro (tomado del estilo de index.blade.php) -->
                <div class="text-white space-y-4">
                    <div class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm text-gray-300">
                        Conectando experiencia con talento
                    </div>

                    <h1 class="text-4xl font-black leading-tight">
                        <span class="text-white">Iniciá sesión o registrate en</span>
                        <span class="gradient-text"><img style="display: inline-block;height: 40px;" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" /></span>
                    </h1>

                    <p class="text-md text-gray-300 leading-relaxed max-w-xl">
                        Compartí y aprendé de la experiencia real. Entrá con tu cuenta o creá una para empezar a conectar con mentores y consultantes.
                    </p>

                
                </div>

                <!-- Right: Auth Card (estética adaptada de index.blade.php) -->
                <div class="relative">
                    <div class="bg-white/5 backdrop-blur-sm rounded-3xl p-8 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <a href="{{ route('home') }}" class="text-2xl font-bold text-white">Pipol</a>
                            {{-- <div class="text-sm text-gray-300">¿Nuevo? <button wire:click="showRegister" class="text-purple-300 underline ml-2">Crear cuenta</button></div> --}}
                        </div>

                        <!-- Tabs -->
                        <div class="flex bg-gray-800/30 rounded-xl p-1 mb-6">
                            <button
                                wire:click="showLogin"
                                class="flex-1 py-3 text-center font-semibold rounded-lg transition-colors cursor-pointer
                                {{ $activeTab === 'login' ? 'active-tab' : 'text-gray-300' }}">
                                Iniciar Sesión
                            </button>
                            <button
                                wire:click="showRegister"
                                class="flex-1 py-3 text-center font-semibold rounded-lg transition-colors cursor-pointer
                                {{ $activeTab === 'register' ? 'active-tab' : 'text-gray-300' }}">
                                Registrarse
                            </button>
                        </div>

                        <!-- Login Form -->
                        @if($activeTab === 'login')
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">Bienvenido de nuevo</h2>
                            <p class="text-gray-300 mb-6">Ingresa tus credenciales para continuar</p>

                            <form wire:submit.prevent="login" class="space-y-4">
                                <div>
                                    <label for="loginEmail" class="block text-sm font-medium text-gray-300 mb-2">Correo electrónico</label>
                                    <input wire:model.defer="loginEmail" type="email" id="loginEmail"
                                        class="w-full px-4 py-3 bg-transparent border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="tu@email.com">
                                    @error('loginEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="loginPassword" class="block text-sm font-medium text-gray-300 mb-2">Contraseña</label>
                                    <input wire:model.defer="loginPassword" type="password" id="loginPassword"
                                        class="w-full px-4 py-3 bg-transparent border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="••••••••">
                                    @error('loginPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <label class="flex items-center text-gray-300">
                                        <input wire:model="remember" type="checkbox"
                                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                        <span class="ml-2">Recordarme</span>
                                    </label>
                                    <a href="#" class="text-purple-300 hover:underline">¿Olvidaste tu contraseña?</a>
                                </div>

                                <button type="submit"
                                    class="w-full btn-primary text-white font-semibold py-3 rounded-full cursor-pointer">
                                    Iniciar Sesión
                                </button>
                            </form>

                            <div class="mt-6 text-center">
                                <p class="text-gray-400 text-sm">O ingresá con</p>
                                <div class="mt-4 grid grid-cols-2 gap-3">
                                    <a href="{{ url('/auth/google') }}" class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <!-- Google -->
                                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                        </svg>
                                        <span class="text-sm">Google</span>
                                    </a>
                                    <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <!-- Linkedin -->
                                        <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        <span class="text-sm">Linkedin</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Register Form -->
                        @if($activeTab === 'register')
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">Crea tu cuenta</h2>
                            <p class="text-gray-300 mb-6">Únete y comenzá a compartir tu experiencia</p>

                            <form wire:submit.prevent="register" class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center gap-2 bg-gray-800/40 p-3 rounded-lg">
                                        <input type="radio" id="consultante" wire:model.defer="is_mentor" value="0" class="w-4 h-4">
                                        <span class="text-gray-200">Soy Consultante</span>
                                    </label>
                                    <label class="flex items-center gap-2 bg-gray-800/40 p-3 rounded-lg">
                                        <input type="radio" id="mentor" wire:model.defer="is_mentor" value="1" class="w-4 h-4">
                                        <span class="text-gray-200">Soy Mentor</span>
                                    </label>
                                </div>

                                <div>
                                    <label for="registerName" class="block text-sm font-medium text-gray-300 mb-2">Tu Nombre</label>
                                    <input wire:model.defer="registerName" type="text" id="registerName"
                                        class="w-full px-4 py-3 bg-transparent border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="Juan">
                                    @error('registerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="registerEmail" class="block text-sm font-medium text-gray-300 mb-2">Correo electrónico</label>
                                    <input wire:model.defer="registerEmail" type="email" id="registerEmail"
                                        class="w-full px-4 py-3 bg-transparent border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="tu@email.com">
                                    @error('registerEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="registerPassword" class="block text-sm font-medium text-gray-300 mb-2">Contraseña</label>
                                        <input wire:model.defer="registerPassword" type="password" id="registerPassword"
                                            class="w-full px-4 py-3 bg-transparent border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                            placeholder="••••••••">
                                        @error('registerPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="registerConfirmPassword" class="block text-sm font-medium text-gray-300 mb-2">Confirmar</label>
                                        <input wire:model.defer="registerConfirmPassword" type="password" id="registerConfirmPassword"
                                            class="w-full px-4 py-3 bg-transparent border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                            placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="flex items-start text-gray-300">
                                    <input type="checkbox" id="terms" class="w-4 h-4 mt-1 text-purple-600" required>
                                    <label for="terms" class="ml-2 text-sm">
                                        Acepto los <a href="#" class="text-purple-300 underline">términos y condiciones</a> y la <a href="#" class="text-purple-300 underline">política de privacidad</a>
                                    </label>
                                </div>

                                <button type="submit" class="w-full btn-primary text-white font-semibold py-3 rounded-full cursor-pointer">
                                    Crear Cuenta
                                </button>
                            </form>

                            <div class="mt-6 text-center">
                                <p class="text-gray-400 text-sm">O registrate con</p>
                                <div class="mt-4 grid grid-cols-2 gap-3">
                                    <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <!-- Google -->
                                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                        </svg>
                                        <span class="text-sm">Google</span>
                                    </button>
                                    <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <svg class="w-5 h-5" fill="#0A66C2" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.025-3.038-1.849-3.038-1.851 0-2.134 1.445-2.134 2.941v5.666h-3.554V9h3.414v1.561h.049c.476-.9 1.637-1.849 3.372-1.849 3.605 0 4.271 2.372 4.271 5.458v6.282zM5.337 7.433c-1.144 0-2.07-.928-2.07-2.073 0-1.146.926-2.073 2.07-2.073 1.143 0 2.069.927 2.069 2.073 0 1.145-.926 2.073-2.069 2.073zM6.518 20.452H4.156V9h2.362v11.452z"/>
                                        </svg>
                                        <span class="text-sm">Linkedin</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="mt-6 text-sm text-gray-400">
                            Al registrarte aceptás nuestros términos de servicio y política de privacidad.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>