<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class Dashboard extends Controller
{
    
    function index() {

        $sessionsAsMentor = auth()->user()->sessionsAsMentor()->where('status', 'completed')->count();
        $sessionsAsMentee = auth()->user()->sessionsAsMentee()->where('status', 'completed')->count();

        $totalEarnings = auth()->user()->transactionsAsReceiver()->sum('amount');
        $totalEarningsThisMonth = auth()->user()->transactionsAsReceiver()
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('amount');
        $totalSpent = auth()->user()->transactionsAsPayer()->sum('amount');
        $testReviews = Reviews::all();
        $totalReviews = auth()->user()->reviewsReceived()->count();
        $ratingReviews = (auth()->user()->reviewsReceived()->avg('rating')) ? round(auth()->user()->reviewsReceived()->avg('rating'), 2) : 0;
        
        // $totalSessionLast30Days = auth()->user()->sessionsAsMentor()
        //     ->where('status', 'completed')
        //     ->where('completed_at', '>=', now()->subDays(30))
        //     ->count();

        $user = auth()->user();

        $totalSessionsLast30Days = $user->sessionsAsMentor()
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subDays(30))
            ->count();

        $sessionsToday = $user->sessionsAsMentor()
            ->where('status', 'completed')
            ->whereDate('completed_at', now())
            ->count();

        $sessionsThisWeek = $user->sessionsAsMentor()
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->startOfWeek())
            ->count();

        $sessionsThisMonth = $user->sessionsAsMentor()
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->startOfMonth())
            ->count();
        //     dd($sessionsThisMonth);
        // dd(now()->startOfMonth()-> toDateTimeString());
        $sessionsPerDay = $user->sessionsAsMentor()
            ->selectRaw('DATE(completed_at) as date, COUNT(*) as total')
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Generar rango completo de días
        $labels = [];
        $data = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            $data[] = $sessionsPerDay[$date]->total ?? 0;
        }


        // dd($sessionsAsMentor);
        return view('backend.dashboard.index', compact(
            'sessionsAsMentor',
            'sessionsAsMentee',
            'totalEarnings',
            'totalEarningsThisMonth',
            'totalSpent',
            'totalReviews',
            'ratingReviews',
            'totalSessionsLast30Days',
            'sessionsToday',
            'sessionsThisWeek',
            'sessionsThisMonth',
            'labels',
            'data',
        ));
    }

    function makeNotificationRead() {
        auth()->user()->unreadNotifications->markAsRead();
        return Json::encode(['status' => 'success']);
    }
    function statistics() {
        return view('backend.components.on-working');
    }
}
