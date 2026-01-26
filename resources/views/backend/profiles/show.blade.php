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
    <div class=" pb-16">
        <div class="max-w-6xl mx- px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl profile-card p-8 md:p-12">
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <!-- Profile Image -->
                    <div class="flex-shrink-0">
                        <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('images/default-avatar.png') }}" 
                             alt="{{ $user->name }} {{ $user->last_name }}'s Avatar" 
                             class="w-32 h-32 md:w-48 md:h-48 rounded-full object-cover border-4 border-emerald-100">
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="flex-grow">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $user->name }} {{ $user->last_name }}</h1>
                                <a href="{{ route('admin.chat.new.conversation', ['user'=> $user->id]) }}" class="btn-primary text-white px-4 py-2 rounded-full text-md font-semibold inline-flex items-center justify-center gap-2 w-full sm:w-auto">Enviar mensaje</a>
                                <p class="text-xl text-emerald-800 font-semibold mb-3">{{ $user->profession }}</p>
                                <div class="flex flex-wrap gap-4 text-gray-600 flex-col">
                                    <div class="flex items-center gap-4">

                                        @if ($user->country)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span>{{ $user->country }}</span>
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                    </div>
                                    @php
                                        $rating = $ratingReviews; // ej: 4.9
                                        $fullStars = floor($rating);
                                        $maxStars = 5;
                                    @endphp
                            
                                    <!-- Widget: Calificación promedio -->
                                    <div class="bg-white ">
                            
                                        <div class="flex flex-col items-start">
                                            <div class="flex items-start gap-1 mb-2">
                                                @for ($i = 1; $i <= $maxStars; $i++)
                                                    <svg
                                                        class="w-8 h-8 {{ $i <= $fullStars ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20"
                                                    >
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                            
                                            <p class="text-2xl font-bold text-gray-800">
                                                {{ number_format($rating, 1) }} / 5.0
                                            </p>
                            
                                            <p class="text-sm text-gray-500 mt-1">
                                                Basado en {{ $totalReviews }} {{ Str::plural('reseña', $totalReviews) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-3">
                                <div class="bg-emerald-50 border-2 border-emerald-800 rounded-lg px-6 py-3 text-center">
                                    <p class="text-sm text-gray-600 mb-1">Tarifa por hora</p>
                                    <p class="text-2xl font-bold text-emerald-900">{{ $user->currency }} {{ number_format($user->hourly_rate, 2) }}</p>
                                </div>
                            @auth
                                @if (auth()->id() === $user->id)
                                    <a href="{{ route('profile.edit') }}" class="bg-emerald-800 text-white px-6 py-3 rounded-lg hover:bg-emerald-900 transition font-semibold">
                                        Editar Perfil
                                    </a>
                                @endif
                                @else
                                <button class="bg-emerald-800 text-white px-6 py-3 rounded-lg hover:bg-emerald-900 transition font-semibold">
                                    Agendar Sesión
                                </button>    
                            @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl  px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About Section -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Sobre mí
                    </h2>
                    <div class="text-gray-700 leading-relaxed space-y-4">
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

                <!-- Experience Section -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Experiencia Profesional
                    </h2>
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        {{ $user->bio_laboral}}
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-8">
                <!-- Skills Section -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Habilidades
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        @php
                            if(is_string($user->skills)){
                                $user->skills = collect(explode(',', $user->skills))->map(function($skill) {
                                    return (object) ['name' => trim($skill)];
                                });
                            }
                        @endphp
                        @if ($user->skills && $user->skills->isNotEmpty())
                            @foreach ($user->skills as $skill)
                                <span class="skill-tag bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full font-medium border border-emerald-200">{{ $skill->name }}</span>
                            @endforeach
                        @else
                            <p>No hay habilidades disponibles.</p>
                        @endif
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Estadísticas</h2>
                    <div class="space-y-4">
                        <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                            <p class="text-sm text-gray-600 mb-1">Sesiones completadas</p>
                            <p class="text-3xl font-bold text-emerald-900"> {{ $totalSessions ?? '0' }} </p>
                        </div>
                        <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                            <p class="text-sm text-gray-600 mb-1">Calificación promedio</p>
                            <div class="flex items-center gap-2">
                                <p class="text-3xl font-bold text-emerald-900"> {{ number_format($rating, 1) }} / 5.0 </p>
                                
                            </div>
                        </div>
                        <div class="stat-card bg-stone-50 rounded-lg p-4 border border-stone-200">
                            <p class="text-sm text-gray-600 mb-1">Años de experiencia</p>
                            <p class="text-3xl font-bold text-emerald-900"> {{ $user->years_of_experience ?? '0' }} </p>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="bg-gradient-to-br from-emerald-800 to-emerald-900 rounded-xl shadow-md p-8 text-white">
                    <h3 class="text-xl font-bold mb-3">¿Listo para comenzar?</h3>
                    <p class="text-emerald-100 mb-6 leading-relaxed">Agenda una sesión de mentoría y da el siguiente paso en tu carrera profesional.</p>
                    <a href="{{ route('mentors.index') }}" class="w-full bg-white text-emerald-900 px-6 py-3 rounded-lg hover:bg-stone-100 transition font-semibold">
                        Agendar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
