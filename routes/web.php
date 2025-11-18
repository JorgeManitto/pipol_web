<?php

use App\Http\Controllers\Backend\Dashboard;
use App\Http\Controllers\Backend\MentorSearchController;
use App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\PipolSessionController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::get('/', [Home::class, 'index'])->name('home');
Route::get('/home/mentors', [Home::class, 'mentors'])->name('home.mentors');
// Route::get('/log-out', [Home::class, 'logOut'])->name('logout');
Route::get('/log-out-v2', function (){
    auth()->logout();
    return redirect()->route('home');
})->name('logout');
Route::get('/auth', function () { return view('frontend.auth.auth'); })->name('login');

Route::get('test-notification', [MentorSearchController::class, 'enviarNotificacion']);

Broadcast::routes(['middleware' => ['auth']]);

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


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', \App\Http\Controllers\Backend\AdminUserController::class);
    });

    Route::post('/notifications/mark-as-read', [Dashboard::class, 'makeNotificationRead'])->name('notifications.markAsRead');

    Route::get('/statistics', [Dashboard::class, 'statistics'])->name('admin.statistics');
});


Route::post('api/appointments', [MentorSearchController::class, 'setAppointment'])->name('api.set-appointment');

Route::get('run-clear', function(){
    Artisan::call('config:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');

    
    return 'Link de storage ejecutado correctamente';
});


// Redirige a Google
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

// Callback desde Google
Route::get('/auth/google/callback', function () {
    // $googleUser = Socialite::driver('google')->user();
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Buscar o crear usuario
    $user = User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'avatar' => $googleUser->getAvatar(),
    ]);

    if ($googleUser->getAvatar()) {
        $contents = file_get_contents($googleUser->getAvatar());
        $filename = 'google_' . Str::random(10) . '.jpg';

        Storage::disk('public')->put('avatars/' . $filename, $contents);

        $user->avatar = $filename;
        $user->save();
    }
    Auth::login($user);

    return redirect('/dashboard');
});