@extends('backend.layout.app')
@section('page_title', 'Agenda - Pipol')
@section('main_content')
<style>
    .agenda-wrapper * {
        font-family: 'Inter', sans-serif;
    }

    .section-card {
        background: #140A24;
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title svg {
        color: #8B5CF6;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .form-label.required::after {
        content: " *";
        color: #F87171;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: #20152E;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 0.625rem;
        font-size: 0.875rem;
        color: #ffffff;
        transition: all 0.2s;
    }

    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .form-input:focus {
        outline: none;
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }

    .form-input option {
        background: #20152E;
        color: #ffffff;
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .help-text {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.35);
        margin-top: 0.375rem;
    }

    .btn-primary-edit {
        background: linear-gradient(135deg, #8B5CF6, #7C3AED);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 12px rgba(139, 92, 246, 0.3);
    }

    .btn-primary-edit:hover {
        background: linear-gradient(135deg, #7C3AED, #6D28D9);
        transform: translateY(-1px);
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.4);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.7);
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        border: 1px solid rgba(255, 255, 255, 0.08);
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #6EE7B7;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #FCA5A5;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
        }
        50% {
            box-shadow: 0 0 0 6px rgba(139, 92, 246, 0);
        }
    }

    #btnMejorarBio:hover {
        animation: pulse-glow 2s infinite;
    }

    #bio.typing {
        border-color: #8B5CF6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }

    /* ─── Availability rows ─── */
    .availability-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: #1C1030;
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 0.75rem;
        transition: all 0.2s;
    }

    .availability-row:hover {
        border-color: rgba(139, 92, 246, 0.2);
        background: #201438;
    }

    .availability-row .slot-label {
        font-size: 0.68rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.35);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .availability-row .slot-value {
        font-weight: 500;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.88rem;
    }

    .badge-active {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        background: rgba(16, 185, 129, 0.12);
        color: #6EE7B7;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .badge-inactive {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        background: rgba(239, 68, 68, 0.12);
        color: #FCA5A5;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .btn-delete {
        padding: 0.5rem;
        background: rgba(239, 68, 68, 0.1);
        color: #FCA5A5;
        border-radius: 0.5rem;
        border: 1px solid rgba(239, 68, 68, 0.15);
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #F87171;
    }

    .empty-state-text {
        color: rgba(255, 255, 255, 0.35);
        font-size: 0.875rem;
        font-style: italic;
        text-align: center;
        padding: 1.5rem 0;
    }

    .form-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        padding-top: 1.5rem;
        margin-top: 0.5rem;
    }

    .form-subtitle {
        font-size: 0.85rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 1rem;
    }
</style>

<div class="agenda-wrapper">

    {{-- Alerts --}}
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
                <textarea id="availabilities" name="availabilities" class="form-input form-textarea"
                    placeholder="Ejemplo: Lunes 9am-12pm, Miércoles 2pm-5pm"></textarea>
                <p class="help-text">Introduce tus horarios disponibles en formato texto. Puedes usar comas para separar diferentes días y horarios.</p>
            </div>

            <input type="hidden" id="availabilities_json" name="availabilities">

            <button type="submit" id="btnSubmit" class="btn-primary-edit">
                <span id="btnSubmitText">Actualizar Horarios</span>
            </button>
            <p id="processingMsg" class="help-text hidden" style="color: #A78BFA; margin-top: 0.5rem;">
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

            JSON.parse(response);

            hiddenInput.value = response;
            textarea.removeAttribute('name');
            form.submit();

        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar los horarios: ' + error.message + '. Intenta reformular el texto.');

            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            btnText.textContent = 'Actualizar Horarios';
            processingMsg.classList.add('hidden');
        }
    });
</script>
@endsection