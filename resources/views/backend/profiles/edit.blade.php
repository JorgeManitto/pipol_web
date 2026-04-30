@extends('backend.layout.app')
@section('page_title', 'Editar Perfil de '.$user->name)

@section('main_content')
<style >
    * {
        font-family: 'Inter', sans-serif;
    }
    
    .section-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: .5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: .5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-group {
        margin-bottom: .5rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.3rem;
    }
    
    .form-label.required::after {
        content: " *";
        color: #ef4444;
    }
    
    .form-input {
        width: 100%;
        padding: .5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #2d5a4a;
        box-shadow: 0 0 0 3px rgba(45, 90, 74, 0.1);
    }
    
    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }
    
    .image-preview-container {
        position: relative;
        display: inline-block;
    }
    
    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 0.75rem;
        border: 3px solid #e5e7eb;
        transition: all 0.3s;
    }
    
    .image-preview:hover {
        border-color: #2d5a4a;
        transform: scale(1.05);
    }
    
    .image-preview.avatar {
        border-radius: 50%;
        width: 120px;
        height: 120px;
    }
    
    .file-upload-btn {
        display: inline-block;
        padding: 0.625rem 1.5rem;
        background: #2d5a4a;
        color: white;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .file-upload-btn:hover {
        background: #3d6a5a;
        transform: translateY(-1px);
    }
    
    .help-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.375rem;
    }
    
    .btn-primary-edit {
        background: #2d5a4a;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary-edit:hover {
        background: #3d6a5a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 90, 74, 0.3);
    }
    
    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-secondary:hover {
        background: #d1d5db;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
        /* Animación para el botón de IA */
    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(147, 51, 234, 0.7);
        }
        50% {
            box-shadow: 0 0 0 6px rgba(147, 51, 234, 0);
        }
    }
    
    #btnMejorarBio:hover {
        animation: pulse-glow 2s infinite;
    }
    
    /* Efecto de escritura para el textarea */
    #bio.typing {
        border-color: #9333ea;
        box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
    }
</style>

