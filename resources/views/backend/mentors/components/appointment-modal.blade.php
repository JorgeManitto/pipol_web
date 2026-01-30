<!-- Appointment booking modal -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b">
                <div class="flex items-center gap-4">
                    <img id="modalProfessionalImage" src="/placeholder.svg" alt="" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 id="modalProfessionalName" class="text-2xl font-bold text-[#1a0a3e]"></h2>
                        <p id="modalProfessionalSpecialty" class="text-gray-600"></p>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Calendar Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-[#1a0a3e] mb-4">Selecciona una fecha</h3>
                        
                        <!-- Calendar Header -->
                        <div class="flex items-center justify-between mb-4">
                            <button onclick="previousMonth()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <h4 id="calendarMonth" class="text-lg font-semibold text-gray-800"></h4>
                            <button onclick="nextMonth()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Calendar Grid -->
                        <div class="grid grid-cols-7 gap-2 mb-2">
                            <div class="text-center text-xs font-semibold text-gray-500 py-2">Dom</div>
                            <div class="text-center text-xs font-semibold text-gray-500 py-2">Lun</div>
                            <div class="text-center text-xs font-semibold text-gray-500 py-2">Mar</div>
                            <div class="text-center text-xs font-semibold text-gray-500 py-2">Mié</div>
                            <div class="text-center text-xs font-semibold text-gray-500 py-2">Jue</div>
                            <div class="text-center text-xs font-semibold text-gray-500 py-2">Vie</div>
                            <div class="text-center text-xs font-semibold text-gray-500 py-2">Sáb</div>
                        </div>
                        <div id="calendarDays" class="grid grid-cols-7 gap-2"></div>
                    </div>
                    
                    <!-- Time Slots Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-[#1a0a3e] mb-4">Horarios disponibles</h3>
                        <div id="timeSlots" class="space-y-2 max-h-96 overflow-y-auto">
                            <p class="text-gray-500 text-center py-8">Selecciona una fecha para ver los horarios disponibles</p>
                        </div>
                    </div>
                </div>
                
                <!-- Selected Appointment Info -->
                <div id="selectedAppointment" class="mt-6 p-4 bg-[#f5f0e8] rounded-lg hidden">
                    <h4 class="font-semibold text-[#1a0a3e] mb-2">Resumen de tu cita</h4>
                    <div class="space-y-1 text-sm text-gray-700">
                        <p><strong>Profesional:</strong> <span id="summaryProfessional"></span></p>
                        <p><strong>Fecha:</strong> <span id="summaryDate"></span></p>
                        <p><strong>Hora:</strong> <span id="summaryTime"></span></p>
                        <p><strong>Tarifa:</strong> <span id="summaryPrice"></span></p>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 border-t">
                <button onclick="closeModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Cancelar
                </button>
                <button id="confirmButton" onclick="confirmAppointment()" class="px-6 py-3 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Ir al pago
                </button>
            </div>
        </div>
    </div>