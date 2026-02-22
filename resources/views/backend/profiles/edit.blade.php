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
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .form-label.required::after {
        content: " *";
        color: #ef4444;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
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

<main class="container px-6 py-8 max-w-6xl mx-auto">
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
                    <select id="workingNow" name="workingNow" class="form-input">
                        <option value="1" {{ old('workingNow', $user->workingNow) == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('workingNow', $user->workingNow) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="currentPosition" class="form-label">Puesto Actual</label>
                    <input type="text" id="currentPosition" name="currentPosition" 
                           value="{{ old('currentPosition', $user->currentPosition) }}" 
                           class="form-input"
                           placeholder="Ej: Senior Developer">
                </div>

                <div class="form-group">
                    <label for="lastPosition" class="form-label">Último Puesto (si no trabajas actualmente)</label>
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
                        <option value="EUR" {{ old('currency', $user->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="ARS" {{ old('currency', $user->currency) == 'ARS' ? 'selected' : '' }}>ARS - Peso Argentino</option>
                        <option value="MXN" {{ old('currency', $user->currency) == 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                        <option value="COP" {{ old('currency', $user->currency) == 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                        <option value="CLP" {{ old('currency', $user->currency) == 'CLP' ? 'selected' : '' }}>CLP - Peso Chileno</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="paypal_email" class="form-label">Email de PayPal</label>
                    <input type="email" id="paypal_email" name="paypal_email" 
                           value="{{ old('paypal_email', $user->paypal_email) }}" 
                           class="form-input"
                           placeholder="tu@email.com">
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
        <div class="section-card">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Verificación de Identidad
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="selfie" class="form-label">Selfie de Verificación</label>
                    <div class="mb-3">
                        @if ($user->selfie)
                            <div class="image-preview-container">
                                <img id="selfiePreview" 
                                    src="{{ route('private.image', ['path' => $user->selfie]) }}" 
                                    alt="Selfie" 
                                    class="image-preview">
                            </div>
                        @else
                            <div class="image-preview-container">
                                <img id="selfiePreview" 
                                    src="{{ asset('images/placeholder-selfie.png') }}" 
                                    alt="Selfie" 
                                    class="image-preview">
                            </div>
                        @endif
                    </div>
                    <label for="selfieUpload" class="file-upload-btn">
                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Subir Selfie
                    </label>
                    <input type="file" id="selfieUpload" name="selfie" accept="image/*" class="hidden">
                    <p class="help-text mt-2">Foto tuya sosteniendo tu documento de identidad</p>
                </div>

                <div class="form-group">
                    <label for="documentPhoto" class="form-label">Foto del Documento</label>
                    <div class="mb-3">
                        @if ($user->documentPhoto)
                            <div class="image-preview-container">
                                <img id="documentPreview" 
                                    src="{{ route('private.image', ['path' => $user->documentPhoto]) }}" 
                                    alt="Documento" 
                                    class="image-preview">
                            </div>
                        @else
                            <div class="image-preview-container">
                                <img id="documentPreview" 
                                    src="{{ asset('images/placeholder-document.png') }}" 
                                    alt="Documento" 
                                    class="image-preview">
                            </div>
                        @endif
                    </div>
                    <label for="documentUpload" class="file-upload-btn">
                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Subir Documento
                    </label>
                    <input type="file" id="documentUpload" name="documentPhoto" accept="image/*" class="hidden">
                    <p class="help-text mt-2">DNI, Pasaporte o identificación oficial clara y legible</p>
                </div>
            </div>
        </div>

      

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 sticky bottom-0 bg-white p-6 rounded-lg shadow-lg border-t-4 border-[#2d5a4a]">
            <a href="{{ route('profile.show', $user->id) }}" 
               class="btn-secondary text-center flex-1">
                Cancelar
            </a>
            <button type="submit" class="btn-primary-edit flex-1">
                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Cambios
            </button>
        </div>
    </form>
        <!-- SECCIÓN 9: HORARIOS DISPONIBLES -->
        @include('backend.availability.availability')
</main>
@include('livewire.components.gemini')
<script>
// Preview de Avatar
document.getElementById('avatarUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('avatarPreview').src = event.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Preview de Selfie
document.getElementById('selfieUpload')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('selfiePreview').src = event.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Preview de Documento
document.getElementById('documentUpload')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('documentPreview').src = event.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Auto-save en localStorage (opcional)
const formInputs = document.querySelectorAll('.form-input, .form-textarea');
formInputs.forEach(input => {
    // Cargar datos guardados
    const savedValue = localStorage.getItem(`profile_${input.name}`);
    if (savedValue && !input.value) {
        input.value = savedValue;
    }
    
    // Guardar mientras se escribe
    input.addEventListener('input', function() {
        localStorage.setItem(`profile_${input.name}`, this.value);
    });
});

// Limpiar localStorage al enviar
document.querySelector('form').addEventListener('submit', function() {
    formInputs.forEach(input => {
        localStorage.removeItem(`profile_${input.name}`);
    });
});


</script>
@endsection