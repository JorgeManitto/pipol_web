@extends('backend.layout.fraccional')
@section('content')
<main class="px-6 py-12">
    <div class="max-w-7xl px-6 mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl mb-2 b bg-clip-text text-white font-bold">
                Solicitudes recibidas
            </h1>
            <p class="text-white">Empresas que quieren trabajar con vos.</p>
        </div>
        @if(!auth()->user()->stripe_connect_id)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                    <path d="M12 9v4"/><path d="M12 17h.01"/>
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-amber-900">Conectá tu cuenta de pagos</p>
                    <p class="text-sm text-amber-800 mt-1">Para poder firmar contratos y recibir pagos necesitás completar el onboarding con Stripe.</p>
                    <a href="{{ route('fraccional.stripe.connect') }}"
                       class="inline-flex items-center gap-2 mt-3 rounded-md px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 transition">
                        Conectar cuenta Stripe
                    </a>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($engagements as $eng)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start gap-4">
                        <img src="{{ $eng->company->avatar ? asset('storage/avatars/'.$eng->company->avatar) : asset('images/default-avatar.png') }}"
                             alt="{{ $eng->company->name }}"
                             class="w-14 h-14 rounded-xl object-cover flex-shrink-0">

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 mb-1">
                                <div>
                                    <h3 class="text-lg font-medium">
                                        {{ $eng->company->name }} {{ $eng->company->last_name }}
                                    </h3>
                                    <p class="text-sm text-white">
                                        {{ $eng->company->company_name ?? $eng->company->email }}
                                    </p>
                                </div>
                                @include('backend.fraccional.partials._status-badge', ['status' => $eng->status])
                            </div>

                            @if($eng->role_requested)
                                <div class="mt-3">
                                    <span class="inline-flex items-center rounded-md bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700 border border-purple-200">
                                        {{ $eng->role_requested }}
                                    </span>
                                </div>
                            @endif

                            @if($eng->diagnostic)
                                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3 p-3 bg-gray-50 rounded-lg text-xs">
                                    <div>
                                        <p class="text-gray-500">Industria</p>
                                        <p class="font-medium text-gray-900">{{ $eng->diagnostic->industry }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Tamaño</p>
                                        <p class="font-medium text-gray-900">{{ $eng->diagnostic->size }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Urgencia</p>
                                        <p class="font-medium text-gray-900">{{ $eng->diagnostic->urgency }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Etapa</p>
                                        <p class="font-medium text-gray-900">{{ $eng->diagnostic->stage }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($eng->initial_message)
                                <div class="mt-3 p-3 bg-purple-50 border border-purple-100 rounded-lg">
                                    <p class="text-xs text-purple-700 font-medium mb-1">Mensaje inicial</p>
                                    <p class="text-sm text-gray-800">{{ $eng->initial_message }}</p>
                                </div>
                            @endif

                            <p class="mt-3 text-xs text-gray-500">
                                Recibida {{ $eng->created_at->diffForHumans() }}
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4">
                                @if($eng->status === 'pending')
                                    <form action="{{ route('fraccional.engagement.accept', $eng) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient-green transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                            Aceptar
                                        </button>
                                    </form>

                                    <div x-data="{ open: false, reason: '' }">
                                        <button @click="open = true"
                                                class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">
                                            Rechazar
                                        </button>

                                        <div x-show="open" x-cloak
                                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                             @click.self="open = false">
                                            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                                                <h3 class="text-lg font-medium mb-4">Rechazar solicitud</h3>
                                                <form action="{{ route('fraccional.engagement.reject', $eng) }}" method="POST">
                                                    @csrf
                                                    <label class="block text-sm text-gray-700 mb-2">Motivo (opcional)</label>
                                                    <textarea name="reason" rows="3" x-model="reason"
                                                              class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-purple-500 focus:outline-none"
                                                              placeholder="Ej: No tengo disponibilidad en este momento..."></textarea>
                                                    <div class="flex gap-2 mt-4">
                                                        <button type="button" @click="open = false"
                                                                class="flex-1 rounded-md px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50 transition">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit"
                                                                class="flex-1 rounded-md px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                                            Confirmar rechazo
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(in_array($eng->status, ['accepted','negotiating','proposed','confirmed','active']))
                                    <a href="{{ route('fraccional.chat.show', $eng) }}"
                                       class=" inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient-green transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                        </svg>
                                        Ir al chat
                                    </a>
                                @endif

                                @if($eng->status === 'confirmed')
                                    <span class="inline-flex items-center gap-2 text-sm text-white">
                                        <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                                        Esperando pago de la empresa
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                    <p class="text-white">Aún no recibiste solicitudes. Asegurate de tener tu perfil completo para mejorar tu visibilidad.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $engagements->links() }}
        </div>
    </div>
</main>
@endsection