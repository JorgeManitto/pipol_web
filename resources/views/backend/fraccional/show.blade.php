@extends('backend.layout.fraccional')
@section('content')
<main class="px-6 py-12">
    <div class="max-w-6xl mx-auto">

        {{-- Botón volver --}}
        <a href="{{ route('fraccional.index') }}" class="inline-flex items-center gap-2 text-gray-200 hover:text-gray-500 mb-6 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Volver a resultados
        </a>

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">

                    {{-- Header con gradiente --}}
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-6 text-white text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm border-4 border-white/30 mb-3">
                            <span class="text-2xl font-bold">{{ $user->average_rating ? round($user->average_rating * 20) . '%' : '—' }}</span>
                        </div>
                        <p class="text-sm text-purple-100">Compatibilidad</p>
                    </div>

                    {{-- Avatar --}}
                    <div class="relative -mt-12 px-6">
                        <img
                            src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                            alt="{{ $user->name }} {{ $user->last_name }}"
                            class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-lg mx-auto"
                        >
                    </div>

                    <div class="p-6 text-center">
                        <h2 class="text-2xl mb-1">{{ $user->name }} {{ $user->last_name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $user->currentPosition ?? $user->profession }}</p>

                        {{-- Rating --}}
                        <div class="flex items-center justify-center gap-1 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-400">
                                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                            </svg>
                            <span class="font-medium text-lg">{{ number_format($user->average_rating ?? 0, 1) }}</span>
                            <span class="text-gray-500">({{ $user->reviewsReceived->count() }} reviews)</span>
                        </div>

                        {{-- Info --}}
                        <div class="space-y-3 mb-6 text-left">
                            @if($user->city || $user->country)
                            <div class="flex items-center gap-3 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span class="text-gray-700">{{ $user->city }}{{ $user->city && $user->country ? ', ' : '' }}{{ $user->country }}</span>
                            </div>
                            @endif

                            <div class="flex items-center gap-3 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M8 2v4"/><path d="M16 2v4"/>
                                    <rect width="18" height="18" x="3" y="4" rx="2"/>
                                    <path d="M3 10h18"/>
                                </svg>
                                <span class="text-gray-700">{{ $user->workingNow ? 'Actualmente ocupado' : 'Disponible inmediato' }}</span>
                            </div>

                            @if($user->years_of_experience)
                            <div class="flex items-center gap-3 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                    <rect width="20" height="14" x="2" y="6" rx="2"/>
                                </svg>
                                <span class="text-gray-700">{{ $user->years_of_experience }} años de experiencia</span>
                            </div>
                            @endif

                            @if($user->linkedin_url)
                            <div class="flex items-center gap-3 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                </svg>
                                <a href="{{ $user->linkedin_url }}" target="_blank" class="text-purple-600 hover:underline">LinkedIn</a>
                            </div>
                            @endif
                        </div>

                        {{-- Precio --}}
                        <div class="border-t border-gray-100 pt-6 mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Precio mensual</span>
                                <span class="text-2xl font-semibold text-purple-600">
                                    ${{ number_format($user->hourly_rate ?? 0, 0, ',', '.') }}/{{ $user->currency ?? 'mes' }}
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('fraccional.engagement.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="professional_id" value="{{ $user->id }}">
                            @if(request('from_engagement'))
                                <input type="hidden" name="from_engagement" value="{{ request('from_engagement') }}">
                            @endif
                            <input type="hidden" name="diagnostic_id"   value="{{ request('diagnostic_id') }}">
                            <input type="hidden" name="role_requested"  value="{{ request('role') }}">
                            <textarea name="initial_message" rows="3"
                                    class="w-full border rounded-lg p-3 mb-3 text-sm"
                                    placeholder="Contale brevemente qué necesitás..."></textarea>
                            <button class="block mt-2 w-full text-center rounded-md px-4 py-2 text-sm font-medium text-white btn-gradient transition">
                                Enviar solicitud
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Contenido principal con tabs --}}
            <div class="lg:col-span-2" x-data="{ tab: 'overview' }">
                {{-- Tabs navigation --}}
                <div class="flex bg-gray-100 rounded-xl p-1 mb-8">
                    <button @click="tab = 'overview'" :class="tab === 'overview' ? 'bg-white shadow-sm' : ''" class="flex-1 text-sm font-medium py-2 px-4 rounded-xl transition">Overview</button>
                    <button @click="tab = 'experience'" :class="tab === 'experience' ? 'bg-white shadow-sm' : ''" class="flex-1 text-sm font-medium py-2 px-4 rounded-xl transition">Experiencia</button>
                    <button @click="tab = 'skills'" :class="tab === 'skills' ? 'bg-white shadow-sm' : ''" class="flex-1 text-sm font-medium py-2 px-4 rounded-xl transition">Habilidades</button>
                    <button @click="tab = 'reviews'" :class="tab === 'reviews' ? 'bg-white shadow-sm' : ''" class="flex-1 text-sm font-medium py-2 px-4 rounded-xl transition">Reviews</button>
                </div>

                {{-- Tab: Overview --}}
                <div x-show="tab === 'overview'" class="space-y-6">
                    {{-- Bio --}}
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-2xl mb-4">Sobre mí</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $user->bio ?? $user->bio_laboral ?? 'Sin descripción disponible.' }}</p>
                    </div>

                    {{-- Sectores --}}
                    @if($user->sectors)
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-2xl mb-4">Industrias</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(is_array($user->sectors) ? $user->sectors : explode(',', $user->sectors) as $sector)
                                <span class="inline-flex items-center rounded-md border border-transparent bg-gray-100 text-sm font-medium py-2 px-4 text-gray-700">
                                    {{ trim($sector) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Educación --}}
                    @if($user->education)
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-2xl mb-4">Certificaciones</h3>
                        <div class="space-y-3">
                            @foreach(is_array($user->education) ? $user->education : explode(',', $user->education) as $cert)
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600">
                                    <path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/>
                                    <circle cx="12" cy="8" r="6"/>
                                </svg>
                                <span class="text-gray-700">{{ trim($cert) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Tab: Experiencia --}}
                <div x-show="tab === 'experience'" class="space-y-6" style="display: none;">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-2xl mb-4">Experiencia laboral</h3>

                        @if($user->currentPosition)
                        <div class="border-l-2 border-purple-600 pl-4 mb-6">
                            <p class="font-medium">{{ $user->currentPosition }}</p>
                            @if($user->companies)
                                <p class="text-gray-600 text-sm">{{ is_array($user->companies) ? implode(', ', $user->companies) : $user->companies }}</p>
                            @endif
                            <span class="text-xs text-purple-600 font-medium">Actual</span>
                        </div>
                        @endif

                        @if($user->lastPosition)
                        <div class="border-l-2 border-gray-200 pl-4 mb-6">
                            <p class="font-medium">{{ $user->lastPosition }}</p>
                            <span class="text-xs text-gray-500">Anterior</span>
                        </div>
                        @endif

                        @if($user->bio_laboral)
                        <p class="text-gray-700 leading-relaxed mt-4">{{ $user->bio_laboral }}</p>
                        @endif
                    </div>

                    @if($user->languages)
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-2xl mb-4">Idiomas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(is_array($user->languages) ? $user->languages : explode(',', $user->languages) as $lang)
                                <span class="inline-flex items-center rounded-md border border-transparent bg-gray-100 text-sm font-medium py-2 px-4 text-gray-700">
                                    {{ trim($lang) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Tab: Habilidades --}}
                <div x-show="tab === 'skills'" style="display: none;">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-2xl mb-6">Habilidades</h3>
                        @if ($user->skills)
                            @php
                                $user_SKILLS_PIVOT = $user->skills;
                                if (is_string($user->skills)) {
                                    $user->skills = collect(explode(',', $user->skills))
                                        ->map(fn($skill, $index) => (object)['id' => $index, 'name' => trim($skill)]);
                                }
                            @endphp
                            @foreach ($user->skills as $skill)
                                <a href="#"
                                class="px-2 py-1 bg-[#f5f0e8] text-[#1a0a3e] text-xs rounded-full hover:bg-[#1a0a3ee8] hover:text-white transition-colors tag ">
                                    {{ $skill->name }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Tab: Reviews --}}
                <div x-show="tab === 'reviews'" class="space-y-6" style="display: none;">
                    @forelse($user->reviewsReceived as $review)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-start gap-4 mb-3">
                            <img
                                src="{{ $review->mentee->avatar ? asset('storage/' . $review->mentee->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($review->mentee->name) }}"
                                alt="{{ $review->mentee->name }}"
                                class="w-10 h-10 rounded-full object-cover"
                            >
                            <div class="flex-1">
                                <p class="font-medium">{{ $review->mentee->name }} {{ $review->mentee->last_name }}</p>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                             fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}"
                                             stroke="currentColor" stroke-width="2"
                                             class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">
                                            <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        @if($review->comment)
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @empty
                        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center text-gray-500">
                            Aún no hay reviews para este profesional.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>
@endsection