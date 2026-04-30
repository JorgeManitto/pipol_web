@extends('backend.layout.app')
@section('page_title', 'Perfil de '.$user->name.' '.$user->last_name)


@section('main_content')
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
      
        .skill-tag {
            transition: all 0.3s ease;
        }
        
        .skill-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3);
        }
        
        .profile-card {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
    </style>

    <!-- Profile Header -->
    <div class="max-w-6xl  px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl profile-card p-4 md:p-6">
            <div class="flex flex-col md:flex-row gap-4 items-center md:items-start">
                <!-- Profile Image -->
                <div class="flex-shrink-0">
                    <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                        alt="{{ $user->name }} {{ $user->last_name }}'s Avatar" 
                        class="w-24 h-24 md:w-48 md:h-48 rounded-full object-cover border-4 border-gray-900">
                </div>
                
                <!-- Profile Info -->
                <div class="flex-grow w-full">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                        <div class="text-center md:text-left">
                            <h1 class="text-xl capitalize md:text-2xl font-bold text-gray-900 mb-1 md:mb-2">
                                {{ $user->name }} {{ $user->last_name }}
                            </h1>
                        
                            <p class="text-sm md:text-md text-gray-800 font-semibold mb-3">{{ $user->profession }}</p>

                            <!-- Location & Email -->
                            <div class="flex flex-col items-center md:items-start gap-2 text-gray-600">
                                <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 md:gap-4">
                                    @if ($user->country)
                                        <div class="flex items-center gap-1.5 text-sm">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span>{{ $user->country }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-1.5 text-sm">
                                        <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="break-all">{{ $user->email }}</span>
                                    </div>
                                </div>

                                <!-- Rating -->
                                @if ($user->is_mentor)
                                    @php
                                        $rating = $ratingReviews;
                                        $fullStars = floor($rating);
                                        $maxStars = 5;
                                    @endphp

                                    <div class="flex flex-col items-center md:items-start mt-2">
                                        <div class="flex items-center gap-0.5 mb-1">
                                            @for ($i = 1; $i <= $maxStars; $i++)
                                                <svg
                                                    class="w-4 h-4 {{ $i <= $fullStars ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                                </svg>
                                            @endfor
                                            <span class="text-sm font-bold text-gray-800 ml-1">
                                                {{ number_format($rating, 1) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            Basado en {{ $totalReviews }} {{ Str::plural('reseña', $totalReviews) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Actions sidebar -->
                        @auth
                            @if (auth()->id() === $user->id)
                                <div class="flex flex-col gap-2 w-full md:w-auto">
                                    <a href="{{ route('profile.edit') }}" 
                                    class="bg-gray-800 text-white px-6 py-2.5 text-sm rounded-lg hover:bg-gray-900 transition font-semibold text-center">
                                        Editar Perfil
                                    </a>
                                    @if ($user->is_mentor)
                                    <button type="button" onclick="openProfilePreview()"
                                            class="border-2 border-[#1a0a3e] text-[#1a0a3e] px-6 py-2.5 text-sm rounded-lg hover:bg-[#1a0a3e] hover:text-white transition font-semibold text-center inline-flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Visualizar Perfil
                                    </button>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('admin.chat.new.conversation', ['user'=> $user->id]) }}" 
                                class="btn-primary text-white px-4 py-2.5 rounded-xl text-sm md:text-md font-semibold inline-flex items-center justify-center gap-2">
                                    Enviar mensaje
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->id() === $user->id && $user->is_mentor)
 
@php
    $previewSessionCount = $user->sessions_as_mentor_count ?? $totalSessions ?? 0;
    $previewRangos = [
        'GOD'      => ['min' => 50, 'color' => '#e11d48', 'bg' => '#fff1f2', 'icon' => '🔥'],
        'HERO'     => ['min' => 30, 'color' => '#7c3aed', 'bg' => '#f5f3ff', 'icon' => '⚡'],
        'PLATINUM' => ['min' => 20, 'color' => '#0ea5e9', 'bg' => '#f0f9ff', 'icon' => '💎'],
        'GOLD'     => ['min' => 10, 'color' => '#d97706', 'bg' => '#fffbeb', 'icon' => '🏆'],
        'SILVER'   => ['min' => 5,  'color' => '#6b7280', 'bg' => '#f9fafb', 'icon' => '🥈'],
        'BRONZE'   => ['min' => 0,  'color' => '#b45309', 'bg' => '#fef3c7', 'icon' => '🥉'],
    ];
    $previewRango = null;
    foreach ($previewRangos as $nombre => $config) {
        if ($previewSessionCount >= $config['min']) {
            $previewRango = ['nombre' => $nombre, ...$config];
            break;
        }
    }
 
    $previewRating = $ratingReviews ?? 0;
    $previewTotalReviews = $totalReviews ?? 0;
    $previewFullStars = floor($previewRating);
 
    // Skills
    $previewSkills = $user->skills;
    if (is_string($previewSkills)) {
        $previewSkills = collect(explode(',', $previewSkills))
            ->map(fn($s) => (object)['name' => trim($s)])
            ->filter(fn($s) => $s->name !== '');
    }
@endphp
 
<!-- Modal Preview Perfil -->
<div id="profilePreviewModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeProfilePreview()"></div>
    
    <!-- Modal Content -->
    <div class="relative z-10 bg-gray-50 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="sticky top-0 bg-white flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t-2xl z-10">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Vista previa del perfil</h3>
                <p class="text-xs text-gray-500">Así ven tu perfil los demás usuarios en el listado de mentores</p>
            </div>
            <button onclick="closeProfilePreview()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
 
        <!-- Card Preview (réplica de mentor-card) -->
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-8 border-blue-500 flex flex-col lg:flex-row gap-4 items-start">
                <!-- Columna izquierda -->
                <div class="flex-1">
                    <!-- Avatar + Nombre + Badge -->
                    <div class="flex items-start gap-4 mb-2">
                        <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                             alt="{{ $user->name }}"
                             class="w-14 h-14 rounded-full object-cover flex-shrink-0">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-semibold text-md text-gray-900">
                                    {{ $user->name }} {{ $user->last_name }}
                                </h3>
                                @if ($previewRango)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                                          style="background-color: {{ $previewRango['bg'] }}; color: {{ $previewRango['color'] }}; border: 1px solid {{ $previewRango['color'] }}20;">
                                        <span>{{ $previewRango['icon'] }}</span>
                                        <span>{{ $previewRango['nombre'] }}</span>
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-600 mb-1">{{ $user->education }}</p>
                            <div class="flex items-center gap-1 text-xs text-gray-500">
                                <span>{{ $user->languages }}</span>
                            </div>
                        </div>
                    </div>
 
                    <!-- Bio truncada -->
                    <div class="mb-2">
                        <p class="text-gray-700 text-xs">
                            {{ Str::limit($user->bio, 210, '...') ?: 'Sin biografía aún.' }}
                        </p>
                    </div>
 
                    <!-- Modalidad -->
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-2">Modalidad de atención</p>
                        <div class="flex items-center gap-2 text-xs text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Online</span>
                        </div>
                    </div>
 
                    <!-- Especialidades -->
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-2">Especialidades:</p>
                        <div class="flex flex-wrap gap-1">
                            @if ($previewSkills && $previewSkills->isNotEmpty())
                                @foreach ($previewSkills as $skill)
                                    <span class="px-2 py-1 bg-[#f5f0e8] text-[#1a0a3e] text-xs rounded-full">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-xs text-gray-400 italic">Sin especialidades</span>
                            @endif
                        </div>
                    </div>
                </div>
 
                <!-- Columna derecha -->
                <div class="min-w-[200px]">
                    <button type="button" disabled
                            class="w-full py-3 border border-[#1a0a3e] text-[#1a0a3e] bg-transparent rounded-lg font-medium text-base opacity-70 cursor-default">
                        Conóceme
                    </button>
 
                    <p class="text-xs text-gray-500 mt-6">Valor hora</p>
                    <p class="text-2xl font-semibold text-[#1a0a3e] mb-4 text-left">
                        {{ $user->currency ?? 'USD' }} {{ number_format($user->hourly_rate, 2) }}/h
                    </p>
 
                    <!-- Estrellas -->
                    @if ($previewTotalReviews > 0)
                        <div>
                            <div class="flex flex-col items-start">
                                <div class="flex items-start gap-1 mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $previewFullStars ? 'text-yellow-400' : 'text-gray-300' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-md font-bold text-gray-800">{{ number_format($previewRating, 1) }} / 5.0</p>
                                <p class="text-xs text-gray-500 mt-1">Basado en {{ $previewTotalReviews }} {{ Str::plural('reseña', $previewTotalReviews) }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
 
            <!-- Nota -->
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-xs text-blue-700 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Esta es la tarjeta que ven otros usuarios cuando buscan mentores.
                </p>
            </div>
        </div>
    </div>
</div>
 
<!-- Script Preview -->
<script>
function openProfilePreview() {
    document.getElementById('profilePreviewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
 
function closeProfilePreview() {
    document.getElementById('profilePreviewModal').classList.add('hidden');
    document.body.style.overflow = '';
}
 
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('profilePreviewModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeProfilePreview();
        }
    }
});
</script>
 
@endif

    <!-- Main Content -->
    <div class="max-w-6xl  px-4 sm:px-6 lg:px-8 py-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About Section -->
                <div class="bg-white rounded-xl shadow-md p-4 mb-2">
                    <h2 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Perfil profesional
                    </h2>
                    <div class="text-gray-700 leading-relaxed space-y-4 text-sm">
                        @if ($user->bio)
                            <p>
                                {{ $user->bio }}
                            </p>
                        @else
                            <p>
                                No hay biografía disponible.
                            </p>
                        @endif
                        
                        
                    </div>
                </div>
                <!-- Experiencia Profesional Section -->
                @if ($user->currentPosition || $user->companies || $user->sectors || $user->seniority)
                <div class="bg-white rounded-xl shadow-md p-4 mb-2">
                    <h2 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Experiencia Profesional
                    </h2>
                    <div class="space-y-4">
                        @if ($user->currentPosition)
                        <div class="flex items-start gap-3">
                            <div class="bg-gray-100 p-2 rounded-lg mt-1">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-600 mb-1">Posición Actual</p>
                                <p class="text-gray-900 font-medium text-xs">{{ $user->currentPosition }}</p>
                                @if ($user->workingNow == 1)
                                    <span class="inline-flex items-center gap-1 mt-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        Trabajando actualmente
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if ($user->seniority)
                        <div class="flex items-start gap-3">
                            <div class="bg-gray-100 p-2 rounded-lg mt-1">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-600 mb-1">Nivel de Seniority</p>
                                <p class="text-gray-900 font-medium text-xs">{{ $user->seniority }}</p>
                            </div>
                        </div>
                        @endif

                        @if ($user->companies)
                        <div class="flex items-start gap-3">
                            <div class="bg-gray-100 p-2 rounded-lg mt-1">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-600 mb-1">Empresas/Organizaciones</p>
                                <p class="text-gray-900 font-medium text-xs">{{ $user->companies }}</p>
                            </div>
                        </div>
                        @endif

                        @if ($user->sectors)
                        <div class="flex items-start gap-3">
                            <div class="bg-gray-100 p-2 rounded-lg mt-1">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-600 mb-1">Sectores de Experiencia</p>
                                <p class="text-gray-900 font-medium text-xs">{{ $user->sectors }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                @endif
                <!-- Reseñas Section -->
                    @if ($user->reviewsReceived && $user->reviewsReceived->isNotEmpty())
                    <div class="bg-white rounded-xl shadow-md p-4" id="review">
                        <h2 class="text-md font-bold text-gray-900 mb-1 flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Reseñas
                            <span class="text-base font-normal text-gray-500">({{ $user->reviewsReceived->count() }})</span>
                        </h2>
                        <div class="space-y-6">
                            @foreach ($user->reviewsReceived as $review)
                                <div class="bg-stone-50 rounded-lg p-5 border border-stone-200">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $review->mentee && $review->mentee->avatar ? asset('storage/avatars/'.$review->mentee->avatar) : asset('images/default-avatar.png') }}" 
                                                alt="Avatar" 
                                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $review->mentee ? $review->mentee->name.' '.$review->mentee->last_name : 'Usuario anónimo' }}</p>
                                                <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    @if ($review->comment)
                                        <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                 @if (auth()->id() != $user->id && $user->is_mentor)
                <!-- Stats Section -->
                    <div class="bg-white rounded-xl shadow-md p-4">
                        <h2 class="text-md font-bold text-gray-900 mb-1">Estadísticas</h2>
                        <div class="space-y-4">
                            <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                                <p class="text-sm text-gray-600 mb-1">Sesiones completadas</p>
                                <p class="text-3xl font-bold text-gray-900"> {{ $totalSessions ?? '0' }} </p>
                            </div>
                            <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                                <p class="text-sm text-gray-600 mb-1">Calificación promedio</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-3xl font-bold text-gray-900"> {{ number_format($rating, 1) }} / 5.0 </p>
                                    
                                </div>
                            </div>
                            <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                                <p class="text-sm text-gray-600 mb-1">Años de experiencia</p>
                                <p class="text-3xl font-bold text-gray-900"> {{ $user->years_of_experience ?? '0' }} </p>
                            </div>
                        </div>
                    </div>
                    
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-2">
                <!-- Skills Section -->
                <div class="bg-white rounded-xl shadow-md p-4">
                    <h2 class="text-md font-bold text-gray-900 mb-1 flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Habilidades
                    </h2>
                    <div class="flex flex-wrap gap-1">
                        @php
                            if(is_string($user->skills)){
                                $user->skills = collect(explode(',', $user->skills))->map(function($skill) {
                                    return (object) ['name' => trim($skill)];
                                });
                            }
                        @endphp
                        @if ($user->skills && $user->skills->isNotEmpty())
                            @foreach ($user->skills as $skill)
                                <span class="skill-tag bg-gray-100 text-gray-800 p-1 text-xs rounded-full font-medium border border-gray-200">{{ $skill->name }}</span>
                            @endforeach
                        @else
                            <p>No hay habilidades disponibles.</p>
                        @endif
                    </div>
                </div>
                <!-- Educación Section -->
                @if ($user->education)
                <div class="bg-white rounded-xl shadow-md p-4">
                    <h2 class="text-md font-bold text-gray-900 mb-1 flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                        </svg>
                        Formación Académica
                    </h2>
                    <div class="text-gray-700 leading-relaxed text-xs">
                        <p>{{ $user->education }}</p>
                    </div>
                </div>
                @endif

                <!-- Idiomas Section -->
                @if ($user->languages)
                <div class="bg-white rounded-xl shadow-md p-4">
                    <h2 class="text-md font-bold text-gray-900 mb-1 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        Idiomas
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $languagesArray = array_map('trim', explode(',', $user->languages));
                        @endphp
                        @foreach ($languagesArray as $language)
                            <span class="bg-gray-100 text-gray-800 p-1 text-xs rounded-full font-medium border border-gray-200 inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ ucfirst($language) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Enlaces Profesionales Section -->
                @if ($user->linkedin_url || $user->website)
                <div class="bg-white rounded-xl shadow-md p-4">
                    <h2 class="text-md font-bold text-gray-900 mb-1 flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Enlaces Profesionales
                    </h2>
                    <div class="space-y-3">
                        @if ($user->linkedin_url)
                        <a href="{{ $user->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                            <div class="bg-blue-600 p-2 rounded">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-600">LinkedIn</p>
                                <p class="text-blue-600 text-xs">Ver perfil</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                        @endif

                        @if ($user->website)
                        <a href="{{ $user->website }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                            <div class="bg-gray-700 p-2 rounded">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-600">Sitio Web</p>
                                <p class="text-gray-700 text-xs">{{ $user->website }}</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
                @if (auth()->id() != $user->id && $user->is_mentor)
                <!-- CTA Section -->
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow-md p-4 text-white">
                        <h3 class="text-md font-bold mb-3">¿Listo para comenzar?</h3>
                        <p class="text-gray-100 mb-4 leading-relaxed">Agenda una sesión de mentoría y da el siguiente paso en tu carrera profesional.</p>
                        <a href="{{ route('mentors.index') }}" class="w-full bg-white text-gray-900 px-6 py-3 rounded-lg hover:bg-stone-100 transition font-semibold">
                            Agendar Sesión
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
