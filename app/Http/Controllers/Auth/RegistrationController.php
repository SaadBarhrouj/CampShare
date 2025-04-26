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

}
