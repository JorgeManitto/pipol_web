@extends('backend.layout.app')
@section('page_title', 'Editar Perfil de '.$user->name.' '.$user->last_name)

@section('main_content')
{{-- <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 my-24">
    <h1 class="text-2xl font-bold mb-4">Editar perfil</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
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

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf


        <div class="flex gap-4 py-8">
       
            
        </div>
        <div class="grid grid-cols-2 gap-4">
            
            <div>
                <label>Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label>Apellido</label>
                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2">
            </div>
            <div class="col-span-2">
                <label>Bio</label>
                <textarea name="bio" rows="3" class="w-full border rounded p-2">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div>
                <label>Profesión</label>
                <input type="text" name="profession" value="{{ old('profession', $user->profession) }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label>Tarifa por hora</label>
                <input type="number" step="0.01" name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label>País</label>
                <input type="text" name="country" value="{{ old('country', $user->country) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label for="is_mentor">Ser Mentor</label>
                <select name="is_mentor" class="w-full border rounded p-2">
                    <option value="0" {{ old('is_mentor', $user->is_mentor) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('is_mentor', $user->is_mentor) == 1 ? 'selected' : '' }}>Sí</option>
                </select>
                
            </div>

            @if ($user->is_mentor)
                <div class="col-span-2">
                    <label>Skills</label>
                    <select name="skills[]" multiple class="w-full border rounded p-2">
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}" {{ $user->skills->contains($skill->id) ? 'selected' : '' }}>
                                {{ $skill->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </form>
</div> --}}
    <!-- Main Content -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #1a3a2e 0%, #2d5a4a 100%);
        }
        
        .skill-tag {
            transition: all 0.2s ease;
        }
        
        .skill-tag:hover {
            transform: translateY(-2px);
        }
        
        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-upload-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }
        
        .profile-preview {
            transition: all 0.3s ease;
        }
        
        .profile-preview:hover {
            transform: scale(1.05);
        }
    </style>
    <main class="container px-6 py-12 max-w-6xl">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-stone-800 mb-2">Editar Perfil</h1>
            <p class="text-stone-600">Actualiza tu información para que otros puedan conocerte mejor</p>
        </div>
        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
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

        <!-- Edit Form -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-8 space-y-8">
            <!-- Profile Photo Section -->
            @csrf

            <div class="border-b border-stone-200 pb-8">
                <h2 class="text-xl font-semibold text-stone-800 mb-6">Foto de Perfil</h2>
                <div class="flex items-center gap-6">
                    @if ($user->avatar)
                    <div class="profile-preview">
                        <img id="previewImagen" src="{{ asset('storage/avatars/'.$user->avatar) }}" 
                             alt="Foto de perfil" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-amber-500">
                    </div>
                    @else
                    <div class="profile-preview">
                        <img id="previewImagen" src="{{ asset('images/default-avatar.png') }}" 
                             alt="Foto de perfil" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-amber-500">
                    </div>
                    @endif
                    <div class="flex-1">
                        <div class="file-upload-wrapper">
                            <label for="photoUpload" class="bg-stone-800 hover:bg-stone-700 text-white px-6 py-3 rounded-lg cursor-pointer inline-block transition">
                                Cambiar Foto
                            </label>
                            <input type="file"  accept="image/*" type="file" name="avatar" id="photoUpload" class="hidden">
                        </div>
                        <p class="text-sm text-stone-500 mt-2">JPG, PNG o GIF. Máximo 5MB.</p>
                    </div>
                </div>
                <script>
                    // const inputImagen = document.querySelector('input[name="avatar"]');
                    const inputImagen = document.getElementById('photoUpload');
                    const previewImagen = document.getElementById('previewImagen');
                    console.log(inputImagen);
                    
                    inputImagen.addEventListener('change', function() {
                        const file = this.files[0];
                        console.log(file);
                        
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImagen.setAttribute('src', e.target.result);
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                </script>
            </div>

            <!-- Basic Information -->
            <div class="border-b border-stone-200 pb-8">
                <h2 class="text-xl font-semibold text-stone-800 mb-6">Información Básica</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-stone-700 mb-2">
                            Nombre *
                        </label>
                        <input type="text" 
                               id="nombre" 
                                name="name" value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                               required>
                    </div>

                    <div>
                        <label for="nombre" class="block text-sm font-medium text-stone-700 mb-2">
                            Apellido *
                        </label>
                        <input type="text" 
                               id="nombre" 
                               name="last_name" value="{{ old('last_name', $user->last_name) }}"
                               class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                               required>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-stone-700 mb-2">
                            Email *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                               required>
                    </div>
                    
                    <div>
                        <label for="rol" class="block text-sm font-medium text-stone-700 mb-2">
                            Profesión 
                        </label>
                        <input type="text" 
                               id="rol" 
                               name="profession" value="{{ old('profession', $user->profession) }}"
                               class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                               required>
                    </div>
                    
                    <div>
                        <label for="ubicacion" class="block text-sm font-medium text-stone-700 mb-2">
                            Ubicación *
                        </label>
                        <input type="text" 
                               id="ubicacion" 
                               name="country" value="{{ old('country', $user->country) }}"
                               class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                               required>
                    </div>
                    
                    <div>
                        <label for="tarifa" class="block text-sm font-medium text-stone-700 mb-2">
                            Tarifa por Hora 
                        </label>
                        <input type="number" 
                               id="tarifa" 
                                name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                               required>
                    </div>
                </div>
            </div>

            <!-- About Me -->
            <div class="border-b border-stone-200 pb-8">
                <h2 class="text-xl font-semibold text-stone-800 mb-6">Sobre Mí</h2>
                <div>
                    <label for="bio" class="block text-sm font-medium text-stone-700 mb-2">
                        Descripción Profesional 
                    </label>
                    <textarea id="bio" 
                              rows="8" name="bio" 
                              class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"
                              required>{{ old('bio', $user->bio) }}</textarea>
                    <p class="text-sm text-stone-500 mt-2">Cuéntale a otros sobre tu experiencia, logros y qué puedes aportar como mentor.</p>
                </div>
            </div>

            <!-- About Me -->
            <div class="border-b border-stone-200 pb-8">
                <h2 class="text-xl font-semibold text-stone-800 mb-6">Experiencia Laboral</h2>
                <div>
                    <label for="bio_laboral" class="block text-sm font-medium text-stone-700 mb-2">
                        Descripción Laboral 
                    </label>
                    <textarea id="bio_laboral" 
                              rows="8" name="bio_laboral" 
                              class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"
                              required>{{ old('bio', $user->bio_laboral) }}</textarea>
                    {{-- <p class="text-sm text-stone-500 mt-2">Cuéntale a otros sobre tu experiencia, logros y qué puedes aportar como mentor.</p> --}}
                </div>
            </div>

            @if ($user->is_mentor)
                <div class="col-span-2">
                    <label>Skills</label>
                    <select name="skills[]" multiple class="w-full border rounded p-2">
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}" {{ $user->skills->contains($skill->id) ? 'selected' : '' }}>
                                {{ $skill->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Skills -->
            {{-- <div class="pb-8">
                <h2 class="text-xl font-semibold text-stone-800 mb-6">Habilidades</h2>
                <div>
                    <label for="nuevaHabilidad" class="block text-sm font-medium text-stone-700 mb-2">
                        Agregar Habilidad
                    </label>
                    <div class="flex gap-2 mb-4">
                        <input type="text" 
                               id="nuevaHabilidad" 
                               placeholder="Ej: Marketing Digital"
                               class="flex-1 px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                        <button type="button" 
                                onclick="agregarHabilidad()"
                                class="bg-stone-800 hover:bg-stone-700 text-white px-6 py-3 rounded-lg font-medium transition">
                            Agregar
                        </button>
                    </div>
                    
                    <div id="habilidadesContainer" class="flex flex-wrap gap-3">
                        <div class="skill-tag bg-amber-100 text-amber-800 px-4 py-2 rounded-full flex items-center gap-2">
                            <span>Marketing Digital</span>
                            <button type="button" onclick="eliminarHabilidad(this)" class="text-amber-600 hover:text-amber-800 font-bold">×</button>
                        </div>
                        <div class="skill-tag bg-amber-100 text-amber-800 px-4 py-2 rounded-full flex items-center gap-2">
                            <span>Programación Web</span>
                            <button type="button" onclick="eliminarHabilidad(this)" class="text-amber-600 hover:text-amber-800 font-bold">×</button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-stone-200">
                <a href="perfil.html" 
                   class="flex-1 bg-stone-200 hover:bg-stone-300 text-stone-800 px-8 py-4 rounded-lg font-semibold text-lg transition text-center">
                    Cancelar
                </a>
                <button type="submit" 
                        class="flex-1 bg-[#2d5a4a] hover:bg-3d6a5a text-white px-8 py-4 rounded-lg font-semibold text-lg transition shadow-lg hover:shadow-xl">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </main>
@endsection