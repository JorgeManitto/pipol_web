{{-- 
    Variables esperadas:
    - $session: Objeto de sesión
--}}

<div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-[#f5f0e8] rounded-lg">
    {{-- Fecha --}}
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <div>
            <p class="text-xs text-gray-600">Fecha</p>
            <p class="font-semibold text-sm">
                {{ \Carbon\Carbon::parse($session->scheduled_at)->format('d/m/Y') }}
            </p>
        </div>
    </div>

    {{-- Hora --}}
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-xs text-gray-600">Hora</p>
            <p class="font-semibold text-sm">
                {{ \Carbon\Carbon::parse($session->scheduled_at)->format('H:i') }}
            </p>
        </div>
    </div>

    {{-- Modalidad --}}
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
        </svg>
        <div>
            <p class="text-xs text-gray-600">Modalidad</p>
            <p class="font-semibold text-sm">Online</p>
        </div>
    </div>

    {{-- Precio --}}
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-[#1a0a3e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-xs text-gray-600">Precio</p>
            <p class="font-semibold text-sm">{{ $session->mentor->currency}} {{ number_format($session->mentor->hourly_rate, 2) }}</p>
        </div>
    </div>
</div>