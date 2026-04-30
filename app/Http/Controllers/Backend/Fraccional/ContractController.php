<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\{Engagement, Contract};
use App\Services\Fraccional\ChatSystemMessenger;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Solo la empresa puede crear la primera propuesta.
     */
    public function store(Request $request, Engagement $engagement)
    {
        // ⬇️ CAMBIO: ahora solo la empresa
        abort_unless($engagement->company_id === auth()->id(), 403,
            'Solo la empresa puede proponer los términos iniciales.');
        abort_if($engagement->contract, 400, 'Ya existe un contrato.');

        $data = $request->validate([
            'objectives'       => 'required|string',
            'responsibilities' => 'required|string',
            'scope'            => 'nullable|string',
            'hours_per_week'   => 'required|integer|min:1|max:40',
            'duration_months'  => 'required|integer|min:1|max:24',
            'monthly_rate'     => 'required|numeric|min:1',
            'currency'         => 'required|string|size:3',
            'start_date'       => 'nullable|date|after_or_equal:today',
        ]);

        $contract = Contract::create([
            ...$data,
            'engagement_id'        => $engagement->id,
            'status'               => 'proposed',
            'terms_version'        => config('fraccional.terms_version', '1.0'),
            'version'              => 1,
            'last_proposed_by'     => auth()->id(),
            'last_proposed_at'     => now(),
            'proposal_history'     => [],
        ]);

        // Guardar la versión 1 en el historial
        $contract->update([
            'proposal_history' => [$contract->snapshotTerms()],
        ]);

        $engagement->update(['status' => 'proposed']);

        ChatSystemMessenger::post($engagement, 'contract_proposed');

        return redirect()->route('fraccional.chat.show', $engagement);
    }

    /**
     * Profesional envía contra-propuesta (modifica los términos y resetea firmas).
     */
    public function counterPropose(Request $request, Contract $contract)
    {
        $engagement = $contract->engagement;

        // ⬇️ NUEVO: solo el profesional puede contra-proponer
        abort_unless($engagement->professional_id === auth()->id(), 403);
        abort_if($contract->isFullySigned(), 400, 'El contrato ya está firmado por ambas partes.');
        abort_if($contract->status === 'active', 400);

        $data = $request->validate([
            'objectives'       => 'required|string',
            'responsibilities' => 'required|string',
            'scope'            => 'nullable|string',
            'hours_per_week'   => 'required|integer|min:1|max:40',
            'duration_months'  => 'required|integer|min:1|max:24',
            'monthly_rate'     => 'required|numeric|min:1',
            'currency'         => 'required|string|size:3',
            'start_date'       => 'nullable|date|after_or_equal:today',
            'counter_proposal_note' => 'required|string|min:10|max:1000',
        ]);

        // Guardar la versión actual en historial antes de modificar
        $history = $contract->proposal_history ?? [];
        $history[] = $contract->snapshotTerms();

        $newVersion = $contract->version + 1;

        $contract->update([
            ...$data,
            'version'                => $newVersion,
            'last_proposed_by'       => auth()->id(),
            'last_proposed_at'       => now(),
            'status'                 => 'counter_proposed',
            // ⬇️ Resetear firmas: cualquier cambio invalida las firmas previas
            'professional_signed_at' => null,
            'company_signed_at'      => null,
            'terms_accepted_at'      => null,
            'proposal_history'       => $history,
        ]);

        $engagement->update(['status' => 'negotiating']);

        ChatSystemMessenger::post($engagement, 'counter_proposed', [
            'version' => $newVersion,
        ]);

        return redirect()->route('fraccional.chat.show', $engagement)
            ->with('success', 'Contra-propuesta enviada. La empresa la revisará.');
    }

    /**
     * Empresa revisa una contra-propuesta y la modifica (nueva versión).
     */
    public function reviseProposal(Request $request, Contract $contract)
    {
        $engagement = $contract->engagement;

        abort_unless($engagement->company_id === auth()->id(), 403);
        abort_if($contract->isFullySigned(), 400);

        $data = $request->validate([
            'objectives'       => 'required|string',
            'responsibilities' => 'required|string',
            'scope'            => 'nullable|string',
            'hours_per_week'   => 'required|integer|min:1|max:40',
            'duration_months'  => 'required|integer|min:1|max:24',
            'monthly_rate'     => 'required|numeric|min:1',
            'currency'         => 'required|string|size:3',
            'start_date'       => 'nullable|date|after_or_equal:today',
            'counter_proposal_note' => 'nullable|string|max:1000',
        ]);

        $history = $contract->proposal_history ?? [];
        $history[] = $contract->snapshotTerms();

        $newVersion = $contract->version + 1;

        $contract->update([
            ...$data,
            'version'                => $newVersion,
            'last_proposed_by'       => auth()->id(),
            'last_proposed_at'       => now(),
            'status'                 => 'proposed',
            'professional_signed_at' => null,
            'company_signed_at'      => null,
            'terms_accepted_at'      => null,
            'proposal_history'       => $history,
        ]);

        $engagement->update(['status' => 'proposed']);

        ChatSystemMessenger::post($engagement, 'company_revised_proposal', [
            'version' => $newVersion,
        ]);

        return redirect()->route('fraccional.chat.show', $engagement)
            ->with('success', 'Propuesta actualizada y enviada al profesional.');
    }

    public function signProfessional(Contract $contract)
    {
        abort_unless($contract->engagement->professional_id === auth()->id(), 403);
        abort_if($contract->professional_signed_at, 400);

        // Solo puede firmar si la última propuesta NO fue del propio profesional
        // (sino estaría firmando su propia contra-propuesta)
        abort_if($contract->isProposedByProfessional(), 400,
            'No podés firmar tu propia contra-propuesta. Esperá la respuesta de la empresa.');

        $user = auth()->user();
        if (!$user->stripe_connect_id) {
            return back()->withErrors([
                'stripe' => 'Necesitás conectar tu cuenta Stripe antes de firmar.'
            ]);
        }

        $contract->update([
            'professional_signed_at' => now(),
            'status' => $contract->company_signed_at ? 'active' : 'signed_by_professional',
        ]);

        ChatSystemMessenger::post($contract->engagement, 'professional_signed');

        return back()->with('success', 'Contrato firmado. Esperando firma y pago de la empresa.');
    }

    public function signCompany(Request $request, Contract $contract)
    {
        abort_unless($contract->engagement->company_id === auth()->id(), 403);

        // ⬇️ NUEVO: la empresa NO puede firmar su propia propuesta sin que el profesional firme primero
        abort_if(
            $contract->isProposedByCompany() && !$contract->professional_signed_at,
            400,
            'Esperá a que el profesional firme primero (o envíe contra-propuesta).'
        );

        $request->validate(['terms_accepted' => 'accepted']);

        $contract->update([
            'company_signed_at'  => now(),
            'terms_accepted_at'  => now(),
        ]);

        $contract->engagement->update(['status' => 'confirmed']);

        ChatSystemMessenger::post($contract->engagement, 'company_signed');

        return redirect()->route('fraccional.payment.form', $contract)
            ->with('info', 'Ahora completá el pago para activar el servicio.');
    }
}