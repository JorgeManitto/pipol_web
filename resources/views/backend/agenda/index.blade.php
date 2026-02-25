@extends('backend.layout.app')
@section('page_title', 'Agenda - Pipol')
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
    <div class="">

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                <strong>✓</strong> {{ session('success') }}
            </div>
        @endif

         @if (session('error'))
            <div class="alert alert-error">
                <strong>✗</strong> {{ session('error') }}
            </div>
        @endif

        <div class="section-card">
            <h2 class="section-title">Definí tu Disponibilidad</h2>
            <form id="formHorarios" method="POST" action="{{ route('agenda.update') }}">
                @csrf
                <div class="form-group">
                    <label for="availabilities" class="form-label required">Horarios Disponibles</label>
                    <textarea id="availabilities" name="availabilities" class="form-input form-textarea" placeholder="Ejemplo: Lunes 9am-12pm, Miércoles 2pm-5pm"></textarea>
                    <p class="help-text">Introduce tus horarios disponibles en formato texto. Puedes usar comas para separar diferentes días y horarios.</p>
                </div>

                {{-- Campo oculto para el JSON procesado --}}
                <input type="hidden" id="availabilities_json" name="availabilities">

                <button type="submit" id="btnSubmit" class="btn-primary-edit">
                    <span id="btnSubmitText">Actualizar Horarios</span>
                </button>
                <p id="processingMsg" class="help-text hidden" style="color: #9333ea; margin-top: 0.5rem;">
                    ⏳ Procesando disponibilidad con IA...
                </p>
            </form>
        </div>

        @include('backend.availability.availability')
    </div>

    <script type="module">
        import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";

        const API_KEY = "{{ env('GEMINI_API_KEY') }}";
        const genAI = new GoogleGenerativeAI(API_KEY);

        const form = document.getElementById('formHorarios');
        const textarea = document.getElementById('availabilities');
        const hiddenInput = document.getElementById('availabilities_json');
        const btn = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnSubmitText');
        const processingMsg = document.getElementById('processingMsg');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const textoUsuario = textarea.value.trim();
            if (!textoUsuario) {
                alert('Por favor, ingresa tus horarios disponibles.');
                return;
            }

            // Deshabilitar botón y mostrar estado
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            btnText.textContent = 'Procesando...';
            processingMsg.classList.remove('hidden');

            try {
                const model = genAI.getGenerativeModel({ model: "gemini-flash-lite-latest" });

                const prompt = `Eres un parser de disponibilidad horaria. Convierte el texto de disponibilidad en español a un JSON válido, siguiendo estrictamente estas reglas:
- Los días deben mapearse a: lunes -> monday, martes -> tuesday, miércoles -> wednesday, jueves -> thursday, viernes -> friday, sábado -> saturday, domingo -> sunday
- Si se indica un rango de días (ej: lunes-viernes), debes generar una entrada por cada día del rango.
- Las horas deben devolverse en formato 24h HH:MM ej: 16pm -> 16:00, 9am -> 09:00
- Si no se especifica fecha, usar: "start_date": null, "end_date": null
- "is_recurring" debe ser true si no hay fechas específicas.
- Devuelve SOLO JSON válido, sin texto adicional.

Texto de entrada: "${textoUsuario}"

Formato de salida:
[{"day_of_week":"monday","start_time":"16:00","end_time":"20:00","start_date":null,"end_date":null,"is_recurring":true}]

IMPORTANTE: No encierres la respuesta en \`\`\`json ni comillas. Devuelve únicamente el JSON plano.`;

                const result = await model.generateContent(prompt);
                const response = result.response.text().trim();

                // Validar que sea JSON válido
                JSON.parse(response);

                // Poner el JSON en el campo oculto y enviar
                hiddenInput.value = response;
                textarea.removeAttribute('name'); // Evitar que se envíe el texto crudo
                form.submit();

            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar los horarios: ' + error.message + '. Intenta reformular el texto.');

                // Restaurar botón
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                btnText.textContent = 'Actualizar Horarios';
                processingMsg.classList.add('hidden');
            }
        });
    </script>
@endsection