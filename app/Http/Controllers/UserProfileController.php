<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    /**
     * Mettre à jour la photo de profil d'un utilisateur
     */
    public function updateAvatar(Request $request, $id)
    {
        // Valider l'ID de l'utilisateur
        $user = User::findOrFail($id);
        
        // Valider la photo
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Supprimer l'ancienne photo de profil si elle existe
        if ($user->avatar_url && Storage::exists('public/' . $user->avatar_url)) {
            Storage::delete('public/' . $user->avatar_url);
        }
        
        // Stocker la nouvelle photo
        $path = $request->file('avatar')->store('avatars', 'public');
        
        // Mettre à jour l'utilisateur
        $user->avatar_url = $path;
        $user->save();
        
        return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès');
    }
    
    /**
     * Mettre à jour la photo de profil du partenaire avec ID=21
     */
    public function updatePartnerAvatar(Request $request)
    {
        return $this->updateAvatar($request, 21);
    }
}
