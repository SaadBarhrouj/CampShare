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
    
</head>

<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900">
    
    @include('partials.header')

    <!-- Main Content -->
    <main class="pt-16 bg-white dark:bg-gray-900">
        <!-- Partner Profile Header -->
        <section class="bg-gray-50 dark:bg-gray-800 py-10 md:py-24 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <!-- Profile Image -->
                    <div class="relative mb-6 md:mb-0 md:mr-8">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-md">
                            <img src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('images/item-default.jpg') }}"
                                 alt="Fatima Benali" 
                                 class="w-full h-full object-cover" />
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center border-2 border-white dark:border-gray-700">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-20">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                                    {{ $user->username }}
                                    <span class="ml-3 text-sm font-medium px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md">
                                        Membre depuis {{ $user->created_at->translatedFormat('Y') }}
                                    </span>
                                </h1>
                                <div class="mt-2 flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    <span>{{$user->city->name}}, Maroc</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statistics -->
                        <div class="flex gap-6 flex-nowrap">
                            <div class="flex flex-col items-center">
                                @if($user->receivedReviews->where('is_visible', true)->where('type', 'forClient')->count() != 0 )
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->averageRatingClient() }}</div>
                                    <div class="flex text-amber-400 mt-1">
                                        <x-star-rating :rating="$user->averageRatingClient()" />
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">({{ $user->receivedReviews->where('is_visible', true)->where('type', 'forClient')->count() }} avis)</div>
                                @else
                                    <div class="flex text-amber-400 mt-2">
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2.5">Non noté</div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col items-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reservationsCount }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Résérvations réalisées</div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Tabs Navigation -->
        <section class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 sticky top-16 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex overflow-x-auto scrollbar-hide">
                    <button id="tab-reviews" class="px-4 py-4 font-medium text-lg whitespace-nowrap tab-active">
                        Avis ( {{ $user->receivedReviews->where('is_visible', true)->where('type', 'forClient')->count() }} )
                    </button>
                </div>
            </div>
        </section>
        
        
        
        <!-- Reviews Section -->
        <section id="reviews-section" class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Avis des utilisateurs sur ce client</h2>
                </div>
                
                <!-- Review Stats -->
                @if($user->receivedReviews->where('is_visible', true)->where('type', 'forClient')->count()!=0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex flex-col items-center mr-8 mb-6 md:mb-0">
                                <div class="text-5xl font-bold text-gray-900 dark:text-white">{{ $user->averageRatingClient() }}</div>
                                <div class="flex text-amber-400 text-xl mt-2">
                                    <x-star-rating :rating="$user->averageRatingClient()" />
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->receivedReviews()->where('is_visible', true)->where('type', 'forClient')->count() }} avis</div>
                            </div>
                            
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="flex items-center mb-2">
                                        <div class="w-24 font-medium text-gray-700 dark:text-gray-300">5 étoiles</div>
                                        <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $user->fiveStarPercentageClient(5) }}%"></div>
                                        </div>
                                        <div class="w-12 text-right text-gray-500 dark:text-gray-400 text-sm">{{ $user->fiveStarPercentageClient(5) }}%</div>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <div class="w-24 font-medium text-gray-700 dark:text-gray-300">4 étoiles</div>
                                        <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $user->fiveStarPercentageClient(4) }}%"></div>
                                        </div>
                                        <div class="w-12 text-right text-gray-500 dark:text-gray-400 text-sm">{{ $user->fiveStarPercentageClient(4) }}%</div>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <div class="w-24 font-medium text-gray-700 dark:text-gray-300">3 étoiles</div>
                                        <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $user->fiveStarPercentageClient(3) }}%"></div>
                                        </div>
                                        <div class="w-12 text-right text-gray-500 dark:text-gray-400 text-sm">{{ $user->fiveStarPercentageClient(3) }}%</div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex items-center mb-2">
                                        <div class="w-24 font-medium text-gray-700 dark:text-gray-300">2 étoiles</div>
                                        <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $user->fiveStarPercentageClient(2) }}%"></div>
                                        </div>
                                        <div class="w-12 text-right text-gray-500 dark:text-gray-400 text-sm">{{ $user->fiveStarPercentageClient(2) }}%</div>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <div class="w-24 font-medium text-gray-700 dark:text-gray-300">1 étoile</div>
                                        <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $user->fiveStarPercentageClient(1) }}%"></div>
                                        </div>
                                        <div class="w-12 text-right text-gray-500 dark:text-gray-400 text-sm">{{ $user->fiveStarPercentageClient(1) }}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Review List -->
                <div class="space-y-6">

                    @forelse ($user->receivedReviews->where('is_visible', true)->where('type', 'forClient') as $review)
                        <div class="review-item {{ $loop->index >= 3 ? 'hidden' : '' }}">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex">
                                        <div class="mr-4">
                                            <a href="{{ route('partner.profile.index', $review->reviewer->id) }}">
                                                <img src="{{ asset($review->reviewer->avatar_url) ?? asset('images/avatar-default.jpg') }}" 
                                                     alt="Ahmed Kaddour" 
                                                     class="w-12 h-12 rounded-full object-cover" />
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('partner.profile.index', $review->reviewer->id) }}" class="font-bold text-gray-900 dark:text-white hover:text-forest dark:hover:text-meadow">{{ $review->reviewer->username }}</a>
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
                            <p class="text-gray-500">Ce client n'a pas encore reçu d'avis.</p>
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
            </div>
        </section>
    </main>
    
    @include('partials.footer')

</body>
</html>