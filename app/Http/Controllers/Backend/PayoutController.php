<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Transfer;
use Stripe\Account;

class PayoutController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Dashboard principal de pagos pendientes
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['payer', 'receiver', 'session'])
            ->where('status', 'paid');

        // Filtro por estado de transferencia
        if ($request->filled('transfer_status')) {
            $query->where('transfer_status', $request->transfer_status);
        } else {
            // Por defecto mostrar pendientes
            $query->where('transfer_status', 'pending');
        }

        // Filtro por mentor
        if ($request->filled('mentor_id')) {
            $query->where('receiver_id', $request->mentor_id);
        }

        // Filtro por rango de fechas
        if ($request->filled('date_from')) {
            $query->whereDate('paid_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('paid_at', '<=', $request->date_to);
        }

        // Búsqueda por nombre de mentor o ID de transacción
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('gateway_transaction_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('receiver', function ($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $transactions = $query->orderBy('paid_at', 'desc')->paginate(20);

        // Estadísticas generales
        $stats = [
            'pending_count'  => Transaction::where('status', 'paid')->where('transfer_status', 'pending')->count(),
            'pending_amount' => Transaction::where('status', 'paid')->where('transfer_status', 'pending')->sum('mentor_amount'),
            'transferred_count'  => Transaction::where('transfer_status', 'transferred')->count(),
            'transferred_amount' => Transaction::where('transfer_status', 'transferred')->sum('mentor_amount'),
            'failed_count'   => Transaction::where('transfer_status', 'failed')->count(),
            'total_fees'     => Transaction::where('status', 'paid')->sum('platform_fee'),
        ];

        // Lista de mentores para el filtro
        $mentors = User::where('is_mentor', true)
            ->whereHas('transactionsReceived')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('backend.payouts.index', compact('transactions', 'stats', 'mentors'));
    }

    /**
     * Ver detalle de pagos de un mentor específico
     */
    public function mentorDetail(User $mentor)
    {
        $transactions = Transaction::with(['payer', 'session'])
            ->where('receiver_id', $mentor->id)
            ->where('status', 'paid')
            ->orderBy('paid_at', 'desc')
            ->paginate(20);

        // Stats del mentor
        $stats = [
            'pending_amount'     => Transaction::where('receiver_id', $mentor->id)->where('transfer_status', 'pending')->sum('mentor_amount'),
            'pending_count'      => Transaction::where('receiver_id', $mentor->id)->where('transfer_status', 'pending')->count(),
            'transferred_amount' => Transaction::where('receiver_id', $mentor->id)->where('transfer_status', 'transferred')->sum('mentor_amount'),
            'transferred_count'  => Transaction::where('receiver_id', $mentor->id)->where('transfer_status', 'transferred')->count(),
            'total_earned'       => Transaction::where('receiver_id', $mentor->id)->where('status', 'paid')->sum('mentor_amount'),
        ];

        // Estado de Stripe Connect
        $stripeStatus = null;
        if ($mentor->stripe_connect_id) {
            try {
                $account = Account::retrieve($mentor->stripe_connect_id);
                $stripeStatus = [
                    'charges_enabled' => $account->charges_enabled,
                    'payouts_enabled' => $account->payouts_enabled,
                    'details_submitted' => $account->details_submitted,
                ];
            } catch (\Exception $e) {
                $stripeStatus = ['error' => $e->getMessage()];
            }
        }

        return view('backend.payouts.mentor-detail', compact('mentor', 'transactions', 'stats', 'stripeStatus'));
    }

    /**
     * Transferir pago individual al mentor
     */
    public function releasePayment(Transaction $transaction)
    {
        if ($transaction->transfer_status === 'transferred') {
            return back()->with('error', 'Este pago ya fue transferido.');
        }

        $mentor = $transaction->receiver;

        if (!$mentor->stripe_connect_id || $mentor->stripe_connect_status !== 'active') {
            return back()->with('error', 'El mentor no tiene cuenta de Stripe conectada o activa.');
        }

        try {
            $transfer = Transfer::create([
                'amount'             => (int) round($transaction->mentor_amount * 100),
                'currency'           => $transaction->currency,
                'destination'        => $mentor->stripe_connect_id,
                'description'        => "Pago sesión #{$transaction->session_id} - Mentor: {$mentor->name}",
                'source_transaction' => $transaction->gateway_transaction_id,
                'metadata'           => [
                    'transaction_id' => $transaction->id,
                    'session_id'     => $transaction->session_id,
                    'mentor_id'      => $mentor->id,
                    'mentor_email'   => $mentor->email,
                ],
            ]);

            $transaction->update([
                'transfer_status'    => 'transferred',
                'stripe_transfer_id' => $transfer->id,
                'transferred_at'     => now(),
            ]);

            return back()->with('success', "Pago de USD {$transaction->mentor_amount} transferido a {$mentor->name}.");

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $transaction->update(['transfer_status' => 'failed']);
            return back()->with('error', 'Error de Stripe: ' . $e->getMessage());

        } catch (\Exception $e) {
            $transaction->update(['transfer_status' => 'failed']);
            return back()->with('error', 'Error al transferir: ' . $e->getMessage());
        }
    }

    /**
     * Liberar todos los pagos pendientes de un mentor
     */
    public function releaseAllForMentor(User $mentor)
    {
        if (!$mentor->stripe_connect_id || $mentor->stripe_connect_status !== 'active') {
            return back()->with('error', 'El mentor no tiene cuenta de Stripe conectada o activa.');
        }

        $transactions = Transaction::where('receiver_id', $mentor->id)
            ->where('status', 'paid')
            ->where('transfer_status', 'pending')
            ->get();

        if ($transactions->isEmpty()) {
            return back()->with('error', 'No hay pagos pendientes para este mentor.');
        }

        $results = ['success' => 0, 'failed' => 0, 'total' => 0];

        foreach ($transactions as $transaction) {
            try {
                $transfer = Transfer::create([
                    'amount'             => (int) round($transaction->mentor_amount * 100),
                    'currency'           => $transaction->currency,
                    'destination'        => $mentor->stripe_connect_id,
                    'description'        => "Pago sesión #{$transaction->session_id}",
                    'source_transaction' => $transaction->gateway_transaction_id,
                    'metadata'           => [
                        'transaction_id' => $transaction->id,
                        'session_id'     => $transaction->session_id,
                    ],
                ]);

                $transaction->update([
                    'transfer_status'    => 'transferred',
                    'stripe_transfer_id' => $transfer->id,
                    'transferred_at'     => now(),
                ]);

                $results['success']++;
                $results['total'] += $transaction->mentor_amount;

            } catch (\Exception $e) {
                $transaction->update(['transfer_status' => 'failed']);
                $results['failed']++;
            }
        }

        $msg = "{$results['success']} pagos transferidos (USD {$results['total']})";
        if ($results['failed'] > 0) {
            $msg .= ", {$results['failed']} fallidos";
        }

        return back()->with('success', $msg);
    }

    /**
     * Liberar pagos seleccionados (bulk)
     */
    public function releaseBulk(Request $request)
    {
        $request->validate([
            'transaction_ids'   => 'required|array|min:1',
            'transaction_ids.*' => 'exists:transactions,id',
        ]);

        $transactions = Transaction::with('receiver')
            ->whereIn('id', $request->transaction_ids)
            ->where('transfer_status', 'pending')
            ->where('status', 'paid')
            ->get();

        if ($transactions->isEmpty()) {
            return back()->with('error', 'No se encontraron pagos pendientes con los IDs indicados.');
        }

        $results = ['success' => 0, 'failed' => 0, 'skipped' => 0, 'total' => 0];

        foreach ($transactions as $transaction) {
            $mentor = $transaction->receiver;

            if (!$mentor->stripe_connect_id || $mentor->stripe_connect_status !== 'active') {
                $results['skipped']++;
                continue;
            }

            try {
                $transfer = Transfer::create([
                    'amount'             => (int) round($transaction->mentor_amount * 100),
                    'currency'           => $transaction->currency,
                    'destination'        => $mentor->stripe_connect_id,
                    'description'        => "Pago sesión #{$transaction->session_id}",
                    'source_transaction' => $transaction->gateway_transaction_id,
                    'metadata'           => [
                        'transaction_id' => $transaction->id,
                        'session_id'     => $transaction->session_id,
                        'mentor_id'      => $mentor->id,
                    ],
                ]);

                $transaction->update([
                    'transfer_status'    => 'transferred',
                    'stripe_transfer_id' => $transfer->id,
                    'transferred_at'     => now(),
                ]);

                $results['success']++;
                $results['total'] += $transaction->mentor_amount;

            } catch (\Exception $e) {
                $transaction->update(['transfer_status' => 'failed']);
                $results['failed']++;
            }
        }

        $msg = "{$results['success']} pagos transferidos (USD " . number_format($results['total'], 2) . ")";
        if ($results['failed'] > 0) $msg .= ", {$results['failed']} fallidos";
        if ($results['skipped'] > 0) $msg .= ", {$results['skipped']} omitidos (sin Stripe Connect)";

        return back()->with('success', $msg);
    }

    /**
     * Reintentar pagos fallidos
     */
    public function retryFailed(Transaction $transaction)
    {
        if ($transaction->transfer_status !== 'failed') {
            return back()->with('error', 'Solo se pueden reintentar pagos fallidos.');
        }

        // Reset a pending y redirigir a release
        $transaction->update([
            'transfer_status'    => 'pending',
            'stripe_transfer_id' => null,
            'transferred_at'     => null,
        ]);

        return $this->releasePayment($transaction);
    }
}
