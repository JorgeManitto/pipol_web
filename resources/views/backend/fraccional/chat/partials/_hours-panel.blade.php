
<div class="p-6" x-data="hoursPanel()">

    {{-- Resumen --}}
    <div class="mb-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-100">
        <p class="text-xs text-purple-600 uppercase tracking-wide mb-1">Aprobadas</p>
        <p class="text-3xl font-semibold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
            {{ number_format($contract->totalHours(), 2) }}
            <span class="text-sm text-gray-600">hs</span>
        </p>

        @if($contract->pendingHours() > 0)
            <p class="text-xs text-amber-700 mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ number_format($contract->pendingHours(), 2) }} hs pendientes de revisión
            </p>
        @endif
        @if($contract->disputedHours() > 0)
            <p class="text-xs text-red-700 mt-1 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/></svg>
                {{ number_format($contract->disputedHours(), 2) }} hs en reclamo
            </p>
        @endif

        <p class="text-xs text-gray-500 mt-2">
            Dedicación acordada: {{ $contract->hours_per_week }} hs/semana
        </p>
    </div>

    {{-- CTA carga (solo profesional) --}}
    @if($isProfessional)
        <button @click="addOpen = true"
                class="w-full rounded-md px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition mb-4">
            + Cargar horas
        </button>
    @endif

    {{-- Listado --}}
    <div class="space-y-2 max-h-[26rem] overflow-y-auto">
        @forelse($contract->timeEntries as $entry)
            @php
                $statusClasses = match($entry->status) {
                    'approved'      => 'border-green-200 bg-green-50',
                    'auto_approved' => 'border-blue-200 bg-blue-50',
                    'disputed'      => 'border-red-200 bg-red-50',
                    default         => 'border-amber-200 bg-amber-50',
                };
            @endphp
            {{-- Estado: empresa subió evidencia, profesional debe responder --}}
            @if($isProfessional && $entry->status === 'evidence_submitted')
                <div class="mt-2 p-2 bg-orange-50 border border-orange-200 rounded text-[11px]">
                    <p class="font-medium text-orange-700 mb-1">📎 La empresa subió evidencia</p>
                    @foreach($entry->evidence_files as $file)
                        <a href="{{ asset('storage/' . $file['path']) }}" target="_blank"
                        class="block text-xs text-blue-600 hover:underline truncate">
                            {{ $file['original_name'] }}
                        </a>
                    @endforeach

                    <div class="flex gap-1 mt-2">
                        <form action="{{ route('fraccional.dispute.accept', $entry) }}" method="POST"
                            onsubmit="return confirm('¿Aceptás la evidencia? Estas horas no se cobrarán.')">
                            @csrf
                            <button type="submit" class="text-xs px-2 py-1 rounded bg-gray-200 hover:bg-gray-300">
                                Aceptar evidencia
                            </button>
                        </form>
                        <button @click="openReject({{ $entry->id }})"
                                class="text-xs px-2 py-1 rounded bg-red-100 text-red-700 hover:bg-red-200">
                            Rechazar e ir a mediación
                        </button>
                    </div>
                </div>
            @endif

            {{-- Estado: profesional disputó, empresa debe subir evidencia --}}
            @if($isCompany && $entry->status === 'disputed')
                <button @click="openEvidence({{ $entry->id }})"
                        class="mt-2 text-xs px-3 py-1.5 rounded bg-orange-600 text-white hover:bg-orange-700 transition">
                    📎 Subir evidencia
                </button>
            @endif

            {{-- Estado: en mediación --}}
            @if($entry->status === 'in_mediation')
                <div class="mt-2 p-2 bg-purple-50 border border-purple-200 rounded text-[11px]">
                    <p class="font-medium text-purple-700">⚖️ En mediación de Pipol</p>
                    <p class="text-gray-600 mt-1">Estamos revisando el caso. Te avisaremos cuando se resuelva.</p>
                </div>
            @endif

            {{-- Estado: resuelta --}}
            @if($entry->isResolvedDispute())
                <div class="mt-2 p-2 bg-gray-50 border border-gray-200 rounded text-[11px]">
                    <p class="font-medium text-gray-700">⚖️ Resolución</p>
                    @if($entry->status === 'resolved_company')
                        <p class="text-gray-600 mt-1">A favor de la empresa: estas horas no se cobran.</p>
                    @elseif($entry->status === 'resolved_professional')
                        <p class="text-gray-600 mt-1">A favor del profesional: las {{ $entry->hours }} hs se aprueban.</p>
                    @elseif($entry->status === 'resolved_partial')
                        <p class="text-gray-600 mt-1">
                            Resolución parcial: {{ $entry->approved_hours_after_mediation }}/{{ $entry->hours }} hs aprobadas.
                        </p>
                    @endif
                    @if($entry->mediation_notes)
                        <p class="text-gray-500 mt-1 italic">"{{ $entry->mediation_notes }}"</p>
                    @endif
                </div>
            @endif
            <div class="p-3 rounded-lg border {{ $statusClasses }}">

                <div class="flex items-start justify-between gap-2 mb-1">
                    <div>
                        <p class="text-sm font-medium text-gray-900">
                            {{ number_format($entry->hours, 2) }} hs
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $entry->worked_on->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- Status badge --}}
                    <div>
                        @if($entry->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Pendiente
                            </span>
                        @elseif($entry->status === 'approved')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800">
                                ✓ Aprobada
                            </span>
                        @elseif($entry->status === 'auto_approved')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800">
                                ⏰ Auto-aprobada
                            </span>
                        @elseif($entry->status === 'disputed')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800">
                                ⚠ En reclamo
                            </span>
                        @endif
                    </div>
                </div>

                <p class="text-xs text-gray-700 mb-2">{{ $entry->description }}</p>

                {{-- Countdown si pendiente --}}
                @if($entry->isPending() && $entry->review_deadline_at)
                    <div class="text-[10px] text-gray-500 flex items-center gap-1 mb-2"
                         x-data="countdown('{{ $entry->review_deadline_at->toIso8601String() }}')"
                         x-init="start()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span x-text="text"></span>
                        <template x-if="expired">
                            <span class="text-blue-600 font-medium">se auto-aprobará pronto</span>
                        </template>
                    </div>
                @endif

                {{-- Motivo de reclamo --}}
                @if($entry->isDisputed() && $entry->dispute_reason)
                    <div class="mt-2 p-2 bg-white border border-red-200 rounded text-[11px]">
                        <p class="font-medium text-red-700 mb-0.5">Motivo del reclamo:</p>
                        <p class="text-gray-700">{{ $entry->dispute_reason }}</p>
                    </div>
                @endif

                {{-- Acciones --}}
                <div class="flex gap-2 mt-2">
                    {{-- Empresa: aprobar / reclamar --}}
                    @if($isCompany && $entry->isPending())
                        <form action="{{ route('fraccional.time.approve', $entry) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="text-xs font-medium text-green-700 hover:text-green-800 px-2 py-1 rounded hover:bg-green-100 transition">
                                ✓ Aprobar
                            </button>
                        </form>

                        <button @click="openDispute({{ $entry->id }})"
                                class="text-xs font-medium text-red-700 hover:text-red-800 px-2 py-1 rounded hover:bg-red-100 transition">
                            ⚠ Reclamar
                        </button>
                    @endif

                    {{-- Profesional: borrar (solo en pending y < 24hs) --}}
                    @if($isProfessional && $entry->isPending() && $entry->created_at->gte(now()->subHours(24)))
                        <form action="{{ route('fraccional.time.destroy', $entry) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta entrada?')" class="ml-auto">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-gray-500 hover:text-red-600 transition">
                                Eliminar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 text-center py-4">
                Aún no hay horas cargadas.
            </p>
        @endforelse
    </div>

    {{-- ======================== --}}
    {{-- Modal: cargar horas (profesional) --}}
    {{-- ======================== --}}
    @if($isProfessional)
        <div x-show="addOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
             @click.self="addOpen = false">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-medium">Cargar horas trabajadas</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        La empresa tendrá 72hs para aprobarlas. Si no responde, se aprueban automáticamente.
                    </p>
                </div>
                <form action="{{ route('fraccional.time.store', $contract) }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                        <input type="date" name="worked_on" required
                               max="{{ now()->toDateString() }}"
                               value="{{ now()->toDateString() }}"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Horas</label>
                        <input type="number" name="hours" step="0.25" min="0.25" max="24" required
                               placeholder="Ej: 2.5"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none">
                        <p class="text-xs text-gray-500 mt-1">Fracciones de 15 minutos (0.25, 0.5, 0.75...)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de la tarea</label>
                        <textarea name="description" rows="3" required maxlength="500"
                                  placeholder="¿En qué trabajaste? Sé específico para facilitar la aprobación."
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"></textarea>
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="addOpen = false"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition">
                            Cargar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ======================== --}}
    {{-- Modal: reclamo (empresa) --}}
    {{-- ======================== --}}
    @if($isCompany)
        <div x-show="disputeOpen" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
             @click.self="disputeOpen = false">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-medium flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                        Iniciar reclamo
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Explicá por qué no estás de acuerdo con estas horas. El profesional podrá responder
                        y nuestro equipo mediará si no llegan a un acuerdo.
                    </p>
                </div>
                <form :action="disputeUrl" method="POST" class="p-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Motivo del reclamo
                        </label>
                        <textarea name="dispute_reason" rows="4" required minlength="10" maxlength="1000"
                                  placeholder="Ej: No tenemos registro de actividad ese día, las horas declaradas no coinciden con lo conversado, etc."
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Mínimo 10 caracteres. Sé claro y específico.</p>
                    </div>

                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-800">
                        Una vez iniciado el reclamo, esta entrada queda en revisión y no suma al total
                        hasta que se resuelva.
                    </div>

                    <div class="flex gap-2 pt-4 border-t border-gray-100">
                        <button type="button" @click="disputeOpen = false"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 rounded-md px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                            Iniciar reclamo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    {{-- Modal evidencia (empresa) --}}
    @if($isCompany)
    <div x-show="evidenceOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="evidenceOpen = false">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b">
                <h3 class="text-lg font-medium">Subir evidencia del reclamo</h3>
                <p class="text-sm text-gray-600 mt-1">Adjuntá hasta 5 archivos que respalden tu reclamo.</p>
            </div>
            <form :action="evidenceUrl" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Archivos</label>
                    <input type="file" name="evidence_files[]" multiple required
                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                        class="w-full text-sm">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, PDF, DOC. Máximo 10MB cada uno.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Notas adicionales</label>
                    <textarea name="evidence_notes" rows="3" maxlength="1000"
                            class="w-full rounded-lg border px-3 py-2 text-sm"
                            placeholder="Contexto extra para el profesional..."></textarea>
                </div>
                <div class="flex gap-2 pt-3 border-t">
                    <button type="button" @click="evidenceOpen = false"
                            class="flex-1 rounded-md px-4 py-2 text-sm border border-gray-300">Cancelar</button>
                    <button type="submit"
                            class="flex-1 rounded-md px-4 py-2 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700">
                        Enviar evidencia
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Modal rechazo evidencia (profesional) --}}
    @if($isProfessional)
    <div x-show="rejectOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="rejectOpen = false">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b">
                <h3 class="text-lg font-medium">Rechazar evidencia</h3>
                <p class="text-sm text-gray-600 mt-1">El caso pasará a mediación de Pipol. Explicá tu posición.</p>
            </div>
            <form :action="rejectUrl" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Tu respuesta</label>
                    <textarea name="professional_response" rows="4" required minlength="10" maxlength="2000"
                            class="w-full rounded-lg border px-3 py-2 text-sm"
                            placeholder="Por qué no aceptás la evidencia presentada..."></textarea>
                </div>
                <div class="flex gap-2 pt-3 border-t">
                    <button type="button" @click="rejectOpen = false"
                            class="flex-1 rounded-md px-4 py-2 text-sm border border-gray-300">Cancelar</button>
                    <button type="submit"
                            class="flex-1 rounded-md px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Ir a mediación
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