<main class="container max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">Editar Perfil</h1>
        <p class="text-white">Actualiza tu información profesional para destacar ante clientes potenciales</p>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success">
            <strong>✓</strong> {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-error">
            <strong>⚠ Hay errores en el formulario:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- SECCIÓN 1: FOTO DE PERFIL -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Foto de Perfil
            </h2>
            
            <div class="flex flex-col md:flex-row items-start gap-6">
                <div class="image-preview-container">
                    <img id="avatarPreview" 
                         src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                         alt="Avatar" 
                         class="image-preview avatar">
                </div>
                
                <div class="flex-1">
                    <label for="avatarUpload" class="file-upload-btn">
                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Cambiar Foto de Perfil
                    </label>
                    <input type="file" id="avatarUpload" name="avatar" accept="image/*" class="hidden">
                    <p class="help-text mt-2">JPG, PNG o GIF. Máximo 2MB. Recomendado: 400x400px</p>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 2: INFORMACIÓN BÁSICA -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Información Básica
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="name" class="form-label required">Nombre Completo</label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="form-input" required>
                </div>

                {{-- <div class="form-group">
                    <label for="last_name" class="form-label">Apellido</label>
                    <input type="text" id="last_name" name="last_name" 
                           value="{{ old('last_name', $user->last_name) }}" 
                           class="form-input">
                </div> --}}

                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" id="email" name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" id="birth_date" name="birth_date" 
                           value="{{ old('birth_date', $user->birth_date) }}" 
                           class="form-input">
                </div>

                <div class="form-group">
                    <label for="gender" class="form-label">Género</label>
                    <select id="gender" name="gender" class="form-input">
                        <option value="">Seleccionar...</option>
                        <option value="Masculino" {{ old('gender', $user->gender) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('gender', $user->gender) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('gender', $user->gender) == 'Otro' ? 'selected' : '' }}>Otro</option>
                        <option value="Prefiero no decir" {{ old('gender', $user->gender) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="profession" class="form-label">Profesión/Título</label>
                    <input type="text" id="profession" name="profession" 
                           value="{{ old('profession', $user->profession) }}" 
                           class="form-input"
                           placeholder="Ej: Diseñador UX/UI, Developer Full Stack">
                </div>

                <div class="form-group">
                    <label for="country" class="form-label required">País</label>
                    <input type="text" id="country" name="country" 
                           value="{{ old('country', $user->country) }}" 
                           class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">Ciudad</label>
                    <input type="text" id="city" name="city" 
                           value="{{ old('city', $user->city) }}" 
                           class="form-input">
                </div>
            </div>
        </div>

        <!-- SECCIÓN 3: PERFIL PROFESIONAL -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Perfil Profesional
            </h2>
            
            <div class="form-group">
                <div class="flex justify-between items-center mb-2">
                    <label for="bio" class="form-label mb-0">Biografía Profesional</label>
                    <button type="button" 
                            onclick="mejorarBioConIA()" 
                            id="btnMejorarBio"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span id="btnMejorarBioText">Mejorar con IA</span>
                    </button>
                </div>
                <textarea id="bio" name="bio" rows="8" 
                        class="form-input form-textarea">{{ old('bio', $user->bio) }}</textarea>
                <p class="help-text">Describe tu experiencia, especialización, trayectoria laboral y qué puedes ofrecer como mentor. Máximo 2000 caracteres.</p>
                
                <!-- Indicador de procesamiento -->
                <div id="bioProcessing" class="hidden mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm text-blue-800 font-medium">Mejorando tu biografía con IA...</span>
                    </div>
                </div>
            </div>

            <!-- Subir CV -->
            <div class="border-b border-stone-200 pb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-stone-800">Importar desde CV</h2>
                </div>
                <p class="text-sm text-stone-500 mb-4">Sube tu CV en PDF y la IA extraerá tu información automáticamente.</p>
                <div class="flex items-center gap-4">
                    <label for="cvUpload" class="inline-flex items-center gap-2 px-5 py-3 bg-stone-800 hover:bg-stone-700 text-white font-semibold rounded-lg cursor-pointer transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Subir CV (PDF)
                    </label>
                    <input type="file" accept=".pdf,.doc,.docx" id="cvUpload" class="hidden">
                    <span id="cvFileName" class="text-sm text-stone-500"></span>
                </div>
                <!-- Indicador de procesamiento CV -->
                <div id="cvProcessing" class="hidden mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="cvProcessingText" class="text-sm text-blue-800 font-medium">Extrayendo texto del CV...</span>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="years_of_experience" class="form-label">Años de Experiencia</label>
                    <input type="number" id="years_of_experience" name="years_of_experience" 
                        value="{{ old('years_of_experience', $user->years_of_experience) }}" 
                        class="form-input" min="0" max="50">
                </div>

                <div class="form-group">
                    <label for="seniority" class="form-label">Nivel de Seniority</label>
                    <select id="seniority" name="seniority" class="form-input">
                        <option value="">Seleccionar...</option>
                        <option value="Jefe" {{ old('seniority', $user->seniority) == 'Jefe' ? 'selected' : '' }}>Jefe</option>
                        <option value="Gerente" {{ old('seniority', $user->seniority) == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                        <option value="Director" {{ old('seniority', $user->seniority) == 'Director' ? 'selected' : '' }}>Director</option>
                        <option value="CEO" {{ old('seniority', $user->seniority) == 'CEO' ? 'selected' : '' }}>CEO</option>
                        <option value="Emprendedor" {{ old('seniority', $user->seniority) == 'Emprendedor' ? 'selected' : '' }}>Emprendedor</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="skills" class="form-label">Habilidades</label>
                <textarea id="skills" name="skills" rows="3" 
                        class="form-input form-textarea"
                        placeholder="Ej: liderazgo de equipos, gestión del talento, toma de decisiones">{{ old('skills', $user->skills) }}</textarea>
                <p class="help-text">Separa las habilidades con comas. Ej: Python, JavaScript, React, Node.js</p>
            </div>
        </div>

        <!-- SECCIÓN 4: EXPERIENCIA LABORAL -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Experiencia Laboral
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="workingNow" class="form-label">¿Trabajando actualmente?</label>
                    <select id="workingNow" name="workingNow" class="form-input" onchange="toggleWorkFields()">
                        <option value="1" {{ old('workingNow', $user->workingNow) == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('workingNow', $user->workingNow) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="form-group" id="currentPositionGroup" style="{{ old('workingNow', $user->workingNow) == 1 ? '' : 'display:none' }}">
                    <label for="currentPosition" class="form-label">Puesto Actual</label>
                    <input type="text" id="currentPosition" name="currentPosition" 
                        value="{{ old('currentPosition', $user->currentPosition) }}" 
                        class="form-input"
                        placeholder="Ej: Senior Developer">
                </div>

                <div class="form-group" id="lastPositionGroup">
                    <label for="lastPosition" class="form-label">Último Puesto</label>
                    <input type="text" id="lastPosition" name="lastPosition" 
                        value="{{ old('lastPosition', $user->lastPosition) }}" 
                        class="form-input">
                </div>

                <div class="form-group">
                    <label for="companies" class="form-label">Empresas</label>
                    <input type="text" id="companies" name="companies" 
                        value="{{ old('companies', $user->companies) }}" 
                        class="form-input"
                        placeholder="Ej: Google, Microsoft, Amazon">
                    <p class="help-text">Separa con comas si has trabajado en múltiples empresas</p>
                </div>

                <div class="form-group md:col-span-2">
                    <label for="sectors" class="form-label">Sectores/Industrias</label>
                    <input type="text" id="sectors" name="sectors" 
                        value="{{ old('sectors', $user->sectors) }}" 
                        class="form-input"
                        placeholder="Ej: Tecnología, Fintech, E-commerce">
                    <p class="help-text">Separa con comas los diferentes sectores en los que has trabajado</p>
                </div>
            </div>
        </div>

        <script>
            function toggleWorkFields() {
                const working = document.getElementById('workingNow').value;
                document.getElementById('currentPositionGroup').style.display = working === '1' ? '' : 'none';
                document.getElementById('currentPosition').value = working === '1' ? document.getElementById('currentPosition').value : '';
                // document.getElementById('lastPositionGroup').style.display = working === '0' ? '' : 'none';
            }
        </script>

        <!-- SECCIÓN 5: FORMACIÓN Y EDUCACIÓN -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
                Formación y Educación
            </h2>
            
            <div class="form-group">
                <label for="education" class="form-label">Educación</label>
                <textarea id="education" name="education" rows="3" 
                          class="form-input form-textarea"
                          placeholder="Ej: Ingeniería en Sistemas - Universidad Nacional">{{ old('education', $user->education) }}</textarea>
                <p class="help-text">Incluye títulos, certificaciones y cursos relevantes</p>
            </div>

            <div class="form-group">
                <label for="languages" class="form-label">Idiomas</label>
                <input type="text" id="languages" name="languages" 
                       value="{{ old('languages', $user->languages) }}" 
                       class="form-input"
                       placeholder="Ej: Español (nativo), Inglés (avanzado), Portugués (intermedio)">
                <p class="help-text">Separa con comas e indica el nivel si es posible</p>
            </div>
        </div>

        <!-- SECCIÓN 6: TARIFAS Y PAGOS -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tarifas y Métodos de Pago
            </h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="form-group">
                    <label for="hourly_rate" class="form-label">Tarifa por Hora</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" 
                           value="{{ old('hourly_rate', $user->hourly_rate) }}" 
                           class="form-input" step="0.01" min="0"
                           placeholder="0.00">
                </div>

                <div class="form-group">
                    <label for="currency" class="form-label">Moneda</label>
                    <select id="currency" name="currency" class="form-input">
                        <option value="USD" {{ old('currency', $user->currency) == 'USD' ? 'selected' : '' }}>USD - Dólar</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 7: ENLACES PROFESIONALES -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                Enlaces Profesionales
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="linkedin_url" class="form-label">LinkedIn</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" 
                           value="{{ old('linkedin_url', $user->linkedin_url) }}" 
                           class="form-input"
                           placeholder="https://linkedin.com/in/tu-perfil">
                </div>

                <div class="form-group">
                    <label for="website" class="form-label">Sitio Web / Portfolio</label>
                    <input type="url" id="website" name="website" 
                           value="{{ old('website', $user->website) }}" 
                           class="form-input"
                           placeholder="https://tu-sitio.com">
                </div>
            </div>
        </div>

        <!-- SECCIÓN 8: VERIFICACIÓN DE IDENTIDAD -->
        <div id="cameraModal" class="fixed inset-0 z-50 hidden">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="closeCameraModal()"></div>
            
            <!-- Modal Content -->
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                        <h3 id="cameraModalTitle" class="text-lg font-semibold text-gray-800">Capturar Foto</h3>
                        <button onclick="closeCameraModal()" type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Camera View -->
                    <div class="relative bg-black" style="min-height: 350px;">
                        <!-- Video (cámara en vivo) -->
                        <video id="cameraStream" autoplay playsinline 
                            class="w-full h-full object-cover" style="min-height: 350px; display: block;">
                        </video>

                        <!-- Canvas oculto para captura -->
                        <canvas id="cameraCanvas" class="hidden"></canvas>

                        <!-- Preview de foto capturada -->
                        <img id="capturedPreview" class="w-full h-full object-cover hidden" style="min-height: 350px;" alt="Foto capturada">

                        <!-- Indicador de carga -->
                        <div id="cameraLoading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 text-white">
                            <svg class="animate-spin w-10 h-10 mb-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <p class="text-sm">Iniciando cámara...</p>
                        </div>

                        <!-- Mensaje de error -->
                        <div id="cameraError" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900 text-white hidden px-6 text-center">
                            <svg class="w-12 h-12 mb-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p id="cameraErrorMsg" class="text-sm mb-3">No se pudo acceder a la cámara</p>
                            <button onclick="retryCameraAccess()" class="px-4 py-2 bg-white text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                                Reintentar
                            </button>
                        </div>

                        <!-- Guía visual (overlay) -->
                        <div id="cameraGuide" class="absolute inset-0 pointer-events-none hidden">
                            <!-- Guía para selfie -->
                            <div id="selfieGuide" class="absolute inset-0 flex items-center justify-center hidden">
                                <div class="w-48 h-60 border-2 border-dashed border-white/60 rounded-full"></div>
                            </div>
                            <!-- Guía para documento -->
                            <div id="documentGuide" class="absolute inset-0 flex items-center justify-center hidden">
                                <div class="w-72 h-44 border-2 border-dashed border-white/60 rounded-lg"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Controles -->
                    <div class="px-6 py-5 bg-gray-50">
                        <!-- Controles de captura (estado: cámara activa) -->
                        <div id="captureControls" class="flex items-center justify-center gap-4">
                            <!-- Cambiar cámara (frontal/trasera) -->
                            <button onclick="switchCamera()" type="button" id="switchCameraBtn" 
                                class="w-12 h-12 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:text-gray-800 hover:shadow-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>

                            <!-- Botón capturar -->
                            <button onclick="capturePhoto()" type="button" id="captureBtn"
                                class="w-16 h-16 rounded-full bg-white border-4 border-gray-300 shadow-lg hover:border-blue-400 hover:shadow-xl transition-all active:scale-95 flex items-center justify-center">
                                <div class="w-12 h-12 rounded-full bg-red-500 hover:bg-red-600 transition-colors"></div>
                            </button>

                            <!-- Placeholder para centrar -->
                            <div class="w-12 h-12"></div>
                        </div>

                        <!-- Controles de confirmación (estado: foto capturada) -->
                        <div id="confirmControls" class="hidden flex items-center justify-center gap-4">
                            <!-- Descartar y volver a tomar -->
                            <button onclick="retakePhoto()" 
                                class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Repetir
                            </button>

                            <!-- Confirmar foto -->
                            <button onclick="confirmPhoto()" 
                                class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Usar Foto
                            </button>
                        </div>

                        <!-- Tip -->
                        <p id="cameraTip" class="text-xs text-center text-gray-500 mt-3">
                            Asegúrate de tener buena iluminación
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 8: VERIFICACIÓN DE IDENTIDAD (actualizada) -->
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Verificación de Identidad
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Selfie -->
                <div class="form-group">
                    <label class="form-label">Selfie de Verificación</label>
                    <div class="mb-3">
                        <div class="image-preview-container">
                            <img id="selfiePreview" 
                                src="{{ $user->selfie ? route('private.image', ['path' => $user->selfie]) : asset('images/placeholder-selfie.png') }}" 
                                alt="Selfie" 
                                class="image-preview">
                        </div>
                    </div>
                    <!-- Botón que abre la cámara -->
                    <button type="button" onclick="openCameraModal('selfie')" class="file-upload-btn w-full text-center">
                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Tomar Selfie
                    </button>
                    <!-- Input hidden para enviar al server -->
                    <input type="file" id="selfieUpload" name="selfie" accept="image/*" class="hidden">
                    {{-- <p class="help-text mt-2">Foto tuya</p> --}}
                </div>

                <!-- Documento -->
                <div class="form-group hidden">
                    <label class="form-label">Foto del Documento</label>
                    <div class="mb-3">
                        <div class="image-preview-container">
                            <img id="documentPreview" 
                                src="{{ $user->documentPhoto ? route('private.image', ['path' => $user->documentPhoto]) : asset('images/placeholder-document.png') }}" 
                                alt="Documento" 
                                class="image-preview">
                        </div>
                    </div>
                    <!-- Botón que abre la cámara -->
                    <button type="button" onclick="openCameraModal('document')" class="file-upload-btn w-full text-center">
                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Fotografiar Documento
                    </button>
                    <!-- Input hidden para enviar al server -->
                    <input type="file" id="documentUpload" name="documentPhoto" accept="image/*" class="hidden">
                    <p class="help-text mt-2">DNI, Pasaporte o identificación oficial clara y legible</p>
                </div>
            </div>
        </div>

      
        <!-- Stripe Connect -->
        <div class="section-card">
            <div class="form-group md:col-span-3">
                <label class="form-label">Cuenta de Cobro (Stripe)</label>
                @if($user->stripe_connect_status === 'active')
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                            ✓ Conectada
                        </span>
                        <form method="POST" action="{{ route('stripe.disconnect') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:underline">Desconectar</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('stripe.connect') }}" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#635BFF] hover:bg-[#5349e0] text-white font-semibold rounded-lg transition-all">
                        Conectar Stripe
                    </a>
                    <p class="help-text mt-1">Necesitás conectar tu cuenta para recibir pagos de sesiones.</p>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 sticky bottom-0 bg-white p-6 rounded-lg shadow-lg border-t-4 border-[#2d5a4a]">
            <a href="{{ route('profile.show', $user->id) }}" 
            class="btn-secondary text-center flex-1">
                Cancelar
            </a>
            <button type="button" onclick="openProfilePreview()" 
                    class="flex-1 px-4 py-2 bg-[#1a0a3e] hover:bg-[#1a0a3ee8] text-white font-semibold rounded-lg transition-all text-center">
                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Visualizar Perfil
            </button>
            <button type="submit" class="btn-primary-edit flex-1">
                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Cambios
            </button>
        </div>
 
 
{{-- ============================================================
   MODAL VISUALIZAR PERFIL - Colocar antes del cierre de </main>
   ============================================================ --}}
 
<!-- Modal Preview Perfil -->
<div id="profilePreviewModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeProfilePreview()"></div>
    
    <!-- Modal Content -->
    <div class="relative z-10 bg-gray-50 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <!-- Header del modal -->
        <div class="sticky top-0 bg-white flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t-2xl z-10">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Vista previa del perfil</h3>
                <p class="text-xs text-gray-500">Así verán tu perfil los demás usuarios</p>
            </div>
            <button onclick="closeProfilePreview()" type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        @php
            // dd("hola");
        @endphp
 
        <!-- Card Preview -->
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-8 border-blue-500 flex flex-col lg:flex-row gap-6 items-start">
                <!-- Columna izquierda -->
                <div class="flex-1">
                    <!-- Avatar + Nombre -->
                    <div class="flex items-start gap-4 mb-4">
                        <img id="previewAvatar" 
                             src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                             alt="Avatar"
                             class="w-14 h-14 rounded-full object-cover flex-shrink-0 border-2 border-gray-100">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 id="previewName" class="font-semibold text-md text-gray-900">
                                    {{ $user->name }}
                                </h3>
                                {{-- Badge de rango (estático, basado en datos actuales) --}}
                                @php
                                    $sessionCount = $user->sessions_as_mentor_count ?? 0;
                                    $rangos = [
                                        'GOD'      => ['min' => 50, 'color' => '#e11d48', 'bg' => '#fff1f2', 'icon' => '🔥'],
                                        'HERO'     => ['min' => 30, 'color' => '#7c3aed', 'bg' => '#f5f3ff', 'icon' => '⚡'],
                                        'PLATINUM' => ['min' => 20, 'color' => '#0ea5e9', 'bg' => '#f0f9ff', 'icon' => '💎'],
                                        'GOLD'     => ['min' => 10, 'color' => '#d97706', 'bg' => '#fffbeb', 'icon' => '🏆'],
                                        'SILVER'   => ['min' => 5,  'color' => '#6b7280', 'bg' => '#f9fafb', 'icon' => '🥈'],
                                        'BRONZE'   => ['min' => 0,  'color' => '#b45309', 'bg' => '#fef3c7', 'icon' => '🥉'],
                                    ];
                                    $mentorRango = null;
                                    foreach ($rangos as $nombre => $config) {
                                        if ($sessionCount >= $config['min']) {
                                            $mentorRango = ['nombre' => $nombre, ...$config];
                                            break;
                                        }
                                    }
                                @endphp
                                @if ($mentorRango)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                          style="background-color: {{ $mentorRango['bg'] }}; color: {{ $mentorRango['color'] }}; border: 1px solid {{ $mentorRango['color'] }}20;">
                                        <span>{{ $mentorRango['icon'] }}</span>
                                        <span>{{ $mentorRango['nombre'] }}</span>
                                    </span>
                                @endif
                            </div>
                            <p id="previewEducation" class="text-xs text-gray-600 mb-1"></p>
                            <div class="flex items-center gap-1 text-xs text-gray-500">
                                <span id="previewLanguages"></span>
                            </div>
                        </div>
                    </div>
 
                    <!-- Bio -->
                    <div class="mb-4">
                        <p id="previewBio" class="text-gray-700 text-xs leading-relaxed"></p>
                    </div>
 
                    <!-- Modalidad -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Modalidad de atención</p>
                        <div class="flex items-center gap-2 text-xs text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Online</span>
                        </div>
                    </div>
 
                    <!-- Skills -->
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-2">Especialidades:</p>
                        <div id="previewSkills" class="flex flex-wrap gap-1"></div>
                    </div>
                </div>
 
                <!-- Columna derecha -->
                <div class="min-w-[200px]">
                    <button type="button" disabled
                            class="w-full py-3 border border-[#1a0a3e] text-[#1a0a3e] bg-transparent rounded-lg font-medium text-base opacity-70 cursor-default">
                        Conóceme
                    </button>
 
                    <p class="text-xs text-gray-500 mt-6">Valor hora</p>
                    <p id="previewRate" class="text-2xl font-semibold text-[#1a0a3e] mb-4 text-left"></p>
 
                    <!-- Estrellas (datos actuales) -->
                    @php
                        $rating = $user->reviewsReceived->avg('rating') ?? 0; 
                        $totalReviews = $user->reviewsReceived->count();
                        $fullStars = floor($rating);
                        $maxStars = 5;
                    @endphp
                    @if ($totalReviews > 0)
                        <div class="bg-white">
                            <div class="flex flex-col items-start">
                                <div class="flex items-start gap-1 mb-2">
                                    @for ($i = 1; $i <= $maxStars; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $fullStars ? 'text-yellow-400' : 'text-gray-300' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-md font-bold text-gray-800">{{ number_format($rating, 1) }} / 5.0</p>
                                <p class="text-xs text-gray-500 mt-1">Basado en {{ $totalReviews }} {{ Str::plural('reseña', $totalReviews) }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
 
            <!-- Nota informativa -->
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-xs text-blue-700 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Esta vista previa refleja los datos actuales del formulario. Guardá los cambios para que se actualice tu perfil público.
                </p>
            </div>
        </div>
    </div>
</div>
 
 
{{-- ============================================================
   SCRIPT - Agregar dentro del bloque <script> existente
   ============================================================ --}}
 
<script>
function openProfilePreview() {
    // Leer valores actuales del formulario
    const getValue = (id) => document.getElementById(id)?.value?.trim() || '';
 
    // Avatar: usar el preview actual (puede haber cambiado)
    const avatarSrc = document.getElementById('avatarPreview')?.src;
    if (avatarSrc) {
        document.getElementById('previewAvatar').src = avatarSrc;
    }
 
    // Nombre
    document.getElementById('previewName').textContent = getValue('name') || 'Sin nombre';
 
    // Educación
    const education = getValue('education');
    document.getElementById('previewEducation').textContent = education || '';
 
    // Idiomas
    document.getElementById('previewLanguages').textContent = getValue('languages') || '';
 
    // Bio (truncada a 210 chars como en la card original)
    const bio = getValue('bio');
    const truncatedBio = bio.length > 210 ? bio.substring(0, 210) + '...' : bio;
    document.getElementById('previewBio').textContent = truncatedBio || 'Sin biografía aún.';
 
    // Skills
    const skillsContainer = document.getElementById('previewSkills');
    skillsContainer.innerHTML = '';
    const skillsText = getValue('skills');
    if (skillsText) {
        skillsText.split(',').forEach(skill => {
            const trimmed = skill.trim();
            if (trimmed) {
                const tag = document.createElement('span');
                tag.className = 'px-2 py-1 bg-[#f5f0e8] text-[#1a0a3e] text-xs rounded-full';
                tag.textContent = trimmed;
                skillsContainer.appendChild(tag);
            }
        });
    } else {
        skillsContainer.innerHTML = '<span class="text-xs text-gray-400 italic">Sin especialidades</span>';
    }
 
    // Tarifa
    const rate = getValue('hourly_rate');
    const currency = getValue('currency') || 'USD';
    if (rate && parseFloat(rate) > 0) {
        document.getElementById('previewRate').textContent = `${currency} ${parseFloat(rate).toFixed(2)}/h`;
    } else {
        document.getElementById('previewRate').textContent = 'Sin tarifa definida';
    }
 
    // Mostrar modal
    document.getElementById('profilePreviewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
 
function closeProfilePreview() {
    document.getElementById('profilePreviewModal').classList.add('hidden');
    document.body.style.overflow = '';
}
 
// Cerrar con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('profilePreviewModal').classList.contains('hidden')) {
        closeProfilePreview();
    }
});
</script>
 
    </form>

    <!-- SECCIÓN: ELIMINAR CUENTA -->
    <div class="section-card mt-8" style="border: 1px solid #fca5a5;">
        <h2 class="section-title" style="color: #dc2626; border-bottom-color: #fecaca;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Zona de Peligro
        </h2>
        <p class="text-sm text-gray-600 mb-4">
            Una vez que elimines tu cuenta, todos tus datos, sesiones e información serán eliminados permanentemente. Esta acción no se puede deshacer.
        </p>
        <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all">
            Eliminar mi cuenta
        </button>
    </div>

    <!-- Modal de confirmación -->
    <div id="deleteModal" class="hidden fixed inset-0 z-50  flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl">
            <h3 class="text-xl font-bold text-gray-900 mb-2">¿Estás seguro?</h3>
            <p class="text-sm text-gray-600 mb-6">Ingresa tu contraseña para confirmar la eliminación permanente de tu cuenta.</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="form-group mb-4">
                    <label for="delete_password" class="form-label required">Contraseña</label>
                    <input type="password" id="delete_password" name="password" class="form-input" required>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                            class="btn-secondary flex-1">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all">
                        Sí, eliminar cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@include('livewire.components.gemini')


<script>
// ============================================================
// CAMERA MODAL - Captura directa sin galería
// ============================================================

const CameraModal = {
    stream: null,
    currentTarget: null,       // 'selfie' | 'document'
    currentFacingMode: 'user', // 'user' (frontal) | 'environment' (trasera)
    capturedBlob: null,

    // Elementos del DOM
    el: {
        modal:           () => document.getElementById('cameraModal'),
        video:           () => document.getElementById('cameraStream'),
        canvas:          () => document.getElementById('cameraCanvas'),
        capturedPreview: () => document.getElementById('capturedPreview'),
        loading:         () => document.getElementById('cameraLoading'),
        error:           () => document.getElementById('cameraError'),
        errorMsg:        () => document.getElementById('cameraErrorMsg'),
        captureControls: () => document.getElementById('captureControls'),
        confirmControls: () => document.getElementById('confirmControls'),
        modalTitle:      () => document.getElementById('cameraModalTitle'),
        cameraTip:       () => document.getElementById('cameraTip'),
        cameraGuide:     () => document.getElementById('cameraGuide'),
        selfieGuide:     () => document.getElementById('selfieGuide'),
        documentGuide:   () => document.getElementById('documentGuide'),
    },

    // ---- Abrir modal ----
    async open(target) {
        this.currentTarget = target;
        this.capturedBlob = null;

        // Configurar UI según tipo
        if (target === 'selfie') {
            this.currentFacingMode = 'user';
            this.el.modalTitle().textContent = 'Tomar Selfie';
            this.el.cameraTip().textContent = 'Sostén tu documento de identidad junto a tu rostro';
        } else {
            this.currentFacingMode = 'environment';
            this.el.modalTitle().textContent = 'Fotografiar Documento';
            this.el.cameraTip().textContent = 'Coloca el documento sobre una superficie plana con buena luz';
        }

        // Mostrar modal
        this.el.modal().classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Reset UI
        this.showState('loading');
        
        // Iniciar cámara
        await this.startCamera();
    },

    // ---- Cerrar modal ----
    close() {
        this.stopCamera();
        this.el.modal().classList.add('hidden');
        document.body.style.overflow = '';
        this.capturedBlob = null;
    },

    // ---- Iniciar stream de cámara ----
    async startCamera() {
        this.stopCamera();

        const constraints = {
            video: {
                facingMode: { ideal: this.currentFacingMode },
                width:  { ideal: 1280 },
                height: { ideal: 960 },
            },
            audio: false,
        };

        try {
            this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            const video = this.el.video();
            video.srcObject = this.stream;
            
            video.onloadedmetadata = () => {
                video.play();
                this.showState('streaming');
                this.showGuide();
            };
        } catch (err) {
            console.error('Error al acceder a la cámara:', err);
            let msg = 'No se pudo acceder a la cámara.';
            if (err.name === 'NotAllowedError') {
                msg = 'Permiso de cámara denegado. Habilítalo en la configuración de tu navegador.';
            } else if (err.name === 'NotFoundError') {
                msg = 'No se encontró ninguna cámara en este dispositivo.';
            } else if (err.name === 'NotReadableError') {
                msg = 'La cámara está siendo usada por otra aplicación.';
            }
            this.el.errorMsg().textContent = msg;
            this.showState('error');
        }
    },

    // ---- Detener cámara ----
    stopCamera() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
        const video = this.el.video();
        if (video) video.srcObject = null;
    },

    // ---- Cambiar cámara frontal/trasera ----
    async switchCamera() {
        this.currentFacingMode = this.currentFacingMode === 'user' ? 'environment' : 'user';
        this.showState('loading');
        await this.startCamera();
    },

    // ---- Capturar foto ----
    capture() {
        const video  = this.el.video();
        const canvas = this.el.canvas();
        
        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext('2d');

        // Si es cámara frontal, espejar la imagen
        if (this.currentFacingMode === 'user') {
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
        }

        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convertir a blob
        canvas.toBlob((blob) => {
            this.capturedBlob = blob;
            this.el.capturedPreview().src = URL.createObjectURL(blob);
            this.showState('captured');
        }, 'image/jpeg', 0.92);
    },

    // ---- Volver a tomar ----
    retake() {
        this.capturedBlob = null;
        this.showState('streaming');
        this.showGuide();
    },

    // ---- Confirmar y asignar al input ----
    confirm() {
        if (!this.capturedBlob) return;

        const fileName = this.currentTarget === 'selfie' 
            ? 'selfie_capture.jpg' 
            : 'document_capture.jpg';

        // Crear File desde Blob
        const file = new File([this.capturedBlob], fileName, { type: 'image/jpeg' });

        // Crear DataTransfer para asignar al input file
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        if (this.currentTarget === 'selfie') {
            document.getElementById('selfieUpload').files = dataTransfer.files;
            document.getElementById('selfiePreview').src = URL.createObjectURL(this.capturedBlob);
        } else {
            document.getElementById('documentUpload').files = dataTransfer.files;
            document.getElementById('documentPreview').src = URL.createObjectURL(this.capturedBlob);
        }

        this.close();
    },

    // ---- Mostrar guía visual ----
    showGuide() {
        const guide = this.el.cameraGuide();
        guide.classList.remove('hidden');
        this.el.selfieGuide().classList.toggle('hidden', this.currentTarget !== 'selfie');
        this.el.documentGuide().classList.toggle('hidden', this.currentTarget !== 'document');
    },

    hideGuide() {
        this.el.cameraGuide().classList.add('hidden');
    },

    // ---- Controlar estados de UI ----
    showState(state) {
        const { video, capturedPreview, loading, error, captureControls, confirmControls } = this.el;

        // Ocultar todo primero
        video().style.display         = 'none';
        capturedPreview().classList.add('hidden');
        loading().classList.add('hidden');
        error().classList.add('hidden');
        captureControls().classList.add('hidden');
        confirmControls().classList.add('hidden');
        this.hideGuide();

        switch (state) {
            case 'loading':
                loading().classList.remove('hidden');
                break;

            case 'streaming':
                video().style.display = 'block';
                captureControls().classList.remove('hidden');
                break;

            case 'captured':
                capturedPreview().classList.remove('hidden');
                confirmControls().classList.remove('hidden');
                break;

            case 'error':
                error().classList.remove('hidden');
                break;
        }
    },
};

    // ---- Funciones globales (llamadas desde onclick) ----
    function openCameraModal(target) {
        CameraModal.open(target);
    }

    function closeCameraModal() {
        CameraModal.close();
    }

    function switchCamera() {
        CameraModal.switchCamera();
    }

    function capturePhoto() {
        CameraModal.capture();
    }

    function retakePhoto() {
        CameraModal.retake();
    }

    function confirmPhoto() {
        CameraModal.confirm();
    }

    function retryCameraAccess() {
        CameraModal.startCamera();
    }


    // ============================================================
    // PREVIEWS & LOCALSTORAGE (código original mejorado)
    // ============================================================

    // Preview de Avatar
    document.getElementById('avatarUpload')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => document.getElementById('avatarPreview').src = event.target.result;
            reader.readAsDataURL(file);
        }
    });

    // Auto-save en localStorage
    const formInputs = document.querySelectorAll('.form-input, .form-textarea');
    formInputs.forEach(input => {
        const savedValue = localStorage.getItem(`profile_${input.name}`);
        if (savedValue && !input.value) input.value = savedValue;
        input.addEventListener('input', function() {
            localStorage.setItem(`profile_${input.name}`, this.value);
        });
    });

    document.querySelector('form')?.addEventListener('submit', function() {
        formInputs.forEach(input => localStorage.removeItem(`profile_${input.name}`));
    });


</script>

<script type="module">
    import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

    const API_KEY = "{{ env('GEMINI_API_KEY') }}";
    const genAI = new GoogleGenerativeAI(API_KEY);

    // --- Subir CV y procesar ---
    const cvInput = document.getElementById('cvUpload');
    const cvProcessing = document.getElementById('cvProcessing');
    const cvProcessingText = document.getElementById('cvProcessingText');
    const cvFileName = document.getElementById('cvFileName');

    cvInput.addEventListener('change', async function () {
        const file = this.files[0];
        if (!file) return;

        cvFileName.textContent = file.name;
        cvProcessing.classList.remove('hidden');
        cvProcessingText.textContent = 'Extrayendo texto del CV...';

        try {
            // 1) Enviar el PDF al backend para extraer texto
            const formData = new FormData();
            formData.append('cvFile', file);

            const response = await fetch("{{ route('cv.extract') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (!response.ok) throw new Error('Error al subir el CV');

            const data = await response.json();

            // 2) Enviar el texto extraído a Gemini para analizar
            cvProcessingText.textContent = 'Analizando CV con IA...';
            await procesarCvYActualizar(data.text);

            cvProcessing.classList.add('hidden');
            mostrarNotificacion('success', '¡CV procesado! Revisá los campos actualizados.');

        } catch (error) {
            console.error('Error procesando CV:', error);
            cvProcessing.classList.add('hidden');
            mostrarNotificacion('error', 'Error al procesar el CV. Intentá de nuevo.');
        }

        // Resetear input para permitir subir el mismo archivo otra vez
        this.value = '';
    });

    // Función que llama a Gemini y actualiza los campos del formulario (MENTOR)
    async function procesarCvYActualizar(text) {
        const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

        const prompt = `Analiza el siguiente CV y devuelve EXCLUSIVAMENTE un JSON válido. No incluyas explicaciones, texto adicional ni markdown. No uses \`\`\`json. Si un dato no está presente, usa null. No inventes información. Las claves deben llamarse EXACTAMENTE así:
    {"nombre_completo": string|null,"birthDate": "YYYY-MM-DD"|null,"country": string|null,"city": string|null,"profession": string|null,"workingNow": "1"|"0"|null,"currentPosition": string|null,"lastPosition": string|null,"yearsExperience": number|null,"companies": string|null,"sectors": string|null,"education": string|null,"languages": string|null,"skills": string|null,"bio": string|null,"seniority": "Jefe"|"Gerente"|"Director"|"CEO"|"Emprendedor"|null,"linkedin_url": string|null,"website": string|null}
    REGLAS IMPORTANTES:
    - workingNow = "1" si tiene un puesto actual o dice "Presente"/"Actualidad", "0" si no.
    - currentPosition = el cargo actual si existe.
    - lastPosition = el cargo anterior inmediato.
    - profession = título profesional o especialización principal.
    - yearsExperience = estimar según fechas laborales (solo número).
    - companies = lista separada por comas.
    - sectors = inferir sectores profesionales principales, separados por comas.
    - education = resumir títulos y certificaciones en una sola frase.
    - languages = lista separada por comas con nivel si aparece.
    - skills = solo hard skills técnicas separadas por comas (máx 200 caracteres).
    - bio = resumen profesional corto (máx 3 líneas, primera persona, tono profesional pero cercano, enfocado en lo que puede aportar como mentor).
    - seniority = inferir según los cargos: solo usar "Jefe", "Gerente", "Director", "CEO" o "Emprendedor".
    - linkedin_url y website: extraer si aparecen en el CV.
    CV: ${text}`;

        const result = await model.generateContent(prompt);
        const responseText = result.response.text().trim();

        let cvData;
        try {
            cvData = JSON.parse(responseText);
        } catch (e) {
            const clean = responseText.replace(/```json|```/g, '').trim();
            cvData = JSON.parse(clean);
        }

        // Mapeo: clave JSON → id del campo en el formulario
        const camposTexto = {
            'name':                cvData.nombre_completo,
            'birth_date':          cvData.birthDate,
            'country':             cvData.country,
            'city':                cvData.city,
            'profession':          cvData.profession,
            'currentPosition':     cvData.currentPosition,
            'lastPosition':        cvData.lastPosition,
            'years_of_experience': cvData.yearsExperience,
            'companies':           cvData.companies,
            'sectors':             cvData.sectors,
            'education':           cvData.education,
            'languages':           cvData.languages,
            'skills':              cvData.skills,
            'linkedin_url':        cvData.linkedin_url,
            'website':             cvData.website,
        };

        // Campos select (se manejan distinto)
        const camposSelect = {
            'seniority':  cvData.seniority,
            'workingNow': cvData.workingNow,
        };

        // Rellenar campos de texto/textarea (solo si están vacíos, excepto bio)
        for (const [fieldId, valor] of Object.entries(camposTexto)) {
            if (!valor && valor !== 0) continue;
            const el = document.getElementById(fieldId);
            if (!el) continue;

            if (!el.value.trim()) {
                el.value = valor;
            }
        }

        // Rellenar selects (solo si no tienen valor seleccionado)
        for (const [fieldId, valor] of Object.entries(camposSelect)) {
            if (!valor) continue;
            const el = document.getElementById(fieldId);
            if (!el) continue;

            // Buscar si existe la opción
            const optionExists = Array.from(el.options).some(opt => opt.value === String(valor));
            if (optionExists) {
                el.value = String(valor);
                // Disparar change para que funcione toggleWorkFields()
                el.dispatchEvent(new Event('change'));
            }
        }

        // Bio con efecto de escritura (siempre se sobrescribe)
        if (cvData.bio) {
            const bioEl = document.getElementById('bio');
            if (bioEl) {
                bioEl.classList.add('typing');
                bioEl.value = '';
                let i = 0;
                await new Promise(resolve => {
                    const intervalo = setInterval(() => {
                        if (i < cvData.bio.length) {
                            bioEl.value += cvData.bio.charAt(i);
                            bioEl.scrollTop = bioEl.scrollHeight;
                            i++;
                        } else {
                            clearInterval(intervalo);
                            bioEl.classList.remove('typing');
                            resolve();
                        }
                    }, 15);
                });
            }
        }
    }
</script>
@endsection