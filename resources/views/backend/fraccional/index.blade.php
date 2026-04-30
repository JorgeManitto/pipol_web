@extends('backend.layout.fraccional')
@section('content')
<main class="px-6 py-12">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-start gap-4 mb-6">
            <div class="mb-8">
                <h1 class="text-4xl text-white mb-3 bg-clip-text  font-bold">
                    Profesionales compatibles
                </h1>
                <p class="text-xl text-white">
                    Encontramos {{ $profesionales->total() }} HR Managers que se ajustan a tu necesidad
                </p>
            </div>
                <div class="ml-auto">
                    <a href="{{ route('home.nuevoDiagnostico') }}" class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient transition">Nuevo diagnóstico</a>
                </div>
        </div>

        {{-- Filtros --}}
        <div class="bg-white rounded-2xl p-6 mb-8 shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
                    <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"/>
                </svg>
                <h3 class="font-medium">Filtros</h3>
            </div>
            <form method="GET" action="{{ route('fraccional.index') }}" class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm text-gray-600 mb-2 block">Seniority</label>
                    <select name="seniority" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <option value="junior" @selected(request('seniority') === 'junior')>Junior</option>
                        <option value="semi-senior" @selected(request('seniority') === 'semi-senior')>Semi-Senior</option>
                        <option value="senior" @selected(request('seniority') === 'senior')>Senior</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600 mb-2 block">Disponibilidad</label>
                    <select name="disponibilidad" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" onchange="this.form.submit()">
                        <option value="">Todas</option>
                        <option value="inmediato" @selected(request('disponibilidad') === 'inmediato')>Disponible inmediato</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600 mb-2 block">Rango de precio</label>
                    <select name="precio_max" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <option value="2000" @selected(request('precio_max') === '2000')>Hasta $2,000</option>
                        <option value="3000" @selected(request('precio_max') === '3000')>Hasta $3,000</option>
                        <option value="5000" @selected(request('precio_max') === '5000')>Hasta $5,000</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- Grid de profesionales --}}
        <div class="grid md:grid-cols-2 gap-6">
            @forelse($profesionales as $profesional)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="p-6">
                        <div class="flex items-start gap-4 mb-4">
                            <img
                                src="{{ $profesional->avatar ? asset('storage/avatars/'.$profesional->avatar) : asset('images/default-avatar.png') }}" 
                                alt="{{ $profesional->name }} {{ $profesional->last_name }}"
                                class="w-16 h-16 rounded-xl object-cover"
                            >
                            <div class="flex-1">
                                <h3 class="text-xl mb-1">{{ $profesional->name }} {{ $profesional->last_name }}</h3>
                                <p class="text-gray-600 mb-2">{{ $profesional->currentPosition ?? $profesional->profession }}</p>
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-400">
                                        <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                                    </svg>
                                    <span class="font-medium">{{ number_format($profesional->average_rating, 1) }}</span>
                                    <span class="text-sm text-gray-500">({{ $profesional->reviewsReceived->count() }})</span>
                                </div>
                            </div>
                        </div>

                        {{-- Skills --}}
                        <div class="flex flex-wrap gap-2 mb-4">
                            {{-- @foreach($profesional->skills->take(3) as $skill)
                                <span class="inline-flex items-center rounded-md border border-transparent bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700">
                                    {{ $skill->name }}
                                </span>
                            @endforeach --}}
                        </div>

                        {{-- Info --}}
                        <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Experiencia</p>
                                <p class="font-medium">{{ $profesional->years_of_experience ?? '—' }} años</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Disponibilidad</p>
                                <p class="font-medium text-sm">
                                    {{ $profesional->workingNow ? 'Ocupado' : 'Disponible' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Precio</p>
                                <p class="font-medium text-purple-600">
                                    ${{ number_format($profesional->hourly_rate, 0, ',', '.') }}/{{ $profesional->currency ?? 'mes' }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('fraccional.show', $profesional->id) }}"
                           class="block mt-2 w-full text-center rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient transition">
                            Ver perfil completo
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12 text-gray-500">
                    No se encontraron profesionales con los filtros seleccionados.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $profesionales->withQueryString()->links() }}
        </div>
    </div>
</main>
@endsection