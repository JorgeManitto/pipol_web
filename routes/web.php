<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LinkedInController;
use App\Http\Controllers\Backend\Admin\Fraccional\MediationController;
use App\Http\Controllers\Backend\AdminSessionsController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\AgendaController;
use App\Http\Controllers\Backend\AvailabilityController;
use App\Http\Controllers\Backend\ChatController;
use App\Http\Controllers\Backend\Dashboard;
use App\Http\Controllers\Backend\FraccionalController;
use App\Http\Controllers\Backend\MentorSearchController;
use App\Http\Controllers\Backend\PrivateImageController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\PayoutController;
use App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Statistics;
use App\Http\Controllers\Backend\StripeConnectController;
use App\Http\Controllers\Backend\StripeWebhookController;
use App\Http\Controllers\PipolSessionController;
use App\Livewire\Chat;
use App\Livewire\MentorRegistrationChat;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Backend\Fraccional\{
    DiagnosticController, EngagementController, ChatController as FraccionalChatController,
    ContractController, DisputeController, EngagementClosureController, FraccionalPaymentController, HistoryController, ProfileController as FraccionalProfileController, StripeConnectController as FraccionalStripeConnectController,
    TimeEntryController
};
use App\Http\Controllers\Backend\Fraccional\AuthController;
use App\Http\Controllers\PreRegistrationController;

Route::get('/', [Home::class, 'proximamente'])->name('proximamente');
Route::post('/pre-registro', [PreRegistrationController::class, 'store'])
    ->middleware('throttle:5,1') // 5 intentos por minuto
    ->name('pre-registration.store');
    
Route::get('/home/mentoria', [Home::class, 'mentorias'])->name('home.mentoria');
Route::get('/home/mentors', [Home::class, 'mentors'])->name('home.mentors');
Route::get('/home', [Home::class, 'principal'])->name('home');
Route::get('/home/fraccional', [Home::class, 'fraccional'])->name('home.fraccional');
Route::get('/nuevo-diagnostico', [FraccionalController::class, 'nuevoDiagnostico'])->name('home.nuevoDiagnostico');

Route::get('/soporte/contacto', [Home::class, 'contacto'])->name('contacto');
Route::get('/soporte/preguntas-frecuentes', [Home::class, 'preguntas'])->name('preguntas.frecuentes');
Route::get('/soporte/ayuda', [Home::class, 'ayuda'])->name('ayuda');



// Route::get('/log-out', [Home::class, 'logOut'])->name('logout');
Route::get('/log-out-v2', function (){
    auth()->logout();
    return redirect()->route('home');
})->name('logout');
Route::get('/auth', function () { return view('frontend.auth.auth'); })->name('login');

Route::get('test-notification', [MentorSearchController::class, 'enviarNotificacion']);

Broadcast::routes(['middleware' => ['auth']]);

