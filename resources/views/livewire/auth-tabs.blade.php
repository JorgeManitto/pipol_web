<div>
    <div class="max-w-md mx-auto px-4 mt-24 py-12" wire:init="$refresh">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="flex items-center p-8 justify-center">
                <div>
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary ">Pipol</a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-gray-200">
                <button
                    wire:click="showLogin"
                    class="flex-1 py-4 text-center font-semibold transition-colors
                    {{ $activeTab === 'login' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-500' }}">
                    Iniciar Sesión
                </button>
                <button
                    wire:click="showRegister"
                    class="flex-1 py-4 text-center font-semibold transition-colors
                    {{ $activeTab === 'register' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-500' }}">
                    Registrarse
                </button>
            </div>

            <!-- Login Form -->
            @if($activeTab === 'login')
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Bienvenido de nuevo</h2>
                <p class="text-gray-600 mb-6">Ingresa tus credenciales para continuar</p>

                <form wire:submit.prevent="login" class="space-y-5">
                    
                    <div>
                        <label for="loginEmail" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico</label>
                        <input wire:model.defer="loginEmail" type="email" id="loginEmail"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none"
                            placeholder="tu@email.com">
                        @error('loginEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                        <input wire:model.defer="loginPassword" type="password" id="loginPassword"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none"
                            placeholder="••••••••">
                        @error('loginPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input wire:model="remember" type="checkbox"
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                        <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors shadow-md">
                        Iniciar Sesión
                    </button>
                </form>
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">O ingresá con</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button  class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Google</span>
                        </button>
                        <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Facebook</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Register Form -->
            @if($activeTab === 'register')
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Crea tu cuenta</h2>
                <p class="text-gray-600 mb-6">Únete y comienza a entrenar tu cerebro</p>

                <form wire:submit.prevent="register" class="space-y-5">
                    <div >
                        <div class="p-4 border border-gray-300 mb-4 rounded-lg">
                            <div class="flex items-center gap-4">
                                <input  type="radio" id="consultante" wire:model.defer='is_mentor' value="0" class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500">
                                <label  for="consultante" class="text-gray-700 font-medium">Soy Consultante</label>
                            </div>
                        </div>
                        <div class="p-4 border border-gray-300 mb-4 rounded-lg">
                            <div class="flex items-center gap-4">
                                <input  type="radio" id="mentor" wire:model.defer='is_mentor' value="1"  class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500">
                                <label for="mentor" class="text-gray-700 font-medium">Soy Mentor</label>
                            </div>
                        </div>
                        
                    </div>
                    <div>
                        <label for="registerName" class="block text-sm font-medium text-gray-700 mb-2">Tu Nombre</label>
                        <input wire:model.defer="registerName" type="text" id="registerName"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none"
                            placeholder="Juan">
                        @error('registerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="registerEmail" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico</label>
                        <input wire:model.defer="registerEmail" type="email" id="registerEmail"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none"
                            placeholder="tu@email.com">
                        @error('registerEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="registerPassword" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                        <input wire:model.defer="registerPassword" type="password" id="registerPassword"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none"
                            placeholder="••••••••">
                        @error('registerPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="registerConfirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirmar contraseña</label>
                        <input wire:model.defer="registerConfirmPassword" type="password" id="registerConfirmPassword"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="terms" class="w-4 h-4 mt-1 text-purple-600 border-gray-300 rounded focus:ring-purple-500" required>
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            Acepto los <a href="#" class="text-purple-600 hover:text-purple-700 font-medium">términos y condiciones</a>
                            y la <a href="#" class="text-purple-600 hover:text-purple-700 font-medium">política de privacidad</a>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors shadow-md">
                        Crear Cuenta
                    </button>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">O regístrate con</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button  class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Google</span>
                        </button>
                        <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Facebook</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-left">
            <p class="text-gray-400 text-sm">
                Al registrarte, aceptas nuestros términos de servicio y política de privacidad
            </p>
        </div>
    </div>

</div>
