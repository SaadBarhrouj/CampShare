<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie; // Import the LeaveRequest model
use App\Models\Evaluation;
use App\Models\Image;
use App\Models\Notifaction;
use App\Models\Objet;
use App\Models\Reclamation;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Annonce;

class PartenaireController extends Controller
{
    function ShowHomePartenaire () {
        return view('Partenaire.tablea_de_bord_partenaire');
    }
}
