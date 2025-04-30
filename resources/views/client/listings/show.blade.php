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

    <!-- Main Content -->
    <main class="pt-16 bg-white dark:bg-gray-900">
        <!-- Breadcrumb -->
        <div class="bg-gray-50 dark:bg-gray-800 py-2 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex text-sm">
                    <a href="index.html" class="text-gray-500 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">Accueil</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="annonces.html" class="text-gray-500 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">Explorer le matériel</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="profil-partenaire-public.html" class="text-gray-500 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">{{ $listing->item->category->name}}</a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $listing->item->title }}</span>
                </nav>
            </div>
        </div>
        
        <!-- Equipment Detail -->
        <section class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Image Gallery -->
                    <div class="w-full lg:w-7/12">
                        <div class="relative h-96 mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <img id="mainImage" src="{{ asset('images/listing-1.jpg') }}"
                                 alt="Pack Camping Complet 2p" 
                                 class="w-full h-full object-contain" />
                        </div>
                        
                        <div class="grid grid-cols-5 gap-2">
                            <div class="thumbnail active h-20 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden" onclick="changeImage(this, 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80')">
                                <img src="{{ asset('images/listing-1.jpg') }}" 
                                     alt="Thumbnail 1" 
                                     class="w-full h-full object-cover" />
                            </div>
                            <div class="thumbnail h-20 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden" onclick="changeImage(this, 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80')">
                                <img src="{{ asset('images/listing-1.jpg') }}" 
                                     alt="Thumbnail 2" 
                                     class="w-full h-full object-cover" />
                            </div>
                            <div class="thumbnail h-20 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden" onclick="changeImage(this, 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80')">
                                <img src="{{ asset('images/listing-1.jpg') }}"
                                     alt="Thumbnail 3" 
                                     class="w-full h-full object-cover" />
                            </div>
                            <div class="thumbnail h-20 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden" onclick="changeImage(this, 'https://images.unsplash.com/photo-1546811740-23e671faf31c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80')">
                                <img src="{{ asset('images/listing-1.jpg') }}"
                                     alt="Thumbnail 4" 
                                     class="w-full h-full object-cover" />
                            </div>
                            <div class="thumbnail h-20 bg-gray-100 dark:bg-gray-700 rounded-md overflow-hidden" onclick="changeImage(this, 'https://images.unsplash.com/photo-1598443037135-f5eeb3ebf5af?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80')">
                                <img src="{{ asset('images/listing-1.jpg') }}" 
                                     alt="Thumbnail 5" 
                                     class="w-full h-full object-cover" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Equipment Details -->
                    <div class="w-full lg:w-5/12">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $listing->item->title }}</h1>
                                    <p class="text-gray-500 dark:text-gray-400">Catégorie - {{ $listing->item->category->name }}</p>
                                </div>
                                <div class="flex items-center mt-1.5">
                                    <i class="fas fa-star text-amber-400 mr-1"></i>
                                    <span class="font-medium">{{ $listing->item->averageRating() }}</span>
                                    <span class="text-gray-500 dark:text-gray-400 ml-1 text-nowrap">({{ $listing->item->reviews->where('is_visible', true)->count() }} avis)</span>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 py-4 mb-4">
                                <div class="flex items-center mb-2">
                                    <div class="h-8 w-8 rounded-full bg-forest text-white flex items-center justify-center mr-3">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div>
                                        <a href="profile-fatima.html" class="font-medium text-gray-900 dark:text-white hover:text-forest dark:hover:text-meadow">{{ $listing->item->partner->username}}</a>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Membre depuis {{ $listing->item->partner->created_at->translatedFormat('F Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mt-3">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    <span>{{ $listing->city->name }}, Maroc.</span>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                                
                                <div class="flex items-baseline">
                                    <h2 class="font-bold text-gray-900 dark:text-white mb-3 mr-4">Prix</h2>
                                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $listing->item->price_per_day }} MAD</span>
                                    <span class="text-gray-600 dark:text-gray-300 ml-2">/jour</span>
                                </div>

                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 py-4 mb-4">
                                <h2 class="font-bold text-gray-900 dark:text-white mb-3">Disponibilité</h2>
                                <p class="text-gray-600 dark:text-gray-300 mb-3">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    Disponible du {{ $listing->availabilities?->first()?->start_date ?? '2025-02-04' }}
                                    au
                                    {{ $listing->availabilities?->first()?->end_date ?? '2025-02-28' }}
                                </p>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 py-4 mb-4">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label for="pickup-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de retrait</label>
                                        <input type="date" id="pickup-date" min="2023-08-01" max="2023-09-28" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base p-2 mt-1">
                                    </div>
                                    <div>
                                        <label for="return-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de retour</label>
                                        <input type="date" id="return-date" min="2023-08-02" max="2023-10-01" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base p-2 mt-1">
                                    </div>
                                    <div>
                                        <label for="delivery-option-toggle" class="flex items-center cursor-pointer mt-2">
                                            <div class="relative">
                                                <input type="checkbox" id="delivery-option-toggle" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-forest transition-colors"></div>
                                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Livraison demandée</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="price-calculation" class="hidden mt-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">450 MAD × <span id="days-count">3</span> jours</span>
                                        <span class="text-gray-900 dark:text-white font-medium" id="subtotal">1350 MAD</span>
                                    </div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-gray-600 dark:text-gray-300">Frais de livraison CampShare (5%)</span>
                                        <span class="text-gray-900 dark:text-white font-medium" id="service-fee">67.50 MAD</span>
                                    </div>
                                    <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-600 mt-2">
                                        <span class="text-gray-900 dark:text-white font-medium">Total</span>
                                        <span class="text-gray-900 dark:text-white font-bold" id="total-price">1417.50 MAD</span>
                                    </div>
                                </div>
                            </div>
                            
                            <button id="reservation-button" class="w-full py-3 bg-sunlight hover:bg-amber-600 text-white font-medium rounded-md shadow-md transition-colors">
                                Réserver maintenant
                            </button>
                            
                        </div>
                    </div>
                </div>
                
                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 dark:border-gray-700 mt-10">
                    <div class="flex overflow-x-auto scrollbar-hide space-x-8">
                        <button id="tab-details" class="tab-active px-1 py-4 font-medium text-lg whitespace-nowrap">
                            Description
                        </button>
                        <button id="tab-reviews" class="px-1 py-4 font-medium text-lg text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            Avis ({{ $listing->item->reviews->where('is_visible', true)->count() }})
                        </button>
                    </div>
                </div>
                
                <!-- Description Section -->
                <section id="details-section" class="py-6">
                    <div class="prose max-w-none prose-forest dark:prose-invert dark:text-gray-300">
                        <p>{{ $listing->item->description }}</p>
                    </div>
                </section>
                
                <!-- Reviews Section -->
                <section id="reviews-section" class="py-6 hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 md:mb-0">Avis sur cet équipement</h2>
                            
                            <button id="write-review-button" class="inline-flex items-center px-4 py-2 bg-forest hover:bg-green-700 text-white rounded-md shadow-sm transition-colors">
                                <i class="fas fa-star mr-2"></i>
                                Évaluer cet équipement
                            </button>
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-start">
                            <div class="md:w-48 flex flex-col items-center mb-4 md:mb-0">
                                <div class="text-5xl font-bold text-gray-900 dark:text-white">{{ $listing->item->averageRating() }}</div>

                                <div class="flex text-amber-400 text-xl mt-2">
                                    <x-star-rating :rating="$listing->item->reviews->avg('rating')" />
                                </div>

                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Basé sur {{ $listing->item->reviews->where('is_visible', true)->count() }} avis</div>
                            </div>
                            
                            <div class="flex-1 ml-0 md:ml-6">
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <div class="w-24 text-sm font-medium text-gray-700 dark:text-gray-300">5 étoiles</div>
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $listing->item->fiveStarPercentage(5) }}%"></div>
                                        </div>
                                        <div class="w-10 text-right text-xs text-gray-500 dark:text-gray-400">{{ $listing->item->fiveStarPercentage(5) }}%</div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-24 text-sm font-medium text-gray-700 dark:text-gray-300">4 étoiles</div>
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $listing->item->fiveStarPercentage(4) }}%"></div>
                                        </div>
                                        <div class="w-10 text-right text-xs text-gray-500 dark:text-gray-400">{{ $listing->item->fiveStarPercentage(4) }}%</div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-24 text-sm font-medium text-gray-700 dark:text-gray-300">3 étoiles</div>
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $listing->item->fiveStarPercentage(3) }}%"></div>
                                        </div>
                                        <div class="w-10 text-right text-xs text-gray-500 dark:text-gray-400">{{ $listing->item->fiveStarPercentage(3) }}%</div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-24 text-sm font-medium text-gray-700 dark:text-gray-300">2 étoiles</div>
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $listing->item->fiveStarPercentage(2) }}%"></div>
                                        </div>
                                        <div class="w-10 text-right text-xs text-gray-500 dark:text-gray-400">{{ $listing->item->fiveStarPercentage(2) }}%</div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-24 text-sm font-medium text-gray-700 dark:text-gray-300">1 étoile</div>
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $listing->item->fiveStarPercentage(1) }}%"></div>
                                        </div>
                                        <div class="w-10 text-right text-xs text-gray-500 dark:text-gray-400">{{ $listing->item->fiveStarPercentage(1) }}%</div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <!-- Review Form (Hidden by default) -->
                    <div id="review-form" class="hidden bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Évaluer cet équipement</h3>
                        
                        <form id="submit-review-form">
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Note globale</label>
                                <div class="star-rating text-2xl">
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="5 étoiles"></label>
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="4 étoiles"></label>
                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3" title="3 étoiles"></label>
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="2 étoiles"></label>
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="1 étoile"></label>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="review-title" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Titre de votre avis</label>
                                <input type="text" id="review-title" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base p-2" placeholder="Résumez votre expérience en quelques mots">
                            </div>
                            
                            <div class="mb-4">
                                <label for="review-comment" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Votre commentaire</label>
                                <textarea id="review-comment" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base p-2" placeholder="Partagez les détails de votre expérience avec cet équipement..."></textarea>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="button" id="cancel-review" class="mr-4 px-4 py-2 font-medium rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    Annuler
                                </button>
                                <button type="submit" class="px-4 py-2 font-medium rounded-md bg-forest hover:bg-green-700 text-white shadow-md transition-colors">
                                    Publier l'avis
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="space-y-6">

                        @forelse ($reviews as $review)
                        <div class="review-item {{ $loop->index >= 3 ? 'hidden' : '' }}">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex">
                                        <div class="mr-4">
                                            <a href="profile-ahmed.html">
                                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                     alt="Ahmed Kaddour" 
                                                     class="w-12 h-12 rounded-full object-cover" />
                                            </a>
                                        </div>
                                        <div>
                                            <a href="profile-ahmed.html" class="font-bold text-gray-900 dark:text-white hover:text-forest dark:hover:text-meadow">{{ $review->reviewer->username }}</a>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <div class="flex text-amber-400">
                                                    <x-star-rating :rating="$review->rating" />
                                                </div>
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $review->created_at->translatedFormat('d F Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-gray-600 dark:text-gray-300"> {{ $review->comment }} </p>
                                </div>

                            </div>
                            </div>

                        @empty
                            <p class="text-gray-500">Aucun avis pour cette annonce.</p>
                        @endforelse

                        <!-- Load More Button -->
                        <div class="flex justify-center mt-8 space-x-3">
                            <button id="loadMoreBtn"
                                class="px-6 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Voir plus d'avis
                            </button>
                            <button id="loadLessBtn"
                                class="px-6 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Voir moins d'avis
                            </button>
                        </div>

                    </div>
                    
                </section>
            </div>
        </section>
        
    </main>
    
    @include('partials.footer')

    <script>
        
    </script>
</body>
</html>