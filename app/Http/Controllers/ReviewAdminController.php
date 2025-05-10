<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $reviews = Review::with(['reviewer', 'reviewee', 'item'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('reviewer', function($q) use ($search) {
                    $q->where('email', 'like', "%$search%")
                      ->orWhere('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%");
                })
                ->orWhereHas('reviewee', function($q) use ($search) {
                    $q->where('email', 'like', "%$search%")
                      ->orWhere('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.reviews.partials.reviews_table', compact('reviews'))->render(),
                'pagination' => (string) $reviews->links()
            ]);
        }

        return view('admin.reviews.index', compact('reviews'));
    }
}