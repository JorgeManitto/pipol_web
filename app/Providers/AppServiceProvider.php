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
                $notificaciones = Notification::where('notifiable_id', auth()->id())->orderBy('created_at', 'DESC')->paginate(10)->pluck('data')->toArray();
                // dd(Notification::where('notifiable_id', auth()->id())->orderBy('created_at', 'DESC')->paginate(10));
                $view->with('notificaciones', $notificaciones);
            } 
        });
    }

}
