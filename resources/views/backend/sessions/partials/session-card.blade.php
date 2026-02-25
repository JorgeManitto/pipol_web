{{-- 
    Variables esperadas:
    - $session: Objeto de sesión
    - $user: Usuario autenticado
    - $type: 'proximas' | 'pasadas' | 'canceladas'
--}}

@php
    $name       = $user->is_mentor ? $session->mentee->name       : $session->mentor->name;
    $image      = $user->is_mentor ? $session->mentee->avatar     : $session->mentor->avatar;
    $profession = $user->is_mentor ? $session->mentee->profession : $session->mentor->profession;

    $borderColorClass = match($type) {
        'proximas'   => $session->reschedule_pending ? 'border-orange-400' : 'border-blue-500',
        'pasadas'    => 'border-yellow-500',
        'canceladas' => 'border-red-500',
        default      => 'border-gray-500',
    };
@endphp

<div class="session-card bg-white rounded-xl shadow-sm p-6 mb-4 border-l-4 {{ $borderColorClass }}">

    {{-- Header --}}
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-start gap-4">
            <img src="{{ $image ? asset('storage/avatars/'.$image) : asset('images/default-avatar.png') }}"
                 alt="{{ $name }}"
                 class="w-16 h-16 rounded-full object-cover">
            <div>
                <h3 class="font-semibold text-lg text-[#1a0a3e] mb-1">{{ $name }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $profession }}</p>

                <span class="status-badge status-{{ $session->transaction ? 'confirmed' : 'pending' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    @if ($session->transaction)
                        {{ $session->transaction->status == 'paid' ? 'Sesión Confirmada' : 'Pendiente de Pago' }}
                    @else
                        Pendiente de Pago
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Session Details --}}
    @include('backend.sessions.partials.session-details', ['session' => $session])

    {{-- ── BANNER: reprogramación pendiente ── --}}
    @if ($session->reschedule_pending && $type === 'proximas')

        @if (! $user->is_mentor)
            {{-- Mentee: debe aceptar o cancelar --}}
            <div class="bg-orange-50 border border-orange-300 rounded-lg p-4 mb-3">
                <p class="text-sm font-semibold text-orange-800 mb-1">
                    ⚠️ El mentor ha reprogramado esta sesión
                </p>
                @if ($session->original_scheduled_at)
                    <p class="text-xs text-orange-700 mb-1">
                        Horario original:
                        <strong>{{ $session->original_scheduled_at->format('d/m/Y H:i') }}</strong>
                    </p>
                @endif
                <p class="text-xs text-orange-700 mb-3">
                    Nuevo horario:
                    <strong>{{ $session->scheduled_at->format('d/m/Y H:i') }}</strong>
                </p>
                <div class="flex gap-2">
                    <button
                        onclick="approveReschedule({{ $session->id }})"
                        class="flex-1 bg-green-600 text-white text-sm py-2 px-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                        ✓ Aceptar nuevo horario
                    </button>
                    <button
                        onclick="rejectReschedule({{ $session->id }})"
                        class="flex-1 bg-red-600 text-white text-sm py-2 px-3 rounded-lg hover:bg-red-700 transition-colors font-medium">
                        ✕ Rechazar y cancelar
                    </button>
                </div>
            </div>

        @else
            {{-- Mentor: le informa que está esperando aprobación --}}
            <div class="bg-orange-50 border border-orange-300 rounded-lg p-3 mb-3">
                <p class="text-sm text-orange-800">
                    <strong>⏳ Esperando confirmación del mentee</strong> para el nuevo horario:
                    <strong>{{ $session->scheduled_at->format('d/m/Y H:i') }}</strong>
                </p>
            </div>
        @endif

    @endif

    {{-- Otros mensajes de estado --}}
    @if ($type === 'proximas' && ! $session->reschedule_pending)
        @if ($session->status === 'pending' && auth()->user()->role == 'mentee')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                <p class="text-sm text-yellow-800">
                    <strong>Esperando confirmación del mentor.</strong>
                    Te notificaremos cuando la sesión sea confirmada.
                </p>
            </div>
        @endif

        @if ($session->status === 'confirmed')
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                <p class="text-sm text-green-800">
                    <strong>Sesión confirmada.</strong> ¡Prepárate para tu sesión con {{ $name }}!
                </p>
            </div>
            @if ($session->meet_link)
                <div class="p-3 mb-3">
                    <span>Enlace:     
                        <a href="{{ $session->meet_link }}" target="_blank" class="text-sm text-blue-500 hover:underline"> {{ $session->meet_link }}</a>
                    </span>
                </div>
            @else
                <div class="p-3 mb-3">
                    <p class="text-sm text-gray-500">No hay enlace de reunión disponible.</p>
                </div>
            @endif
        @endif
    @endif

    {{-- Action Buttons --}}
    @include('backend.sessions.partials.session-actions', [
        'session' => $session,
        'type'    => $type,
        'name'    => $name,
        'image'   => $image,
    ])
</div>