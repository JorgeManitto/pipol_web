<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\{Contract, Engagement, TimeEntry, Transaction};
use App\Services\Fraccional\ChatSystemMessenger;
use Illuminate\Http\Request;
use Stripe\{Stripe, PaymentIntent, Transfer};

class FraccionalPaymentController extends Controller
{
    public function form(Contract $contract)
    {
        abort_unless($contract->engagement->company_id === auth()->id(), 403);
        abort_unless($contract->isFullySigned(), 400, 'Contrato no firmado por ambas partes.');
        return view('backend.fraccional.payment.form', compact('contract'));
    }

    public function createIntent(Contract $contract)
    {
        
        abort_unless($contract->engagement->company_id === auth()->id(), 403);
        abort_unless($contract->professional_signed_at, 400, 'El profesional aún no firmó.');
        abort_unless($contract->company_signed_at, 400, 'Debés aceptar los términos primero.');

        Stripe::setApiKey(config('services.stripe.secret'));

        $amount   = (float) $contract->monthly_rate;
        $feePct   = (float) $contract->platform_fee_percentage;
        $fee      = round($amount * $feePct / 100, 2);
        $proNet   = round($amount - $fee, 2);
        $cents    = (int) round($amount * 100);

        $pi = PaymentIntent::create([
            'amount'   => $cents,
            'currency' => strtolower($contract->currency),
            'automatic_payment_methods' => ['enabled' => true],
            'description'    => "Pipol Fraccional · Contrato #{$contract->id}",
            'transfer_group' => "FRACCIONAL_CONTRACT_{$contract->id}",
            'metadata' => [
                'contract_id'     => $contract->id,
                'engagement_id'   => $contract->engagement_id,
                'company_id'      => $contract->engagement->company_id,
                'professional_id' => $contract->engagement->professional_id,
            ],
        ]);

        $tx = Transaction::updateOrCreate(
            ['stripe_payment_intent_id' => $pi->id],
            [
                'contract_id'         => $contract->id,
                'engagement_id'       => $contract->engagement_id,
                'company_id'          => $contract->engagement->company_id,
                'professional_id'     => $contract->engagement->professional_id,
                'amount'              => $amount,
                'platform_fee'        => $fee,
                'professional_amount' => $proNet,
                'currency'            => $contract->currency,
                'status'              => 'pending',
            ]
        );

        return response()->json([
            'clientSecret'  => $pi->client_secret,
            'transactionId' => $tx->id,
        ]);
    }

    /**
     * Liberación TOTAL: el monto neto del profesional completo.
     * Se usa cuando todas las horas están aprobadas o no hay disputas pendientes.
     */
    public function release(Engagement $engagement)
    {
        abort_unless(
            $engagement->company_id === auth()->id() || auth()->user()->role === 'admin',
            403
        );

        // Validar que no haya disputas activas
        $activeDisputes = $engagement->contract->timeEntries()
            ->whereIn('status', [
                TimeEntry::STATUS_DISPUTED,
                TimeEntry::STATUS_EVIDENCE_SUBMITTED,
                TimeEntry::STATUS_IN_MEDIATION,
            ])->count();

        if ($activeDisputes > 0) {
            return back()->withErrors([
                'release' => "No se puede liberar el pago total: hay {$activeDisputes} entradas en disputa. Resolvelas o usá liberación parcial.",
            ]);
        }

        $tx = $engagement->transactions()->where('status', 'held')->firstOrFail();
        $professional = $engagement->professional;

        if (!$professional->stripe_account_id) {
            return back()->withErrors(['stripe' => 'El profesional no completó su onboarding Stripe Connect.']);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $transfer = Transfer::create([
                'amount'         => (int) round($tx->professional_amount * 100),
                'currency'       => strtolower($tx->currency),
                'destination'    => $professional->stripe_account_id,
                'transfer_group' => "FRACCIONAL_CONTRACT_{$tx->contract_id}",
                'description'    => "Liberación total contrato #{$tx->contract_id}",
                'metadata'       => [
                    'contract_id'    => $tx->contract_id,
                    'engagement_id'  => $engagement->id,
                    'transaction_id' => $tx->id,
                    'release_type'   => 'total',
                ],
            ]);

            $tx->update([
                'stripe_transfer_id' => $transfer->id,
                'status'             => 'released',
                'released_amount'    => $tx->professional_amount,
                'retained_amount'    => 0,
                'released_at'        => now(),
            ]);

            $engagement->update(['status' => 'completed', 'completed_at' => now()]);

            ChatSystemMessenger::post($engagement, 'service_released');

            return redirect()->route('fraccional.closure.show', $engagement)
            ->with('success', 'Fondos liberados al profesional.');
        } catch (\Throwable $e) {
            return back()->withErrors(['stripe' => 'Error al liberar: ' . $e->getMessage()]);
        }
    }

