@extends('backend.layout.app')

@section('page_title', 'Editar Usuario')

@section('main_content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl text-white font-bold mb-6">Editar Usuario</h1>

    @if($errors->any())
        <div class="bg-red-500 p-2 rounded mb-4 text-white">
            <strong>Hay errores en el formulario:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Información General -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Información General</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Apellido</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Contraseña (opcional)</label>
                    <input type="password" name="password" class="w-full border rounded p-2"
                        placeholder="Dejar vacío para no cambiar">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Fecha de nacimiento</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Género</label>
                    <select name="gender" class="w-full border rounded p-2">
                        <option value="">Seleccionar</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Hombre</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Mujer</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Perfil -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Perfil</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium">País</label>
                    <input type="text" name="country" value="{{ old('country', $user->country) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Ciudad</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Profesión</label>
                    <input type="text" name="profession" value="{{ old('profession', $user->profession) }}"
                        class="w-full border rounded p-2">
                </div>
            </div>

            <div>
                <label class="block mb-1 font-medium">Bio personal</label>
                <textarea name="bio" rows="3" class="w-full border rounded p-2">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">Bio laboral</label>
                <textarea name="bio_laboral" rows="3" class="w-full border rounded p-2">{{ old('bio_laboral', $user->bio_laboral) }}</textarea>
            </div>

            <!-- Avatar -->
            <div class="flex items-center gap-4">
                <div>
                    <label class="block mb-1 font-medium">Avatar</label>
                    <input type="file" name="avatar">
                </div>

                @if($user->avatar)
                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}"
                         class="w-20 h-20 rounded-full object-cover border">
                @endif
            </div>
        </div>

        <!-- Experiencia Laboral -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Experiencia Laboral</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">¿Trabaja actualmente?</label>
                    <select name="workingNow" class="w-full border rounded p-2">
                        <option value="">Seleccionar</option>
                        <option value="1" {{ old('workingNow', $user->workingNow) == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('workingNow', $user->workingNow) === 0 || old('workingNow', $user->workingNow) === '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Años de experiencia</label>
                    <input type="number" name="years_of_experience" value="{{ old('years_of_experience', $user->years_of_experience) }}"
                        class="w-full border rounded p-2" min="0">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Posición actual</label>
                    <input type="text" name="currentPosition" value="{{ old('currentPosition', $user->currentPosition) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Última posición</label>
                    <input type="text" name="lastPosition" value="{{ old('lastPosition', $user->lastPosition) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Seniority</label>
                    <select name="seniority" class="w-full border rounded p-2">
                        <option value="">Seleccionar</option>
                        <option value="junior" {{ old('seniority', $user->seniority) == 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="semi-senior" {{ old('seniority', $user->seniority) == 'semi-senior' ? 'selected' : '' }}>Semi-Senior</option>
                        <option value="senior" {{ old('seniority', $user->seniority) == 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="lead" {{ old('seniority', $user->seniority) == 'lead' ? 'selected' : '' }}>Lead</option>
                        <option value="director" {{ old('seniority', $user->seniority) == 'director' ? 'selected' : '' }}>Director</option>
                        <option value="c-level" {{ old('seniority', $user->seniority) == 'c-level' ? 'selected' : '' }}>C-Level</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block mb-1 font-medium">Empresas (separadas por coma)</label>
                <input type="text" name="companies" value="{{ old('companies', $user->companies) }}"
                    class="w-full border rounded p-2" placeholder="Ej: Google, Microsoft, Mercado Libre">
            </div>

            <div>
                <label class="block mb-1 font-medium">Sectores (separados por coma)</label>
                <input type="text" name="sectors" value="{{ old('sectors', $user->sectors) }}"
                    class="w-full border rounded p-2" placeholder="Ej: Tecnología, Finanzas, Salud">
            </div>
        </div>

        <!-- Educación e Idiomas -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Educación e Idiomas</h2>

            <div>
                <label class="block mb-1 font-medium">Educación</label>
                <textarea name="education" rows="3" class="w-full border rounded p-2"
                    placeholder="Ej: MBA - Universidad de Buenos Aires, Ing. Sistemas - ITBA">{{ old('education', $user->education) }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">Idiomas (separados por coma)</label>
                <input type="text" name="languages" value="{{ old('languages', $user->languages) }}"
                    class="w-full border rounded p-2" placeholder="Ej: Español, Inglés, Portugués">
            </div>
        </div>

        <!-- Skills -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Skills</h2>

            @if($user->skills)
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $user->skills) as $skill)
                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                            {{ trim($skill) }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div>
                <label class="block mb-1 font-medium">Skills (separadas por coma)</label>
                <input type="text" name="skills" value="{{ old('skills', $user->skills) }}"
                    class="w-full border rounded p-2" placeholder="Ej: Liderazgo, Gestión de equipos, Marketing">
            </div>
        </div>

        <!-- Redes y links -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Redes y Enlaces</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">LinkedIn URL</label>
                    <input type="text" name="linkedin_url" placeholder="https://ar.linkedin.com/" value="{{ old('linkedin_url', $user->linkedin_url) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Website</label>
                    <input type="text" name="website" placeholder="https://www.google.com/" value="{{ old('website', $user->website) }}"
                        class="w-full border rounded p-2">
                </div>
            </div>
        </div>

        <!-- Mentor / Roles -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Rol y Mentor</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Rol</label>
                    <select name="role" class="w-full border rounded p-2">
                        <option value="mentee" {{ $user->role == 'mentee' ? 'selected' : '' }}>Mentee</option>
                        <option value="mentor" {{ $user->role == 'mentor' ? 'selected' : '' }}>Mentor</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">¿Es mentor?</label>
                    <select name="is_mentor" class="w-full border rounded p-2">
                        <option value="0" {{ $user->is_mentor == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $user->is_mentor == 1 ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Nivel de perfil</label>
                    <select name="profile_level" class="w-full border rounded p-2">
                        <option value="">Seleccionar</option>
                        <option value="basic" {{ old('profile_level', $user->profile_level) == 'basic' ? 'selected' : '' }}>Básico</option>
                        <option value="intermediate" {{ old('profile_level', $user->profile_level) == 'intermediate' ? 'selected' : '' }}>Intermedio</option>
                        <option value="complete" {{ old('profile_level', $user->profile_level) == 'complete' ? 'selected' : '' }}>Completo</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tarifas -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Tarifas y Pagos</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Tarifa por hora</label>
                    <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}"
                        class="w-full border rounded p-2" step="0.01" min="0">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Moneda</label>
                    <select name="currency" class="w-full border rounded p-2">
                        <option value="">Seleccionar</option>
                        <option value="USD" {{ old('currency', $user->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('currency', $user->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="ARS" {{ old('currency', $user->currency) == 'ARS' ? 'selected' : '' }}>ARS</option>
                        <option value="BRL" {{ old('currency', $user->currency) == 'BRL' ? 'selected' : '' }}>BRL</option>
                        <option value="MXN" {{ old('currency', $user->currency) == 'MXN' ? 'selected' : '' }}>MXN</option>
                        <option value="CLP" {{ old('currency', $user->currency) == 'CLP' ? 'selected' : '' }}>CLP</option>
                        <option value="COP" {{ old('currency', $user->currency) == 'COP' ? 'selected' : '' }}>COP</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">PayPal Email</label>
                    <input type="email" name="paypal_email" value="{{ old('paypal_email', $user->paypal_email) }}"
                        class="w-full border rounded p-2">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Stripe Connect ID</label>
                    <input type="text" name="stripe_connect_id" value="{{ old('stripe_connect_id', $user->stripe_connect_id) }}"
                        class="w-full border rounded p-2">
                </div>
            </div>
        </div>

        <!-- Estado -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Estado</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Activo</label>
                    <select name="active" class="w-full border rounded p-2">
                        <option value="1" {{ $user->active ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !$user->active ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Sesión completa</label>
                    <select name="session_complete" class="w-full border rounded p-2">
                        <option value="1" {{ $user->session_complete ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !$user->session_complete ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Registro completo</label>
                    <select name="is_register_end" class="w-full border rounded p-2">
                        <option value="1" {{ old('is_register_end', $user->is_register_end) ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !old('is_register_end', $user->is_register_end) ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Rating promedio</label>
                    <input type="number" step="0.1" name="average_rating" min="0" max="5"
                        value="{{ old('average_rating', $user->average_rating) }}"
                        class="w-full border rounded p-2">
                </div>
            </div>
        </div>

        <!-- Info de proveedor OAuth (solo lectura) -->
        @if($user->provider || $user->linkedin_id)
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Autenticación Externa <span class="text-sm text-gray-400 font-normal">(solo lectura)</span></h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($user->provider)
                <div>
                    <label class="block mb-1 font-medium text-gray-500">Proveedor</label>
                    <input type="text" value="{{ $user->provider }}" class="w-full border rounded p-2 bg-gray-100" disabled>
                </div>
                @endif

                @if($user->provider_id)
                <div>
                    <label class="block mb-1 font-medium text-gray-500">Provider ID</label>
                    <input type="text" value="{{ $user->provider_id }}" class="w-full border rounded p-2 bg-gray-100" disabled>
                </div>
                @endif

                @if($user->linkedin_id)
                <div>
                    <label class="block mb-1 font-medium text-gray-500">LinkedIn ID</label>
                    <input type="text" value="{{ $user->linkedin_id }}" class="w-full border rounded p-2 bg-gray-100" disabled>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Estadísticas rápidas (solo lectura) -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            {{-- <h2 class="text-xl font-semibold">Estadísticas <span class="text-sm text-gray-400 font-normal">(solo lectura)</span></h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">{{ $user->sessionsAsMentor->count() }}</p>
                    <p class="text-sm text-gray-500">Sesiones como mentor</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ $user->sessionsAsMentee->count() }}</p>
                    <p class="text-sm text-gray-500">Sesiones como mentee</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ $user->reviewsReceived->count() }}</p>
                    <p class="text-sm text-gray-500">Reviews recibidas</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-2xl font-bold text-orange-600">{{ $user->tickets->count() }}</p>
                    <p class="text-sm text-gray-500">Tickets</p>
                </div>
            </div> --}}

            <p class="text-xs text-gray-400">
                Registrado: {{ $user->created_at->format('d/m/Y H:i') }}
                · Última actualización: {{ $user->updated_at->format('d/m/Y H:i') }}
                @if($user->email_verified_at)
                    · Email verificado: {{ $user->email_verified_at->format('d/m/Y') }}
                @else
                    · <span class="text-red-500">Email no verificado</span>
                @endif
            </p>
        </div>

        <!-- Submit -->
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600">
                ← Volver a la lista
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Guardar cambios
            </button>
        </div>

    </form>
</div>
@endsection