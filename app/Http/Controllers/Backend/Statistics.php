<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Statistics extends Controller
{
    public function index(){

        $statistics = Transaction::where('receiver_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        // dd($statistics);
        return view('backend.statistics.index', compact('statistics'));
    }
}
