<div class="section-card" style="margin-top: 1.5rem;">
    <h2 class="section-title">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Horarios Disponibles
    </h2>

    {{-- Lista de horarios existentes --}}
    <div id="availabilities-list" style="margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
        @forelse($user->availabilities()->orderBy('day_of_week')->get() as $slot)

            <div class="availability-row" data-id="{{ $slot->id }}">
                <div style="flex: 1; min-width: 140px;">
                    <span class="slot-label">Día</span>
                    <p class="slot-value">{{ [
                        'monday'    => 'Lunes',
                        'tuesday'   => 'Martes',
                        'wednesday' => 'Miércoles',
                        'thursday'  => 'Jueves',
                        'friday'    => 'Viernes',
                        'saturday'  => 'Sábado',
                        'sunday'    => 'Domingo',
                        0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes',
                        3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado',
                    ][$slot->day_of_week] ?? ucfirst($slot->day_of_week) }}
                    </p>
                </div>
                <div style="flex: 1; min-width: 100px;">
                    <span class="slot-label">Desde</span>
                    <p class="slot-value">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</p>
                </div>
                <div style="flex: 1; min-width: 100px;">
                    <span class="slot-label">Hasta</span>
                    <p class="slot-value">{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</p>
                </div>
                <div style="flex: 1; min-width: 100px;">
                    <span class="slot-label">Recurrente</span>
                    <p class="slot-value">
                        @if($slot->is_recurring)
                            <span style="color: #6EE7B7;">✓ Sí</span>
                        @else
                            <span style="color: rgba(255,255,255,0.4);">No</span>
                        @endif
                    </p>
                </div>
                <div style="flex: 1; min-width: 80px;">
                    <span class="slot-label">Estado</span>
                    <p class="slot-value">
                        @if($slot->active)
                            <span class="badge-active">Activo</span>
                        @else
                            <span class="badge-inactive">Inactivo</span>
                        @endif
                    </p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <form method="POST" action="{{ route('availability.destroy', $slot->id) }}"
                          onsubmit="return confirm('¿Eliminar este horario?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" title="Eliminar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        @empty
            <p class="empty-state-text">Todavía no cargaste ningún horario disponible.</p>
        @endforelse
    </div>

    {{-- Formulario para agregar / editar horario --}}
    <div class="form-divider">
        <h3 class="form-subtitle" id="availabilityFormTitle">➕ Agregar nuevo horario</h3>

        <form method="POST" id="availabilityForm" action="{{ route('availability.store') }}">
            @csrf
            <input type="hidden" name="_method" id="availabilityMethod" value="POST">
            <input type="hidden" name="availability_id" id="availabilityId" value="">

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                {{-- Día --}}
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

                {{-- Hora inicio --}}
                <div class="form-group">
                    <label class="form-label required">Hora de inicio</label>
                    <input type="time" name="start_time" id="av_start" class="form-input" required>
                </div>

                {{-- Hora fin --}}
                <div class="form-group">
                    <label class="form-label required">Hora de fin</label>
                    <input type="time" name="end_time" id="av_end" class="form-input" required>
                </div>

                {{-- Recurrente (oculto) --}}
                <div class="form-group" style="display: none;">
                    <label class="form-label">¿Es recurrente?</label>
                    <select name="is_recurring" id="av_recurring" class="form-input">
                        <option value="1">Sí (se repite cada semana)</option>
                        <option value="0">No (rango de fechas específico)</option>
                    </select>
                </div>

                {{-- Estado --}}
                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select name="active" id="av_active" class="form-input">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>

            {{-- Fechas opcionales --}}
            <div id="dateRangeFields" class="hidden" style="display: none; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Fecha de inicio</label>
                    <input type="date" name="start_date" id="av_start_date" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha de fin</label>
                    <input type="date" name="end_date" id="av_end_date" class="form-input">
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.25rem;">
                <button type="submit" class="btn-primary-edit">
                    <svg style="display: inline; width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        const recurringSelect = document.getElementById('av_recurring');
        const dateRangeFields = document.getElementById('dateRangeFields');

        recurringSelect?.addEventListener('change', function () {
            if (this.value === '0') {
                dateRangeFields.style.display = 'grid';
            } else {
                dateRangeFields.style.display = 'none';
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
                dateRangeFields.style.display = 'grid';
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
            dateRangeFields.style.display = 'none';
        }
    </script>
</div>