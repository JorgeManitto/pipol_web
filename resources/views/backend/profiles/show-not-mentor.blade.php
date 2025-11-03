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
    <div class="pb-16">
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
                                <p class="text-xl text-emerald-800 font-semibold mb-3">{{ $user->profession }}</p>
                                <div class="flex flex-wrap gap-4 text-gray-600">
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
                            </div>
                            
                            <div class="flex flex-col gap-3">
                                
                            @auth
                                @if (auth()->id() === $user->id)
                                    <a href="{{ route('profile.edit') }}" class="bg-emerald-800 text-white px-6 py-3 rounded-lg hover:bg-emerald-900 transition font-semibold">
                                        Editar Perfil
                                    </a>
                                @endif
                                 
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
            <div class="lg:col-span-3 space-y-8">
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


            </div>

        </div>
    </div>
@endsection
