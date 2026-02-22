<div id="cancelModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-[#1a0a3e]">Cancelar sesión</h3>
                <button onclick="closeCancelModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-800 mb-1">¿Estás seguro que deseas cancelar esta sesión?</p>
                <p class="font-semibold text-[#1a0a3e] mt-2" id="cancel-mentor-name"></p>
                <p class="text-sm text-gray-600" id="cancel-session-time"></p>
                <input type="hidden" name="session_id" id="cancel-session-id" value="">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de cancelación (opcional)</label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a0a3e] focus:border-transparent" rows="3" placeholder="Cuéntanos por qué cancelas esta sesión..."></textarea>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-yellow-800">
                    <strong>Política de cancelación:</strong> El mentor puede cancelar hasta 48 horas antes de que empiece la sesión.
                </p>
            </div>

            <div class="flex gap-3">
                <button onclick="closeCancelModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Volver
                </button>
                <button onclick="confirmCancel()" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Confirmar Cancelación
                </button>
            </div>
        </div>
    </div>
</div>
