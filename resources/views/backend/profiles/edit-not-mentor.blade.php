@extends('backend.layout.app')
@section('page_title', 'Editar Perfil de '.$user->name.' '.$user->last_name)

@section('main_content')
<style>
    * {
        font-family: 'Inter', sans-serif;
    }
    
    .profile-preview {
        transition: all 0.3s ease;
    }
    
    .profile-preview:hover {
        transform: scale(1.05);
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

<main class="container  max-w-6xl">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">Editar Perfil</h1>
        <p class="text-white">Actualiza tu información para que otros puedan conocerte mejor</p>
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
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-4 space-y-8">
        @csrf

        <!-- Profile Photo Section -->
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
                        <input type="file" accept="image/*" name="avatar" id="photoUpload" class="hidden">
                    </div>
                    <p class="text-sm text-stone-500 mt-2">JPG, PNG o GIF. Máximo 5MB.</p>
                </div>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="border-b border-stone-200 pb-8">
            <h2 class="text-xl font-semibold text-stone-800 mb-6">Información Básica</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="nombre" class="form-label required">
                        Nombre *
                    </label>
                    <input type="text" 
                           id="nombre" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="form-input"
                           required>
                </div>


                
                <div>
                    <label for="email" class="form-label required">
                        Email *
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="form-input"
                           required>
                </div>
                
                <div>
                    <label for="profession" class="form-label">
                        Profesión / Ocupación
                    </label>
                    <input type="text" 
                           id="profession" 
                           name="profession" 
                           value="{{ old('profession', $user->profession) }}"
                           class="form-input"
                           placeholder="Ej: Estudiante de Marketing, Desarrollador Junior">
                </div>
                
                <div>
                    <label for="country" class="form-label">
                        País *
                    </label>
                    <input type="text" 
                           id="country" 
                           name="country" 
                           value="{{ old('country', $user->country) }}"
                           class="form-input"
                           required>
                </div>

                <div>
                    <label for="city" class="form-label">
                        Ciudad
                    </label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           value="{{ old('city', $user->city) }}"
                           class="form-input"
                           placeholder="Ej: Buenos Aires, Madrid">
                </div>
                
            </div>
        </div>

        <!-- About Me Section with IA Button -->
        <div class="border-b border-stone-200 pb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-stone-800">Sobre Mí</h2>
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
            
            <div>
                <label for="bio" class="form-label">
                    Descripción Personal
                </label>
                <textarea id="bio" 
                          rows="8" 
                          name="bio" 
                          class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"
                          placeholder="Cuéntanos sobre ti, tus intereses, objetivos profesionales y qué esperas de una mentoría...">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-sm text-stone-500 mt-2">Cuéntanos sobre ti, tus intereses, objetivos profesionales y qué esperas aprender con una mentoría.</p>
                
                <!-- Indicador de procesamiento -->
                <div id="bioProcessing" class="hidden mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm text-blue-800 font-medium">Mejorando tu presentación con IA...</span>
                    </div>
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
        <div >
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

        <div class="form-group">
            <label for="skills" class="form-label">Habilidades</label>
            <textarea id="skills" name="skills" rows="3" 
                    class="form-input form-textarea"
                    placeholder="Ej: liderazgo de equipos, gestión del talento, toma de decisiones">{{ old('skills', $user->skills) }}</textarea>
            <p class="help-text">Separa las habilidades con comas.</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-stone-200">
            <a href="{{ route('profile.show', $user->id) }}" 
               class="flex-1 bg-stone-200 hover:bg-stone-300 text-stone-800 px-8 py-4 rounded-lg font-semibold text-lg transition text-center">
                Cancelar
            </a>
            <button type="submit" 
                    class="flex-1 bg-[#2d5a4a] hover:bg-[#3d6a5a] text-white px-8 py-4 rounded-lg font-semibold text-lg transition shadow-lg hover:shadow-xl">
                Guardar Cambios
            </button>
        </div>
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



<!-- JavaScript Section -->
<script type="module">
    import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

    const API_KEY = "{{ env('GEMINI_API_KEY') }}";
    const genAI = new GoogleGenerativeAI(API_KEY);

    // Preview de imagen
    const inputImagen = document.getElementById('photoUpload');
    const previewImagen = document.getElementById('previewImagen');
    
    inputImagen.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImagen.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Función para mejorar biografía con IA (versión para mentees)
    window.mejorarBioConIA = async function() {
        const bioTextarea = document.getElementById('bio');
        const bioActual = bioTextarea.value.trim();
        
        // Validar que haya texto
        if (!bioActual) {
            alert('Por favor, escribe primero algo sobre ti antes de usar la IA para mejorar el texto.');
            return;
        }

        // Validar longitud mínima
        if (bioActual.length < 30) {
            alert('Tu presentación es muy corta. Escribe al menos 30 caracteres para que la IA pueda mejorarla.');
            return;
        }

        // Deshabilitar botón y mostrar indicador
        const btn = document.getElementById('btnMejorarBio');
        const btnText = document.getElementById('btnMejorarBioText');
        const processing = document.getElementById('bioProcessing');
        
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btnText.textContent = 'Procesando...';
        processing.classList.remove('hidden');

        try {
            // Recopilar datos del perfil para contexto
            const contexto = {
                bio: bioActual,
                profesion: document.getElementById('profession')?.value || '',
                nombre: document.getElementById('nombre')?.value || '',
                pais: document.getElementById('country')?.value || '',
                ciudad: document.getElementById('city')?.value || '',
            };

            const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

            const prompt = `Eres un experto en redacción de presentaciones personales profesionales. Tu tarea es mejorar la siguiente biografía de un mentee (persona que busca mentoría) considerando el contexto de su perfil.

CONTEXTO DEL PERFIL:
- Nombre: ${contexto.nombre || 'No especificado'}
- Profesión/Ocupación: ${contexto.profesion || 'No especificado'}
- Ubicación: ${contexto.ciudad ? contexto.ciudad + ', ' : ''}${contexto.pais || 'No especificado'}

PRESENTACIÓN ACTUAL:
"${bioActual}"

INSTRUCCIONES PARA MEJORAR:
1. Mantén TODA la información relevante del texto original (intereses, objetivos, aspiraciones)
2. Mejora la redacción para que sea clara, concisa y profesional pero cercana
3. Usa primera persona con tono amigable pero profesional
4. Estructura sugerida:
   - [Quién eres / Tu contexto actual]
   - [Tus intereses o áreas de desarrollo]
   - [Qué buscas aprender o lograr]
   - [Por qué estás interesado en mentoría]
5. Destaca motivación, objetivos claros y ganas de aprender
6. Elimina redundancias y frases genéricas
7. Máximo 150 palabras
8. Si hay errores gramaticales, corrígelos
9. Haz que suene genuino y auténtico, no como un CV formal

IMPORTANTE:
- NO inventes información que no esté en el texto original
- NO cambies las aspiraciones o intereses de la persona
- NO uses clichés corporativos excesivos
- Mantén un tono humano y accesible
- Si el texto menciona desafíos o áreas de mejora, mantenlos (muestra autenticidad)

Devuelve ÚNICAMENTE el texto mejorado, sin títulos, sin comillas, sin explicaciones adicionales:`;

            const result = await model.generateContent(prompt);
            const bioMejorada = result.response.text().trim();
            
            // Efecto de escritura gradual
            bioTextarea.classList.add('typing');
            bioTextarea.value = '';
            
            let i = 0;
            const intervalo = setInterval(() => {
                if (i < bioMejorada.length) {
                    bioTextarea.value += bioMejorada.charAt(i);
                    bioTextarea.scrollTop = bioTextarea.scrollHeight; // Auto-scroll
                    i++;
                } else {
                    clearInterval(intervalo);
                    bioTextarea.classList.remove('typing');
                }
            }, 15); // Velocidad de escritura
            
            mostrarNotificacion('success', '¡Presentación mejorada con IA! Revisa y ajusta si es necesario.');
            
        } catch (error) {
            console.error('Error al mejorar biografía:', error);
            mostrarNotificacion('error', 'Error al mejorar la presentación. Por favor intenta de nuevo.');
        } finally {
            // Restaurar estado del botón después de un delay
            setTimeout(() => {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                btnText.textContent = 'Mejorar con IA';
                processing.classList.add('hidden');
            }, 1000);
        }
    }

        window.ejecutarCv = async function(text) {
        try {
            const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

            const prompt = 'Analiza el siguiente CV y devuelve EXCLUSIVAMENTE un JSON válido. No incluyas explicaciones, texto adicional ni markdown. No uses ```json. Si un dato no está presente, usa null. No inventes información. Las claves deben llamarse EXACTAMENTE así:{"nombre_completo": string|null,"birthDate": "YYYY-MM-DD"|null,"country": string|null,"city": string|null,"workingNow": "yes"|"no"|null,"currentPosition": string|null,"lastPosition": string|null,"yearsExperience": number|null,"companies": string|null,"sectors": string|null,"education": string|null,"languages": string|null,"skills": string|null,"bio": string|null,"seniority": "Jefe"|"Gerente"|"Director"|"CEO"| "Emprendedor" | "Director" | null}REGLAS IMPORTANTES:- workingNow = "yes" si tiene un puesto actual o dice "Presente".- currentPosition = el cargo actual si existe.- lastPosition = el cargo anterior inmediato.- yearsExperience = estimar según fechas laborales (solo número).- companies = lista separada por comas.- sectors = inferir sectores profesionales principales.- education = resumir en una sola frase.- languages = lista separada por comas.- skills = solo hard skills técnicas separadas por comas y que no pase de 200 letras.- bio = resumen profesional corto (máx 3 líneas).- seniority: Jefe, Gerente , Director, CEO, Emprendedor , Director.  CV:' + text;
            const result = await model.generateContent(prompt);
            const response = result.response.text();
            // const response = '{"nombre_completo": "Jorge Oscar Manitto", "birthDate": null, "country": "Argentina", "city": "Pilar, Provincia de Buenos Aires", "workingNow": "yes", "currentPosition": "Desarrollador web", "lastPosition": "Desarrollador web", "yearsExperience": 5, "companies": "Workana, Upwork freelance, Pupila\u00ae", "sectors": "Desarrollo de software, Servicios freelance", "education": "Ingenier\u00eda en Electr\u00f3nica y Administraci\u00f3n/Administrador de redes en Universidad Nacional de Moreno (2018 - 2024)", "languages": null, "skills": "PHP, Laravel, JavaScript, Desarrollo web, Dise\u00f1o web, Dise\u00f1os adaptativos, Optimizaciones en buscadores", "bio": "Desarrollador web con m\u00e1s de 4 a\u00f1os de experiencia en PHP, Laravel y JavaScript. Especializado en crear soluciones escalables y optimizadas para mejorar la experiencia del usuario.", "seniority": "Senior"}';
            console.log(response);
            

            // 🔁 Volver a Livewire con el CV procesado
            Livewire.dispatch('cvProcesado', { cvData: response });

        } catch (error) {
            console.error(error);
            alert('Error al procesar el CV: ' + error.message);
            Livewire.dispatch('cvProcesado', { cvData: 'Hubo un error al procesar el CV.' });
        }

    }

    // Función auxiliar para mostrar notificaciones
    function mostrarNotificacion(tipo, mensaje) {
        const notification = document.createElement('div');
        const bgColor = tipo === 'success' ? 'bg-green-500' : 'bg-red-500';
        
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300`;
        notification.style.transform = 'translateX(400px)';
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                ${tipo === 'success' ? 
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' :
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                }
                <span class="font-medium">${mensaje}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:bg-white hover:bg-opacity-20 rounded p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animación de entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Remover después de 8 segundos
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, 8000);
    }

    // Auto-save en localStorage (opcional) - previene pérdida de datos
    const formInputs = document.querySelectorAll('input[type="text"], input[type="email"], textarea');
    formInputs.forEach(input => {
        // Cargar datos guardados
        const savedValue = localStorage.getItem(`profile_mentee_${input.name}`);
        if (savedValue && !input.value) {
            input.value = savedValue;
        }
        
        // Guardar mientras se escribe
        input.addEventListener('input', function() {
            localStorage.setItem(`profile_mentee_${input.name}`, this.value);
        });
    });

    // Limpiar localStorage al enviar
    document.querySelector('form').addEventListener('submit', function() {
        formInputs.forEach(input => {
            localStorage.removeItem(`profile_mentee_${input.name}`);
        });
    });

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

// Función que llama a Gemini y actualiza los campos del formulario
async function procesarCvYActualizar(text) {
    const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

    const prompt = `Analiza el siguiente CV y devuelve EXCLUSIVAMENTE un JSON válido. No incluyas explicaciones, texto adicional ni markdown. No uses \`\`\`json. Si un dato no está presente, usa null. No inventes información. Las claves deben llamarse EXACTAMENTE así:{"nombre_completo": string|null,"country": string|null,"city": string|null,"currentPosition": string|null,"skills": string|null,"bio": string|null,"linkedin_url": string|null,"website": string|null}REGLAS:- skills = solo hard skills técnicas separadas por comas (máx 200 caracteres).- bio = resumen profesional corto (máx 3 líneas, primera persona, tono cercano).- linkedin_url y website: extraer si aparecen en el CV.CV: ${text}`;

    const result = await model.generateContent(prompt);
    const responseText = result.response.text().trim();

    // Parsear JSON
    let cvData;
    try {
        cvData = JSON.parse(responseText);
    } catch (e) {
        // Intentar limpiar si viene con backticks
        const clean = responseText.replace(/```json|```/g, '').trim();
        cvData = JSON.parse(clean);
    }

    // Actualizar campos del formulario (solo si tienen valor y el campo está vacío o el usuario confirma)
    const campos = {
        'nombre': cvData.nombre_completo,
        'country': cvData.country,
        'city': cvData.city,
        'profession': cvData.currentPosition,
        'skills': cvData.skills,
        'bio': cvData.bio,
        'linkedin_url': cvData.linkedin_url,
        'website': cvData.website,
    };

    for (const [fieldId, valor] of Object.entries(campos)) {
        if (!valor) continue;
        const el = document.getElementById(fieldId);
        if (!el) continue;

        // Si el campo ya tiene contenido, solo sobrescribir bio (efecto escritura)
        if (fieldId === 'bio') {
            el.classList.add('typing');
            el.value = '';
            let i = 0;
            await new Promise(resolve => {
                const intervalo = setInterval(() => {
                    if (i < valor.length) {
                        el.value += valor.charAt(i);
                        el.scrollTop = el.scrollHeight;
                        i++;
                    } else {
                        clearInterval(intervalo);
                        el.classList.remove('typing');
                        resolve();
                    }
                }, 15);
            });
        } else if (!el.value.trim()) {
            // Solo rellenar campos vacíos
            el.value = valor;
        }
    }
}
</script>
@endsection