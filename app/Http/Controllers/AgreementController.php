<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    public function generateAgreement()
    {
        $data = [
            'title' => 'Contrat de Location - CampShare',
            'content' => [
                'Vous êtes responsable des équipements loués.',
                'Les retards de retour peuvent entraîner des frais supplémentaires.',
                'Les dommages ou pertes doivent être signalés immédiatement.',
                'CampShare se réserve le droit de suspendre tout compte non conforme aux règles.',
                'Le service est fourni "tel quel" sans garantie de disponibilité permanente.',
            ]
        ];

        $pdf = Pdf::loadView('pdf.agreement', $data);

        return $pdf->download('contrat_location.pdf');
    }
}
