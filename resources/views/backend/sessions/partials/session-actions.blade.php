{{-- 
    Variables esperadas:
    - $session: Objeto de sesion
    - $type: 'proximas' | 'pasadas' | 'canceladas'
    - $name: Nombre del mentor/mentee
    - $image: Ruta del avatar
--}}

    @php
         $isMentor        = $session->mentor->id === auth()->id();
    @endphp
<div class="flex flex-col lg:flex-row gap-3">
    @if ($type === 'proximas')
        @php
           
            $scheduledDate   = \Carbon\Carbon::parse($session->scheduled_at);
            $mentorCanModify = $scheduledDate->copy()->greaterThanOrEqualTo(now()->addHours(48));

            // ✅ El mentor puede ver acciones de edición tanto en pending como en confirmed
            $canShowMentorEditActions = $isMentor && in_array($session->status, ['pending', 'confirmed']);

            $counterpartName = $isMentor ? $session->mentee->name : $session->mentor->name;
            $dateLabel       = $scheduledDate->format('D, d M Y');
            $timeLabel       = $scheduledDate->format('H:i') . ' - ' . $scheduledDate->copy()->addHour()->format('H:i');
        @endphp

        {{-- Mentee esperando confirmación --}}
        @if ($session->status === 'pending' && $session->mentee->id === auth()->id())
            <button class="flex-1 bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed" disabled>
                Esperando Confirmacion
            </button>
        @endif

        {{-- Mentor confirma sesión pendiente --}}
        @if ($session->status === 'pending' && $isMentor)
            <button onclick="openConfirmModal({{ $session->id }})"
                    class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                Confirmar Sesion
            </button>
        @endif

        {{-- Acciones de sesión confirmada --}}
        @if ($session->status === 'confirmed')
            @if (! $isMentor)
                <a href="/new-conversation/{{ $session->mentor->id }}"
                   class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors flex items-center justify-center gap-2">
                    Enviar mensaje
                </a>
            @else 
                {{-- <button class="flex-1 bg-[#1e40af] text-white py-2 px-4 rounded-lg cursor-pointer"
                        onclick="generarUrlMeet({{ $session->id }})">
                    Generar Link de Reunion
                </button> --}}
            @endif
        @endif

        {{-- Botón "Unirse" --}}
        @if ($session->status === 'confirmed' && $session->meet_link)
            <a href="{{ $session->meet_link }}" target="_blank" class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Unirse a la Sesion
            </a>
        @endif
        {{-- ── Acciones de edición para el MENTOR (pending + confirmed) ── --}}
        @if ($canShowMentorEditActions)
            @if ($mentorCanModify)
                <button
                    class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors"
                    onclick="openRescheduleModal('{{ $session->id }}','{{ $counterpartName }}','{{ $dateLabel }}','{{ $timeLabel }}')">
                    Reprogramar
                </button>

                <button
                    class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors"
                    onclick="openCancelModal('{{ $session->id }}','{{ $counterpartName }}','{{ $dateLabel }}','{{ $timeLabel }}')">
                    Cancelar
                </button>
            @else
                {{-- Fuera de la ventana de 48 h: botones deshabilitados con tooltip explicativo --}}
                <button class="px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed"
                        title="Solo puedes reprogramar con al menos 48 h de antelación" disabled>
                    Reprogramar (hasta 48h antes)
                </button>
                @if ($session->status === 'confirmed')
                    <button class="px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed"
                            title="Solo puedes cancelar con al menos 48 h de antelación" disabled>
                        Cancelar (hasta 48h antes)
                    </button>
                @endif
            @endif

        {{-- ── Botón cancelar para el MENTEE en sesión confirmed ── --}}
        @elseif (! $isMentor && $session->status === 'confirmed')
            {{-- <button
                class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors"
                onclick="openCancelModal('{{ $session->id }}','{{ $counterpartName }}','{{ $dateLabel }}','{{ $timeLabel }}')">
                Cancelar
            </button> --}}
        @endif

    @elseif ($type === 'pasadas')
        @if (! $session->review && !$isMentor)
            <button onclick="openReviewModal('{{ $session->id }}','{{ $image ? asset('storage/avatars/'.$image) : asset('images/default-avatar.png') }}','{{ $name }}')"
                    class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                Dejar Reseña
            </button>
        @endif

        {{-- <button class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors">
            Tuve un problema con la sesion
        </button> --}}

    @elseif ($type === 'canceladas' && !$isMentor)
        <button class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
            Dejar Reseña
        </button>

        {{-- <button class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors">
            Tuve un problema con la sesion
        </button> --}}
    @endif
</div>