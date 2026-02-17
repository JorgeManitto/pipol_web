<div id="rescheduleModal" class="modal">
    <div class="modal-content">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-[#1a0a3e]">Reprogramar Sesion</h3>
                <button onclick="closeRescheduleModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="mb-4 p-4 bg-[#f5f0e8] rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Sesion actual con</p>
                <p class="font-semibold text-[#1a0a3e]" id="reschedule-mentor-name"></p>
                <p class="text-sm text-gray-600 mt-2" id="reschedule-current-time"></p>
                <input type="hidden" id="reschedule-session-id" value="">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nueva fecha</label>
                <input id="reschedule-date" type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a0a3e] focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nuevo horario</label>
                <input id="reschedule-time" type="time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a0a3e] focus:border-transparent">
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-yellow-800">
                    <strong>Politica:</strong> El mentor puede reprogramar hasta 48 horas antes de que empiece la sesion.
                </p>
            </div>

            <div class="flex gap-3">
                <button onclick="closeRescheduleModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button onclick="confirmReschedule()" class="flex-1 bg-[#1a0a3e] text-white px-4 py-2 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                    Confirmar Cambio
                </button>
            </div>
        </div>
    </div>
</div>
