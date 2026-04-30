@extends('backend.layout.fraccional')

@section('title', 'Historial')

@section('content')
<main class="px-6 py-12">
    <div class="max-w-6xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl mb-2 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent font-bold">
                Historial
            </h1>
            <p class="text-gray-600">Tus trabajos y solicitudes finalizadas.</p>
        </div>

        {{-- Toggle rol (si aplica) --}}
        @if(auth()->user()->isFraccionalProfessional() && auth()->user()->isFraccionalCompany())
            <div class="inline-flex bg-gray-100 rounded-xl p-1 mb-6">
                <a href="{{ route('fraccional.history', ['role' => 'company']) }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg transition {{ $viewing === 'company' ? 'bg-white shadow-sm' : 'text-gray-600' }}">
                    Como empresa
                </a>
                <a href="{{ route('fraccional.history', ['role' => 'professional']) }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg transition {{ $viewing === 'professional' ? 'bg-white shadow-sm' : 'text-gray-600' }}">
                    Como profesional
                </a>
            </div>
        @endif

        {{-- Métricas --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total</p>
                <p class="text-2xl font-semibold">{{ $metrics['total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Completados</p>
                <p class="text-2xl font-semibold text-green-600">{{ $metrics['completed'] }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Rechazados</p>
                <p class="text-2xl font-semibold text-red-500">{{ $metrics['rejected'] }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                @if($viewing === 'professional')
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Ingresado</p>
                    <p class="text-2xl font-semibold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        ${{ number_format($metrics['total_earned'] ?? 0, 0, ',', '.') }}
                    </p>
                @else
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Invertido</p>
                    <p class="text-2xl font-semibold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        ${{ number_format($metrics['total_spent'] ?? 0, 0, ',', '.') }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Lista --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-100">
                @forelse($engagements as $eng)
                    @php $other = $viewing === 'company' ? $eng->professional : $eng->company; @endphp
                    <div class="p-5 hover:bg-gray-50 transition">
                        <div class="flex items-start gap-4">
                            <img src="{{ $other->avatar ? asset('storage/avatars/'.$other->avatar) : asset('images/default-avatar.png') }}"
                                 class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-medium">{{ $other->name }} {{ $other->last_name }}</h3>
                                        <p class="text-sm text-gray-600">
                                            @if($eng->contract)
                                                {{ $eng->contract->hours_per_week }}hs/sem · {{ $eng->contract->duration_months }} meses ·
                                                ${{ number_format($eng->contract->monthly_rate, 0, ',', '.') }} {{ $eng->contract->currency }}
                                            @else
                                                {{ $eng->role_requested ?? 'Solicitud' }}
                                            @endif
                                        </p>
                                    </div>
                                    @include('backend.fraccional.partials._status-badge', ['status' => $eng->status])
                                </div>

                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-gray-500">
                                    <span>
                                        @if($eng->completed_at)
                                            Completado el {{ $eng->completed_at->format('d/m/Y') }}
                                        @elseif($eng->rejected_at)
                                            Rechazado el {{ $eng->rejected_at->format('d/m/Y') }}
                                        @elseif($eng->cancelled_at)
                                            Cancelado el {{ $eng->cancelled_at->format('d/m/Y') }}
                                        @endif
                                    </span>
                                    @if($eng->contract && $eng->contract->totalHours())
                                        <span>·</span>
                                        <span>{{ number_format($eng->contract->totalHours(), 1) }} hs registradas</span>
                                    @endif
                                </div>

                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('fraccional.chat.show', $eng) }}"
                                       class="text-xs font-medium text-purple-600 hover:text-purple-700">
                                        Ver detalles →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">
                        <p>Aún no tenés trabajos finalizados.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $engagements->withQueryString()->links() }}
        </div>
    </div>
</main>
@endsection