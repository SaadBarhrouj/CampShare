<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function downloadContract()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        // Vérification du rôle de l'utilisateur
        if ($user->role === 'proprietaire') {
            // Générer un PDF spécifique pour le rôle "partenaire"
            return $this->generatePartnerContract($user);
        }

        // Générer un contrat standard pour les autres utilisateurs (ex: admin, client, etc.)
        return $this->generateStandardContract($user);
    }

    /**
     * Génère un contrat spécifique pour les partenaires.
     */
    protected function generatePartnerContract($user)
    {
        $pdf = Pdf::loadView('contracts.partner_contract', [
            'user' => $user,
            'date' => now()->format('d/m/Y'),
        ]);

        $filename = 'Contrat_Partenaire_' . $user->id . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Génère un contrat standard (pour les clients ou autres rôles).
     */
    protected function generateStandardContract($user)
    {
        $pdf = Pdf::loadView('contracts.contract', [
            'user' => $user,
            'date' => now()->format('d/m/Y'),
        ]);

        $filename = 'Contrat_CampShare_' . $user->id . '.pdf';

        return $pdf->download($filename);
    }
}
