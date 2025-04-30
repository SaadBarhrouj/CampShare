<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{




    public function show($username)
{
    $user = User::where('username', $username)->firstOrFail();
    return view('profiles.show', compact('user'));
}
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $user = Auth::user();
        
        try {
            // Suppression de l'ancien avatar s'il existe
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            // Stockage du nouveau fichier (cohérent avec register)
            $path = $request->file('avatar')->store('profile_images', 'public');

            // Mise à jour de l'utilisateur
            $user->avatar_url = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'avatar_url' => Storage::disk('public')->url($path) // Retourne l'URL complète
            ]);

        } catch (\Exception $e) {
            Log::error("Erreur mise à jour avatar: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }
}