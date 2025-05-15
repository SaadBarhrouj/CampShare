<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegistrationForm()
    {
        $cities = City::orderBy('name')->get();
        return view('auth.register', compact('cities'));
    }

    /**
     * Traite l'inscription de l'utilisateur
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'      => 'required|string|max:255|unique:users',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20|regex:/^\+?[0-9\s\-()]+$/',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Correct: nullable
            'cin_recto'     => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'cin_verso'     => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'city_id'       => 'required|exists:cities,id',
            'terms'         => 'required|accepted',
            'contract'      => 'required|accepted',
            'is_subscribed' => 'nullable|boolean',
            'role'          => 'nullable|in:partner', // Valide que si 'role' est présent, c'est 'partner'
        ], [
            'phone_number.regex' => 'Le numéro de téléphone doit être valide.',
            'terms.accepted'     => 'Vous devez accepter les CGU et la Politique de Confidentialité.',
            'contract.accepted'  => 'Vous devez accepter le Contrat de Location.',
            'image.max'          => 'L\'image de profil ne doit pas dépasser 5MB.',
            'cin_recto.required' => 'La photo recto de la CIN est requise.',
            'cin_recto.max'      => 'La photo recto de la CIN ne doit pas dépasser 5MB.',
            'cin_verso.required' => 'La photo verso de la CIN est requise.',
            'cin_verso.max'      => 'La photo verso de la CIN ne doit pas dépasser 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation', 'image', 'cin_recto', 'cin_verso'));
        }

        $imagePath = null;
        $cinRectoPath = null;
        $cinVersoPath = null;

        DB::beginTransaction();

        try {
            // Stockage des fichiers
            
            // x
            //$imagePath = $this->storeUploadedFile($request->file('image'), 'storage/profile_images');
            //$cinRectoPath = $this->storeUploadedFile($request->file('cin_recto'), 'storage/cin_images');
            //$cinVersoPath = $this->storeUploadedFile($request->file('cin_verso'), 'storage/cin_images');


            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imagePath = 'storage/' . $this->storeUploadedFile($request->file('image'), 'profile_images');
            } else {
                $imagePath = "images/avatar-default.jpg";
            }

            $cinRectoPath = $this->storeUploadedFile($request->file('cin_recto'), 'cin_images');
            $cinVersoPath = $this->storeUploadedFile($request->file('cin_verso'), 'cin_images');

             if ($cinRectoPath === null || $cinVersoPath === null) {
                 throw new \Exception("Erreur lors du traitement des fichiers CIN requis.");
             }

            $user = User::create([
                'username'      => $request->username,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'address'       => $request->address,
                'phone_number'  => $request->phone_number,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'avatar_url'    => $imagePath,
                'cin_recto'     => 'storage/' . $cinRectoPath,
                'cin_verso'     => 'storage/' . $cinVersoPath,
                'role'          => ($request->has('role') && $request->input('role') === 'partner') ? 'partner' : 'client',
                 // =============================
                'is_subscriber' => $request->boolean('is_subscribed'), 
                'city_id'       => $request->city_id,
                'is_active'     => 1,
            ]);

            DB::commit();
            Auth::login($user);

            $redirectRoute = $user->role === 'partner' ? 'HomePartenaie' : 'HomeClient';
            return redirect()->route($redirectRoute)
                             ->with('success', 'Votre compte a été créé avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->cleanupUploads(array_filter([$imagePath, $cinRectoPath, $cinVersoPath]));
            Log::error("Erreur Inscription: " . $e->getMessage());
            return back()
                ->with('error', 'Une erreur technique est survenue durant l\'inscription. Veuillez réessayer.')
                ->withInput($request->except('password', 'password_confirmation', 'image', 'cin_recto', 'cin_verso'));
        }
    }

    /**
     * Stocke un fichier uploadé
     */
    protected function storeUploadedFile($file, string $directory): string
    {
        if (!$file || !$file->isValid()) {
            throw new \Exception("Fichier invalide");
        }

        return $file->store($directory, 'public');
    }

    /**
     * Supprime les fichiers en cas d'erreur
     */
    protected function cleanupUploads(array $paths): void
    {
        foreach ($paths as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
