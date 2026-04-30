<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Esto se ejecuta en cada render de vista, cuando Auth ya está disponible
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $notificaciones = Notification::where('read_at', null)->where('notifiable_id', auth()->id())->orderBy('created_at', 'DESC')->paginate(10)->pluck('data')->toArray();
                // dd(Notification::where('notifiable_id', auth()->id())->orderBy('created_at', 'DESC')->paginate(10));
                $view->with('notificaciones', $notificaciones);
            } 
        });
        View::composer('backend.layout.fraccional', function ($view) {
            if (!auth()->check()) return;

            $user = auth()->user();

            // Si no es de fraccional, no calculamos contadores
            if (!$user->isFraccional()) {
                $view->with([
                    'menu_pendingReceived' => 0,
                    'menu_activeAsCompany' => 0,
                    'menu_activeAsPro'     => 0,
                ]);
                return;
            }

            $pendingReceived = $user->isFraccionalProfessional()
                ? \App\Models\Fraccional\Engagement::where('professional_id', $user->id)
                    ->where('status', 'pending')->count()
                : 0;

            $activeAsCompany = $user->isFraccionalCompany()
                ? \App\Models\Fraccional\Engagement::where('company_id', $user->id)
                    ->whereIn('status', ['accepted','negotiating','proposed','confirmed','active'])->count()
                : 0;

            $activeAsPro = $user->isFraccionalProfessional()
                ? \App\Models\Fraccional\Engagement::where('professional_id', $user->id)
                    ->whereIn('status', ['accepted','negotiating','proposed','confirmed','active'])->count()
                : 0;

            $view->with(compact('pendingReceived', 'activeAsCompany', 'activeAsPro'));
        });
    }

}
