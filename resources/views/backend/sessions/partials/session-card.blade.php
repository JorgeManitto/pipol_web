{{-- 
    Variables esperadas:
    - $session: Objeto de sesión
    - $user: Usuario autenticado
    - $type: 'proximas' | 'pasadas' | 'canceladas'
--}}

@php
    $name = $user->is_mentor ? $session->mentee->name : $session->mentor->name;
    $image = $user->is_mentor ? $session->mentee->avatar : $session->mentor->avatar;
    $profession = $user->is_mentor ? $session->mentee->profession : $session->mentor->profession;
    
    $borderColorClass = match($type) {
        'proximas' => 'border-blue-500',
        'pasadas' => 'border-yellow-500',
        'canceladas' => 'border-red-500',
        default => 'border-gray-500'
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
                        {{$session->transaction->status == 'paid' ? 'Sesión Confirmada' : 'Pendiente de Pago'}}
                    @else
                        Pendiente de Pago
                    @endif
                </span>
            </div>
        </div>
        <button class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
            </svg>
        </button>
    </div>
    
    {{-- Session Details --}}
    @include('backend.sessions.partials.session-details', ['session' => $session])

    {{-- Status Messages --}}
    @if ($type === 'proximas')
        @if ($session->status === 'pending' && auth()->user()->role == 'mentee')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                <p class="text-sm text-yellow-800">
                    <strong>Esperando confirmación del mentor.</strong> Te notificaremos cuando la sesión sea confirmada.
                </p>
            </div>
        @endif
        
        @if ($session->status === 'confirmed')
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                <p class="text-sm text-green-800">
                    <strong>Sesión confirmada.</strong> ¡Prepárate para tu sesión con {{ $name }}!
                </p>
            </div>

            <div class="p-3 mb-3">
                <p class="text-sm text-blue-500">Url de la reunión: No disponible.</p>
            </div>
        @endif
    @endif

    {{-- Action Buttons --}}
    @include('backend.sessions.partials.session-actions', [
        'session' => $session,
        'type' => $type,
        'name' => $name,
        'image' => $image
    ])
</div>