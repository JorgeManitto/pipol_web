<div class="session-card bg-white rounded-xl shadow-sm p-6 mb-4 border-l-4 border-blue-500 max-w-3xl">
    {{-- <div class="flex items-start justify-between mb-4">
    </div> --}}

    <div class="flex items-start gap-4 mb-5 ">
        <img 
            src="{{ $mentor->avatar ? asset('storage/avatars/'.$mentor->avatar) : asset('images/default-avatar.png') }}" 
            alt="{{ $mentor->name }} {{ $mentor->last_name }}"
            class="w-14 h-14 rounded-full object-cover flex-shrink-0"
        >
        <div class="flex-1 ">
            <div class="flex items-baseline gap-2 mb-1">
                <a href="{{ route('profile.show', ['id' => $mentor->id]) }}">
                    <h3 class="font-semibold text-lg text-gray-900 hover:text-[#1a0a3ee8] transition-colors cursor-pointer">
                        {{ $mentor->name }} {{ $mentor->last_name }}
                    </h3>
                </a>
                <svg class="w-4 h-4 text-[#d4af6a]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zM9 10.586l1.293 1.293a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-sm text-gray-600 mb-2">{{ $mentor->profession }}</p>
            <div class="flex items-center gap-1 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                </svg>
                <span>Español</span>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <p class="text-gray-700 text-sm">
            {{ Str::limit($mentor->bio, 150, '...') }}
        </p>
    </div>
    <!-- Especialidades -->
    <div class="mb-5">
        <p class="text-xs text-gray-500 mb-2">Especialidades:</p>
        <div class="flex flex-wrap gap-2">
            @if ($mentor->skills)
                @php
                    $mentor_SKILLS_PIVOT = $mentor->skills;
                    if (is_string($mentor->skills)) {
                        $mentor->skills = collect(explode(',', $mentor->skills))
                            ->map(fn($skill, $index) => (object)['id' => $index, 'name' => trim($skill)]);
                    }
                @endphp
                @foreach ($mentor->skills as $skill)
                    <a href="{{ route('mentors.index', ['skill' => $skill->id]) }}"
                    class="px-3 py-1 bg-[#f5f0e8] text-[#1a0a3e] text-xs rounded-full hover:bg-[#1a0a3ee8] transition-colors tag ">
                        {{ $skill->name }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    <div class="mb-4">
        <p class="text-xs text-gray-500 mb-2">Modalidad de atención</p>
        <div class="flex items-center gap-2 text-sm text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span>Online</span>
        </div>
    </div>

    <div class="border-t mt-auto">
        <p class="text-2xl font-bold text-[#1a0a3e] mb-4 pt-2 text-left">
            {{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}/h
        </p>
        <button  data-mentor='@json($mentor)'
            data-avatar="{{ $mentor->avatar ? asset("storage/avatars/".$mentor->avatar) : asset("images/default-avatar.png") }}"
            data-price="{{ $mentor->currency }} {{ number_format($mentor->hourly_rate, 2) }}"
            
            class="w-full py-3 bg-[#1a0a3e] text-white rounded-lg hover:bg-[#1a0a3ee8] transition-colors font-medium text-base mentor-btn cursor-pointer">
            Conóceme
        </button>
    </div>
</div>