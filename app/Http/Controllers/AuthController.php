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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials, $request->filled('remember-me'))) {
    
            $user = Auth::user();
    
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
    
                return back()->withErrors([
                    'email' => 'Votre compte a été désactivé. Veuillez contacter le support.',
                ])->withInput($request->only('email', 'remember-me'));
            }
    
            $request->session()->regenerate();
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
        ])->withInput($request->only('email', 'remember-me'));
    }
    

    public function logout()
    {
        Auth::logout();  
        return redirect()->route('login');  
    }
}
