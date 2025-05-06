<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember-me'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Si besoin d’enregistrer autre chose au login, tu peux le faire ici

            session()->flash('success', 'Connexion réussie.');

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'partner') {
                return redirect()->route('HomePartenaie');
            } else {
                return redirect()->route('HomeClient');
            }
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    public function logout()
    {
        Auth::logout();  
        return redirect()->route('login');  
    }
}
