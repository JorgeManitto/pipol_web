<div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-[#1a0a3e]">Confirmar Sesión</h3>
                    <button onclick="closeConfirmModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <input type="hidden" name="session_id" id="confirm-session-id" value="">
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">
                        <strong>¿Estás seguro que deseas confirmar esta sesión?</strong> Una vez confirmada, no podrás reprogramarla ni cancelarla .
                    </p>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Volver
                    </button>
                    
                    <button type="submit" onclick="confirmSession()" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Confirmar Sesión
                    </button>
                    
                </div>

            </div>
        </div>
    </div>