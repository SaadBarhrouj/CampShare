<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    
        $query = Listing::where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->whereHas('item.partner', function ($query) {
                $query->where('is_active', true);
            })
            ->with('item.category'); 

        $premiumQuery = Listing::where('is_premium', true)
            ->where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->whereHas('item.partner', function ($query) {
                $query->where('is_active', true);
            })
            ->with('item.category');
    
        if ($request->filled('search')) {
            $search = $request->search;
        
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', function ($q2) use ($search) {
                    $q2->where('title', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($q2) use ($search) {
                    $q2->where('name', 'LIKE', "%{$search}%");
                });
            });
        
            $premiumQuery->where(function ($q) use ($search) {
                $q->whereHas('item', function ($q2) use ($search) {
                    $q2->where('title', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($q2) use ($search) {
                    $q2->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        // Filter by category name
        if ($request->has('category')) {
            $query->whereHas('item.category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });

            $premiumQuery->whereHas('item.category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->has('price_range')) {
            $range = $request->price_range;
        
            $query->whereHas('item', function ($q) use ($range) {
                if ($range === '200+') {
                    $q->where('price_per_day', '>=', 200);
                } elseif (preg_match('/^(\d+)-(\d+)$/', $range, $matches)) {
                    $min = (int)$matches[1];
                    $max = (int)$matches[2];
                    $q->whereBetween('price_per_day', [$min, $max]);
                }
            });
        
            $premiumQuery->whereHas('item', function ($q) use ($range) {
                if ($range === '200+') {
                    $q->where('price_per_day', '>=', 200);
                } elseif (preg_match('/^(\d+)-(\d+)$/', $range, $matches)) {
                    $min = (int)$matches[1];
                    $max = (int)$matches[2];
                    $q->whereBetween('price_per_day', [$min, $max]);
                }
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

        if ($request->has('city')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('name', $request->city);
            });
        
            $premiumQuery->whereHas('city', function ($q) use ($request) {
                $q->where('name', $request->city);
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

        $listingsCount = $query->count();
        $premiumListingsCount = $premiumQuery->count();
    
        $listings = $query->paginate(15)->appends($request->query());
        $premiumListings = $premiumQuery->take(3)->get();
    
        

        $categories = Category::all();
        $cities = City::orderBy('name')->get();
    
        return view('client.listings.index', compact(
            'listings', 
            'premiumListings', 
            'listingsCount', 
            'premiumListingsCount', 
            'sort',
            'categories',
            'cities',
        ));
    }
    


    public function indexPremium(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // default sort

        $query = Listing::where('is_premium', true)
            ->where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->whereHas('item.partner', function ($query) {
                $query->where('is_active', true);
            })
            ->with('item.category');

        if ($request->filled('search')) {
            $search = $request->search;
        
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', function ($q2) use ($search) {
                    $q2->where('title', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($q2) use ($search) {
                    $q2->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

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

        if ($request->has('price_range')) {
            $range = $request->price_range;
        
            $query->whereHas('item', function ($q) use ($range) {
                if ($range === '200+') {
                    $q->where('price_per_day', '>=', 200);
                } elseif (preg_match('/^(\d+)-(\d+)$/', $range, $matches)) {
                    $min = (int)$matches[1];
                    $max = (int)$matches[2];
                    $q->whereBetween('price_per_day', [$min, $max]);
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

        
        if ($request->has('city')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('name', $request->city);
            });
        }

        $premiumListingsCount = $query->count();
        $premiumListings = $query->paginate(15)->appends($request->query());

        $categories = Category::all();
        $cities = City::orderBy('name')->get();

        return view('client.listings.indexPremium', compact(
            'premiumListings',
            'premiumListingsCount',
            'sort',
            'categories',
            'cities',
        ));
    }


    public function indexAll(Request $request)
    {
        $sort = $request->query('sort', 'latest'); // default sort
        
        $query = Listing::where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->whereHas('item.partner', function ($query) {
                $query->where('is_active', true);
            })
            ->with('item.category');

        if ($request->filled('search')) {
            $search = $request->search;
        
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', function ($q2) use ($search) {
                    $q2->where('title', 'LIKE', "%{$search}%");
                })->orWhereHas('city', function ($q2) use ($search) {
                    $q2->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

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

        if ($request->has('price_range')) {
            $range = $request->price_range;
        
            $query->whereHas('item', function ($q) use ($range) {
                if ($range === '200+') {
                    $q->where('price_per_day', '>=', 200);
                } elseif (preg_match('/^(\d+)-(\d+)$/', $range, $matches)) {
                    $min = (int)$matches[1];
                    $max = (int)$matches[2];
                    $q->whereBetween('price_per_day', [$min, $max]);
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

        
        if ($request->has('city')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('name', $request->city);
            });
        }

        $listingsCount = $query->count();
        $listings = $query->paginate(15)->appends($request->query());

        $categories = Category::all();
        $cities = City::orderBy('name')->get();

        return view('client.listings.indexAll', compact(
            'listings',
            'listingsCount',
            'sort',
            'categories',
            'cities',
        ));
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
   public function destruyoy(Listing $listing)
    {
        try {
            $listing->delete();
            return redirect()->back()->with('success', 'Annonce supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression');
        }
    }

    public function destroy(Listing $listing)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $listing->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            return redirect()->back()->with('success', 'Annonce supprimée avec succès');
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
    
}
