@extends('backend.layout.app')

@section('page_title', 'Gestión de Sesiones')

@push('styles')
<style>
    .stats-card {
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        transition: transform 0.2s;
    }
    .stats-card:hover { transform: translateY(-2px); }
    .stats-card .stats-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }
    .stats-card .stats-label {
        font-size: 0.85rem;
        opacity: 0.8;
        margin-top: 0.25rem;
    }
    .badge-meet { font-size: 0.75rem; }
    .session-row { transition: background 0.15s; }
    .session-row:hover { background: rgba(0,0,0,0.02); }
    .btn-generate-meet {
        white-space: nowrap;
    }
</style>
@endpush
@section('main_content')


<div class="w-full bg-white rounded-xl px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Sesiones Confirmadas</h1>
        <p class="mt-1 text-sm text-gray-500">Próximas sesiones con estado <span class="font-medium text-emerald-600">CONFIRMADO</span></p>
    </div>

    {{-- Filtro búsqueda --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('admin.sessions.index') }}" class="flex flex-col  sm:flex-row gap-3">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text"
                       id="search"
                       name="search"
                       placeholder="Nombre o email del mentor / mentee..."
                       value="{{ request('search') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filtrar
                </button>
                @if(request('search'))
                <a href="{{ route('admin.sessions.index') }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mentor</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mentee</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Duración</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Meet</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="px-5 py-4 text-sm text-gray-400 whitespace-nowrap">{{ $session->id }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $session->mentor->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $session->mentor->email ?? '' }}</p>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $session->mentee->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $session->mentee->email ?? '' }}</p>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $session->scheduled_at->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $session->scheduled_at->format('H:i') }} hs</p>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 whitespace-nowrap">
                                {{ $session->duration_minutes ?? '—' }} min
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap" id="meet-cell-{{ $session->id }}">
                                @if($session->meet_link)
                                    <a href="{{ $session->meet_link }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Abrir Meet
                                    </a>
                                @else
                                    <button type="button"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 transition-colors"
                                            data-session-id="{{ $session->id }}"
                                            onclick="generateMeet(this)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Generar Meet
                                    </button>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.sessions.show', $session->id) }}"
                                   class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                                    Ver
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm text-gray-500">No se encontraron sesiones confirmadas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sessions->hasPages())
            <div class="border-t border-gray-200 px-5 py-4">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Toast container --}}
<div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2 max-w-sm"></div>
{{-- @push('scripts') --}}
<script>
    function generateMeet(btn) {
        const sessionId = btn.dataset.sessionId;

        btn.disabled = true;
        btn.innerHTML = `<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Generando...`;
        btn.classList.add('opacity-75', 'cursor-not-allowed');

        fetch("{{ route('admin.sessions.generate-meet', ':id') }}".replace(':id', sessionId), {
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
                const cell = document.getElementById('meet-cell-' + sessionId);
                cell.innerHTML = `
                    <a href="${data.meet_link}" target="_blank"
                       class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Abrir Meet
                    </a>`;
                showToast('Enlace de Meet generado correctamente', 'success');
            } else {
                resetBtn(btn);
                showToast(data.message || 'Error al generar el enlace.', 'error');
            }
        })
        .catch(() => {
            resetBtn(btn);
            showToast('Error de conexión al generar el enlace.', 'error');
        });
    }

    function resetBtn(btn) {
        btn.disabled = false;
        btn.classList.remove('opacity-75', 'cursor-not-allowed');
        btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Generar Meet`;
    }

    function showToast(message, type) {
        const container = document.getElementById('toast-container');
        const colors = type === 'success'
            ? 'bg-emerald-50 border-emerald-200 text-emerald-800'
            : 'bg-red-50 border-red-200 text-red-800';
        const icon = type === 'success'
            ? '<svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            : '<svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

        const toast = document.createElement('div');
        toast.className = `flex items-center gap-3 rounded-xl border px-4 py-3 shadow-lg text-sm font-medium ${colors} animate-fade-in`;
        toast.innerHTML = `${icon} <span>${message}</span>`;
        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
</script>
{{-- @endpush --}}
@endsection

