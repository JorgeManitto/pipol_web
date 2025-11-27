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
    function contacto() {
        return view('frontend.soporte.contacto');
    }

    function preguntas() {
        return view('frontend.soporte.preguntas');
    }

    function ayuda() {
        return view('frontend.soporte.ayuda');
    }

    function terminoycondiciones()  {
        return view('frontend.legal.terminos-y-condiciones');
    }

    function politica() {
        return view('frontend.legal.politica-y-privacidad');
    }
}
