<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // default sorting
    
        $query = Listing::with('item.category'); // eager load
        $premiumQuery = Listing::where('is_premium', true)->with('item.category');
    
        // Filter by category name
        if ($request->has('category')) {
            $query->whereHas('item.category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });

            $premiumQuery->whereHas('item.category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Apply price filter if min or max price is set
        if ($request->has('price_range')) {
            $priceRange = $request->price_range;
            $query->whereHas('item', function($q) use ($priceRange) {
                switch($priceRange) {
                    case '0-50':
                        $q->where('price_per_day', '>=', 0)
                          ->where('price_per_day', '<=', 50);
                        break;
                    case '50-100':
                        $q->where('price_per_day', '>', 50)
                          ->where('price_per_day', '<=', 100);
                        break;
                    case '100-200':
                        $q->where('price_per_day', '>', 100)
                          ->where('price_per_day', '<=', 200);
                        break;
                    case '200+':
                        $q->where('price_per_day', '>', 200);
                        break;
                }
            });

            $premiumQuery->whereHas('item', function($q) use ($priceRange) {
                switch($priceRange) {
                    case '0-50':
                        $q->where('price_per_day', '>=', 0)
                          ->where('price_per_day', '<=', 50);
                        break;
                    case '50-100':
                        $q->where('price_per_day', '>', 50)
                          ->where('price_per_day', '<=', 100);
                        break;
                    case '100-200':
                        $q->where('price_per_day', '>', 100)
                          ->where('price_per_day', '<=', 200);
                        break;
                    case '200+':
                        $q->where('price_per_day', '>', 200);
                        break;
                }
            });
        } else if ($request->has('min_price') || $request->has('max_price')) {
            $query->whereHas('item', function($q) use ($request) {
                if ($request->has('min_price')) {
                    $q->where('price_per_day', '>=', $request->min_price);
                }
                if ($request->has('max_price')) {
                    $q->where('price_per_day', '<=', $request->max_price);
                }
            });

            $premiumQuery->whereHas('item', function($q) use ($request) {
                if ($request->has('min_price')) {
                    $q->where('price_per_day', '>=', $request->min_price);
                }
                if ($request->has('max_price')) {
                    $q->where('price_per_day', '<=', $request->max_price);
                }
            });
        }
    
        // Sorting logic
        switch ($sort) {
            case 'price_asc':
                $query->join('items', 'listings.item_id', '=', 'items.id')
                      ->orderBy('items.price_per_day', 'asc')
                      ->select('listings.*');
                $premiumQuery->join('items', 'listings.item_id', '=', 'items.id')
                             ->orderBy('items.price_per_day', 'asc')
                             ->select('listings.*');
                break;
    
            case 'price_desc':
                $query->join('items', 'listings.item_id', '=', 'items.id')
                      ->orderBy('items.price_per_day', 'desc')
                      ->select('listings.*');
                $premiumQuery->join('items', 'listings.item_id', '=', 'items.id')
                             ->orderBy('items.price_per_day', 'desc')
                             ->select('listings.*');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                $premiumQuery->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                $premiumQuery->orderBy('created_at', 'desc');
                break;
        }
    
        $listings = $query->simplePaginate(9)->appends($request->query());
        $premiumListings = $premiumQuery->take(3)->get();
    
        $listingsCount = $query->count();
        $premiumListingsCount = $premiumQuery->count();
    
        return view('client.listings.index', compact(
            'listings', 
            'premiumListings', 
            'listingsCount', 
            'premiumListingsCount', 
            'sort'
        ));
    }
    


    public function indexPremium(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // default sort

        $query = Listing::where('is_premium', true)->with('item.category');

        // Apply category filter if present
        if ($request->has('category')) {
            $query->whereHas('item.category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Apply price filter if min or max price is set
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->whereHas('item', function($q) use ($request) {
                if ($request->has('min_price')) {
                    $q->where('price_per_day', '>=', $request->min_price);
                }
                if ($request->has('max_price')) {
                    $q->where('price_per_day', '<=', $request->max_price);
                }
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->join('items', 'listings.item_id', '=', 'items.id')
                    ->orderBy('items.price_per_day', 'asc')
                    ->select('listings.*');
                break;
            case 'price_desc':
                $query->join('items', 'listings.item_id', '=', 'items.id')
                    ->orderBy('items.price_per_day', 'desc')
                    ->select('listings.*');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $premiumListingsCount = $query->count();
        $premiumListings = $query->simplePaginate(9)->appends($request->query());

        return view('client.listings.indexPremium', compact(
            'premiumListings',
            'premiumListingsCount',
            'sort'
        ));
    }


    public function indexAll(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // default sort
        
        $query = Listing::with('item.category');

        // Apply category filter if present
        if ($request->has('category')) {
            $query->whereHas('item.category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Apply price filter if min or max price is set
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->whereHas('item', function($q) use ($request) {
                if ($request->has('min_price')) {
                    $q->where('price_per_day', '>=', $request->min_price);
                }
                if ($request->has('max_price')) {
                    $q->where('price_per_day', '<=', $request->max_price);
                }
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->join('items', 'listings.item_id', '=', 'items.id')
                    ->orderBy('items.price_per_day', 'asc')
                    ->select('listings.*');
                break;
            case 'price_desc':
                $query->join('items', 'listings.item_id', '=', 'items.id')
                    ->orderBy('items.price_per_day', 'desc')
                    ->select('listings.*');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $listingsCount = $query->count();
        $listings = $query->simplePaginate(9)->appends($request->query());

        return view('client.listings.indexAll', compact('listings', 'listingsCount', 'sort'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $reviews = $listing->item->reviews()->where('is_visible', true)->latest()->get();
        return view('client.listings.show', compact('listing', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
