@extends('backend.layout.app')
@section('page_title', 'Gestión de Pagos')

@section('main_content')
<style>
    * { font-family: 'Inter', sans-serif; }

    .section-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: .5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: .5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.25rem;
        border-left: 4px solid;
    }

    .stat-card.pending   { border-left-color: #f59e0b; }
    .stat-card.success   { border-left-color: #10b981; }
    .stat-card.failed    { border-left-color: #ef4444; }
    .stat-card.fees      { border-left-color: #6366f1; }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-pending     { background: #fef3c7; color: #92400e; }
    .badge-transferred { background: #d1fae5; color: #065f46; }
    .badge-failed      { background: #fee2e2; color: #991b1b; }

    .btn-release {
        background: #2d5a4a;
        color: white;
        padding: 0.375rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-release:hover {
        background: #3d6a5a;
        transform: translateY(-1px);
    }

    .btn-retry {
        background: #f59e0b;
        color: white;
        padding: 0.375rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-retry:hover { background: #d97706; }

    .btn-bulk {
        background: #1a0a3e;
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-bulk:hover {
        background: #2d1a5e;
        transform: translateY(-1px);
    }
    .btn-bulk:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .form-input {
        width: 100%;
        padding: .5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #2d5a4a;
        box-shadow: 0 0 0 3px rgba(45, 90, 74, 0.1);
    }

    .table-row:hover { background: #f9fafb; }

    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

    .checkbox-cell input[type="checkbox"] {
        width: 1rem;
        height: 1rem;
        accent-color: #2d5a4a;
        cursor: pointer;
    }
</style>

<main class="container max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">Gestión de Pagos</h1>
        <p class="text-white">Administra las transferencias a mentores vía Stripe Connect</p>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success"><strong>✓</strong> {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error"><strong>⚠</strong> {{ session('error') }}</div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-card pending shadow-sm">
            <p class="text-sm text-gray-500">Pendientes</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_count'] }}</p>
            <p class="text-sm font-semibold text-amber-700">USD {{ number_format($stats['pending_amount'], 2) }}</p>
        </div>
        <div class="stat-card success shadow-sm">
            <p class="text-sm text-gray-500">Transferidos</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['transferred_count'] }}</p>
            <p class="text-sm font-semibold text-emerald-700">USD {{ number_format($stats['transferred_amount'], 2) }}</p>
        </div>
        <div class="stat-card failed shadow-sm">
            <p class="text-sm text-gray-500">Fallidos</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['failed_count'] }}</p>
        </div>
        <div class="stat-card fees shadow-sm">
            <p class="text-sm text-gray-500">Comisiones totales</p>
            <p class="text-2xl font-bold text-gray-900">USD {{ number_format($stats['total_fees'], 2) }}</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="section-card">
        <form method="GET" action="{{ route('admin.payouts.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                <select name="transfer_status" class="form-input">
                    <option value="pending"     {{ request('transfer_status', 'pending') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                    <option value="transferred"  {{ request('transfer_status') == 'transferred' ? 'selected' : '' }}>Transferidos</option>
                    <option value="failed"       {{ request('transfer_status') == 'failed' ? 'selected' : '' }}>Fallidos</option>
                    <option value=""              {{ request('transfer_status') === '' ? 'selected' : '' }}>Todos</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mentor</label>
                <select name="mentor_id" class="form-input">
                    <option value="">Todos</option>
                    @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id }}" {{ request('mentor_id') == $mentor->id ? 'selected' : '' }}>
                            {{ $mentor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Desde</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Hasta</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input">
            </div>
            <div>
                <button type="submit" class="btn-release w-full py-2">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de transacciones -->
    <div class="section-card">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <h2 class="section-title mb-0 pb-0 border-b-0">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Transacciones
            </h2>

            <!-- Acción masiva -->
            <div id="bulkActions" class="hidden flex items-center gap-3">
                <span id="selectedCount" class="text-sm text-gray-600 font-medium">0 seleccionados</span>
                <button type="button" onclick="submitBulkRelease()" class="btn-bulk">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Liberar seleccionados
                </button>
            </div>
        </div>

        @if($transactions->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 font-medium">No se encontraron transacciones</p>
                <p class="text-sm text-gray-400 mt-1">Ajusta los filtros para ver resultados</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <form id="bulkForm" method="POST" action="{{ route('admin.payouts.release.bulk') }}">
                    @csrf
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-100 text-left text-gray-500 text-xs uppercase tracking-wider">
                                <th class="py-3 px-2 checkbox-cell">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th class="py-3 px-3">Mentor</th>
                                <th class="py-3 px-3">Sesión</th>
                                <th class="py-3 px-3">Monto Total</th>
                                <th class="py-3 px-3">Comisión</th>
                                <th class="py-3 px-3">Monto Mentor</th>
                                <th class="py-3 px-3">Estado</th>
                                <th class="py-3 px-3">Fecha Pago</th>
                                {{-- <th class="py-3 px-3">Acciones</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $tx)
                                <tr class="border-b border-gray-50 table-row">
                                    <td class="py-3 px-2 checkbox-cell">
                                        @if($tx->transfer_status === 'pending')
                                            <input type="checkbox" name="transaction_ids[]"
                                                   value="{{ $tx->id }}" class="bulk-check"
                                                   onchange="updateBulkUI()">
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        <a href="{{ route('admin.payouts.mentor', $tx->receiver_id) }}"
                                           class="flex items-center gap-2 hover:text-[#2d5a4a] transition">
                                            <img src="{{ $tx->receiver->avatar ? asset('storage/avatars/'.$tx->receiver->avatar) : asset('images/default-avatar.png') }}"
                                                 class="w-8 h-8 rounded-full object-cover border border-gray-200" alt="">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $tx->receiver->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $tx->receiver->email }}</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="py-3 px-3 text-gray-600">#{{ $tx->session_id }}</td>
                                    <td class="py-3 px-3 font-semibold text-gray-900">USD {{ number_format($tx->amount, 2) }}</td>
                                    <td class="py-3 px-3 text-indigo-600 font-medium">USD {{ number_format($tx->platform_fee, 2) }}</td>
                                    <td class="py-3 px-3 font-bold text-emerald-700">USD {{ number_format($tx->mentor_amount, 2) }}</td>
                                    <td class="py-3 px-3">
                                        @if($tx->transfer_status === 'pending')
                                            <span class="badge badge-pending">Pendiente</span>
                                        @elseif($tx->transfer_status === 'transferred')
                                            <span class="badge badge-transferred">Transferido</span>
                                        @elseif($tx->transfer_status === 'failed')
                                            <span class="badge badge-failed">Fallido</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-gray-500">
                                        {{ $tx->paid_at ? $tx->paid_at->format('d/m/Y H:i') : '-' }}
                                        @if($tx->transferred_at)
                                            <br><span class="text-xs text-emerald-600">Liberado: {{ $tx->transferred_at->format('d/m/Y H:i') }}</span>
                                        @endif
                                    </td>
                                    {{-- <td class="py-3 px-3">
                                        <div class="flex items-center gap-2">
                                            @if($tx->transfer_status === 'pending')
                                                <form method="POST" action="{{ route('admin.payouts.release', $tx) }}"
                                                      onsubmit="return confirm('¿Liberar USD {{ number_format($tx->mentor_amount, 2) }} a {{ $tx->receiver->name }}?')">
                                                    @csrf
                                                    <button type="submit" class="btn-release">Liberar</button>
                                                </form>
                                            @elseif($tx->transfer_status === 'failed')
                                                <form method="POST" action="{{ route('admin.payouts.retry', $tx) }}"
                                                      onsubmit="return confirm('¿Reintentar transferencia?')">
                                                    @csrf
                                                    <button type="submit" class="btn-retry">Reintentar</button>
                                                </form>
                                            @elseif($tx->transfer_status === 'transferred' && $tx->stripe_transfer_id)
                                                <span class="text-xs text-gray-400" title="{{ $tx->stripe_transfer_id }}">
                                                    {{ Str::limit($tx->stripe_transfer_id, 18) }}
                                                </span>
                                            @endif
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="mt-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        @endif
    </div>
</main>

<script>
    function toggleSelectAll() {
        const checked = document.getElementById('selectAll').checked;
        document.querySelectorAll('.bulk-check').forEach(cb => { cb.checked = checked; });
        updateBulkUI();
    }

    function updateBulkUI() {
        const checked = document.querySelectorAll('.bulk-check:checked');
        const bulkActions = document.getElementById('bulkActions');
        const countEl = document.getElementById('selectedCount');

        if (checked.length > 0) {
            bulkActions.classList.remove('hidden');
            countEl.textContent = checked.length + ' seleccionado' + (checked.length > 1 ? 's' : '');
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    function submitBulkRelease() {
        const checked = document.querySelectorAll('.bulk-check:checked');
        if (checked.length === 0) return;
        if (!confirm(`¿Liberar ${checked.length} pago(s) seleccionados?`)) return;
        document.getElementById('bulkForm').submit();
    }
</script>
@endsection
