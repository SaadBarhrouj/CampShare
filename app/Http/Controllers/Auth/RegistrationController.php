<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $cities = City::all();
        return view('auth.register', compact('cities'));
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username'     => 'required|string|max:255',
        'address'     => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'email'        => 'required|string|email|max:255|unique:users',
        'password'     => 'required|string|min:8|confirmed',
        'cin_recto'    => 'required|image|mimes:jpeg,png,jpg|max:5120',
        'cin_verso'    => 'required|image|mimes:jpeg,png,jpg|max:5120',
        'city_id'      => 'required|exists:cities,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput($request->except('password', 'password_confirmation'));
    }

    DB::beginTransaction();

    try {
        // Upload CIN images
        $cinRectoPath = $request->file('cin_recto')->store('cin_images', 'public');
        $cinVersoPath = $request->file('cin_verso')->store('cin_images', 'public');

        // Création de l'utilisateur
        $user = User::create([
            'username'     => $request->input('username'),
            'address'     => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'email'        => $request->input('email'),
            'password'     => Hash::make($request->input('password')),
            'cin_recto'    => $cinRectoPath,
            'cin_verso'    => $cinVersoPath,
            'role'         => 'client',
            'city_id'      => $request->input('city_id'),
        ]);

        DB::commit();

        Auth::login($user);

        return redirect()->route('client.listings.index')->with('success', 'Votre compte a été créé avec succès!');

    } catch (\Exception $e) {
        DB::rollBack();

        // Nettoyage des fichiers
        Storage::disk('public')->delete([$cinRectoPath ?? '', $cinVersoPath ?? '']);

        Log::error("Erreur inscription: " . $e->getMessage());
        return back()->with('error', 'Erreur lors de l’inscription. Veuillez réessayer.')->withInput();
    }
}


    // Fonction pour générer un contrat PDF pour l'utilisateur
    protected function generateUserContract(User $user)
    {
        try {
            Storage::disk('public')->makeDirectory('contracts');
/*
             Génération du PDF à partir de la vue Blade contract.blade.php
            $pdf = Pdf::loadView('contracts.contract', [
                'user' => $user,
                'date' => now()->format('d/m/Y')
            ]);

             Nom du fichier du contrat
            $filename = 'contract_'.$user->id.'_'.now()->format('YmdHis').'.pdf';
            $contractPath = 'contracts/'.$filename;

             Sauvegarde du fichier PDF dans le stockage public
            Storage::disk('public')->put($contractPath, $pdf->output());

             Mise à jour de la base de données avec le chemin du contrat généré
            $user->update([
                'contract_path' => $contractPath
            ]);

            return $contractPath;*/

        } catch (\Exception $e) {
            Log::error("Erreur génération contrat: ".$e->getMessage());
            throw $e;
        }
    }

    // Fonction pour télécharger le contrat
    public function downloadContract()
    {
        $user = Auth::user();

        /*if (!$user || !$user->contract_path) {
            abort(403, 'Contrat non disponible.');
        }

        $fullPath = storage_path('app/public/'.$user->contract_path);

        if (!file_exists($fullPath)) {
            abort(404, 'Fichier contrat introuvable');
        }

        return response()->download($fullPath, 'Contrat_CampShare_'.$user->id.'.pdf');*/
    }
}
