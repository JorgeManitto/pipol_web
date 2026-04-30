<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\Engagement;
use App\Services\Fraccional\{ChatSystemMessenger, SimilarProfilesService};
use Illuminate\Http\Request;
use Stripe\{Stripe, Refund};

class EngagementClosureController extends Controller
{
    /**
     * Pantalla de cierre: aparece cuando engagement está completed o resolved-company.
     */
    public function show(Engagement $engagement)
    {
        abort_unless($engagement->company_id === auth()->id(), 403);
        abort_unless(in_array($engagement->status, ['completed', 'closed_refunded']), 400);

        return view('backend.fraccional.closure.show', compact('engagement'));
    }

    /**
     * Empresa quiere continuar con el mismo profesional → renovar contrato.
     * Crea un nuevo engagement ligado al anterior.
     */
    public function continueWithSame(Engagement $engagement)
    {
        abort_unless($engagement->company_id === auth()->id(), 403);

        $newEngagement = Engagement::create([
            'diagnostic_id'   => $engagement->diagnostic_id,
            'company_id'      => $engagement->company_id,
            'professional_id' => $engagement->professional_id,
            'role_requested'  => $engagement->role_requested,
            'initial_message' => "Renovación del contrato anterior #{$engagement->id}.",
            'status'          => 'pending',
        ]);

        $engagement->update(['closure_choice' => 'continue', 'closed_at' => now()]);

        return redirect()->route('fraccional.chat.show', $newEngagement)
            ->with('info', 'Solicitud enviada al profesional para renovar la contratación.');
    }

    /**
     * Empresa quiere ver perfiles similares con ajustes (más senior, más económico, etc.).
     */
    public function findSimilar(Request $request, Engagement $engagement, SimilarProfilesService $service)
    {
        abort_unless($engagement->company_id === auth()->id(), 403);

        $newInput = $request->validate([
            'preference'      => 'required|in:similar,more_senior,more_economic,custom',
            'custom_input'    => 'nullable|string|max:1000',
            'max_budget'      => 'nullable|numeric|min:0',
        ]);

        $result = $service->findSimilar($engagement, $newInput);

        $engagement->update([
            'closure_choice' => 'find_similar',
            'closure_input'  => $newInput,
            'closed_at'      => now(),
        ]);

        return view('backend.fraccional.closure.similar', [
            'engagement' => $engagement,
            'profiles'   => $result['profiles'],
            'criteria'   => $result['criteria'],
            'reasoning'  => $result['reasoning'],
            'newInput'   => $newInput,
        ]);
    }

    /**
     * Empresa pide devolución total del dinero.
     */
    public function refund(Request $request, Engagement $engagement)
    {
        abort_unless($engagement->company_id === auth()->id(), 403);

        $request->validate([
            'reason' => 'required|string|min:10|max:1000',
        ]);

        $tx = $engagement->transactions()
            ->whereIn('status', ['held', 'partially_released'])
            ->first();

        if (!$tx) {
            return back()->withErrors([
                'refund' => 'No hay fondos disponibles para reembolsar. Si el pago ya fue liberado al profesional, contactá a soporte.',
            ]);
        }

        // Solo se puede pedir refund total si NO hubo liberación parcial
        if ($tx->status === 'partially_released') {
            return back()->withErrors([
                'refund' => 'Ya hubo una liberación parcial. Solicitá la devolución del monto retenido por el área de soporte.',
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $refund = Refund::create([
                'charge'   => $tx->stripe_charge_id,
                'metadata' => [
                    'engagement_id' => $engagement->id,
                    'reason'        => $request->reason,
                ],
            ]);

            $tx->update([
                'status'      => 'refunded',
                'refunded_at' => now(),
            ]);

            $engagement->update([
                'closure_choice' => 'refund',
                'closure_input'  => ['reason' => $request->reason],
                'status'         => 'closed_refunded',
                'closed_at'      => now(),
            ]);

            ChatSystemMessenger::post($engagement, 'refund_issued', [
                'amount'   => $tx->amount,
                'currency' => $tx->currency,
            ]);

            return redirect()->route('fraccional.engagement.sent')
                ->with('success', 'Reembolso procesado. El monto se acreditará en 5-10 días hábiles.');

        } catch (\Throwable $e) {
            return back()->withErrors(['refund' => 'Error procesando reembolso: ' . $e->getMessage()]);
        }
    }

    /**
     * Cerrar sin más acciones.
     */
    public function finish(Engagement $engagement)
    {
        abort_unless($engagement->company_id === auth()->id(), 403);
        $engagement->update(['closure_choice' => 'finished', 'closed_at' => now()]);
        return redirect()->route('fraccional.history')->with('success', 'Servicio finalizado.');
    }
}