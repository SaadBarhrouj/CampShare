<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - ParentCo</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/styles.css', 'resources/js/script.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
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
            </div>
            
        </div>
    </header>

    <main class="bg-white dark:bg-gray-900 transition-all duration-300">
        <!-- Filter Panel -->
        <div class="border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-16 bg-white dark:bg-gray-800 z-40 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="py-4 flex flex-wrap items-center justify-between gap-4">
                        <!-- Category Filter Pills -->
                        <div class="flex items-center space-x-3 overflow-x-auto scrollbar-hide">
                            <a href="{{ route('client.listings.indexPremium') }}">
                                <button class="whitespace-nowrap px-4 py-2 text-sunlight rounded-full font-medium border border-sunlight hover:bg-opacity-20 transition-all">
                                    Tous prémiums
                                </button>
                            </a>
                            <a href="{{ route('client.listings.indexPremium', ['category' => 'tentes']) }}">
                                <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    Tentes
                                </button>
                            </a>
                            <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                Sacs de couchage
                            </button>
                            <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                Matelas
                            </button>
                            <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                Cuisine
                            </button>
                            <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                Mobilier
                            </button>
                            <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                Éclairage
                            </button>
                        </div>
                        
                        <!-- Sort and Map View Options -->
                        <div class="flex space-x-4">
                            <div class="relative">
                                <button id="sort-button" class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all w-46">
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
                                        <a href="{{ route('client.listings.indexPremium', ['sort' => 'price_asc']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix croissant</a>
                                        <a href="{{ route('client.listings.indexPremium', ['sort' => 'price_desc']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix décroissant</a>
                                        <a href="{{ route('client.listings.indexPremium', ['sort' => 'oldest']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus anciens</a>
                                        <a href="{{ route('client.listings.indexPremium', ['sort' => 'latest']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus récents</a>
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
                                    <img src="https://images.unsplash.com/photo-1571687949921-1306bfb24b72?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                        alt="Tente 4 places premium" 
                                        class="w-full h-full object-cover" />
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ $premiumListing->title }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Catégorie - {{ $premiumListing->category->name }}</p>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span>{{ $premiumListing->averageRating() }} <span class="text-gray-500 dark:text-gray-400">({{ $premiumListing->reviews->count() }})</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i>
                                        <a href="/profile/mohammed-alami" class="hover:text-forest dark:hover:text-sunlight">{{ $premiumListing->partner->username }}</a>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                        <span>{{ $premiumListing->partner->address }}</span>
                                    </div>
                                    
                                    <div class="text-sm mb-3">
                                        <span class="text-gray-600 dark:text-gray-300">Disponible du  au </span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-xl text-gray-900 dark:text-white">{{ $premiumListing->price_per_day }} MAD</span>
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