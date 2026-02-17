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
            background-color: #1a0a3e;
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
            background-color: #1a0a3e;
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
            background-color: #1a0a3e;
            color: white;
            border-color: #1a0a3e;
        }
    </style>
    
    

    <div class=" justify-center flex flex-col lg:flex-row gap-8">
        @include('backend.mentors.components.filters-sidebar')
        <div class="flex flex-col gap-4">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-2">
                <div class="flex items-center gap-3 mb-4">
                    <h1 class="text-3xl font-bold text-[#1a0a3e]">Pipol</h1>
                    <svg class="w-6 h-6 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-gray-600 mb-6">Diseñado para quienes están en la búsqueda de un profesional adecuado a tus necesidades.</p>
                @livewire('buscador')
            </div>

            <div class="flex items-center justify-center gap-4 mb-2">
                <div class="h-px bg-white flex-1"></div>
                <p class="text-white">Conecta de manera fácil, segura y privada con un mentor en línea.</p>
                <div class="h-px bg-white flex-1"></div>
            </div>

            @if ($mentors->count())
                <!-- Results Count -->
                <div class="flex justify-between items-center">
                    <p class="text-white ">{{ $mentors->count() }} resultados encontrados</p>
                </div>
            @endif
            @if ($mentors->count())
                <div>
                    @foreach ($mentors as $mentor)
                        @include('backend.mentors.components.card')
                    @endforeach
                </div>
            
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
            @else
            <div class="flex justify-between items-baseline">
                <p class="text-gray-600 text-white">No se encontraron profesionales que coincidan con tu búsqueda.</p>

                @if (request('q'))
                    <a href="{{ route('mentors.index') }}" class="px-6 py-2 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors">Limpiar filtros</a>
                @endif
            </div>
        @endif
        </div>
    </div>

    <div>
        {{ $mentors->links() }}
    </div>
    
    @include('backend.mentors.components.perfil-modal')
    @include('backend.mentors.components.appointment-modal')
    @include('backend.mentors.components.appointment-message-modal')

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
                    isPast ? 'disabled' : 'border-gray-200 hover:border-[#1a0a3e]'
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
                timeSlot.className = 'time-slot w-full py-3 px-4 border border-gray-300 rounded-lg text-left hover:border-[#1a0a3e] transition-colors';
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