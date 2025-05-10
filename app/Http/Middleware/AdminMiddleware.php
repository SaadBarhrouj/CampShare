<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
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
        Log::info('AdminMiddleware: Vérification du rôle admin pour ' . (Auth::check() ? Auth::user()->email : 'utilisateur non connecté'));
        
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            Log::warning('AdminMiddleware: Accès refusé à ' . $request->path() . ' pour ' . (Auth::check() ? Auth::user()->email . ' (rôle: ' . Auth::user()->role . ')' : 'utilisateur non connecté'));
            
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Accès non autorisé. Vous devez être un administrateur.'], 403);
            }
            
            if (Auth::check()) {
                // Rediriger vers l'espace approprié selon le rôle
                if (Auth::user()->role === 'client') {
                    return redirect()->route('HomeClient')->with('error', 'Cette section est réservée aux administrateurs.');
                } elseif (Auth::user()->role === 'partner') {
                    return redirect()->route('HomePartenaie')->with('error', 'Cette section est réservée aux administrateurs.');
                }
            }
            
            return redirect()->route('login')->with('error', 'Accès non autorisé. Vous devez être un administrateur.');
        }

        Log::info('AdminMiddleware: Accès autorisé à ' . $request->path() . ' pour ' . Auth::user()->email);
        return $next($request);
    }
} 