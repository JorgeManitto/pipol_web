<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class Dashboard extends Controller
{
    function index() {
        
        
        return view('backend.dashboard.index');
    }

    function makeNotificationRead() {
        auth()->user()->unreadNotifications->markAsRead();
        return Json::encode(['status' => 'success']);
    }
    function statistics() {
        return view('backend.components.on-working');
    }
}
