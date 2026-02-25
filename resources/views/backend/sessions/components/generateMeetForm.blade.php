<div id="generateMeetForm" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-[#1a0a3e]">Generar Link de Reunión</h3>
                <button onclick="closeGenerateMeetForm()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>Genera un link de reunión para tu sesión programada.</strong>
                    Este link será compartido con el mentee para que pueda unirse a la sesión.
                </p>
                {{-- <p class="text-sm text-red-500">
                    Se necesita haber vinculado la sesión con Google para generar el link.
                </p> --}}
                <input type="hidden" name="session_id" id="session_id">
            </div>

            <!-- Resultado del link generado -->
            <div id="meetResult" class="hidden mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-800 font-semibold mb-1">¡Link generado!</p>
                <a id="meetLink" href="#" target="_blank" class="text-blue-600 underline break-all text-sm"></a>
            </div>

            <div class="flex gap-3">
                <button onclick="closeGenerateMeetForm()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" id="btnGenerateMeet" onclick="generateMeetLink()" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors cursor-pointer">
                    Generar Link
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function generateMeetLink() {
    const btn = document.getElementById('btnGenerateMeet');
    const sessionId = document.getElementById('session_id').value;

    btn.disabled = true;
    btn.textContent = 'Generando...';

    fetch(`{{ route('admin.generateReunionGoogle') }}?session_id=${sessionId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const resultDiv = document.getElementById('meetResult');
            const linkEl = document.getElementById('meetLink');

            linkEl.href = data.meet_link;
            linkEl.textContent = data.meet_link;
            resultDiv.classList.remove('hidden');

            btn.textContent = '✓ Generado';
        } else {
            alert('Error al generar el link');
            btn.disabled = false;
            btn.textContent = 'Generar Link';
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error al generar el link de reunión');
        btn.disabled = false;
        btn.textContent = 'Generar Link';
    });
}
</script>