Route::middleware(['auth','profile.completed', 'check.active'])->group(function () {
    Route::get('/test-meet', [AdminUserController::class, 'testMeet'])->name('test.meet');
});
Route::get('/mentors', [MentorSearchController::class, 'index'])->name('mentors.index');
Route::middleware(['auth','profile.completed', 'email.verified'])->group(function () {

    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/cv-to-text', [ProfileController::class, 'returnTextFromCv'])->name('cv.extract');
    Route::post('/stripe/payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('createPaymentIntent');

    Route::get('/sessions', [PipolSessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/{id}', [PipolSessionController::class, 'show'])->name('sessions.show');

    Route::post('/sessions/{id}/confirm', [PipolSessionController::class, 'confirm'])->name('sessions.confirm');
    Route::post('/sessions/confirmjson', [PipolSessionController::class, 'confirmJson'])->name('sessions.confirmjson');
    Route::post('/sessions/{id}/complete', [PipolSessionController::class, 'complete'])->name('sessions.complete');
    Route::post('/sessions/cancel', [PipolSessionController::class, 'cancel'])->name('sessions.cancel');
    Route::post('/sessions/reschedule', [PipolSessionController::class, 'reschedule'])->name('sessions.reschedule');

    Route::post('/sessions/review', [PipolSessionController::class, 'review'])->name('sessions.review');

    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

    Route::prefix('admin')->middleware('is_admin')->name('admin.')->group(function () {
        Route::resource('users', \App\Http\Controllers\Backend\AdminUserController::class);

        Route::get('/generate-reunion-google', [PipolSessionController::class, 'generateReunionGoogle'])->name('generateReunionGoogle');
        Route::get('sessions',              [AdminSessionsController::class, 'index'])->name('sessions.index');
        Route::get('sessions/{session}',    [AdminSessionsController::class, 'show'])->name('sessions.show');
        Route::post('sessions/{session}/generate-meet', [AdminSessionsController::class, 'generateMeet'])->name('sessions.generate-meet');
        
        Route::get('payouts', [PayoutController::class, 'index'])->name('payouts.index');
        Route::get('payouts/mentor/{mentor}', [PayoutController::class, 'mentorDetail'])->name('payouts.mentor');
        Route::post('payouts/{transaction}/release', [PayoutController::class, 'releasePayment'])->name('payouts.release');
        Route::post('payouts/{transaction}/retry', [PayoutController::class, 'retryFailed'])->name('payouts.retry');
        Route::post('payouts/mentor/{mentor}/release-all', [PayoutController::class, 'releaseAllForMentor'])->name('payouts.release.all');
        Route::post('payouts/release-bulk', [PayoutController::class, 'releaseBulk'])->name('payouts.release.bulk');

    });

    Route::post('/notifications/mark-as-read', [Dashboard::class, 'makeNotificationRead'])->name('notifications.markAsRead');

    Route::get('/statistics', [Statistics::class, 'index'])->name('admin.statistics');

    Route::get('/crear-link', [PaymentController::class, 'generarLink']);

    Route::get('/mensajes',             [ChatController::class, 'index'])->name('admin.chat.index');
    Route::get('/mensajes/{conversation}', [ChatController::class, 'show'])->name('admin.chat.show');
    Route::post('/mensajes/{conversation}',[ChatController::class, 'store'])->name('admin.chat.store');

    Route::get('/new-conversation/{user}', [Chat::class, 'createNewConversation'])->name('admin.chat.new.conversation');
   
    Route::post('/count-view-profile', [MentorSearchController::class, 'countViewProfile'])->name('mentors.countViewProfile');

    Route::get('stripe/connect', [StripeConnectController::class, 'connect'])->name('stripe.connect');
});

Route::get('stripe/connect/callback', [StripeConnectController::class, 'callback'])->name('stripe.connect.callback');
Route::get('stripe/connect/refresh', [StripeConnectController::class, 'refresh'])->name('stripe.connect.refresh');
Route::post('stripe/disconnect', [StripeConnectController::class, 'disconnect'])->name('stripe.disconnect');

Route::post('stripe/webhook/connect', [StripeWebhookController::class, 'handleConnect'])
    ->name('stripe.webhook.connect');

Route::post('api/appointments', [MentorSearchController::class, 'setAppointment'])->name('api.set-appointment');

Route::get('run-clear', function(){
    Artisan::call('config:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('storage:link');

    return 'Link de storage ejecutado correctamente';
});
Route::get('/run-worker', function () {
    Artisan::call('queue:work --stop-when-empty');
});

Route::get('/auth/linkedin', [LinkedInController::class, 'redirect']);
Route::get('/auth/linkedin/callback', [LinkedInController::class, 'callback']);

Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('auth.google');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});

Route::middleware(['auth',
])->group(function () {

    Route::get('/chat', function () {return view('frontend.auth.chat');})->name('chat');
    Route::get('/chat-cv', function () {return view('frontend.auth.chat-cv');})->name('chat-cv');

    Route::get('/linkedin/redirect/view', [LinkedInController::class, 'redirectToLinkedinView'])->name('linkedin.redirect.view');
    Route::get('/linkedin/set-as-mentor', [LinkedInController::class, 'setUserAsMentor'])->name('linkedin.set.as.mentor');


    Route::post('/sessions/approve-reschedule', [PipolSessionController::class, 'approveReschedule'])
        ->name('sessions.approveReschedule');

    Route::post('/sessions/reject-reschedule', [PipolSessionController::class, 'rejectReschedule'])
        ->name('sessions.rejectReschedule');

});

// Opcional: guardar datos
Route::post('/guardar-datos', function (Illuminate\Http\Request $request) {
    // Puedes guardarlo en DB o enviarlo por mail
    return response()->json(['ok' => true]);
});
Route::post('/procesar-cv', function () {
    // Aquí procesás el PDF/Word y retornás los datos extraídos
    return response()->json([
        "nombre" => "Ejemplo",
        "email" => "ejemplo@mail.com",
        "experiencia" => "5 años",
        // ...
    ]);
});

Route::get('/chat-v2', [MentorRegistrationChat::class, 'render'])->name('chat.v2');

Route::middleware('auth')->group(function () {
    // Ruta simple (solo verificar autenticación)
    Route::get('/private/images/{path}', [PrivateImageController::class, 'show'])
        ->where('path', '.*')
        ->name('private.image');
    
    // Ruta segura (verificar que sea el dueño o admin)
    Route::get('/secure/images/{path}', [PrivateImageController::class, 'showSecure'])
        ->where('path', '.*')
        ->name('secure.image');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
    Route::put('/availability/{availability}', [AvailabilityController::class, 'update'])->name('availability.update');
    Route::delete('/availability/{availability}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');


    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::post('/agenda/update', [AgendaController::class, 'updateHorarios'])->name('agenda.update');
});
Route::middleware('guest')->group(function () {

    // Formulario "Olvidé mi contraseña"
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
        ->name('password.request');

    // Enviar link de recuperación
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
        ->name('password.email');

    // Formulario para ingresar nueva contraseña (llega desde el mail)
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    // Procesar el cambio de contraseña
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.update');        
});
Route::middleware(['auth'])->group(function () {
    // Mostrar el aviso "verificá tu email"
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    // Procesar el clic en el link del mail
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard'); // o a donde quieras
    })->middleware(['auth', 'signed'])->name('verification.verify');

    // Reenviar el link
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

Route::get('/politica-de-privacidad', function () {
    return view('privacy-policy');
})->name('politica.y.privacidad');
Route::get('/terminos-y-condiciones', function () {
    return view('terms');
})->name('terminos.y.condiciones');

Route::get('/test-cv', fn () => view('test-cv'));

Route::get('/fraccional',            [FraccionalController::class, 'index'])->name('fraccional.index');
Route::get('/fraccional/{user}',      [FraccionalController::class, 'show'])->name('fraccional.show');
Route::prefix('fraccional/auth')->name('fraccional.auth.')->group(function () {
    Route::get('/show', [AuthController::class, 'show'])->name('show');
    Route::post('/login',    [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
});
Route::middleware(['auth'])->prefix('fraccional')->name('fraccional.')->group(function () {
   
    Route::get('/perfil/show',          [FraccionalProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil',          [FraccionalProfileController::class, 'update'])->name('profile.update');
    Route::put('/perfil/avatar',   [FraccionalProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Historial
    Route::get('/historial/show',       [HistoryController::class, 'index'])->name('history');
        

        // Time entries (profesional)
    Route::post('/contract/{contract}/time-entries',
        [TimeEntryController::class, 'store'])->name('time.store');
    Route::delete('/time-entries/{entry}',
        [TimeEntryController::class, 'destroy'])->name('time.destroy');

    Route::post('/time-entries/{entry}/approve', [TimeEntryController::class, 'approve'])->name('time.approve');
    Route::post('/time-entries/{entry}/dispute', [TimeEntryController::class, 'dispute'])->name('time.dispute');

    // Diagnóstico
    Route::post('/diagnostico', [DiagnosticController::class, 'store'])->name('diagnostico.store');

    // Engagements
    Route::post('/engagement',                    [EngagementController::class, 'store'])->name('engagement.store');
    Route::get('/mis/enviadas',                   [EngagementController::class, 'sent'])->name('engagement.sent');
    Route::get('/mis/recibidas',                  [EngagementController::class, 'received'])->name('engagement.received');
    Route::post('/engagement/{engagement}/accept',[EngagementController::class, 'accept'])->name('engagement.accept');
    Route::post('/engagement/{engagement}/reject',[EngagementController::class, 'reject'])->name('engagement.reject');
    Route::post('/engagement/{engagement}/cancel',[EngagementController::class, 'cancel'])->name('engagement.cancel');
    // Chat
    Route::get('/engagement/{engagement}/chat/messages',[FraccionalChatController::class, 'messages'])->name('chat.messages');
    Route::get('/engagement/{engagement}/chat',  [FraccionalChatController::class, 'show'])->name('chat.show');
    Route::post('/engagement/{engagement}/chat', [FraccionalChatController::class, 'send'])->name('chat.send');

    // Contrato
    Route::post('/engagement/{engagement}/contract',    [ContractController::class, 'store'])->name('contract.store');
    Route::put('/contract/{contract}',                  [ContractController::class, 'update'])->name('contract.update');
    Route::post('/contract/{contract}/sign-pro',        [ContractController::class, 'signProfessional'])->name('contract.sign.pro');
    Route::post('/contract/{contract}/sign-company',    [ContractController::class, 'signCompany'])->name('contract.sign.company');

    // Pagos
    Route::get('/contract/{contract}/pay',              [FraccionalPaymentController::class, 'form'])->name('payment.form');
    Route::post('/contract/{contract}/payment-intent',  [FraccionalPaymentController::class, 'createIntent'])->name('payment.intent');
    Route::post('/engagement/{engagement}/release',     [FraccionalPaymentController::class, 'release'])->name('payment.release');

    // Stripe Connect (profesional)
    Route::get('/stripe/connect',         [FraccionalStripeConnectController::class, 'connect'])->name('stripe.connect');
    Route::get('/stripe/connect/return',  [FraccionalStripeConnectController::class, 'return'])->name('stripe.return');
    Route::get('/stripe/connect/refresh', [FraccionalStripeConnectController::class, 'refresh'])->name('stripe.refresh');

    Route::post('/time-entries/{entry}/evidence',        [DisputeController::class, 'submitEvidence'])->name('dispute.evidence');
    Route::post('/time-entries/{entry}/accept-evidence', [DisputeController::class, 'acceptEvidence'])->name('dispute.accept');
    Route::post('/time-entries/{entry}/reject-evidence', [DisputeController::class, 'rejectEvidence'])->name('dispute.reject');

    // Pago parcial (extender lo que ya tenías)
    Route::post('/engagement/{engagement}/release-partial', [FraccionalPaymentController::class, 'releasePartial'])->name('payment.release_partial');
    Route::post('/engagement/{engagement}/refund-retained', [FraccionalPaymentController::class, 'refundRetained'])->name('payment.refund');

    Route::get('/engagement/{engagement}/closure',           [EngagementClosureController::class, 'show'])->name('closure.show');
    Route::post('/engagement/{engagement}/closure/continue', [EngagementClosureController::class, 'continueWithSame'])->name('closure.continue');
    Route::post('/engagement/{engagement}/closure/similar',  [EngagementClosureController::class, 'findSimilar'])->name('closure.similar');
    Route::post('/engagement/{engagement}/closure/refund',   [EngagementClosureController::class, 'refund'])->name('closure.refund');
    Route::post('/engagement/{engagement}/closure/finish',   [EngagementClosureController::class, 'finish'])->name('closure.finish');

    });
    // Admin
    Route::middleware(['auth'])->prefix('admin/fraccional')->name('admin.fraccional.')->group(function () {
        Route::get('/mediacion/show',                [MediationController::class, 'index'])->name('mediation.index');
        Route::get('/mediacion/{entry}',        [MediationController::class, 'show'])->name('mediation.show');
        Route::post('/mediacion/{entry}',       [MediationController::class, 'resolve'])->name('mediation.resolve');
    });
Route::post('/webhooks/stripe', [\App\Http\Controllers\Webhooks\StripeWebhookController::class, 'handle'])
    ->name('webhooks.stripe');

    // Ruta para ejecutar el comando de auto-aprobación de horas cada hora
use Illuminate\Support\Facades\Schedule;
Schedule::command('fraccional:auto-approve-hours')->hourly();