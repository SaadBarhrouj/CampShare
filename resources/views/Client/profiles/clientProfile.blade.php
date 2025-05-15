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
    
    <!-- Header -->
    <nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('index') }}" class="flex items-center">
                        <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                        <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('client.listings.index') }}" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Explorer le matériel</a>
                    @auth
                        @php
                            $user = Auth::user();
                        @endphp
                        @if($user)
                            @if($user->role == 'client')
                                <button type="button" id="openPartnerModalBtn" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300 cursor-pointer">
                                    Devenir Partenaire
                                </button>
                            @endif
                            <div class="relative ml-4">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <a id="notifications-client-icon-link" href="{{ route('notifications.client.index') }}" class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                            <i class="fas fa-bell"></i>
                                            @php
                                                $unreadNotificationsCount = $unreadNotificationsCount ?? \App\Http\Controllers\NotificationController::getUnreadClientNotificationCount();
                                            @endphp
                                            @if($unreadNotificationsCount > 0)
                                                <span id="notification-badge-count" class="absolute -top-1 -right-1 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full">
                                                    {{ $unreadNotificationsCount }}
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="relative">
                                        <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                            <img src="{{ asset($user->avatar_url ?? 'images/default-avatar.png') }}" alt="Avatar de {{ $user->username }}" class="h-8 w-8 rounded-full object-cover" />
                                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $user->username }}</span>
                                            <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                        </button>
                                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-[51] border border-gray-200 dark:border-gray-600">
                                            <div class="py-1">
                                                <a href="{{ route('HomeClient.profile') }}#profile" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                                </a>
                                                <a href="{{ route('HomeClient') }}" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <i class="fas fa-tachometer-alt mr-2 opacity-70"></i> Espace Client
                                                </a>
                                                @if($user->role == 'partner')
                                                <a href="{{ route('HomePartenaie') }}" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <i class="fas fa-briefcase mr-2 opacity-70"></i> Espace Partenaire
                                                </a>
                                                @endif
                                                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($user->role == 'client')
                            <div id="partnerAcceptModal" class="fixed inset-0 z-[60] hidden overflow-y-auto items-center justify-center" style="background: rgba(0, 0, 0, 0.6)" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden max-w-2xl w-full p-6 m-4">
                                    <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                            Devenir Partenaire Campshare
                                        </h3>
                                        <button id="closePartnerModalBtn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" aria-label="Fermer">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                    <div class="mt-4 mb-6 max-h-[60vh] overflow-y-auto px-1">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            En devenant partenaire sur <strong>Campshare</strong>, notre plateforme de location d'équipements de camping, vous vous engagez à respecter les points suivants :
                                            <ul class="mt-3 ml-4 list-disc space-y-2 text-sm">
                                                <li><strong>Qualité et Sécurité :</strong> Fournir du matériel de camping conforme à sa description, propre, sécurisé et en parfait état de fonctionnement.</li>
                                                <li><strong>Annonces à Jour :</strong> Maintenir les informations de vos annonces (photos, descriptions, prix, caractéristiques) exactes et actuelles.</li>
                                                <li><strong>Disponibilité :</strong> Gérer avec précision et réactivité le calendrier de disponibilité de votre matériel pour éviter les doubles réservations.</li>
                                                <li><strong>Communication :</strong> Répondre rapidement (idéalement sous 24h) aux demandes de réservation et aux questions des locataires potentiels.</li>
                                                <li><strong>Gestion des Réservations :</strong> Honorer les réservations confirmées. Vous serez notifié par email et via votre espace partenaire lors de l'acceptation d'une réservation par un client.</li>
                                                <li><strong>Préparation et Restitution :</strong> Préparer le matériel loué pour le retrait par le locataire et vérifier son état lors de la restitution.</li>
                                                <li><strong>Respect des Règles :</strong> Vous conformer aux <a href="{{ route('conditions.generales') }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">Conditions Générales Partenaires de Campshare</a>.</li>
                                            </ul>
                                            <br>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                                En cliquant sur 'Accepter et Continuer', vous confirmez avoir lu, compris et accepté ces engagements pour rejoindre la communauté des partenaires Campshare.
                                            </p>
                                        </p>
                                    </div>
                                    <div class="flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 pt-4">
                                        <button type="button" id="cancelPartnerModalBtn" class="cursor-pointer mr-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition duration-150 ease-in-out">
                                            Annuler
                                        </button>
                                        <form method="POST" action="{{ route('devenir_partenaire') }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" id="confirmPartnerBtn" class="cursor-pointer px-4 py-2 bg-forest text-white rounded-md hover:bg-opacity-90 dark:bg-sunlight dark:text-gray-900 dark:hover:bg-opacity-90 transition duration-150 ease-in-out shadow-sm">
                                                Accepter et Continuer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                    @else
                        <div class="flex items-center space-x-4 ml-4">
                            <a href="{{ route('login.form') }}" class="px-4 py-2 font-medium rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Connexion</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 font-medium rounded-md bg-sunlight hover:bg-amber-600 text-white shadow-md transition duration-300">Inscription</a>
                        </div>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-800 pb-4 shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('client.listings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Explorer le matériel</a>
                @auth
                    @php
                        $user = $user ?? Auth::user();
                    @endphp
                    @if($user)
                        @if($user->role == 'client')
                            <button type="button" id="openPartnerModalBtnMobile" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Devenir Partenaire</button>
                        @endif
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-3">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset($user->avatar_url ?? 'images/default-avatar.png') }}" alt="Avatar de {{ $user->username }}" class="h-8 w-8 rounded-full object-cover" />
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800 dark:text-white">{{ $user->username }}</div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </div>
                                <div class="ml-auto flex items-center">
                                    <a href="{{ route('notifications.client.index') }}" class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <i class="fas fa-bell text-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="{{ route('HomeClient.profile') }}#profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                </a>
                                <a href="{{ route('HomeClient') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-tachometer-alt mr-2 opacity-70"></i> Espace Client
                                </a>
                                @if($user->role == 'partner')
                                <a href="{{ route('HomePartenaie') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-briefcase mr-2 opacity-70"></i> Espace Partenaire
                                </a>
                                @endif
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                </a>
                                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="mt-4 flex flex-col space-y-3 px-3">
                        <a href="{{ route('login.form') }}" class="px-4 py-2 font-medium rounded-md text-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 transition duration-300">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 font-medium rounded-md text-center bg-sunlight hover:bg-amber-600 text-white transition duration-300">Inscription</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
    <!-- End Header -->

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