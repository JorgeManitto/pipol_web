@extends('backend.layout.fraccional')

@section('title', 'Mi perfil')

@section('content')
<main class="px-6 py-12">
    <div class="max-w-7xl px-6 mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl mb-2 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent font-bold">
                Mi perfil
            </h1>
            <p class="text-gray-200">Mantené tu información actualizada para aparecer en las búsquedas de empresas.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6" x-data="{ tab: 'personal' }">

            {{-- Sidebar con tabs --}}
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">

                    {{-- Avatar + nombre --}}
                    <div class="p-6 text-center bg-gradient-to-br from-purple-50 to-pink-50 border-b border-gray-100">
                        <form action="{{ route('fraccional.profile.avatar') }}" method="POST" enctype="multipart/form-data"
                              x-data="{ preview: null }" class="inline-block relative group">
                            @csrf @method('PUT')
                            <img x-bind:src="preview || '{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}'"
                                 class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-md mx-auto">
                            <label class="absolute inset-0 bg-black/50 rounded-2xl opacity-0 group-hover:opacity-100 transition flex items-center justify-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                <input type="file" name="avatar" class="hidden" accept="image/*"
                                       @change="preview = URL.createObjectURL($event.target.files[0]); $nextTick(() => $event.target.form.submit())">
                            </label>
                        </form>

                        <h3 class="mt-4 text-lg font-medium">{{ $user->name }} {{ $user->last_name }}</h3>
                        <p class="text-sm text-gray-600">{{ $user->currentPosition ?? $user->profession ?? 'Completá tu profesión' }}</p>
                    </div>

                    {{-- Estado Stripe --}}
                    <div class="p-4 border-b border-gray-100">
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Pagos</p>
                        @if($user->stripe_account_id && $user->stripe_charges_enabled)
                            <div class="flex items-center gap-2 text-sm text-green-700">
                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                Cuenta conectada
                            </div>
                        @else
                            <a href="{{ route('fraccional.stripe.connect') }}"
                               class="block text-sm text-amber-700 hover:underline">
                                ⚠ Conectar cuenta Stripe
                            </a>
                        @endif
                    </div>

                    {{-- Tabs --}}
                    <nav class="p-2">
                        <button @click="tab = 'personal'" :class="tab === 'personal' ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium transition">
                            Información personal
                        </button>
                        <button @click="tab = 'professional'" :class="tab === 'professional' ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium transition">
                            Perfil profesional
                        </button>
                        <button @click="tab = 'availability'" :class="tab === 'availability' ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium transition">
                            Disponibilidad & tarifas
                        </button>
                    </nav>
                </div>
            </aside>

            {{-- Form --}}
            <div class="lg:col-span-2">
                <form action="{{ route('fraccional.profile.update') }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    {{-- Tab: Personal --}}
                    <div x-show="tab === 'personal'" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <h3 class="text-lg font-medium">Información personal</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">País</label>
                                <input type="text" name="country" value="{{ old('country', $user->country) }}"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                       placeholder="https://linkedin.com/in/tu-usuario"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sitio web</label>
                                <input type="url" name="website" value="{{ old('website', $user->website) }}"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                        </div>
                    </div>

                    {{-- Tab: Professional --}}
                    <div x-show="tab === 'professional'" x-cloak class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <h3 class="text-lg font-medium">Perfil profesional</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Profesión</label>
                                <input type="text" name="profession" value="{{ old('profession', $user->profession) }}"
                                       placeholder="Ej: HR Manager Fraccional"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Posición actual</label>
                                <input type="text" name="currentPosition" value="{{ old('currentPosition', $user->currentPosition) }}"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Años de experiencia</label>
                                <input type="number" name="years_of_experience" value="{{ old('years_of_experience', $user->years_of_experience) }}" min="0" max="70"
                                       class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Seniority</label>
                                <select name="seniority" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                                    <option value="">—</option>
                                    @foreach(['junior','semi-senior','senior'] as $s)
                                        <option value="{{ $s }}" @selected(old('seniority', $user->seniority) === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio corta</label>
                            <textarea name="bio" rows="3" maxlength="500"
                                      class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border"
                                      placeholder="Una descripción breve sobre vos">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Experiencia laboral</label>
                            <textarea name="bio_laboral" rows="4" maxlength="2000"
                                      class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border"
                                      placeholder="Contá tu trayectoria, logros, proyectos destacados...">{{ old('bio_laboral', $user->bio_laboral) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Idiomas</label>
                            <input type="text" name="languages" value="{{ old('languages', is_array($user->languages) ? implode(', ', $user->languages) : $user->languages) }}"
                                   placeholder="Ej: Español, Inglés, Portugués"
                                   class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                            <p class="text-xs text-gray-500 mt-1">Separá por comas.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Industrias / Sectores</label>
                            <input type="text" name="sectors" value="{{ old('sectors', is_array($user->sectors) ? implode(', ', $user->sectors) : $user->sectors) }}"
                                   placeholder="Ej: Tecnología, Fintech, Retail"
                                   class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                        </div>
                    </div>

                    {{-- Tab: Availability --}}
                    <div x-show="tab === 'availability'" x-cloak class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <h3 class="text-lg font-medium">Disponibilidad & tarifas</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Horas semanales disponibles
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="range" name="weekly_hours_available"
                                           value="{{ old('weekly_hours_available', $user->weekly_hours_available ?? 20) }}"
                                           min="0" max="40" step="1"
                                           class="flex-1"
                                           x-data
                                           x-on:input="$refs.hoursLabel.textContent = $event.target.value">
                                    <span class="text-lg font-semibold text-purple-600 min-w-[3rem] text-right">
                                        <span x-ref="hoursLabel">{{ $user->weekly_hours_available ?? 20 }}</span>
                                        <span class="text-sm text-gray-500">hs</span>
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">¿Cuántas horas por semana podés dedicar a trabajos fraccionales?</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl cursor-pointer">
                                    <input type="checkbox" name="workingNow" value="1" @checked(old('workingNow', $user->workingNow))
                                           class="rounded text-purple-600 focus:ring-purple-500">
                                    <div>
                                        <p class="text-sm font-medium">Actualmente ocupado</p>
                                        <p class="text-xs text-gray-500">Marcá esto si ya estás cargado en varios proyectos y no podés tomar nuevos trabajos por ahora.</p>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tarifa mensual</label>
                                <div class="flex gap-2">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                                    <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}" min="0" step="0.01"
                                           class="flex-1 rounded-r-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Es tu tarifa de referencia. Se puede negociar en cada contrato.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Moneda</label>
                                <select name="currency" class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:ring-0 border">
                                    @foreach(['USD','ARS','EUR'] as $c)
                                        <option value="{{ $c }}" @selected(old('currency', $user->currency) === $c)>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Guardar --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('fraccional.show', $user) }}" target="_blank"
                           class="px-4 py-2.5 text-sm font-medium text-gray-200 border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition">
                            Ver mi perfil público
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg hover:from-purple-700 hover:to-pink-700 transition">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection