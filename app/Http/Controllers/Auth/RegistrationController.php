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
        // Validation des données
        $validator = Validator::make($request->all(), [
            'username'      => 'required|string|max:255|unique:users',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20|regex:/^\+?[0-9\s\-]+$/',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'cin_recto'     => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'cin_verso'     => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'city_id'       => 'required|exists:cities,id',
            'terms'         => 'required|accepted',
            'contract'      => 'required|accepted',
        ], [
            'phone_number.regex' => 'Le numéro de téléphone doit être valide',
            'terms.required'     => 'Vous devez accepter les CGU',
            'contract.required'  => 'Vous devez accepter le contrat',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        DB::beginTransaction();

        try {
            // Stockage des fichiers
            $imagePath = $this->storeUploadedFile($request->file('image'), 'profile_images');
            $cinRectoPath = $this->storeUploadedFile($request->file('cin_recto'), 'cin_images');
            $cinVersoPath = $this->storeUploadedFile($request->file('cin_verso'), 'cin_images');

            // Création de l'utilisateur
            $user = User::create([
                'username'      => $request->username,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'address'       => $request->address,
                'phone_number'  => $request->phone_number,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'avatar_url'    => $imagePath,
                'cin_recto'     => $cinRectoPath,
                'cin_verso'     => $cinVersoPath,
                'role'          => $request->has('role') ? 'partner' : 'client',
                'is_subscribed' => $request->has('is_subscribed') ? 1 : 0,
                'city_id'       => $request->city_id,
                'newsletter'    => $request->has('newsletter'),
            ]);

            DB::commit();

            Auth::login($user);

            return redirect()->route('client.listings.index')
                ->with('success', 'Votre compte a été créé avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();

            $this->cleanupUploads([$imagePath ?? null, $cinRectoPath ?? null, $cinVersoPath ?? null]);

            Log::error("Erreur lors de l'inscription: " . $e->getMessage());

            return back()
                ->with('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.')
                ->withInput();
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
