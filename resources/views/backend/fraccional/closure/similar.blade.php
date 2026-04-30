@extends('backend.layout.fraccional')
@section('title', 'Perfiles similares')
@section('content')
<main class="px-6 py-12">
    <div class="max-w-6xl mx-auto">

        <a href="{{ route('fraccional.closure.show', $engagement) }}"
           class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Volver
        </a>

        <h1 class="text-3xl font-bold mb-2 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
            Perfiles similares
        </h1>
        <p class="text-gray-600 mb-6">
            Encontramos {{ $profiles->count() }} profesionales que se ajustan a tus criterios.
        </p>

        {{-- Reasoning de la IA --}}
        @if($reasoning)
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-purple-700 uppercase tracking-wide mb-1">Análisis IA</p>
                    <p class="text-sm text-gray-700">{{ $reasoning }}</p>
                </div>
            </div>
        @endif

        {{-- Grid de profesionales --}}
        @if($profiles->count() > 0)
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($profiles as $profesional)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <img src="{{ $profesional->avatar ? asset('storage/avatars/'.$profesional->avatar) : asset('images/default-avatar.png') }}"
                                     alt="{{ $profesional->name }}"
                                     class="w-16 h-16 rounded-xl object-cover">
                                <div class="flex-1">
                                    <h3 class="text-xl mb-1">{{ $profesional->name }} {{ $profesional->last_name }}</h3>
                                    <p class="text-gray-600 mb-2">{{ $profesional->currentPosition ?? $profesional->profession }}</p>
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-400">
                                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                                        </svg>
                                        <span class="font-medium text-sm">{{ number_format($profesional->average_rating ?? 0, 1) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3 pt-4 border-t border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500">Seniority</p>
                                    <p class="font-medium text-sm capitalize">{{ $profesional->seniority ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Experiencia</p>
                                    <p class="font-medium text-sm">{{ $profesional->years_of_experience ?? '—' }} años</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tarifa</p>
                                    <p class="font-medium text-sm text-purple-600">
                                        ${{ number_format($profesional->hourly_rate, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('fraccional.show', $profesional) }}?from_engagement={{ $engagement->id }}"
                               class="block w-full mt-4 text-center rounded-md px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition">
                                Ver perfil completo
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                <p class="text-gray-600 mb-4">No encontramos profesionales con esos criterios.</p>
                <a href="{{ route('fraccional.closure.show', $engagement) }}"
                   class="text-purple-600 hover:underline text-sm">
                    Ajustar búsqueda
                </a>
            </div>
        @endif
    </div>
</main>
@endsection