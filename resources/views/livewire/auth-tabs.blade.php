{{-- AUTH-TABS --}}
<div>

    <div class="min-h-dvh relative pt-2 pb-20 px-4 bg-[#0F071A]">
        <div class="max-w-xl mx-auto">
            <div class="grid lg:grid-cols-1 gap-4 items-center">
                <!-- Left: Branding / Intro (tomado del estilo de index.blade.php) -->
                <div class="text-white space-y-4">
                    <div class="flex items-start flex-col gap-2 mb-0">
                        <a href="{{ route('home.mentoria') }}" class="flex items-center  py-2 rounded-full text-sm text-auth-tabs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M15 18l-6-6 6-6" />
                            </svg>
                            Volver a mentorías
                        </a>
                    </div>

                    <h1 class="text-2xl font-black leading-tight mb-0">
                        <span class="text-white">Iniciá sesión o registrate en</span>
                        <a href="{{ route('home') }}" class="gradient-text"><img style="display: inline-block;height: 32px;" src="{{ asset('/images/logo-clea-recorte.png') }}" alt="Pipol" /></a>
                    </h1>

                    <p class="text-xs font-normal text-auth-tabs leading-relaxed max-w-xl pb-0">
                        Ingresá con tu cuenta o creá una para empezar a conectar con mentores y mentees.
                    </p>

                
                </div>
                <div class="relative">
                    <div class="bg-[#140A24] backdrop-blur-sm rounded-3xl p-3 md:py-4 md:px-10 border border-gray-700/50">
   
                        <!-- Tabs -->
                        <div class="flex bg-[#20152E] rounded-xl p-1 mb-1">
                            <button
                                wire:click="showLogin"
                                class="flex-1 py-2 text-center font-normal text-sm rounded-lg transition-colors cursor-pointer
                                {{ $activeTab === 'login' ? 'active-tab' : 'bg-[#20152E] text-auth-tabs' }}">
                                Iniciar Sesión
                            </button>
                            <button
                                wire:click="showRegister"
                                class="flex-1 py-2 text-center font-normal text-sm rounded-lg transition-colors cursor-pointer
                                {{ $activeTab === 'register' ? 'active-tab' : 'bg-[#20152E] text-auth-tabs' }}">
                                Registrarse
                            </button>
                        </div>

                        <!-- Login Form -->
                        @if($activeTab === 'login')
                        <div>
                            <h2 class="text-xl font-bold text-white mb-1">Bienvenido de nuevo</h2>
                            <p class="text-auth-tabs mb-4 text-sm">Ingresa tus credenciales para continuar</p>

                            <form wire:submit.prevent="login" class="space-y-4">
                                <div>
                                    <label for="loginEmail" class="block text-xs font-normal text-auth-tabs text-uppercase mb-1">Correo electrónico</label>
                                    <input wire:model.defer="loginEmail" type="email" id="loginEmail"
                                        class="w-full px-4 py-2 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="tu@email.com">
                                    @error('loginEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="loginPassword" class="block text-xs font-normal text-auth-tabs text-uppercase mb-1">Contraseña</label>
                                    <input wire:model.defer="loginPassword" type="password" id="loginPassword"
                                        class="w-full px-4 py-2 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="••••••••">
                                    @error('loginPassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex items-center justify-between text-xs">
                                    <label class="flex items-center text-auth-tabs text-uppercase">
                                        <input wire:model="remember" type="checkbox"
                                            class="appearance-none w-4 h-4  rounded-full border-1 border-white bg-transparent
                                        checked:bg-[#8B5CF6] checked:border-[#fff] cursor-pointer shrink-0">
                                        <span class="ml-2">Recordarme</span>
                                    </label>
                                    <a href="{{ route('password.request') }}" class="text-[#8B5CF6] hover:underline">¿Olvidaste tu contraseña?</a>
                                </div>

                                <button type="submit"
                                    class="w-full btn-primary text-white font-semibold py-2 rounded-xl cursor-pointer text-sm">
                                    Iniciar Sesión
                                </button>
                            </form>

                            <div class="mt-6 text-center">
                                <p class="text-gray-400 text-xs">O ingresá con</p>
                                <div class="mt-4 grid grid-cols-2 gap-3">
                                    <a href="{{ url('/auth/google') }}" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <!-- Google -->
                                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                        </svg>
                                        <span class="text-sm">Google</span>
                                    </a>
                                    <a href="{{ url('/auth/linkedin') }}" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <!-- Linkedin -->
                                        <svg class="w-5 h-5" fill="#0A66C2" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.025-3.038-1.849-3.038-1.851 0-2.134 1.445-2.134 2.941v5.666h-3.554V9h3.414v1.561h.049c.476-.9 1.637-1.849 3.372-1.849 3.605 0 4.271 2.372 4.271 5.458v6.282zM5.337 7.433c-1.144 0-2.07-.928-2.07-2.073 0-1.146.926-2.073 2.07-2.073 1.143 0 2.069.927 2.069 2.073 0 1.145-.926 2.073-2.069 2.073zM6.518 20.452H4.156V9h2.362v11.452z"/>
                                        </svg>
                                        <span class="text-sm">Linkedin</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Register Form -->
                        @if($activeTab === 'register')
                        <div>
                            <h2 class="text-xl font-bold text-white mb-1">Crea tu cuenta</h2>
                            <p class="text-auth-tabs mb-1 text-sm">Únete y comenzá a compartir tu experiencia</p>

                            <form wire:submit.prevent="register" class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center gap-2 bg-[#20152E] text-white p-3 rounded-lg has-[:checked]:border has-[:checked]:border-[#8B5CF6] has-[:checked]:text-[#8B5CF6] cursor-pointer">
                                        <input type="radio" id="consultante" wire:model.defer="is_mentor" value="0"
                                            class="appearance-none w-4 h-4 rounded-full border-2 border-white bg-white
                                            checked:border-[#8B5CF6] checked:bg-[#8B5CF6] checked:shadow-[inset_0_0_0_3px_white] cursor-pointer">
                                        <span class="text-sm">Soy Mentee</span>
                                    </label>
                                    <label class="flex items-center gap-2 bg-[#20152E] text-white p-3 rounded-lg has-[:checked]:border has-[:checked]:border-[#8B5CF6] has-[:checked]:text-[#8B5CF6] cursor-pointer">
                                        <input type="radio" id="mentor" wire:model.defer="is_mentor" value="1"
                                            class="appearance-none w-4 h-4 rounded-full border-2 border-white bg-white
                                            checked:border-[#8B5CF6] checked:bg-[#8B5CF6] checked:shadow-[inset_0_0_0_3px_white] cursor-pointer">
                                        <span class="text-sm">Soy Mentor</span>
                                    </label>
                                </div>

                                <div>
                                    <label for="registerName" class="block text-xs font-normal text-auth-tabs text-uppercase mb-1">Tu Nombre</label>
                                    <input wire:model.defer="registerName" type="text" id="registerName"
                                        class="w-full px-4 py-2 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="Juan">
                                    @error('registerName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="registerEmail" class="block text-xs font-normal text-auth-tabs text-uppercase mb-1">Correo electrónico</label>
                                    <input wire:model.defer="registerEmail" type="email" id="registerEmail"
                                        class="w-full px-4 py-2 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                        placeholder="tu@email.com">
                                    @error('registerEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="registerPassword" class="block text-xs font-normal text-auth-tabs text-uppercase mb-1">Contraseña</label>
                                        <input wire:model.defer="registerPassword" type="password" id="registerPassword"
                                            class="w-full px-4 py-2 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                            placeholder="••••••••">
                                        @error('registerPassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="registerConfirmPassword" class="block text-xs font-normal text-auth-tabs text-uppercase mb-1">Confirmar</label>
                                        <input wire:model.defer="registerConfirmPassword" type="password" id="registerConfirmPassword"
                                            class="w-full px-4 py-2 bg-[#20152E] border border-gray-700 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-white"
                                            placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="flex items-center text-auth-tabs">
                                    <input type="checkbox" id="terms"
                                        class="appearance-none w-4 h-4  rounded-full border-1 border-white bg-transparent
                                        checked:bg-[#8B5CF6] checked:border-[#fff] cursor-pointer shrink-0" required>
                                    <label for="terms" class="ml-2 text-xs">
                                        Acepto los <a href="#" class="text-[#8B5CF6] underline">términos y condiciones</a> y la <a href="#" class="text-[#8B5CF6] underline">política de privacidad</a>
                                    </label>
                                </div>

                                <button type="submit"
                                    class="w-full btn-primary text-white font-semibold py-2 rounded-xl cursor-pointer text-sm flex items-center justify-center gap-2"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-70 cursor-not-allowed">

                                    <svg wire:loading wire:target="register" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>

                                    <span wire:loading.remove wire:target="register">Crear Cuenta</span>
                                    <span wire:loading wire:target="register">Creando...</span>
                                </button>
                            </form>

                            <div class="mt-2 text-center">
                                <p class="text-gray-400 text-xs">O registrate con</p>
                                <div class="mt-2 grid grid-cols-2 gap-3">
                                    <a href="{{ url('/auth/google') }}" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <!-- Google -->
                                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                        </svg>
                                        <span class="text-sm">Google</span>
                                    </a>
                                    <a  href="{{ url('/auth/linkedin') }}" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-700 rounded-lg hover:bg-gray-800 transition-colors text-gray-200">
                                        <svg class="w-5 h-5" fill="#0A66C2" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.025-3.038-1.849-3.038-1.851 0-2.134 1.445-2.134 2.941v5.666h-3.554V9h3.414v1.561h.049c.476-.9 1.637-1.849 3.372-1.849 3.605 0 4.271 2.372 4.271 5.458v6.282zM5.337 7.433c-1.144 0-2.07-.928-2.07-2.073 0-1.146.926-2.073 2.07-2.073 1.143 0 2.069.927 2.069 2.073 0 1.145-.926 2.073-2.069 2.073zM6.518 20.452H4.156V9h2.362v11.452z"/>
                                        </svg>
                                        <span class="text-sm">Linkedin</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="mt-2 text-sm text-gray-400">
                            Al registrarte aceptás nuestros términos de servicio y política de privacidad.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>