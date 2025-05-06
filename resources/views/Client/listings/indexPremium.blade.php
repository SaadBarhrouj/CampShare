<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - ParentCo</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/styles.css', 'resources/js/script.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/filters.js') }}"></script>
    
</head>


<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900">

    @include('partials.header')

    <!-- Page Header -->
    <header class="pt-24 pb-10 bg-gray-50 dark:bg-gray-800 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Découvrir le matériel de camping</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Trouvez le matériel idéal pour votre prochaine aventure en plein air.
                </p>
                <div class="rounded-lg pt-4 md:pt-6 transition-all duration-300 md:w-180">
                    <form action="{{ route('client.listings.indexPremium') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="search" name="search" placeholder="Rechercher des tentes, lampes, boussoles ..." class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3">
                            </div>
                        </div>
                    
                        <div class="flex items-end">
                            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-sunlight hover:bg-amber-600 text-white font-medium rounded-md shadow-sm transition duration-300 flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i>
                                Rechercher
                            </button>
                        </div>
                    </form>                    
                </div>
                @if(request('search'))
                    <p class="text-xl text-gray-400 mt-6">Résultats pour "<strong>{{ request('search') }}</strong>"</p>
                @endif
            </div>
            </div>
            
        </div>
    </header>

    <main class="bg-white dark:bg-gray-900 transition-all duration-300">
        <!-- Filter Panel -->
        <div class="border-b border-gray-200 dark:border-gray-700 shadow-sm top-16 bg-white dark:bg-gray-800 z-40 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="py-4 flex flex-wrap items-center justify-between gap-4">
                        <!-- Category Filter Pills -->
                        <div class="flex items-center space-x-3 overflow-x-auto">
                            <!-- All Categories Button -->
                            <a href="{{ route('client.listings.indexPremium') }}">
                                <button class="whitespace-nowrap px-5 py-2 text-sunlight rounded-full font-medium border border-sunlight hover:bg-opacity-20 transition-all">
                                    Tous les articles
                                </button>
                            </a>

                            <!-- Dynamic Category Buttons -->
                            @foreach ($categories as $category)
                                @php
                                    $query = request()->query(); 
                                    $query['category'] = $category->name; 
                                @endphp
                                <a href="{{ route('client.listings.indexPremium', $query) }}"
                                    data-selected-category="{{ $category->name }}"
                                    class="whitespace-nowrap px-5 py-2 {{ request('category') === $category->name ? 'bg-forest text-white border-forest' : 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600' }} rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                        
                        <!-- Price Filter -->
                        <div class="flex items-center space-x-3">
                            <a href="" data-price-range="0-50"
                               class="whitespace-nowrap px-4 py-2 {{ request('price_range') === '0-50' ? 'bg-forest text-white' : 'bg-white dark:bg-gray-700' }} rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                0-50 MAD
                            </a>
                            <a href="" data-price-range="50-100"
                               class="whitespace-nowrap px-4 py-2 {{ request('price_range') === '50-100' ? 'bg-forest text-white' : 'bg-white dark:bg-gray-700' }} rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                50-100 MAD
                            </a>
                            <a href="" data-price-range="100-200"
                               class="whitespace-nowrap px-4 py-2 {{ request('price_range') === '100-200' ? 'bg-forest text-white' : 'bg-white dark:bg-gray-700' }} rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                100-200 MAD
                            </a>
                            <a href="" data-price-range="200+"
                               class="whitespace-nowrap px-4 py-2 {{ request('price_range') === '200+' ? 'bg-forest text-white' : 'bg-white dark:bg-gray-700' }} rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                200+ MAD
                            </a>
                        </div>
                        
                        <!-- Sort and Map View Options -->
                        <div class="flex space-x-4">
                            
                            <div class="relative">
                                <button id="city-filter-button"
                                    data-current-city="{{ request('city') }}"
                                    class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all w-46">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>
                                        {{ request('city') ?? 'Toutes les villes' }}
                                    </span>
                                    <i class="fas fa-chevron-down ml-2"></i>
                                </button>
                            
                                <!-- City Dropdown -->
                                <div id="city-dropdown" class="hidden absolute right-0 mt-1 w-46 bg-white dark:bg-gray-700 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600 max-h-64 overflow-y-auto">
                                    <div class="py-1">
                                        <a href="{{ route('client.listings.indexPremium', array_merge(request()->except('city'), ['city' => null])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Toutes les villes</a>
                                        @foreach ($cities as $city)
                                            <a href="{{ route('client.listings.indexPremium', array_merge(request()->except('city'), ['city' => $city->name])) }}"
                                               class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                {{ $city->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <button id="sort-button" 
                                    data-current-sort="{{ $sort }}"
                                    class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all w-46">
                                    <i class="fas fa-sort mr-2"></i>
                                        @php
                                            $sortLabels = [
                                                'price_asc' => 'Prix croissant',
                                                'price_desc' => 'Prix décroissant',
                                                'oldest' => 'Plus anciens',
                                                'latest' => 'Plus récents',
                                            ];
                                        @endphp

                                        <span>
                                            {{ $sortLabels[$sort] ?? 'Plus récents' }}
                                        </span>
                                    <i class="fas fa-chevron-down ml-2"></i>
                                </button>
                                
                                <!-- Sort Dropdown -->
                                <div id="sort-dropdown" class="hidden absolute right-0 mt-1 w-46 bg-white dark:bg-gray-700 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600">
                                    <div class="py-1">
                                        <a href="{{ route('client.listings.indexPremium', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix croissant</a>
                                        <a href="{{ route('client.listings.indexPremium', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix décroissant</a>
                                        <a href="{{ route('client.listings.indexPremium', array_merge(request()->query(), ['sort' => 'oldest'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus anciens</a>
                                        <a href="{{ route('client.listings.indexPremium', array_merge(request()->query(), ['sort' => 'latest'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus récents</a>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                                <i class="fas fa-map-marked-alt mr-2"></i>
                                <span>Voir la carte</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Premium Listings Section -->
        <section class="py-8 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-gray-800 dark:to-gray-800 border-b border-amber-100 dark:border-gray-700 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-crown text-sunlight mr-2"></i>
                            Annonces Premium ({{ $premiumListingsCount }})
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Équipements mis en avant par nos partenaires de confiance.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Premium Listings -->
                    @forelse ($premiumListings as $premiumListing)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:shadow-lg hover:-translate-y-1 relative">
                            <div class="absolute top-4 left-4 z-10 bg-sunlight text-white rounded-full px-3 py-1 font-medium text-xs flex items-center">
                                <i class="fas fa-crown mr-1"></i> 
                                PREMIUM
                            </div>
                            <a href="{{ route('client.listings.show', $premiumListing->id) }}">
                                <div class="relative h-52">
                                    <img src="{{ $premiumListing->item?->images?->first() ? asset($premiumListing->item->images->first()->url) : asset('images/item-default.jpg') }}"
                                        alt="Tente 4 places premium" 
                                        class="w-full h-full object-cover" />
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ $premiumListing->item->title }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Catégorie - {{ $premiumListing->item->category->name }}</p>
                                        </div>
                                        <div class="flex items-center text-sm flex-nowrap">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span class="flex flex-nowrap">{{ $premiumListing->item->averageRating() }} <span class="text-gray-500 dark:text-gray-400">({{ $premiumListing->item->reviews->count() }})</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i>
                                        <a href="{{ route('partner.profile.index', $premiumListing->item->partner->id) }}" class="hover:text-forest dark:hover:text-sunlight">{{ $premiumListing->item->partner->username }}</a>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                        <span>{{ $premiumListing->city->name }}, Maroc.</span>
                                    </div>
                                    
                                    <div class="text-sm mb-3">
                                        <span class="text-gray-600 dark:text-gray-300">Disponible du {{ $premiumListing->start_date }} au {{ $premiumListing->end_date }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-xl text-gray-900 dark:text-white">{{ $premiumListing->item->price_per_day }} MAD</span>
                                            <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                        </div>
                                        <a href="{{ route('client.listings.show', $premiumListing->id) }}" class="inline-block">
                                            <button class="px-4 py-2 bg-forest hover:bg-green-700 text-white rounded-md transition-colors shadow-sm">
                                                Voir détails
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucun annonce prémium encore.</p>
                    @endforelse

                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $premiumListings->links() }}
                </div>

            </div>
        </section>
        
    </main>

    @include('partials.footer')

</body>
</html>