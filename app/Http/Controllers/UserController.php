<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
public function toggleActivation(Request $request, $userId)
{
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }

    $newStatus = $request->input('is_active'); 
    $user->is_active = $newStatus;
    $user->save();

    return response()->json(['message' => 'Statut de l\'utilisateur mis à jour']);
}

public function becomePartner(Request $request)
{
    $user = Auth::user();
    
    // Vérifier si l'utilisateur est déjà partenaire
    if ($user->role === 'partner') {
        return response()->json([
            'success' => false,
            'message' => 'Vous êtes déjà partenaire'
        ]);
    }
    
    // Vérifier si l'utilisateur a fourni tous les documents nécessaires
    if (empty($user->cin_recto)) {
        return response()->json([
            'success' => false,
            'message' => 'Vous devez télécharger votre CIN recto avant de devenir partenaire'
        ]);
    }
    
    // Mettre à jour le rôle
    $user->role = 'partner';
    $user->save();
    
    return response()->json([
        'success' => true,
        'message' => 'Félicitations ! Vous êtes maintenant partenaire'
    ]);
}

public function saveNotes(User $user, Request $request)
{
    $request->validate([
        'message' => 'nullable|string',
        'is_active' => 'required|boolean'
    ]);

    // Sauvegarder le statut actif/inactif
    $user->is_active = $request->is_active;
    $user->save();

    // Sauvegarder la note si elle existe
    if ($request->message) {
        $user->messages()->create([
            'message' => $request->message
        ]);
    }

    return response()->json([
        'message' => 'Notes enregistrées avec succès',
        'is_active' => $user->is_active
    ]);
}

}
