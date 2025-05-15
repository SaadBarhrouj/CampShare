<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%$search%")
                  ->orWhereHas('partner', function ($q) use ($search) {
                      $q->where('email', 'like', "%$search%");
                  });
        }

        $equipments = $query->with(['images', 'partner'])->get();

        return view('admin.equipments.index', compact('equipments'));
    }
}
