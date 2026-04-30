<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || is_null($request->user()->email_verified_at)) {
            // Para API/JSON devolvé un 403; para web redirigí
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Tu email no está verificado.'], 403);
            }

            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}