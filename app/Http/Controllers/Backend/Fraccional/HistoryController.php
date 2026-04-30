<?php 
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\Engagement;

class HistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = request('role', 'auto'); // auto | company | professional

        $query = Engagement::whereIn('status', ['completed', 'rejected', 'cancelled'])
            ->with(['company', 'professional', 'contract', 'transactions', 'diagnostic']);

        if ($role === 'company' || ($role === 'auto' && $user->role !== 'mentee')) {
            $query->where('company_id', $user->id);
            $viewing = 'company';
        } else {
            $query->where('professional_id', $user->id);
            $viewing = 'professional';
        }

        $engagements = $query->latest('updated_at')->paginate(15);

        // Métricas
        $metrics = [
            'total'       => $engagements->total(),
            'completed'   => (clone $query)->where('status', 'completed')->count(),
            'rejected'    => (clone $query)->where('status', 'rejected')->count(),
            'total_spent' => $viewing === 'company'
                ? $user->transactionsAsPayer()->where('status', 'released')->sum('amount') //payerTransactions
                : null,
            'total_earned' => $viewing === 'professional'
                ? \App\Models\Fraccional\Transaction::where('professional_id', $user->id)
                    ->where('status', 'released')->sum('professional_amount')
                : null,
        ];

        return view('backend.fraccional.history.index', compact('engagements', 'metrics', 'viewing'));
    }
}