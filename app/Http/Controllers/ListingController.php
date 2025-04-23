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
    
        $query = Listing::query();
        $premiumQuery = Listing::where('is_premium', true); // default base
    
        // Apply category filter to both queries if present
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
    
            $premiumQuery->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }
    
        // Sorting logic
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                $premiumQuery->orderBy('price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
                $premiumQuery->orderBy('price_per_day', 'desc');
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
    
        $listingsCount = $query->toBase()->getCountForPagination();
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
        $sort = $request->query('sort', 'latest'); // default sort: latest

        $query = Listing::where('is_premium', true);

        // Apply category filter if present
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
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
        $premiumListings = $query->simplePaginate(9);

        return view('client.listings.indexPremium', compact('premiumListings', 'premiumListingsCount', 'sort'));
    }


    public function indexAll(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // default sort: latest

        $query = Listing::query();

        // Apply category filter if present
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
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
        $listings = $query->simplePaginate(9);

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
        $reviews = $listing->reviews()->latest()->get();
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
