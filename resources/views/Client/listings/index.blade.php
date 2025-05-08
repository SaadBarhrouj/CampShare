<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - ParentCo</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/styles.css', 'resources/js/script.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/favicon_io/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/favicon_io/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="CampShare - Louez facilement le matériel de camping dont vous avez besoin
    directement entre particuliers.">
    <meta name="keywords" content="camping, location, matériel, aventure, plein air, partage, communauté">

    <!-- Map dependencies -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
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
                    <form action="{{ route('client.listings.index') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
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
                            <a href="{{ route('client.listings.index') }}">
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
                                <a href="{{ route('client.listings.index', $query) }}"
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
                                        <a href="{{ route('client.listings.index', array_merge(request()->except('city'), ['city' => null])) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Toutes les villes</a>
                                        @foreach ($cities as $city)
                                            <a href="{{ route('client.listings.index', array_merge(request()->except('city'), ['city' => $city->name])) }}"
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
                                        <a href="{{ route('client.listings.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix croissant</a>
                                        <a href="{{ route('client.listings.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix décroissant</a>
                                        <a href="{{ route('client.listings.index', array_merge(request()->query(), ['sort' => 'oldest'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus anciens</a>
                                        <a href="{{ route('client.listings.index', array_merge(request()->query(), ['sort' => 'latest'])) }}" 
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus récents</a>
                                    </div>
                                </div>
                            </div>
                            
                            <button id="toggleMapBtn" class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
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

                @php
                    $locations = $listings->map(function($listing) {
                        return [
                            'lat' => $listing->latitude,
                            'lng' => $listing->longitude,
                            'title' => $listing->item->title,
                            'url' => route('client.listings.show', $listing->id),
                            'category' => $listing->item->category->name,
                            'username' => $listing->item->partner->username,
                            'image' => $listing->item?->images?->first()
                                ? asset($listing->item->images->first()->url)
                                : asset('images/item-default.jpg')
                        ];
                    });
                @endphp
                
                <!-- Map -->
                <div id="listing-map-container" class="hidden mt-4 mb-8 h-80 sm:h-120 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-600 z-0"></div>

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-crown text-sunlight mr-2"></i>
                            Annonces Premium ({{ $premiumListingsCount }})
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Équipements mis en avant par nos partenaires de confiance.</p>
                    </div>
                    
                    <a href="{{ route('client.listings.indexPremium') }}" class="text-forest dark:text-sunlight font-medium hover:underline">
                        Tout voir <i class="fas fa-arrow-right ml-1"></i>
                    </a>
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
                                            <span class="flex flex-nowrap">{{ $premiumListing->item->averageRating() }} <span class="text-gray-500 dark:text-gray-400">({{ $premiumListing->item->reviews->where('is_visible', true)->where('type', 'forObject')->count() }})</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i>
                                        <a href="{{ route('partner.profile.index', $premiumListing->item->partner->id) }}" class="hover:text-forest dark:hover:text-sunlight">{{ $premiumListing->item->partner->username }}</a>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                        <span>{{ $premiumListing->city->name }}, Maroc</span>
                                    </div>
                                    
                                    <div class="text-sm mb-3">
                                        <span class="text-gray-600 dark:text-gray-300">Disponible du {{ $premiumListing->start_date->translatedFormat('j F Y') }} au {{ $premiumListing->end_date->translatedFormat('j F Y') }} </span>
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
            </div>
        </section>
        
        <!-- Regular Listings Section -->
        <section class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="fa-solid fa-screwdriver-wrench text-forest mr-2"></i>
                            Équipements disponibles ({{ $listingsCount }})
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Trouvez le matériel idéal avec nos partenaires.</p>
                    </div>
                    
                    <a href="{{ route('client.listings.indexAll') }}" class="text-forest dark:text-sunlight font-medium hover:underline">
                        Tout voir <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Regular Listings -->
                    @forelse ($listings as $listing)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transform transition duration-300 hover:shadow-md hover:-translate-y-1 relative">
                            <div class="absolute top-4 left-4 z-10 bg-forest text-white rounded-full px-3 py-1 font-medium text-xs flex items-center">
                                {{ $listing->item->category->name }}
                            </div>
                            <a href="{{ route('client.listings.show', $listing->id) }}">
                                <div class="relative h-48">
                                    <img src="{{ $listing->item?->images?->first() ? asset($listing->item->images->first()->url) : asset('images/item-default.jpg') }}"
                                        alt="Tente 2 places" 
                                        class="w-full h-full object-cover" />
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-white">{{ $listing->item->title }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Catégorie - {{ $listing->item->category->name }}</p>
                                        </div>
                                        <div class="flex items-center text-sm flex-nowrap">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span class="flex flex-nowrap">{{ $listing->item->averageRating() }} <span class="text-gray-500 dark:text-gray-400">({{ $listing->item->reviews->where('is_visible', true)->where('type', 'forObject')->count() }})</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i>
                                        <a href="{{ route('partner.profile.index', $listing->item->partner->id) }}" class="hover:text-forest dark:hover:text-sunlight">{{ $listing->item->partner->username }}</a>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                        <span>{{ $listing->city->name }}, Maroc</span>
                                    </div>
                                    
                                    <div class="text-sm mb-3">
                                        <span class="text-gray-600 dark:text-gray-300">Disponible du {{ $listing->start_date->translatedFormat('j F Y') }} au {{ $listing->end_date->translatedFormat('j F Y') }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-lg text-gray-900 dark:text-white">{{ $listing->item->price_per_day }} MAD</span>
                                            <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                        </div>
                                        <a href="{{ route('client.listings.show', $listing->id) }}" class="inline-block">
                                            <button class="px-4 py-2 bg-forest hover:bg-green-700 text-white rounded-md transition-colors shadow-sm">
                                                Voir détails
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucun annonce publiée encore.</p>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $listings->links() }}
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <!-- Map Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleMapBtn');
            const mapContainer = document.getElementById('listing-map-container');
            const locations = @json($locations);
            let map = null;
            let mapInitialized = false;
    
            toggleBtn.addEventListener('click', function () {
                mapContainer.classList.toggle('hidden');
    
                if (!mapInitialized && !mapContainer.classList.contains('hidden')) {
                    if (!locations.length) return;
    
                    map = L.map('listing-map-container').setView([locations[0].lat, locations[0].lng], 10);
    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 19
                    }).addTo(map);
    
                    const bounds = [];
    
                    locations.forEach(loc => {
                        if (loc.lat && loc.lng) {
                            // Small offset to hide the exact location (±0.01 degrees ≈ ±1km)
                            const offsetLat = loc.lat + (Math.random() - 0.5) * 0.02;
                            const offsetLng = loc.lng + (Math.random() - 0.5) * 0.02;
    
                            const circle = L.circle([offsetLat, offsetLng], {
                                color: '#3b82f6',
                                fillColor: '#93c5fd',
                                fillOpacity: 0.3,
                                radius: 1500 
                            }).addTo(map);
    
                            circle.bindPopup(`
                                <div class="flex gap-2 items-center" style="min-width: 250px;">
                                    <img src="${loc.image}" alt="Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div>
                                        <strong>${loc.title}</strong><br>
                                        <small>Catégorie: ${loc.category}</small><br>
                                        <small>Partenaire: ${loc.username}</small><br>
                                        <em>Zone approximative</em>
                                    </div>
                                </div>
                            `);
    
                            circle.on('click', function () {
                                window.location.href = loc.url;
                            });

                            circle.on('mouseover', function () {
                                this.openPopup();
                            });
                            circle.on('mouseout', function () {
                                this.closePopup();
                            });

                            bounds.push([loc.offsetLat, loc.offsetLng]);

                        }
                    });
    
                    if (bounds.length) map.fitBounds(bounds);
    
                    mapInitialized = true;
                }
    
                // Change button text
                const span = toggleBtn.querySelector('span');
                span.textContent = mapContainer.classList.contains('hidden') ? 'Voir la carte' : 'Cacher la carte';
            });
        });
    </script>
    

</body>
</html>