<div>
    {{-- Cards de mentores --}}
    <div class="grid md:grid-cols-3 gap-6">
        @foreach ($mentors as $mentor)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <img src="{{ $mentor->avatar ? asset('storage/avatars/'.$mentor->avatar) : asset('images/default-avatar.png') }}"
                             class="w-20 h-20 rounded-full object-cover">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $mentor->name }} {{ $mentor->last_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $mentor->profession }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-1">Especialidades:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($mentor->skills as $skill)
                                <span class="px-2 py-1 bg-[#f5f0e8] text-[#2d5a4a] text-xs rounded-full">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t pt-3">
                        <p class="text-lg font-bold text-[#2d5a4a] mb-2">{{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}</p>
                        <button wire:click="openModal({{ $mentor->id }})" class="w-full py-2 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition">
                            Reservar sesión
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal visual, controlado por JS pero enlazado a Livewire --}}
    <div id="appointmentModal" class="modal {{ $showModal ? 'active' : '' }}">
        <div class="modal-content">
            <div class="flex items-center justify-between p-6 border-b">
                <div class="flex items-center gap-4">
                    <img id="modalProfessionalImage" src="/placeholder.svg" alt="" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 id="modalProfessionalName" class="text-2xl font-bold text-[#2d5a4a]"> {{ $selectedMentor->name . ' ' . $selectedMentor->last_name }}</h2>
                        <p id="modalProfessionalSpecialty" class="text-gray-600"></p>
                    </div>
                </div>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- hidden inputs para Livewire --}}
            <input type="hidden" wire:model="selectedDate">
            <input type="hidden" wire:model="selectedTime">

            {{-- Modal Body --}}
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-[#2d5a4a] mb-4">Selecciona una fecha</h3>
                        <div id="calendarContainer"></div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-[#2d5a4a] mb-4">Horarios disponibles</h3>
                        <div id="timeSlotsContainer" class="space-y-2 max-h-96 overflow-y-auto text-center text-gray-500">
                            Selecciona una fecha para ver horarios disponibles
                        </div>
                    </div>
                </div>

                <div id="selectedAppointment" class="mt-6 p-4 bg-[#f5f0e8] rounded-lg hidden">
                    <h4 class="font-semibold text-[#2d5a4a] mb-2">Resumen de tu cita</h4>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p><strong>Profesional:</strong> <span id="summaryProfessional"></span></p>
                        <p><strong>Fecha:</strong> <span id="summaryDate"></span></p>
                        <p><strong>Hora:</strong> <span id="summaryTime"></span></p>
                        <p><strong>Tarifa:</strong> <span id="summaryPrice"></span></p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between p-6 border-t">
                <button wire:click="closeModal" class="px-6 py-3 border rounded-lg hover:bg-gray-50">Cancelar</button>
                <button wire:click="createReservation" class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a]">
                    Confirmar cita
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('open-modal', event => {
        const data = event.detail.mentor;
        console.log(data);
        
        document.getElementById('modalProfessionalName').textContent = data.name;
        document.getElementById('modalProfessionalSpecialty').textContent = data.profession;
        document.getElementById('modalProfessionalImage').src = data.avatar;
        document.getElementById('summaryProfessional').textContent = data.name;
        document.getElementById('summaryPrice').textContent = data.price;

        renderCalendar();
        document.body.style.overflow = 'hidden';
    });

    window.addEventListener('close-modal', () => {
        document.getElementById('appointmentModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    });

    // Simula tu calendario (puede reemplazarse por un calendario real)
    function renderCalendar() {
        const timeSlotsContainer = document.getElementById('timeSlotsContainer');
        const times = ["09:00", "09:30", "10:00", "10:30", "11:00", "14:00", "15:00", "16:00"];
        timeSlotsContainer.innerHTML = '';

        times.forEach(time => {
            const btn = document.createElement('button');
            btn.textContent = time;
            btn.className = 'block w-full border rounded py-2 hover:border-[#2d5a4a]';
            btn.onclick = () => {
                @this.set('selectedTime', time);
                document.getElementById('summaryTime').textContent = time;
                document.getElementById('selectedAppointment').classList.remove('hidden');
            };
            timeSlotsContainer.appendChild(btn);
        });
    }
</script>
@endpush