<script>
function hoursPanel() {
    return {
        addOpen: false,
        disputeOpen: false,
        disputeUrl: '',
        evidenceOpen: false,
        evidenceUrl: '',
        rejectOpen: false,
        rejectUrl: '',

        openDispute(id) {
            this.disputeUrl = `/fraccional/time-entries/${id}/dispute`;
            this.disputeOpen = true;
        },
        openEvidence(id) {
            this.evidenceUrl = `/fraccional/time-entries/${id}/evidence`;
            this.evidenceOpen = true;
        },
        openReject(id) {
            this.rejectUrl = `/fraccional/time-entries/${id}/reject-evidence`;
            this.rejectOpen = true;
        },
    };
}

function countdown(deadlineIso) {
    return {
        text: '',
        expired: false,
        interval: null,

        start() {
            this.update();
            this.interval = setInterval(() => this.update(), 60000); // cada minuto
        },

        update() {
            const now = new Date();
            const deadline = new Date(deadlineIso);
            const diff = deadline - now;

            if (diff <= 0) {
                this.text = 'Plazo vencido';
                this.expired = true;
                if (this.interval) clearInterval(this.interval);
                return;
            }

            const hours = Math.floor(diff / 3600000);
            const minutes = Math.floor((diff % 3600000) / 60000);

            if (hours >= 24) {
                const days = Math.floor(hours / 24);
                const remHours = hours % 24;
                this.text = `${days}d ${remHours}h restantes`;
            } else if (hours > 0) {
                this.text = `${hours}h ${minutes}m restantes`;
            } else {
                this.text = `${minutes}m restantes`;
            }
        },
    };
}
</script>