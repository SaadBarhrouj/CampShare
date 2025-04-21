<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    function ShowHomeClient () {
        return view('Client.tablea_de_bord_client');
    }
}
