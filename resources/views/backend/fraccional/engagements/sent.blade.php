@extends('backend.layout.fraccional')
@section('content')
<main class="px-6 py-12">
    <div class="max-w-7xl px-6 mx-auto">

        <div class="flex items-start justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl mb-2 b bg-clip-text text-white font-bold">
                    Mis solicitudes
                </h1>
                <p class="text-white">Seguí el estado de las contrataciones que iniciaste.</p>
            </div>
            <a href="{{ route('fraccional.index') }}"
               class="hidden md:inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition">
                Buscar profesionales
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($engagements as $eng)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start gap-4">
                        <img src="{{ $eng->professional->avatar ? asset('storage/avatars/'.$eng->professional->avatar) : asset('images/default-avatar.png') }}"
                             alt="{{ $eng->professional->name }}"
                             class="w-14 h-14 rounded-xl object-cover flex-shrink-0">

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 mb-1">
                                <div>
                                    <h3 class="text-lg font-medium">
                                        {{ $eng->professional->name }} {{ $eng->professional->last_name }}
                                    </h3>
                                    <p class="text-sm text-white">
                                        {{ $eng->professional->currentPosition ?? $eng->professional->profession }}
                                    </p>
                                </div>
                                @include('backend.fraccional.partials._status-badge', ['status' => $eng->status])
                            </div>

                            @if($eng->role_requested)
                                <p class="text-sm text-gray-500 mt-2">
                                    <span class="font-medium text-gray-700">Rol solicitado:</span> {{ $eng->role_requested }}
                                </p>
                            @endif

                            @if($eng->initial_message)
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm text-gray-700 border-l-2 border-purple-400">
                                    {{ $eng->initial_message }}
                                </div>
                            @endif

                            @if($eng->status === 'rejected' && $eng->rejection_reason)
                                <div class="mt-3 p-3 bg-red-50 rounded-lg text-sm text-red-700">
                                    <span class="font-medium">Motivo del rechazo:</span> {{ $eng->rejection_reason }}
                                </div>
                            @endif

                            <div class="flex flex-wrap items-center gap-2 mt-4 text-xs text-gray-500">
                                <span>Enviada {{ $eng->created_at->diffForHumans() }}</span>
                                @if($eng->accepted_at)
                                    <span>·</span>
                                    <span>Aceptada {{ $eng->accepted_at->diffForHumans() }}</span>
                                @endif
                            </div>

                            {{-- CTAs según status --}}
                            <div class="flex flex-wrap gap-2 mt-4">
                                @if(in_array($eng->status, ['accepted','negotiating','proposed','active']))
                                    <a href="{{ route('fraccional.chat.show', $eng) }}"
                                       class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                        </svg>
                                        Ir al chat
                                    </a>
                                @endif

                                @if($eng->status === 'confirmed' && $eng->contract)
                                    <a href="{{ route('fraccional.payment.form', $eng->contract) }}"
                                       class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient-green transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>
                                        </svg>
                                        Completar pago
                                    </a>
                                @endif

                                @if($eng->status === 'active')
                                    <form action="{{ route('fraccional.payment.release', $eng) }}" method="POST"
                                          onsubmit="return confirm('¿Confirmás que el servicio fue entregado satisfactoriamente? Se liberarán los fondos al profesional.')">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient-green transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                            Marcar como completado
                                        </button>
                                    </form>
                                @endif

                                @if(in_array($eng->status, ['pending','accepted','negotiating','proposed']))
                                    <form action="{{ route('fraccional.engagement.cancel', $eng) }}" method="POST"
                                          onsubmit="return confirm('¿Cancelar esta solicitud?')">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">
                                            Cancelar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-50 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium mb-2">Aún no iniciaste ninguna contratación</h3>
                    <p class="text-white mb-6">Buscá profesionales compatibles con tu necesidad y enviá tu primera solicitud.</p>
                    <a href="{{ route('fraccional.index') }}"
                       class="inline-flex items-center gap-2 rounded-md px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition">
                        Explorar profesionales
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $engagements->links() }}
        </div>
    </div>
</main>
@endsection