<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso · Pipol Fraccional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [v-cloak] { display: none; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50">

<div id="fraccional-auth"
     data-initial-tab="{{ $tab }}"
     data-initial-type="{{ $type }}"
     data-login-url="{{ route('fraccional.auth.login') }}"
     data-register-url="{{ route('fraccional.auth.register') }}"
     data-google-url="{{ url('/auth/google?origin=fraccional') }}"
     data-linkedin-url="{{ url('/auth/linkedin?origin=fraccional') }}">

    <main class="min-h-screen flex items-center justify-center px-4 py-12" v-cloak>
        <div class="max-w-xl w-full">

            {{-- Header --}}
            <a href="{{ route('home.fraccional') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Volver al sitio
            </a>

            <div class="mb-8">
                <div class="inline-flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-lg bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        Pipol Fraccional
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    [[ activeTab === 'login' ? 'Bienvenido de nuevo' : 'Creá tu cuenta' ]]
                </h1>
                <p class="text-gray-600">
                    [[ activeTab === 'login'
                        ? 'Ingresá para gestionar tus contrataciones fraccionales.'
                        : 'Conectá con empresas que necesitan tu expertise por horas.' ]]
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 md:p-8">

                {{-- Tabs --}}
                <div class="flex bg-gray-100 rounded-xl p-1 mb-6">
                    <button @click="activeTab = 'login'"
                            :class="activeTab === 'login' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600'"
                            class="flex-1 py-2 text-sm font-medium rounded-lg transition">
                        Iniciar sesión
                    </button>
                    <button @click="activeTab = 'register'"
                            :class="activeTab === 'register' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600'"
                            class="flex-1 py-2 text-sm font-medium rounded-lg transition">
                        Registrarme
                    </button>
                </div>

                {{-- Error global --}}
                <div v-if="globalError" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    [[ globalError ]]
                </div>

                {{-- LOGIN --}}
                <form v-if="activeTab === 'login'" @submit.prevent="submitLogin" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase tracking-wide mb-1.5">
                            Correo electrónico
                        </label>
                        <input type="email" v-model="login.email" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm"
                               placeholder="tu@email.com">
                        <p v-if="errors.email" class="text-xs text-red-600 mt-1">[[ errors.email[0] ]]</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase tracking-wide mb-1.5">
                            Contraseña
                        </label>
                        <input type="password" v-model="login.password" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm"
                               placeholder="••••••••">
                        <p v-if="errors.password" class="text-xs text-red-600 mt-1">[[ errors.password[0] ]]</p>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                            <input type="checkbox" v-model="login.remember"
                                   class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            Recordarme
                        </label>
                        <a href="{{ route('password.request') }}" class="text-purple-600 hover:underline font-medium">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button type="submit" :disabled="loading"
                            class="w-full py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg hover:from-purple-700 hover:to-pink-700 transition disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <svg v-if="loading" class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                            <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" class="opacity-75"></path>
                        </svg>
                        <span>[[ loading ? 'Ingresando...' : 'Iniciar sesión' ]]</span>
                    </button>
                </form>

                {{-- REGISTER --}}
                <form v-if="activeTab === 'register'" @submit.prevent="submitRegister" class="space-y-4">

                    {{-- Tipo de cuenta --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase tracking-wide mb-2">
                            ¿Cómo querés usar Pipol Fraccional?
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label :class="register.type === 'company'
                                ? 'border-purple-500 bg-purple-50 ring-2 ring-purple-200'
                                : 'border-gray-200 hover:border-gray-300'"
                                   class="border-2 p-4 rounded-xl cursor-pointer transition text-center">
                                <input type="radio" v-model="register.type" value="company" class="hidden">
                                <div class="text-2xl mb-1">🏢</div>
                                <p class="text-sm font-medium" :class="register.type === 'company' ? 'text-purple-700' : 'text-gray-700'">
                                    Empresa
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Quiero contratar talento</p>
                            </label>
                            <label :class="register.type === 'professional'
                                ? 'border-purple-500 bg-purple-50 ring-2 ring-purple-200'
                                : 'border-gray-200 hover:border-gray-300'"
                                   class="border-2 p-4 rounded-xl cursor-pointer transition text-center">
                                <input type="radio" v-model="register.type" value="professional" class="hidden">
                                <div class="text-2xl mb-1">💼</div>
                                <p class="text-sm font-medium" :class="register.type === 'professional' ? 'text-purple-700' : 'text-gray-700'">
                                    Profesional
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Quiero ofrecer mis servicios</p>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase tracking-wide mb-1.5">
                            Nombre completo
                        </label>
                        <input type="text" v-model="register.name" required minlength="3"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm"
                               placeholder="Juan Pérez">
                        <p v-if="errors.name" class="text-xs text-red-600 mt-1">[[ errors.name[0] ]]</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 uppercase tracking-wide mb-1.5">
                            Correo electrónico
                        </label>
                        <input type="email" v-model="register.email" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm"
                               placeholder="tu@email.com">
                        <p v-if="errors.email" class="text-xs text-red-600 mt-1">[[ errors.email[0] ]]</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 uppercase tracking-wide mb-1.5">
                                Contraseña
                            </label>
                            <input type="password" v-model="register.password" required minlength="8"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm"
                                   placeholder="••••••••">
                            <p v-if="errors.password" class="text-xs text-red-600 mt-1">[[ errors.password[0] ]]</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 uppercase tracking-wide mb-1.5">
                                Confirmar
                            </label>
                            <input type="password" v-model="register.password_confirmation" required minlength="8"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none text-sm"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" v-model="register.terms" required
                               class="mt-0.5 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="text-xs text-gray-600">
                            Acepto los <a href="#" class="text-purple-600 underline">términos y condiciones</a>
                            y la <a href="#" class="text-purple-600 underline">política de privacidad</a>.
                        </span>
                    </label>

                    <button type="submit" :disabled="loading || !register.terms"
                            class="w-full py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg hover:from-purple-700 hover:to-pink-700 transition disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <svg v-if="loading" class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                            <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" class="opacity-75"></path>
                        </svg>
                        <span>[[ loading ? 'Creando cuenta...' : 'Crear cuenta' ]]</span>
                    </button>
                </form>

                {{-- Social --}}
                <div class="mt-6">
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-3 bg-white text-xs text-gray-500">
                                O [[ activeTab === 'login' ? 'ingresá' : 'registrate' ]] con
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a :href="googleUrl"
                           class="flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Google
                        </a>
                        <a :href="linkedinUrl"
                           class="flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <svg class="w-4 h-4" fill="#0A66C2" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.025-3.038-1.849-3.038-1.851 0-2.134 1.445-2.134 2.941v5.666h-3.554V9h3.414v1.561h.049c.476-.9 1.637-1.849 3.372-1.849 3.605 0 4.271 2.372 4.271 5.458v6.282zM5.337 7.433c-1.144 0-2.07-.928-2.07-2.073 0-1.146.926-2.073 2.07-2.073 1.143 0 2.069.927 2.069 2.073 0 1.145-.926 2.073-2.069 2.073zM6.518 20.452H4.156V9h2.362v11.452z"/>
                            </svg>
                            LinkedIn
                        </a>
                    </div>
                </div>
            </div>

            <p class="text-center text-xs text-gray-500 mt-6">
                Al registrarte aceptás nuestros términos de servicio y política de privacidad.
            </p>
        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.4.21/vue.global.prod.min.js"></script>
<script>
    const { createApp, ref, reactive } = Vue;

    const root = document.getElementById('fraccional-auth');

    createApp({
        compilerOptions: { delimiters: ['[[', ']]'] },
        setup() {
            const loginUrl     = root.dataset.loginUrl;
            const registerUrl  = root.dataset.registerUrl;
            const googleUrl    = root.dataset.googleUrl;
            const linkedinUrl  = root.dataset.linkedinUrl;
            const csrf         = document.querySelector('meta[name="csrf-token"]').content;

            const activeTab    = ref(root.dataset.initialTab || 'login');
            const loading      = ref(false);
            const errors       = ref({});
            const globalError  = ref(null);

            const login = reactive({
                email: '', password: '', remember: false,
            });

            const register = reactive({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                type: root.dataset.initialType || 'company',
                terms: false,
            });

            async function postJson(url, body) {
                loading.value = true;
                errors.value = {};
                globalError.value = null;

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                        },
                        body: JSON.stringify(body),
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        if (data.errors) errors.value = data.errors;
                        if (data.message) globalError.value = data.message;
                        return null;
                    }
                    return data;
                } catch (e) {
                    globalError.value = 'Error de conexión. Intentá de nuevo.';
                    return null;
                } finally {
                    loading.value = false;
                }
            }

            async function submitLogin() {
                const data = await postJson(loginUrl, { ...login });
                if (data?.redirect) window.location.href = data.redirect;
            }

            async function submitRegister() {
                if (!register.terms) {
                    globalError.value = 'Debés aceptar los términos y condiciones.';
                    return;
                }
                const data = await postJson(registerUrl, { ...register });
                if (data?.redirect) window.location.href = data.redirect;
            }

            return {
                activeTab, loading, errors, globalError,
                login, register,
                googleUrl, linkedinUrl,
                submitLogin, submitRegister,
            };
        },
    }).mount('#fraccional-auth');
</script>
</body>
</html>