<?php

use App\Http\Middleware\CheckUserActive;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\EnsureProfileCompleted;
use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'profile.completed' => EnsureProfileCompleted::class,
            'email.verified' => EnsureEmailIsVerified::class,
            'check.active' => CheckUserActive::class,
            'is_admin' => IsAdmin::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook/connect',
            'webhooks/stripe'
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('fraccional*')) {
                return route('fraccional.auth.show');
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