    /**
     * Liberación PARCIAL: calcula qué porcentaje de horas fue aprobado y libera proporcional.
     * El resto queda retenido en la cuenta plataforma para refund o resolución posterior.
     */
    public function releasePartial(Request $request, Engagement $engagement)
    {
        abort_unless(
            $engagement->company_id === auth()->id() || auth()->user()->role === 'admin',
            403
        );

        $request->validate([
            'release_notes' => 'nullable|string|max:1000',
        ]);

        $contract = $engagement->contract;
        $tx = $engagement->transactions()->where('status', 'held')->firstOrFail();
        $professional = $engagement->professional;

        if (!$professional->stripe_account_id) {
            return back()->withErrors(['stripe' => 'El profesional no completó su onboarding Stripe Connect.']);
        }

        // Calcular proporcional: total_aprobado / total_acordado_por_el_contrato
        $approvedHours = $contract->totalHours(); // ya excluye disputas
        $contractedHours = $contract->hours_per_week * 4 * $contract->duration_months; // estimado mensual base

        // Tope: nunca pagar más de lo que se cobró
        $proportion = $contractedHours > 0
            ? min(1.0, $approvedHours / $contractedHours)
            : 0;

        $releasedAmount = round($tx->professional_amount * $proportion, 2);
        $retainedAmount = round($tx->professional_amount - $releasedAmount, 2);

        if ($releasedAmount <= 0) {
            return back()->withErrors([
                'release' => 'No hay horas aprobadas todavía. No se puede liberar nada.',
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $transfer = Transfer::create([
                'amount'         => (int) round($releasedAmount * 100),
                'currency'       => strtolower($tx->currency),
                'destination'    => $professional->stripe_account_id,
                'transfer_group' => "FRACCIONAL_CONTRACT_{$tx->contract_id}",
                'description'    => "Liberación parcial contrato #{$tx->contract_id} ({$proportion}%)",
                'metadata'       => [
                    'contract_id'      => $tx->contract_id,
                    'engagement_id'    => $engagement->id,
                    'transaction_id'   => $tx->id,
                    'release_type'     => 'partial',
                    'approved_hours'   => $approvedHours,
                    'contracted_hours' => $contractedHours,
                ],
            ]);

            $tx->update([
                'stripe_transfer_id' => $transfer->id,
                'status'             => 'partially_released',
                'released_amount'    => $releasedAmount,
                'retained_amount'    => $retainedAmount,
                'released_at'        => now(),
                'release_notes'      => $request->release_notes,
            ]);

            $engagement->update(['status' => 'completed', 'completed_at' => now()]);

            ChatSystemMessenger::post($engagement, 'partial_release', [
                'released' => $releasedAmount,
                'retained' => $retainedAmount,
                'currency' => $tx->currency,
            ]);

            return redirect()->route('fraccional.closure.show', $engagement)
            ->with('success', "Pago parcial liberado: {$releasedAmount} {$tx->currency}.");
        } catch (\Throwable $e) {
            return back()->withErrors(['stripe' => 'Error al liberar: ' . $e->getMessage()]);
        }
    }

    /**
     * Refund del monto retenido: lo devolvemos al cliente.
     */
    public function refundRetained(Request $request, Engagement $engagement)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $tx = $engagement->transactions()
            ->where('status', 'partially_released')
            ->firstOrFail();

        if ($tx->retained_amount <= 0) {
            return back()->withErrors(['refund' => 'No hay monto retenido para reembolsar.']);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $refund = \Stripe\Refund::create([
                'charge'   => $tx->stripe_charge_id,
                'amount'   => (int) round($tx->retained_amount * 100),
                'metadata' => [
                    'transaction_id' => $tx->id,
                    'reason'         => $request->reason ?? 'Disputa resuelta a favor empresa',
                ],
            ]);

            $tx->update([
                'status'        => 'refunded',
                'refunded_at'   => now(),
            ]);

            return back()->with('success', "Reembolsados {$tx->retained_amount} al cliente.");
        } catch (\Throwable $e) {
            return back()->withErrors(['refund' => $e->getMessage()]);
        }
    }
}