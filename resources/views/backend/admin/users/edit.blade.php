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
                    <label class="block mb-1 font-medium">Género</label>
                    <select name="gender" class="w-full border rounded p-2">
                        <option value="">Seleccionar</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Hombre</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Mujer</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block mb-1 font-medium">Profesión</label>
                <input type="text" name="profession" value="{{ old('profession', $user->profession) }}"
                    class="w-full border rounded p-2">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Rol</label>
                    <select name="role" class="w-full border rounded p-2">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario</option>
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
            </div>
        </div>

        <!-- Tarifas -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Tarifas y Pagos</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Tarifa por hora</label>
                    <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Moneda</label>
                    <input type="text" name="currency" value="{{ old('currency', $user->currency) }}"
                        class="w-full border rounded p-2">
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

                <div>
                    <label class="block mb-1 font-medium">Años de experiencia</label>
                    <input type="number" name="years_of_experience" value="{{ old('years_of_experience', $user->years_of_experience) }}"
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
                    <label class="block mb-1 font-medium">Rating promedio</label>
                    <input type="number" step="0.1" name="average_rating"
                        value="{{ old('average_rating', $user->average_rating) }}"
                        class="w-full border rounded p-2">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Guardar cambios
            </button>
        </div>

    </form>
</div>
@endsection
