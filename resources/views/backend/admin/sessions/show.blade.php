@extends('backend.layout.app')

@section('page_title', 'Gestión de Sesiones')
@section('main_content')
<div class="w-full bg-white rounded-xl px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.sessions.index') }}" class="hover:text-indigo-600 transition-colors">Sesiones Confirmadas</a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">Sesión #{{ $session->id }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Info principal --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Detalle de la Sesión</h2>
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-200">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>

                <div class="px-6 py-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Mentor --}}
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mentor</p>
                            <p class="text-sm font-medium text-gray-900">{{ $session->mentor->name ?? '—' }}</p>
                            <p class="text-sm text-gray-500">{{ $session->mentor->email ?? '—' }}</p>
                        </div>
                        {{-- Mentee --}}
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mentee</p>
                            <p class="text-sm font-medium text-gray-900">{{ $session->mentee->name ?? '—' }}</p>
                            <p class="text-sm text-gray-500">{{ $session->mentee->email ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 mt-5 pt-5 grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Fecha programada</p>
                            <p class="text-sm text-gray-900">{{ $session->scheduled_at->format('d/m/Y H:i') }} hs</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Duración</p>
                            <p class="text-sm text-gray-900">{{ $session->duration_minutes ?? '—' }} minutos</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Estado temporal</p>
                            @if($session->scheduled_at->isFuture())
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Próxima</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Pasada</span>
                            @endif
                        </div>
                    </div>

                    @if($session->notes)
                        <div class="border-t border-gray-100 mt-5 pt-5">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Notas</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $session->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">

            {{-- Meet --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Google Meet
                    </h3>
                </div>
                <div class="p-5 text-center" id="meet-section">
                    @if($session->meet_link)
                        <div class="rounded-full bg-emerald-100 w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Enlace generado</p>
                        <a href="{{ $session->meet_link }}" target="_blank"
                           class="block w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white text-center hover:bg-emerald-700 transition-colors mb-3">
                            Abrir Meet
                        </a>
                        <div class="flex rounded-lg border border-gray-200 overflow-hidden">
                            <input type="text" value="{{ $session->meet_link }}" readonly id="meet-link-input"
                                   class="flex-1 border-0 text-xs text-gray-500 bg-gray-50 px-3 py-2 focus:ring-0">
                            <button onclick="copyMeetLink()"
                                    class="px-3 bg-white border-l border-gray-200 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                        </div>
                    @else
                        <div class="rounded-full bg-amber-100 w-12 h-12 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Sin enlace de Meet</p>
                        <button type="button"
                                id="btn-generate"
                                onclick="generateMeet()"
                                class="block w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white text-center hover:bg-indigo-700 transition-colors">
                            Generar Meet
                        </button>
                    @endif
                </div>
            </div>

            {{-- Timestamps --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 space-y-1">
                <p class="text-xs text-gray-400"><span class="font-medium text-gray-500">Creada:</span> {{ $session->created_at->format('d/m/Y H:i') }}</p>
                <p class="text-xs text-gray-400"><span class="font-medium text-gray-500">Actualizada:</span> {{ $session->updated_at->format('d/m/Y H:i') }}</p>
            </div>

        </div>

    </div>

    {{-- Volver --}}
    <div class="mt-8">
        <a href="{{ route('admin.sessions.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver al listado
        </a>
    </div>

</div>
<script>
    function generateMeet() {
        const btn = document.getElementById('btn-generate');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        btn.textContent = 'Generando...';

        fetch("{{ route('admin.sessions.generate-meet', $session->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const section = document.getElementById('meet-section');
                section.innerHTML = `
                    <div class="rounded-full bg-emerald-100 w-12 h-12 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Enlace generado</p>
                    <a href="${data.meet_link}" target="_blank"
                       class="block w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white text-center hover:bg-emerald-700 transition-colors mb-3">
                        Abrir Meet
                    </a>
                    <div class="flex rounded-lg border border-gray-200 overflow-hidden">
                        <input type="text" value="${data.meet_link}" readonly id="meet-link-input"
                               class="flex-1 border-0 text-xs text-gray-500 bg-gray-50 px-3 py-2 focus:ring-0">
                        <button onclick="copyMeetLink()"
                                class="px-3 bg-white border-l border-gray-200 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>`;
            } else {
                btn.disabled = false;
                btn.classList.remove('opacity-75', 'cursor-not-allowed');
                btn.textContent = 'Generar Meet';
                alert(data.message || 'Error al generar el enlace.');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
            btn.textContent = 'Generar Meet';
            alert('Error de conexión.');
        });
    }

    function copyMeetLink() {
        const input = document.getElementById('meet-link-input');
        navigator.clipboard.writeText(input.value);
    }
</script>
@endsection
