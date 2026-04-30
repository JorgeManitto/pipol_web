<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\Diagnostic;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'problem'        => 'required|string',
            'size'           => 'required|string',
            'industry'       => 'required|string',
            'urgency'        => 'required|string',
            'stage'          => 'required|string',
            'ai_role'        => 'nullable|string',
            'ai_problem'     => 'nullable|string',
            'ai_impact'      => 'nullable|string',
            'ai_hours'       => 'nullable|string',
            'ai_insights'    => 'nullable|array',
            'ai_match_count' => 'nullable|string',
        ]);

        $diagnostic = Diagnostic::create([
            ...$data,
            'company_id' => auth()->id(),
        ]);

        return response()->json([
            'id'       => $diagnostic->id,
            'redirect' => route('fraccional.index', [
                'role'          => $data['ai_role'] ?? null,
                'diagnostic_id' => $diagnostic->id,
            ]),
        ]);
    }
}