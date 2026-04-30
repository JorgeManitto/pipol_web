@extends('backend.layout.app')
@section('page_title', 'Pagos de ' . $mentor->name)

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
    .stat-card.total     { border-left-color: #6366f1; }

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
    .badge-active      { background: #d1fae5; color: #065f46; }
    .badge-inactive    { background: #fee2e2; color: #991b1b; }

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
    .btn-release:hover { background: #3d6a5a; }

    .btn-release-all {
        background: #1a0a3e;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-release-all:hover { background: #2d1a5e; transform: translateY(-1px); }

    .btn-retry {
        background: #f59e0b;
        color: white;
        padding: 0.375rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
    }
    .btn-retry:hover { background: #d97706; }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 1rem;
        transition: opacity 0.2s;
    }
    .btn-back:hover { opacity: 0.8; }

    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

    .table-row:hover { background: #f9fafb; }
</style>

<main class="container max-w-7xl mx-auto">
    <!-- Back -->
    <a href="{{ route('admin.payouts.index') }}" class="btn-back">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a Pagos
    </a>

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <img src="{{ $mentor->avatar ? asset('storage/avatars/'.$mentor->avatar) : asset('images/default-avatar.png') }}"
                 class="w-16 h-16 rounded-full object-cover border-3 border-white shadow" alt="">
            <div>
                <h1 class="text-4xl font-bold text-white mb-1">{{ $mentor->name }}</h1>
                <p class="text-white opacity-80">{{ $mentor->email }} · {{ $mentor->profession ?? 'Mentor' }}</p>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success"><strong>✓</strong> {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error"><strong>⚠</strong> {{ session('error') }}</div>
    @endif

    <!-- Stripe Connect Status + Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
        <!-- Stripe Status -->
        <div class="section-card lg:col-span-1">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Stripe Connect</h3>
            @if($mentor->stripe_account_id)
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Estado</span>
                        @if($mentor->stripe_connect_status === 'active')
                            <span class="badge badge-active">Activo</span>
                        @else
                            <span class="badge badge-inactive">Inactivo</span>
                        @endif
                    </div>
                    @if($stripeStatus && !isset($stripeStatus['error']))
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Cobros</span>
                            <span class="text-sm {{ $stripeStatus['charges_enabled'] ? 'text-emerald-600' : 'text-red-600' }} font-medium">
                                {{ $stripeStatus['charges_enabled'] ? '✓ Habilitado' : '✗ No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pagos</span>
                            <span class="text-sm {{ $stripeStatus['payouts_enabled'] ? 'text-emerald-600' : 'text-red-600' }} font-medium">
                                {{ $stripeStatus['payouts_enabled'] ? '✓ Habilitado' : '✗ No' }}
                            </span>
                        </div>
                    @elseif(isset($stripeStatus['error']))
                        <p class="text-xs text-red-500 mt-2">Error: {{ Str::limit($stripeStatus['error'], 80) }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-2 break-all">ID: {{ $mentor->stripe_account_id }}</p>
                </div>
            @else
                <div class="text-center py-4">
                    <svg class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    <p class="text-sm text-gray-500 font-medium">Sin cuenta conectada</p>
                    <p class="text-xs text-gray-400 mt-1">El mentor no podrá recibir transferencias</p>
                </div>
            @endif
        </div>

        <!-- Stats -->
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
        <div class="stat-card total shadow-sm">
            <p class="text-sm text-gray-500">Total ganado</p>
            <p class="text-2xl font-bold text-gray-900">USD {{ number_format($stats['total_earned'], 2) }}</p>
        </div>
    </div>

    <!-- Release All -->
    @if($stats['pending_count'] > 0 && $mentor->stripe_account_id && $mentor->stripe_connect_status === 'active')
        <div class="section-card flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="font-semibold text-gray-900">
                    {{ $stats['pending_count'] }} pago(s) pendiente(s) por USD {{ number_format($stats['pending_amount'], 2) }}
                </p>
                <p class="text-sm text-gray-500">Transferir todos los pagos pendientes a {{ $mentor->name }}</p>
            </div>
            <form method="POST" action="{{ route('admin.payouts.release.all', $mentor) }}"
                  onsubmit="return confirm('¿Liberar TODOS los pagos pendientes (USD {{ number_format($stats['pending_amount'], 2) }}) a {{ $mentor->name }}?')">
                @csrf
                <button type="submit" class="btn-release-all">
                    <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Liberar todos los pagos
                </button>
            </form>
        </div>
    @endif

    <!-- Transactions table -->
    <div class="section-card">
        <h2 class="section-title">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Historial de Transacciones
        </h2>

        @if($transactions->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 font-medium">No hay transacciones para este mentor</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-100 text-left text-gray-500 text-xs uppercase tracking-wider">
                            <th class="py-3 px-3">Sesión</th>
                            <th class="py-3 px-3">Cliente</th>
                            <th class="py-3 px-3">Monto</th>
                            <th class="py-3 px-3">Comisión</th>
                            <th class="py-3 px-3">Neto Mentor</th>
                            <th class="py-3 px-3">Estado</th>
                            <th class="py-3 px-3">Fecha</th>
                            <th class="py-3 px-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $tx)
                            <tr class="border-b border-gray-50 table-row">
                                <td class="py-3 px-3 text-gray-600 font-medium">#{{ $tx->session_id }}</td>
                                <td class="py-3 px-3">
                                    <p class="font-medium text-gray-900">{{ $tx->payer->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $tx->payer->email ?? '' }}</p>
                                </td>
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
                                <td class="py-3 px-3 text-gray-500 text-xs">
                                    Pagado: {{ $tx->paid_at ? $tx->paid_at->format('d/m/Y H:i') : '-' }}
                                    @if($tx->transferred_at)
                                        <br><span class="text-emerald-600">Liberado: {{ $tx->transferred_at->format('d/m/Y H:i') }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    @if($tx->transfer_status === 'pending')
                                        <form method="POST" action="{{ route('admin.payouts.release', $tx) }}"
                                              onsubmit="return confirm('¿Liberar USD {{ number_format($tx->mentor_amount, 2) }}?')">
                                            @csrf
                                            <button type="submit" class="btn-release">Liberar</button>
                                        </form>
                                    @elseif($tx->transfer_status === 'failed')
                                        <form method="POST" action="{{ route('admin.payouts.retry', $tx) }}"
                                              onsubmit="return confirm('¿Reintentar?')">
                                            @csrf
                                            <button type="submit" class="btn-retry">Reintentar</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">{{ Str::limit($tx->stripe_transfer_id, 16) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</main>
@endsection
