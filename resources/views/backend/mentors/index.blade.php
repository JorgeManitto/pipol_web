@extends('backend.layout.app')
@section('page_title', 'Profesionales - Pipol')
@section('main_content')
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar-icon {
            transition: all 0.3s ease;
        }
        
        .sidebar-icon:hover {
            transform: translateX(4px);
        }
        
        .filter-checkbox:checked + label {
            background-color: #2d5a4a;
            color: white;
        }
        
        .professional-card {
            transition: all 0.3s ease;
        }
        
        .professional-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .tag {
            transition: all 0.2s ease;
        }
        
        .tag:hover {
            transform: scale(1.05);
        }
        
        /* Added modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .modal-content {
            background: white;
            border-radius: 20px;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .calendar-day {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .calendar-day:hover:not(.disabled):not(.selected) {
            background-color: #f5f0e8;
            transform: scale(1.05);
        }
        
        .calendar-day.selected {
            background-color: #2d5a4a;
            color: white;
        }
        
        .calendar-day.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        .time-slot {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .time-slot:hover:not(.selected) {
            background-color: #f5f0e8;
            transform: scale(1.02);
        }
        
        .time-slot.selected {
            background-color: #2d5a4a;
            color: white;
            border-color: #2d5a4a;
        }
    </style>
            <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
        <div class="flex items-center gap-3 mb-4">
            <h1 class="text-3xl font-bold text-[#2d5a4a]">Pipol</h1>
            <svg class="w-6 h-6 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <p class="text-gray-600 mb-6">Diseñado para quienes están en la búsqueda de un profesional adecuado a tus necesidades.</p>
        
        {{-- <div class="relative">
            <form action="">
                <input type="text" name="q" value="{{ request('q')}}" placeholder="¿Encontremos a tu próximo terapeuta?" class="w-full px-6 py-4 rounded-xl border-2 border-gray-200 focus:border-[#2d5a4a] focus:outline-none text-gray-700">
                <button class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors">
                    Buscar
                </button>
            </form>
        </div> --}}

        @livewire('buscador')
        {{-- <p class="text-xs text-gray-500 mt-3">Pipol no te sugiere ningún tratamiento médico.</p> --}}
    </div>

    <div class="flex items-center justify-center gap-4 mb-8">
        <div class="h-px bg-white flex-1"></div>
        <p class="text-white">Conecta de manera fácil, segura y privada con un mentor en línea.</p>
        <div class="h-px bg-white flex-1"></div>
    </div>

    @if ($mentors->count())
        <!-- Results Count -->
        <div class="flex justify-between items-center">
            <p class="text-white mb-6">{{ $mentors->count() }} resultados encontrados</p>
            @if (request('q'))
                <a href="{{ route('mentors.index') }}" class="px-6 py-2 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors">Limpiar filtros</a>
            @endif
        </div>
    @endif

    @if ($mentors->count())
    <div class="container">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
            @foreach ($mentors as $mentor)
            <!-- Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col h-full min-h-[480px] lg:min-h-[520px]">

                <!-- Contenido principal (flexible) -->
                <div class="p-4 flex flex-col flex-grow">

                    <!-- Avatar + nombre + profesión + idioma -->
                    <div class="flex items-start gap-4 mb-5">
                        <img 
                            src="{{ $mentor->avatar ? asset('storage/avatars/'.$mentor->avatar) : asset('images/default-avatar.png') }}" 
                            alt="{{ $mentor->name }} {{ $mentor->last_name }}"
                            class="w-14 h-14 rounded-full object-cover flex-shrink-0"
                        >
                        <div class="flex-1">
                            <div class="flex items-baseline gap-2 mb-1">
                                <a href="{{ route('profile.show', ['id' => $mentor->id]) }}">
                                    <h3 class="font-semibold text-lg text-gray-900 hover:text-[#2d5a4a] transition-colors">
                                        {{ $mentor->name }} {{ $mentor->last_name }}
                                    </h3>
                                </a>
                                <svg class="w-4 h-4 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zM9 10.586l1.293 1.293a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $mentor->profession }}</p>
                            <div class="flex items-center gap-1 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                                <span>Español</span>
                            </div>
                        </div>
                    </div>

                    <!-- Especialidades -->
                    <div class="mb-5">
                        <p class="text-xs text-gray-500 mb-2">Especialidades:</p>
                        <div class="flex flex-wrap gap-2">
                            @if ($mentor->skills)
                                @php
                                    if (is_string($mentor->skills)) {
                                        $mentor->skills = collect(explode(',', $mentor->skills))
                                            ->map(fn($skill, $index) => (object)['id' => $index, 'name' => trim($skill)]);
                                    }
                                @endphp
                                @foreach ($mentor->skills as $skill)
                                    <a href="{{ route('mentors.index', ['skill' => $skill->id]) }}"
                                    class="px-3 py-1 bg-[#f5f0e8] text-[#2d5a4a] text-xs rounded-full hover:bg-[#e8dfcc] transition-colors tag">
                                        {{ $skill->name }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="">
                        <p class="text-xs text-gray-500 mb-2">Modalidad de atención</p>
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Online</span>
                        </div>
                    </div>
                    <div class="border-t mt-auto">
                        <p class="text-2xl font-bold text-[#2d5a4a] mb-4 pt-2 text-left">
                            {{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}/h
                        </p>
                        <button  data-mentor='@json($mentor)'
                            data-avatar="{{ $mentor->avatar ? asset("storage/avatars/".$mentor->avatar) : asset("images/default-avatar.png") }}"
                            data-price="{{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}"
                            
                            class="w-full py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium text-base mentor-btn">
                            Conóceme
                        </button>
                        

                        {{-- <button 
                            onclick="openModal(
                                '{{ $mentor->id }}',
                                '{{ $mentor->name }} {{ $mentor->last_name }}',
                                '{{ $mentor->profession }}',
                                '{{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}',
                                '{{ $mentor->avatar ? asset('storage/avatars/'.$mentor->avatar) : asset('images/default-avatar.png') }}',
                                '{{ auth()->id() }}',
                                '{{ $mentor->hourly_rate }}',
                                '{{ $mentor->currency }}'
                            )"
                            class="w-full py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium text-base">
                            Conóceme
                        </button> --}}
                    </div>

                </div>
            </div>
            @endforeach
            <script>
                document.querySelectorAll('.mentor-btn').forEach(btn => {
                    btn.addEventListener('click', function () {

                        const mentor = JSON.parse(this.dataset.mentor);
                        const avatar = this.dataset.avatar;
                        const price = this.dataset.price;

                        console.log(mentor); // ✅ ahora sí
                        openPerfilModal(mentor, avatar, price);
                    });
                });

            </script>
        </div>
    </div>
    
    @else
    <div class="flex justify-between items-center">
        <p class="text-gray-600 text-white">No se encontraron profesionales que coincidan con tu búsqueda.</p>

        @if (request('q'))
            <a href="{{ route('mentors.index') }}" class="px-6 py-2 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors">Limpiar filtros</a>
        @endif
    </div>
    @endif

    <!-- Pagination -->
    {{-- <div class="flex justify-center items-center gap-2 mt-12">
        <button class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="px-4 py-2 rounded-lg bg-[#2d5a4a] text-white">1</button>
        <button class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">2</button>
        <button class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">3</button>
        <span class="px-2">...</span>
        <button class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">13</button>
        <button class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div> --}}
    <div>
        {{ $mentors->links() }}
    </div>
    
    @include('backend.mentors.components.perfil-modal')
    <!-- Appointment booking modal -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b">
                <div class="flex items-center gap-4">
                    <img id="modalProfessionalImage" src="/placeholder.svg" alt="" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h2 id="modalProfessionalName" class="text-2xl font-bold text-[#2d5a4a]"></h2>
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
                        <h3 class="text-lg font-semibold text-[#2d5a4a] mb-4">Selecciona una fecha</h3>
                        
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
                        <h3 class="text-lg font-semibold text-[#2d5a4a] mb-4">Horarios disponibles</h3>
                        <div id="timeSlots" class="space-y-2 max-h-96 overflow-y-auto">
                            <p class="text-gray-500 text-center py-8">Selecciona una fecha para ver los horarios disponibles</p>
                        </div>
                    </div>
                </div>
                
                <!-- Selected Appointment Info -->
                <div id="selectedAppointment" class="mt-6 p-4 bg-[#f5f0e8] rounded-lg hidden">
                    <h4 class="font-semibold text-[#2d5a4a] mb-2">Resumen de tu cita</h4>
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
                <button id="confirmButton" onclick="confirmAppointment()" class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Ir al pago
                </button>
            </div>
        </div>
    </div>
    <div class="modal" id="appointmentMessage">
        <div class="modal-content">
            <div class="flex justify-center p-6">
                <h2 class="text-2xl font-bold text-[#2d5a4a] text-center">Notificación de pipol</h2>
            </div>
            <div id="content-payment">
                <div class="p-6">
                    <div id="message"></div>
                    <div class="my-4">
                        <h3 class="text-lg font-semibold text-[#2d5a4a] mb-4">Realiza tu pago para asegurar tu mentoría</h3>
                    </div>
                    <script src="https://js.stripe.com/v3/"></script>
                    <form id="payment-form">
                        <div class="mb-6">
                            <div id="card-element"></div>
                        </div>
                        
                        <button id="submit" class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium w-full">Pagar</button>
                    </form>
    
                </div>
                <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                    <button onclick="closeMessageModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full">
                        Cerrar
                    </button>
                    <a href="{{ route('sessions.index') }}" class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium w-full">Ir a mis Sesiones </a>
                </div>
            </div>
            <div id="container-loader" style="display: none;">
                <div class="flex justify-center p-6">
                    <div style="width: 150px;height: 150px;">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 150">
                            <path fill="none" stroke="#1A0A3E" stroke-width="15" stroke-linecap="round" stroke-dasharray="300 385" stroke-dashoffset="0" d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z">
                                <animate attributeName="stroke-dashoffset" calcMode="spline" dur="2" values="685;-685" keySplines="0 0 1 1" repeatCount="indefinite"></animate>
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div style="display: none;" id="response-message">
                <div class="flex justify-start p-6">
                    <h2 class="text-2xl font-bold text-[#000000] text-center" id="response-message-text"></h2>
                </div>
                <div class="flex items-center gap-4 flex-col md:flex-row p-6">
                    <button onclick="closeMessageModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium w-full">
                        Cerrar
                    </button>
                    <a href="{{ route('sessions.index') }}" class="px-6 py-3 bg-[#2d5a4a] text-white rounded-lg hover:bg-[#3d6a5a] transition-colors font-medium w-full">Ir a mis Sesiones </a>
                </div>
            </div>
        </div>
    </div>

   
    
    <!-- Added JavaScript for modal functionality -->
    <script>
        const contentPayment = document.getElementById('content-payment');
        const appointmentMessage = document.getElementById('appointmentMessage');
        const messageDiv = document.getElementById('message');
        const containerLoader = document.getElementById('container-loader');
        const responseMessageDiv = document.getElementById('response-message');
        const responseMessageText = document.getElementById('response-message-text');

        let idSession = null;
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;
        let currentProfessional = {
            mentor_id: '',
            name: '',
            specialty: '',
            price: '',
            image: '',
            mentee_id: '',
            hourly_rate: '',
            currency: '',
        };
        
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        
        // Sample time slots (in a real app, these would come from the backend)
        const availableTimeSlots = [
            "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
            "14:00", "14:30", "15:00", "15:30", "16:00", "16:30",
            "17:00", "17:30", "18:00", "18:30"
        ];
        
        function openModal(mentor_id,name, specialty, price, image, mentee_id, hourly_rate, currency) {
            currentProfessional = { mentor_id ,name, specialty, price, image, mentee_id, hourly_rate ,currency};
            console.log(currentProfessional);
            
            const modalProfessionalName  = document.getElementById('modalProfessionalName')
            const modalProfessionalSpecialty  = document.getElementById('modalProfessionalSpecialty')
            const modalProfessionalImage  = document.getElementById('modalProfessionalImage')
            const appointmentModal  = document.getElementById('appointmentModal')
            if (modalProfessionalName)modalProfessionalName.textContent = name;
            if(modalProfessionalSpecialty)modalProfessionalSpecialty.textContent = specialty;
            if(modalProfessionalImage)modalProfessionalImage.src = image;
            if(appointmentModal)appointmentModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            renderCalendar();
        }
        
        function closeModal() {
            document.getElementById('appointmentModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            selectedDate = null;
            selectedTime = null;
            document.getElementById('selectedAppointment').classList.add('hidden');
            document.getElementById('confirmButton').disabled = true;
        }
        
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            document.getElementById('calendarMonth').textContent = `${monthNames[month]} ${year}`;
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();
            
            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';
            
            // Empty cells for days before month starts
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                calendarDays.appendChild(emptyDay);
            }
            
            // Days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayDate = new Date(year, month, day);
                const isPast = dayDate < today.setHours(0, 0, 0, 0);
                
                const dayElement = document.createElement('div');
                dayElement.className = `calendar-day text-center py-3 rounded-lg border ${
                    isPast ? 'disabled' : 'border-gray-200 hover:border-[#2d5a4a]'
                }`;
                dayElement.textContent = day;
                
                if (!isPast) {
                    dayElement.onclick = () => selectDate(year, month, day);
                }
                
                calendarDays.appendChild(dayElement);
            }
        }
        
        function selectDate(year, month, day) {
            selectedDate = new Date(year, month, day);
            selectedTime = null;
            
            // Update calendar UI
            const days = document.querySelectorAll('.calendar-day');
            days.forEach(d => d.classList.remove('selected'));
            event.target.classList.add('selected');
            
            // Render time slots
            renderTimeSlots();
            
            // Hide appointment summary
            document.getElementById('selectedAppointment').classList.add('hidden');
            document.getElementById('confirmButton').disabled = true;
        }
        
        function renderTimeSlots() {
            const timeSlotsContainer = document.getElementById('timeSlots');
            timeSlotsContainer.innerHTML = '';
            
            availableTimeSlots.forEach(time => {
                const timeSlot = document.createElement('button');
                timeSlot.className = 'time-slot w-full py-3 px-4 border border-gray-300 rounded-lg text-left hover:border-[#2d5a4a] transition-colors';
                timeSlot.textContent = time;
                timeSlot.onclick = () => selectTime(time, timeSlot);
                timeSlotsContainer.appendChild(timeSlot);
            });
        }
        
        function selectTime(time, element) {
            selectedTime = time;
            
            // Update time slots UI
            const slots = document.querySelectorAll('.time-slot');
            slots.forEach(s => s.classList.remove('selected'));
            element.classList.add('selected');
            
            // Show appointment summary
            updateAppointmentSummary();
            document.getElementById('confirmButton').disabled = false;
        }
        
        function updateAppointmentSummary() {
            const dateStr = selectedDate.toLocaleDateString('es-ES', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            document.getElementById('summaryProfessional').textContent = currentProfessional.name;
            document.getElementById('summaryDate').textContent = dateStr;
            document.getElementById('summaryTime').textContent = selectedTime;
            document.getElementById('summaryPrice').textContent = currentProfessional.price;
            document.getElementById('selectedAppointment').classList.remove('hidden');
        }
        
        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }
        
        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }
        

        // Esto es para prod
        // async function confirmAppointment() {
        //     const button = document.getElementById("confirmButton");

        //     if (selectedDate && selectedTime) {
        //         // Mostrar loader
        //         button.disabled = true;
        //         const originalText = button.innerHTML;
        //         button.innerHTML = `
        //             <svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        //                 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        //                 <path class="opacity-75" fill="currentColor"
        //                     d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
        //                 </path>
        //             </svg>
        //             Cargando...
        //         `;

        //         try {
        //             currentProfessional.selectedDate = selectedDate.toISOString().split('T')[0];
        //             currentProfessional.selectedTime = selectedTime;

        //             // Esperar a que termine la llamada a la API
        //             await setAppointmentToApi(currentProfessional);

        //             closeModal();
        //         } catch (error) {
        //             console.error(error);
        //             alert('Ocurrió un error al confirmar la cita.');
        //         } finally {
        //             // Restaurar el botón
        //             button.innerHTML = originalText;
        //             button.disabled = false;
        //         }
        //     }
        // }

        // Esto es para dev
        async function confirmAppointment() {
            const button = document.getElementById("confirmButton");

            if (selectedDate && selectedTime) {
                // Mostrar loader
                button.disabled = true;
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                        </path>
                    </svg>
                    Cargando...
                `;

                try {
                    currentProfessional.selectedDate = selectedDate.toISOString().split('T')[0];
                    currentProfessional.selectedTime = selectedTime;

                    // Simular llamada a la API (2 segundos)
                    await new Promise(resolve => setTimeout(resolve, 2000));
                    await setAppointmentToApi(currentProfessional);
                    // Simula éxito
                    closeModal();
                } catch (error) {
                    console.error(error);
                    alert('Ocurrió un error al confirmar la cita.');
                } finally {
                    // Restaurar botón
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            }
        }


        
        // Close modal when clicking outside
        document.getElementById('appointmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function setAppointmentToApi(params) {
            fetch('/api/appointments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(params)
            })
            .then(response => response.json())
            .then(data => {
                openMessageModal(data.message);
                console.log('Appointment saved:', data);
                idSession = data.session_id;
            })
            .catch((error) => {
                openMessageModal('Ocurrió un error al guardar la cita. Por favor, inténtalo de nuevo.');
                console.error('Error:', error);
            });
        }
        function openMessageModal(message) {
            // document.getElementById('message').textContent = message;
            document.getElementById('appointmentMessage').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeMessageModal() {
            document.getElementById('appointmentMessage').classList.remove('active');

            document.getElementById('message').textContent = '';
            document.getElementById('response-message-text').textContent = '';

            responseMessageDiv.style.display = 'none';

            document.body.style.overflow = 'auto';
             contentPayment.style.display = 'block';
        }
    </script>

     <script>


        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        document.getElementById('payment-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            console.log(parseInt(currentProfessional.hourly_rate));
            contentPayment.style.display = 'none';
            containerLoader.style.display = 'block';

            const response = await fetch('{{route('createPaymentIntent')}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: parseInt(currentProfessional.hourly_rate), // $75.00
                    profesionalId: currentProfessional.mentor_id,
                    idSession : idSession,
                })
            });

            const data = await response.json();

            const result = await stripe.confirmCardPayment(data.clientSecret, {
                payment_method: {
                    card: cardElement
                }

            });

            if (result.error) {
                containerLoader.style.display = 'none';
                responseMessageDiv.style.display = 'block';
                responseMessageText.textContent = 'Error en el pago: ' + result.error.message;
                idSession = null;
                console.log(result.error.message);
            } else if (result.paymentIntent.status === 'succeeded') {
                console.log('Pago exitoso 🎉');
                idSession = null;
                containerLoader.style.display = 'none';
                responseMessageDiv.style.display = 'block';
                responseMessageText.textContent = 'Pago realizado con éxito. ¡Gracias!';
            }
        });
    </script>
@endsection