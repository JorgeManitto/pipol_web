{{-- 
    Variables esperadas:
    - $session: Objeto de sesion
    - $type: 'proximas' | 'pasadas' | 'canceladas'
    - $name: Nombre del mentor/mentee
    - $image: Ruta del avatar
--}}

<div class="flex flex-col lg:flex-row gap-3">
    @if ($type === 'proximas')
        @php
            $isMentor = $session->mentor->id === auth()->id();
            $scheduledDate = \Carbon\Carbon::parse($session->scheduled_at);
            $mentorCanModify = $scheduledDate->copy()->greaterThanOrEqualTo(now()->addHours(48));
            $canShowMentorEditActions = $isMentor && $session->status !== 'confirmed';
            $counterpartName = $isMentor ? $session->mentee->name : $session->mentor->name;
            $dateLabel = $scheduledDate->format('D, d M Y');
            $timeLabel = $scheduledDate->format('H:i') . ' - ' . $scheduledDate->copy()->addHour()->format('H:i');
        @endphp

        {{-- Botones para sesiones proximas --}}
        @if($session->status === 'pending' && $session->mentee->id === auth()->id())
            <button class="flex-1 bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed" disabled>
                Esperando Confirmacion
            </button>
        @endif

        @if ($session->status === 'pending' && $session->mentor->id === auth()->id())
            <button onclick="openConfirmModal({{ $session->id }})" 
                    class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                Confirmar Sesion
            </button>
        @endif

        @if ($session->status === 'confirmed')
            @if ($session->mentor->id != auth()->id())
                <a href="/new-conversation/{{$session->mentor->id}}" class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors flex items-center justify-center gap-2">Enviar mensaje</a>
            @endif

            @if ($session->mentor->id === auth()->id())
                <button class="flex-1 bg-[#1e40af] text-white py-2 px-4 rounded-lg cursor-pointer" 
                        onclick="generarUrlMeet()">
                    Generar Link de Reunion
                </button>
            @endif
        @endif

        <button class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            Unirse a la Sesion
        </button>

        @if ($session->status != 'confirmed')
            @if ($canShowMentorEditActions)
                @if ($mentorCanModify)
                    <button
                        class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors"
                        onclick="openRescheduleModal('{{ $session->id }}','{{ $counterpartName }}', '{{ $dateLabel }}', '{{ $timeLabel }}')">
                        Reprogramar
                    </button>

                    <button class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors" 
                            onclick="openCancelModal('{{ $session->id }}','{{ $counterpartName }}', '{{ $dateLabel }}', '{{ $timeLabel }}')">
                        Cancelar
                    </button>
                @else
                    <button class="px-4 py-2 border border-gray-300 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                        Reprogramar (hasta 48h antes)
                    </button>

                    <button class="px-4 py-2 border border-gray-300 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                        Cancelar (hasta 48h antes)
                    </button>
                @endif
            @else
                <button class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors" 
                        onclick="openCancelModal('{{ $session->id }}','{{ $counterpartName }}', '{{ $dateLabel }}', '{{ $timeLabel }}')">
                    Cancelar
                </button>
            @endif
        @endif

    @elseif ($type === 'pasadas')
        {{-- Botones para sesiones pasadas --}}
        @if (!$session->review)
            <button onclick="openReviewModal('{{ $session->id }}', '{{ $image ? asset('storage/avatars/'.$image) : asset('images/default-avatar.png') }}', '{{ $name }}')" 
                    class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
                Dejar Reseña
            </button>
        @endif

        <button class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors">
            Tuve un problema con la sesion
        </button>

    @elseif ($type === 'canceladas')
        {{-- Botones para sesiones canceladas --}}
        <button class="flex-1 bg-[#1a0a3e] text-white py-2 px-4 rounded-lg hover:bg-[#1a0a3ee8] transition-colors">
            Dejar Reseña
        </button>

        <button class="px-4 py-2 border border-[#1a0a3e] text-[#1a0a3e] rounded-lg hover:bg-[#f5f0e8] transition-colors">
            Tuve un problema con la sesion
        </button>
    @endif
</div>
