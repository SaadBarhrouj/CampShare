<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PartnerMiddleware
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
        Log::info('PartnerMiddleware: Vérification du rôle partenaire pour ' . (Auth::check() ? Auth::user()->email : 'utilisateur non connecté'));
        
        if (!Auth::check() || Auth::user()->role !== 'partner') {
            Log::warning('PartnerMiddleware: Accès refusé à ' . $request->path() . ' pour ' . (Auth::check() ? Auth::user()->email . ' (rôle: ' . Auth::user()->role . ')' : 'utilisateur non connecté'));
            
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Accès non autorisé. Vous devez être un partenaire.'], 403);
            }
            
            if (Auth::check()) {
                // Rediriger vers l'espace approprié selon le rôle
                if (Auth::user()->role === 'client') {
                    return redirect()->route('HomeClient')->with('error', 'Accès non autorisé. Vous devez être un partenaire.');
                } elseif (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard')->with('error', 'Accès non autorisé. Vous devez être un partenaire.');
                }
            }
            
            return redirect()->route('login')->with('error', 'Accès non autorisé. Vous devez être un partenaire.');
        }

        Log::info('PartnerMiddleware: Accès autorisé à ' . $request->path() . ' pour ' . Auth::user()->email);
        return $next($request);
    }
} 