<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Home extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    function mentors() {
        return view('frontend.mentors');
    }
    function logOut() {
        auth()->logout();
        return redirect()->route('home');
    }
}
