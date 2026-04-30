<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\{Engagement, Conversation};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EngagementController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'professional_id'  => 'required|exists:users,id',
            'diagnostic_id'    => 'nullable|exists:fraccional_diagnostics,id',
            'role_requested'   => 'nullable|string|max:100',
            'initial_message'  => 'nullable|string|max:1000',
            'from_engagement'  => 'nullable|exists:fraccional_engagements,id',
        ]);

        // Si viene de un engagement previo, heredar el diagnóstico
        if (!empty($data['from_engagement']) && empty($data['diagnostic_id'])) {
            $previous = Engagement::find($data['from_engagement']);
            if ($previous && $previous->company_id === auth()->id()) {
                $data['diagnostic_id'] = $previous->diagnostic_id;
                $data['initial_message'] = ($data['initial_message'] ?? '') .
                    "\n\n[Vengo de una contratación anterior con feedback aplicado]";
            }
        }

        unset($data['from_engagement']);

        $exists = Engagement::where('company_id', auth()->id())
            ->where('professional_id', $data['professional_id'])
            ->whereIn('status', ['pending','accepted','negotiating','proposed','confirmed','active'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya tenés una solicitud activa con este profesional.');
        }

        $engagement = Engagement::create([
            ...$data,
            'company_id' => auth()->id(),
            'status'     => 'pending',
        ]);

        // $engagement->professional->notify(new NewEngagementRequest($engagement));

        return redirect()->route('fraccional.engagement.sent')
            ->with('success', 'Solicitud enviada al profesional.');
    }

    public function accept(Engagement $engagement)
    {
        abort_unless($engagement->professional_id === auth()->id(), 403);
        abort_unless($engagement->status === 'pending', 400);

        DB::transaction(function () use ($engagement) {
            $engagement->update(['status' => 'accepted', 'accepted_at' => now()]);
            Conversation::create([
                'engagement_id'   => $engagement->id,
                'last_message_at' => now(),
            ]);
        });

        return redirect()->route('fraccional.chat.show', $engagement);
    }

    public function reject(Request $request, Engagement $engagement)
    {
        abort_unless($engagement->professional_id === auth()->id(), 403);
        abort_unless($engagement->status === 'pending', 400);

        $engagement->update([
            'status'          => 'rejected',
            'rejected_at'     => now(),
            'rejection_reason'=> $request->input('reason'),
        ]);

        return back()->with('success', 'Solicitud rechazada.');
    }

    public function cancel(Engagement $engagement)
    {
        abort_unless($engagement->involves(auth()->id()), 403);
        abort_if(in_array($engagement->status, ['active','completed']), 400,
            'No podés cancelar una contratación activa o completada.');

        $engagement->update(['status' => 'cancelled', 'cancelled_at' => now()]);
        return back()->with('success', 'Solicitud cancelada.');
    }

    public function sent()
    {
        $engagements = Engagement::where('company_id', auth()->id())
            ->with('professional', 'contract')->latest()->paginate(20);
        return view('backend.fraccional.engagements.sent', compact('engagements'));
    }

    public function received()
    {
        $engagements = Engagement::where('professional_id', auth()->id())
            ->with('company', 'diagnostic', 'contract')->latest()->paginate(20);
        return view('backend.fraccional.engagements.received', compact('engagements'));
    }
}