@php
    $sessionCount = $mentor->sessions_as_mentor_count ?? 0;
    $rangos = [
        'GOD'      => ['min' => 50, 'color' => '#e11d48', 'bg' => '#fff1f2', 'icon' => '🔥'],
        'HERO'     => ['min' => 30, 'color' => '#7c3aed', 'bg' => '#f5f3ff', 'icon' => '⚡'],
        'PLATINUM' => ['min' => 20, 'color' => '#0ea5e9', 'bg' => '#f0f9ff', 'icon' => '💎'],
        'GOLD'     => ['min' => 10, 'color' => '#d97706', 'bg' => '#fffbeb', 'icon' => '🏆'],
        'SILVER'   => ['min' => 5,  'color' => '#6b7280', 'bg' => '#f9fafb', 'icon' => '🥈'],
        'BRONZE'   => ['min' => 0,  'color' => '#b45309', 'bg' => '#fef3c7', 'icon' => '🥉'],
    ];
    $mentorRango = null;
    foreach ($rangos as $nombre => $config) {
        if ($sessionCount >= $config['min']) {
            $mentorRango = ['nombre' => $nombre, ...$config];
            break;
        }
    }

    $mentorReviews = $mentor->reviewsReceived
        ->where('visible', 1)
        ->map(function ($r) {
            return [
                'rating' => $r->rating,
                'comment' => $r->comment,
                'created_at' => $r->created_at->format('d/m/Y'),
            ];
        })
        ->values();
@endphp

<div class="session-card bg-white rounded-xl shadow-sm p-4 mb-4 border-l-8 border-blue-500 flex flex-col lg:flex-row gap-4 items-start max-w-3xl">
    <div>
        
    <div class="flex items-start gap-4 mb-2 ">
        <img 
            src="{{ $mentor->avatar ? asset('storage/avatars/'.$mentor->avatar) : asset('images/default-avatar.png') }}" 
            alt="{{ $mentor->name }} {{ $mentor->last_name }}"
            class="w-14 h-14 rounded-full object-cover flex-shrink-0"
        >
        <div class="flex-1 ">
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('profile.show', ['id' => $mentor->id]) }}">
                    <h3 class="font-semibold text-md text-gray-900 hover:text-[#1a0a3ee8] transition-colors cursor-pointer">
                        {{ $mentor->name }} {{ $mentor->last_name }}
                    </h3>
                </a>

                {{-- Badge de rango --}}
                @if ($mentorRango)
                    <span 
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold"
                        style="background-color: {{ $mentorRango['bg'] }}; color: {{ $mentorRango['color'] }}; border: 1px solid {{ $mentorRango['color'] }}20;"
                        title="{{ $mentorRango['nombre'] }} — {{ $sessionCount }} sesiones completadas"
                    >
                        <span>{{ $mentorRango['icon'] }}</span>
                        <span>{{ $mentorRango['nombre'] }}</span>
                    </span>
                @endif
            </div>
            <p class="text-xs text-gray-600 mb-1">{{ $mentor->education }}</p>
            <div class="flex items-center gap-1 text-xs text-gray-500">
                
                <span>{{$mentor->languages}}</span>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <p class="text-gray-700 text-xs ">
            {{ Str::limit($mentor->bio, 210, '...') }}
        </p>
    </div>
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
            @if ($mentor->skills)
                @php
                    $mentor_SKILLS_PIVOT = $mentor->skills;
                    if (is_string($mentor->skills)) {
                        $mentor->skills = collect(explode(',', $mentor->skills))
                            ->map(fn($skill, $index) => (object)['id' => $index, 'name' => trim($skill)]);
                    }
                @endphp
                @foreach ($mentor->skills as $skill)
                    <a href="#"
                    class="px-2 py-1 bg-[#f5f0e8] text-[#1a0a3e] text-xs rounded-full hover:bg-[#1a0a3ee8] hover:text-white transition-colors tag ">
                        {{ $skill->name }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    
    </div>

    <div class="min-w-2xs">
        <button  data-mentor='@json($mentor)'
            data-avatar="{{ $mentor->avatar ? asset("storage/avatars/".$mentor->avatar) : asset("images/default-avatar.png") }}"
            data-price="{{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}"
            data-availabilities='@json($mentor->availabilities->where("active", 1)->values())'
            data-confirmed-sessions='@json($mentor->sessionsAsMentor->map(fn($s) => ["scheduled_at" => $s->scheduled_at, "duration_minutes" => $s->duration_minutes]))'
            data-linkedin-url='{{ $mentor->linkedin_url }}'
            data-rango='@json($mentorRango)'
            data-reviews='@json($mentorReviews)'
            class="w-full py-3 border border-[#1a0a3e] text-[#1a0a3e] bg-transparent rounded-lg hover:bg-[#1a0a3ee8] hover:text-white transition-colors font-medium text-base mentor-btn cursor-pointer">
            Conóceme
        </button>

        <p class="text-xs text-gray-500 mt-6">Valor hora</p>

        <p class="text-2xl font-semibold text-[#1a0a3e] mb-4 text-left hourly-rate"
        data-original-currency="USD"
        data-original-amount="{{ $mentor->hourly_rate }}">
            USD {{ number_format($mentor->hourly_rate, 2) }}/h
        </p>

        
        @if ($mentor->is_mentor)
            @php
                $rating = $mentor->reviewsReceived->avg('rating') ?? 0; 
                $totalReviews = $mentor->reviewsReceived->count();
                $fullStars = floor($rating);
                $maxStars = 5;
            @endphp
    
            <!-- Widget: Calificación promedio -->
            <div class="bg-white ">
                <div class="flex flex-col items-start">
                    <div class="flex items-start gap-1 mb-2">
                        @for ($i = 1; $i <= $maxStars; $i++)
                            <svg
                                class="w-4 h-4 {{ $i <= $fullStars ? 'text-yellow-400' : 'text-gray-300' }}"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.287 3.953c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.175 0l-3.357 2.44c-.784.57-1.838-.197-1.54-1.118l1.287-3.953a1 1 0 00-.364-1.118L2.316 9.38c-.784-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.953z"/>
                            </svg>
                        @endfor
                    </div>
    
                    <p class="text-md font-bold text-gray-800">
                        {{ number_format($rating, 1) }} / 5.0
                    </p>
    
                    <p class="text-xs text-gray-500 mt-1">
                        Basado en {{ $totalReviews }} {{ Str::plural('reseña', $totalReviews) }}
                    </p>
                </div>
            </div>
        @endif
       
    </div>
</div>