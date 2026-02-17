@extends('backend.layout.app')
@section('page_title', 'Mis Sesiones')
 
@section('main_content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Mis Sesiones</h1>
                <p class="text-white">Gestiona tus sesiones programadas con mentores</p>
            </div>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm animate-fade-in">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if (request()->status)
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm animate-fade-in">
            <p class="font-medium">{{ request()->status }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sessions List -->
        <div class="lg:col-span-2">
            <!-- Tabs -->
            <div class="flex gap-2 mb-6 bg-white p-2 rounded-lg shadow-sm">
                <button class="tab-button active flex-1 py-2 px-4 rounded-lg font-medium" data-tab="proximas">
                    PrÃ³ximas ({{ $proximas_sesiones->count() }})
                </button>
                <button class="tab-button flex-1 py-2 px-4 rounded-lg font-medium text-gray-600" data-tab="pasadas">
                    Pasadas ({{ $pasadas_sesiones->count() }})
                </button>
                <button class="tab-button flex-1 py-2 px-4 rounded-lg font-medium text-gray-600" data-tab="canceladas">
                    Canceladas ({{ $canceladas_sesiones->count() }})
                </button>
            </div>

            <!-- Sessions Container -->
            <div id="sessions-container">
                <!-- PrÃ³ximas Sessions -->
                <div class="tab-content active" data-content="proximas">
                    @foreach ($proximas_sesiones as $session)
                        @include('backend.sessions.partials.session-card', [
                            'session' => $session,
                            'user' => $user,
                            'type' => 'proximas'
                        ])
                    @endforeach                
                </div>

                <!-- Pasadas Sessions -->
                <div class="tab-content hidden" data-content="pasadas">  
                    @foreach ($pasadas_sesiones as $session)
                        @include('backend.sessions.partials.session-card', [
                            'session' => $session,
                            'user' => $user,
                            'type' => 'pasadas'
                        ])
                    @endforeach     
                </div>

                <!-- Canceladas Sessions -->
                <div class="tab-content hidden" data-content="canceladas">
                    @foreach ($canceladas_sesiones as $session)
                        @include('backend.sessions.partials.session-card', [
                            'session' => $session,
                            'user' => $user,
                            'type' => 'canceladas'
                        ])
                    @endforeach    
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Calendar Widget -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg text-[#1a0a3e]" id="calendar-month-year">
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h3>
                    <div class="flex gap-2">
                        <button onclick="changeMonth(-1)" class="p-1 hover:bg-gray-100 rounded transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button onclick="changeMonth(1)" class="p-1 hover:bg-gray-100 rounded transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="calendar-mini mb-2">
                    <div class="text-center text-xs font-medium text-gray-500 py-2">D</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">L</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">M</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">M</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">J</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">V</div>
                    <div class="text-center text-xs font-medium text-gray-500 py-2">S</div>
                </div>
                
                <div class="calendar-mini" id="calendar-grid">
                    <!-- Calendar days will be generated by JavaScript -->
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <div class="flex items-center gap-2 text-sm mb-2">
                        <div class="w-3 h-3 rounded-full bg-[#1a0a3e]"></div>
                        <span class="text-gray-600">Sesiones programadas</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-3 h-3 rounded-full border-2 border-[#d4af6a]"></div>
                        <span class="text-gray-600">Hoy</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-[#1a0a3e] to-[#1a0a3ee8] rounded-xl shadow-sm p-6 text-white">
                <h3 class="font-semibold text-lg mb-2">Â¿Necesitas ayuda?</h3>
                <p class="text-sm text-white/80 mb-4">Nuestro equipo estÃ¡ disponible para asistirte con cualquier consulta.</p>
                <button class="w-full bg-white text-[#1a0a3e] py-2 px-4 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                    Contactar Soporte
                </button>
            </div>
        </div>
    </div>
    
    <!-- Reschedule Modal -->
    @include('backend.sessions.components.rescheduleModal')

    {{-- Confirm Modal --}}
    @include('backend.sessions.components.confirmModal')
    
    {{-- generateMeetForm Modal --}}
    @include('backend.sessions.components.generateMeetForm')

    {{-- Review Modal --}}
    @include('backend.sessions.components.review-modal')
    
    <!-- Cancel Modal -->
    @include('backend.sessions.components.cancelModal')
    
    <script>
        // Datos del calendario desde el backend
        const calendarData = @json($calendarData);
        let currentMonth = {{ $calendarData['currentMonth'] }};
        let currentYear = {{ $calendarData['currentYear'] }};
        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                           'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.dataset.tab;
                
                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.add('hidden'));
                
                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                document.querySelector(`[data-content="${tabName}"]`).classList.remove('hidden');
            });
        });

        // Cambiar mes del calendario
        function changeMonth(direction) {
            currentMonth += direction;
            
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            } else if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            
            generateCalendar();
        }

        // Generar calendario dinÃ¡micamente
        function generateCalendar() {
            const calendarGrid = document.getElementById('calendar-grid');
            const monthYearTitle = document.getElementById('calendar-month-year');
            
            // Actualizar tÃ­tulo
            monthYearTitle.textContent = `${monthNames[currentMonth - 1]} ${currentYear}`;
            
            // Limpiar grid
            calendarGrid.innerHTML = '';
            
            // Calcular dÃ­as del mes
            const firstDay = new Date(currentYear, currentMonth - 1, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
            
            // DÃ­a actual
            const today = new Date();
            const isCurrentMonth = today.getMonth() + 1 === currentMonth && today.getFullYear() === currentYear;
            const todayDate = today.getDate();
            
            // AÃ±adir celdas vacÃ­as antes del primer dÃ­a
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                calendarGrid.appendChild(emptyDay);
            }
            
            // AÃ±adir dÃ­as del mes
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;
                
                // Formato de fecha para comparar
                const dateStr = `${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                
                // Marcar dÃ­a actual
                if (isCurrentMonth && day === todayDate) {
                    dayElement.classList.add('today');
                }
                
                // Verificar si hay sesiones en este dÃ­a
                if (calendarData.sessionsByDate[dateStr]) {
                    const sessions = calendarData.sessionsByDate[dateStr];
                    const hasUpcoming = sessions.some(s => s.is_upcoming);
                    
                    if (hasUpcoming) {
                        dayElement.classList.add('has-session');
                    }
                    
                    // AÃ±adir tooltip con informaciÃ³n de sesiones
                    const sessionCount = sessions.length;
                    dayElement.title = `${sessionCount} sesiÃ³n${sessionCount > 1 ? 'es' : ''}`;
                    
                    // Hacer clickeable
                    dayElement.style.cursor = 'pointer';
                    dayElement.onclick = () => showSessionsForDate(dateStr, sessions);
                }
                
                calendarGrid.appendChild(dayElement);
            }
        }

        // Mostrar sesiones de una fecha especÃ­fica
        function showSessionsForDate(date, sessions) {
            const formattedDate = new Date(date).toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            let sessionsList = sessions.map(s => `
                <div class="p-3 bg-gray-50 rounded-lg mb-2">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">${s.time}</span>
                        <span class="text-xs px-2 py-1 rounded ${
                            s.status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                            s.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                            'bg-gray-100 text-gray-800'
                        }">
                            ${s.status === 'confirmed' ? 'Confirmada' : 
                              s.status === 'pending' ? 'Pendiente' : 
                              s.status}
                        </span>
                    </div>
                </div>
            `).join('');
            
            // Crear modal simple
            const modalHTML = `
                <div id="session-date-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="closeSessionDateModal(event)">
                    <div class="bg-white rounded-xl max-w-md w-full p-6" onclick="event.stopPropagation()">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-[#1a0a3e]">${formattedDate}</h3>
                            <button onclick="closeSessionDateModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-600 mb-3">${sessions.length} sesiÃ³n${sessions.length > 1 ? 'es' : ''} programada${sessions.length > 1 ? 's' : ''}:</p>
                            ${sessionsList}
                        </div>
                    </div>
                </div>
            `;
            
            // AÃ±adir modal al DOM
            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        // Cerrar modal de sesiones por fecha
        function closeSessionDateModal(event) {
            if (!event || event.target.id === 'session-date-modal') {
                const modal = document.getElementById('session-date-modal');
                if (modal) {
                    modal.remove();
                }
            }
        }

        // Modal functions
        function openRescheduleModal(id, mentorName, date, time) {
            document.getElementById('reschedule-session-id').value = id;
            document.getElementById('reschedule-mentor-name').textContent = mentorName;
            document.getElementById('reschedule-current-time').textContent = `${date} • ${time}`;
            document.getElementById('reschedule-date').value = '';
            document.getElementById('reschedule-time').value = '';
            document.getElementById('rescheduleModal').classList.add('active');
        }

        function closeRescheduleModal() {
            document.getElementById('rescheduleModal').classList.remove('active');
        }

        function confirmReschedule() {
            const id = document.getElementById('reschedule-session-id').value;
            const date = document.getElementById('reschedule-date').value;
            const time = document.getElementById('reschedule-time').value;

            if (!date || !time) {
                alert('Selecciona fecha y horario para reprogramar la sesión.');
                return;
            }

            fetch('{{route("sessions.reschedule")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id, scheduled_at: `${date} ${time}:00` })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.status || 'No se pudo reprogramar la sesión.');
                }
                return data;
            })
            .then(data => {
                alert(data.status);
                window.location.reload();
            })
            .catch(error => {
                alert(error.message);
            });

            closeRescheduleModal();
        }

        function openCancelModal(id, mentorName, date, time) {
            document.getElementById('cancel-session-id').value = id;
            document.getElementById('cancel-mentor-name').textContent = mentorName;
            document.getElementById('cancel-session-time').textContent = `${date} - ${time}`;
            document.getElementById('cancelModal').classList.add('active');
        }

        function openConfirmModal(id) {
            document.getElementById('confirmModal').classList.add('active');
            document.getElementById('confirm-session-id').value = id;
        }

        function closeConfirmModal(){
            document.getElementById('confirmModal').classList.remove('active');
        }
        
        function confirmSession() {
            fetch('{{route("sessions.confirmjson")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: document.getElementById('confirm-session-id').value })
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = window.location.pathname + '?status='+ data.status;
            });

            closeConfirmModal();
        }

        function generarUrlMeet(){
            document.getElementById('generateMeetForm').classList.add('active');
        }
        
        function closeGenerateMeetForm(){
            document.getElementById('generateMeetForm').classList.remove('active');
        }
        
        function closeCancelModal() {
            document.getElementById('cancelModal').classList.remove('active');
        }

        function confirmCancel() {
            fetch('{{route("sessions.cancel")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: document.getElementById('cancel-session-id').value })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.status || 'No se pudo cancelar la sesión.');
                }
                return data;
            })
            .then(data => {
                alert(data.status);
                window.location.reload();
            })
            .catch(error => {
                alert(error.message);
            });

            closeCancelModal();
        }

        // Close modals when clicking outside
        document.getElementById('rescheduleModal').addEventListener('click', (e) => {
            if (e.target.id === 'rescheduleModal') {
                closeRescheduleModal();
            }
        });

        document.getElementById('cancelModal').addEventListener('click', (e) => {
            if (e.target.id === 'cancelModal') {
                closeCancelModal();
            }
        });

        // Initialize calendar on page load
        generateCalendar();
    </script>
@endsection
