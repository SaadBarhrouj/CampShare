<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveAccountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Votre compte a été désactivé. Veuillez contacter l\'administrateur.'], 403);
            }
            return redirect()->route('login')->with('error', 'Votre compte a été désactivé. Veuillez contacter l\'administrateur.');
        }

        return $next($request);
    }
} 