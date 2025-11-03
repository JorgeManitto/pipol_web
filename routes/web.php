<?php

use App\Http\Controllers\Backend\Dashboard;
use App\Http\Controllers\Backend\MentorSearchController;
use App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\PipolSessionController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [Home::class, 'index'])->name('home');
Route::get('/log-out', [Home::class, 'logOut'])->name('logout');
Route::get('/auth', function () { return view('frontend.auth.auth'); })->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');


    Route::get('/mentors', [MentorSearchController::class, 'index'])->name('mentors.index');


    Route::get('/sessions', [PipolSessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/{id}', [PipolSessionController::class, 'show'])->name('sessions.show');

    Route::post('/sessions/{id}/confirm', [PipolSessionController::class, 'confirm'])->name('sessions.confirm');
    Route::post('/sessions/{id}/complete', [PipolSessionController::class, 'complete'])->name('sessions.complete');
    Route::post('/sessions/{id}/cancel', [PipolSessionController::class, 'cancel'])->name('sessions.cancel');

    Route::post('/sessions/{id}/review', [PipolSessionController::class, 'review'])->name('sessions.review');


    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
});


Route::post('api/appointments', [MentorSearchController::class, 'setAppointment'])->name('api.set-appointment');

Route::get('run-clear', function(){
    Artisan::call('config:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');

    
    return 'Link de storage ejecutado correctamente';
});