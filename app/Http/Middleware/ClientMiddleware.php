<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientMiddleware
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
        Log::info('ClientMiddleware: Vérification du rôle pour ' . (Auth::check() ? Auth::user()->email : 'utilisateur non connecté'));
        
        if (!Auth::check()) {
            Log::warning('ClientMiddleware: Accès refusé - utilisateur non connecté');
            
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Vous devez être connecté pour accéder à cette ressource.'], 401);
            }
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette ressource.');
        }

        // Les partenaires peuvent aussi accéder aux fonctionnalités client
        if (Auth::user()->role === 'client' || Auth::user()->role === 'partner') {
            Log::info('ClientMiddleware: Accès autorisé à ' . $request->path() . ' pour ' . Auth::user()->email . ' (rôle: ' . Auth::user()->role . ')');
            return $next($request);
        }
        
        // Pour les autres rôles (admin), rediriger vers leur espace
        Log::warning('ClientMiddleware: Accès refusé à ' . $request->path() . ' pour ' . Auth::user()->email . ' (rôle: ' . Auth::user()->role . ')');
        
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Accès non autorisé. Vous devez être un client ou un partenaire.'], 403);
        }
        
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Cette fonctionnalité est réservée aux clients et partenaires.');
        }
        
        return redirect()->route('login')->with('error', 'Accès non autorisé. Vous devez être un client ou un partenaire.');
    }
} 