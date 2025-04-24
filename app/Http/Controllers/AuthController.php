<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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

        
        //$pdf = Pdf::loadView('contracts.contract', [
        //    'user' => $user,
        //    'date' => now()->format('d/m/Y'),
        //]);

        //$filename = 'contract_' . $user->id . '.pdf';
        //$path = 'contracts/' . $filename;

       
        //Storage::disk('public')->makeDirectory('contracts');
        
   
        //Storage::disk('public')->put($path, $pdf->output());

      
        //$user->contract = $path;
        $user->save();

        session()->flash('success', 'Contrat PDF généré avec succès.');

     
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'partner') {
            return redirect()->route('HomePartenaie');
        } else {
            return redirect()->route('client.listings.index');
        }
    }

    return back()->withErrors([
        'email' => 'Email ou mot de passe incorrect.',
    ]);
}

}
