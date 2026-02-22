<div class="section-card mt-6">
            <h2 class="section-title">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Horarios Disponibles
            </h2>

            <!-- Lista de horarios existentes -->
            <div id="availabilities-list" class="mb-6 space-y-3">
                @forelse($user->availabilities()->orderBy('day_of_week')->get() as $slot)
                
                    <div class="availability-row flex flex-wrap items-center gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg" data-id="{{ $slot->id }}">
                        <div class="flex-1 min-w-[140px]">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Día</span>
                            <p class="font-medium text-gray-800">{{ [
                                'monday'    => 'Lunes',
                                'tuesday'   => 'Martes',
                                'wednesday' => 'Miércoles',
                                'thursday'  => 'Jueves',
                                'friday'    => 'Viernes',
                                'saturday'  => 'Sábado',
                                'sunday'    => 'Domingo',
                                // por si acaso también hay numéricos:
                                0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes',
                                3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado',
                            ][$slot->day_of_week] ?? ucfirst($slot->day_of_week) }}
                            </p>
                        </div>
                        <div class="flex-1 min-w-[100px]">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Desde</span>
                            <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</p>
                        </div>
                        <div class="flex-1 min-w-[100px]">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Hasta</span>
                            <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</p>
                        </div>
                        <div class="flex-1 min-w-[100px]">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Recurrente</span>
                            <p class="font-medium">
                                @if($slot->is_recurring)
                                    <span class="text-green-600">✓ Sí</span>
                                @else
                                    <span class="text-gray-500">No</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex-1 min-w-[80px]">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Estado</span>
                            <p class="font-medium">
                                @if($slot->active)
                                    <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs">Activo</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs">Inactivo</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <button type="button"
                                    onclick="editAvailability({{ $slot->id }}, {{ $slot->day_of_week }}, '{{ $slot->start_time }}', '{{ $slot->end_time }}', {{ $slot->is_recurring ? 1 : 0 }}, {{ $slot->active ? 1 : 0 }}, '{{ $slot->start_date }}', '{{ $slot->end_date }}')"
                                    class="p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors"
                                    title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('availability.destroy', $slot->id) }}" onsubmit="return confirm('¿Eliminar este horario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic text-center py-4">Todavía no cargaste ningún horario disponible.</p>
                @endforelse
            </div>

            <!-- Formulario para agregar / editar horario -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-bold text-gray-700 mb-4" id="availabilityFormTitle">➕ Agregar nuevo horario</h3>

                <form method="POST" id="availabilityForm" action="{{ route('availability.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="availabilityMethod" value="POST">
                    <input type="hidden" name="availability_id" id="availabilityId" value="">

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Día -->
                        <div class="form-group">
                            <label class="form-label required">Día de la semana</label>
                            <select name="day_of_week" id="av_day" class="form-input" required>
                                <option value="">Seleccionar...</option>
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miércoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                                <option value="6">Sábado</option>
                                <option value="0">Domingo</option>
                            </select>
                        </div>

                        <!-- Hora inicio -->
                        <div class="form-group">
                            <label class="form-label required">Hora de inicio</label>
                            <input type="time" name="start_time" id="av_start" class="form-input" required>
                        </div>

                        <!-- Hora fin -->
                        <div class="form-group">
                            <label class="form-label required">Hora de fin</label>
                            <input type="time" name="end_time" id="av_end" class="form-input" required>
                        </div>

                        <!-- Recurrente -->
                        <div class="form-group hidden">
                            <label class="form-label">¿Es recurrente?</label>
                            <select name="is_recurring" id="av_recurring" class="form-input">
                                <option value="1">Sí (se repite cada semana)</option>
                                <option value="0">No (rango de fechas específico)</option>
                            </select>
                        </div>

                        <!-- Estado -->
                        <div class="form-group">
                            <label class="form-label">Estado</label>
                            <select name="active" id="av_active" class="form-input">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fechas opcionales (solo si no es recurrente) -->
                    <div id="dateRangeFields" class="hidden grid md:grid-cols-2 gap-4 mt-2">
                        <div class="form-group">
                            <label class="form-label">Fecha de inicio</label>
                            <input type="date" name="start_date" id="av_start_date" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Fecha de fin</label>
                            <input type="date" name="end_date" id="av_end_date" class="form-input">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-4">
                        <button type="submit" class="btn-primary-edit">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span id="availabilitySubmitText">Guardar horario</span>
                        </button>
                        <button type="button" onclick="resetAvailabilityForm()" class="btn-secondary">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
            <script>
                // --- Availability form logic ---
                const recurringSelect = document.getElementById('av_recurring');
                const dateRangeFields = document.getElementById('dateRangeFields');

                recurringSelect?.addEventListener('change', function () {
                    if (this.value === '0') {
                        dateRangeFields.classList.remove('hidden');
                        dateRangeFields.classList.add('grid');
                    } else {
                        dateRangeFields.classList.add('hidden');
                        dateRangeFields.classList.remove('grid');
                    }
                });

                function editAvailability(id, day, start, end, recurring, active, startDate, endDate) {
                    document.getElementById('availabilityFormTitle').textContent = '✏️ Editando horario';
                    document.getElementById('availabilitySubmitText').textContent = 'Actualizar horario';
                    document.getElementById('availabilityId').value = id;
                    document.getElementById('availabilityMethod').value = 'PUT';
                    document.getElementById('availabilityForm').action = `/availability/${id}`;

                    document.getElementById('av_day').value = day;
                    document.getElementById('av_start').value = start.substring(0, 5);
                    document.getElementById('av_end').value = end.substring(0, 5);
                    document.getElementById('av_recurring').value = recurring;
                    document.getElementById('av_active').value = active;
                    document.getElementById('av_start_date').value = startDate ?? '';
                    document.getElementById('av_end_date').value = endDate ?? '';

                    if (recurring == 0) {
                        dateRangeFields.classList.remove('hidden');
                        dateRangeFields.classList.add('grid');
                    }

                    document.getElementById('availabilityForm').scrollIntoView({ behavior: 'smooth' });
                }

                function resetAvailabilityForm() {
                    document.getElementById('availabilityFormTitle').textContent = '➕ Agregar nuevo horario';
                    document.getElementById('availabilitySubmitText').textContent = 'Guardar horario';
                    document.getElementById('availabilityId').value = '';
                    document.getElementById('availabilityMethod').value = 'POST';
                    document.getElementById('availabilityForm').action = "{{ route('availability.store') }}";
                    document.getElementById('availabilityForm').reset();
                    dateRangeFields.classList.add('hidden');
                    dateRangeFields.classList.remove('grid');
                }
            </script>
        </div>