<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class AdminEquipmentController extends Controller
{
    public function index()
    {
     
        $equipments = Item::with([
            'partner.user', 
            'images',      
            'listing',     
            'category'      
        ])->paginate(10); 

        return view('admin.equipments.index', compact('equipments'));
    }
}