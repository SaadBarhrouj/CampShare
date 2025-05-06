<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Partenaire - CampShare | Louez du matériel de camping entre particuliers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'forest': '#2D5F2B',
                        'meadow': '#4F7942',
                        'earth': '#8B7355',
                        'wood': '#D2B48C',
                        'sky': '#5D9ECE',
                        'water': '#1E7FCB',
                        'sunlight': '#FFAA33',
                    }
                }
            },
            darkMode: 'class',
        }

        // Detect dark mode preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (event.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Navigation hover effects */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: currentColor;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Active link style */
        .active-nav-link {
            position: relative;
        }
        
        .active-nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #FFAA33;
        }
        
        /* Input styles */
        .custom-input {
            transition: all 0.3s ease;
            border-width: 2px;
        }
        
        .custom-input:focus {
            box-shadow: 0 0 0 3px rgba(45, 95, 43, 0.2);
        }
        
        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-switch .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        .toggle-switch input:checked + .slider {
            background-color: #2D5F2B;
        }
        
        .dark .toggle-switch input:checked + .slider {
            background-color: #4F7942;
        }
        
        .toggle-switch input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        /* Sidebar active */
        .sidebar-link.active {
            background-color: rgba(45, 95, 43, 0.1);
            color: #2D5F2B;
            border-left: 4px solid #2D5F2B;
        }
        
        .dark .sidebar-link.active {
            background-color: rgba(79, 121, 66, 0.2);
            color: #4F7942;
            border-left: 4px solid #4F7942;
        }
        
        /* Equipment card hover effect */
        .equipment-card {
            transition: all 0.3s ease;
        }
        
        .equipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Chat styles */
        .chat-container {
            max-height: 400px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        
        .chat-message {
            margin-bottom: 15px;
            display: flex;
        }
        
        .chat-message.outgoing {
            justify-content: flex-end;
        }
        
        .chat-bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 80%;
        }
        
        .chat-message.incoming .chat-bubble {
            background-color: #f3f4f6;
            border-bottom-left-radius: 5px;
        }
        
        .dark .chat-message.incoming .chat-bubble {
            background-color: #374151;
        }
        
        .chat-message.outgoing .chat-bubble {
            background-color: #2D5F2B;
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .dark .chat-message.outgoing .chat-bubble {
            background-color: #4F7942;
        }

        /* Styles pour les boutons principaux - action buttons */
        button[type="submit"],
        a.inline-flex,
        button.px-4.py-2,
        button.px-6.py-2,
        .w-full.md\\:w-auto.px-4.py-2,
        button.inline-flex {
            background-color: #2D5F2B !important; /* forest color */
            color: white !important;
            transition: all 0.3s ease;
        }
        
        /* Exceptions pour les boutons retour/annuler */
        button[id^="back-to-step"],
        button[onclick="toggleEditMode(false)"] {
            background-color: white !important;
            color: #374151 !important;
            border: 1px solid #D1D5DB !important;
        }
        
        /* Hover state for action buttons */
        button[type="submit"]:hover,
        a.inline-flex:hover,
        button.px-4.py-2:hover,
        button.px-6.py-2:hover,
        .w-full.md\\:w-auto.px-4.py-2:hover,
        button.inline-flex:hover {
            background-color: #215A1A !important; /* darker forest */
        }


    </style>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <!-- Logo -->
                    <a href="index.html" class="flex items-center">
                        <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/Client" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Espace Client</a>
                    
                    <!-- User menu -->
                    <div class="relative ml-4">
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button id="notifications-button" class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                    <i class="fas fa-bell"></i>
                                    <span class="notification-badge">3</span>
                                </button>
                                
                                <!-- Notifications dropdown -->
                                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                            <a href="#" class="text-sm text-forest dark:text-meadow hover:underline">Marquer tout comme lu</a>
                                        </div>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @foreach($notifications as $notification)
                                        <a href="#" class="block px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                            <div class="flex">
                                                <div class="flex-shrink-0 mr-3">
                                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center text-blue-500 dark:text-blue-300">
                                                        <i class="fas fa-shopping-bag"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Nouvelle demande de location</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $notification->message }}</p>
                                                    {{-- <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Il y a 23 minutes</p> --}}                                                </div>
                                            </div>
                                        </a>
                                        @endforeach

                                    </div>
                                    <div class="p-3 text-center border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('notifications.partner.index') }}" class="text-sm font-medium text-forest dark:text-meadow hover:underline">
                                            Voir toutes les notifications
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- User profile menu -->
                            <div class="relative">
                                <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                    <img src="{{$user->avatar_url}}" 
                                         alt="{{$user->username}}" 
                                         class="h-8 w-8 rounded-full object-cover" />
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $user->username }}</span>
                                    <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                </button>
                                
                                <!-- User dropdown menu -->
                                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600">
                                    <div class="py-1">
                                        <a href="#profile_partenaire"  data-target="profile" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                        </a>

                                        <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                        <a href="#logout" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <a href="#comment-ca-marche" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Comment ça marche ?</a>
                <a href="annonces.html" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Explorer le matériel</a>
                <a href="/Client" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Espace Client</a>
            </div>
            
            <!-- Mobile profile menu -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-3">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                             alt="Fatima Benali" 
                             class="h-10 w-10 rounded-full" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-900 dark:text-white">{{ $user->username }}</div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $user->username }}</div>
                    </div>
                    <div class="ml-auto flex items-center space-x-4">
                        <button class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <button class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-envelope text-lg"></i>
                            <span class="notification-badge">2</span>
                        </button>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                        <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                    </a>
                    <a href="#account-settings" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                        <i class="fas fa-cog mr-2 opacity-70"></i> Paramètres
                    </a>
                    <a href="#public-profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                        <i class="fas fa-eye mr-2 opacity-70"></i> Voir mon profil public
                    </a>
                    <a href="#logout" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                        <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="flex flex-col md:flex-row pt-16">



     <!-- Sidebar (hidden on mobile) -->
        <aside class="hidden md:block w-64 bg-white dark:bg-gray-800 shadow-md h-screen fixed overflow-y-auto">
            <div class="p-5">
                <div class="mb-6 px-3 flex flex-col items-center">
                    <div class="relative">
                        <img src="{{$user->avatar_url}}"  
                             alt=src="{{$user->username}}"  
                             class="w-24 h-24 rounded-full border-4 border-forest dark:border-meadow object-cover" />
                        <div class="absolute bottom-1 right-1 bg-green-500 p-1 rounded-full border-2 border-white dark:border-gray-800">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-4">{{ $user->username }}</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Partenaire depuis 2021</div>
                    <div class="flex items-center mt-2">
                    @php
                        $rating = $AverageRating;  
                        $fullStars = floor($rating); 
                        $halfStar = $rating - $fullStars !=0
                    @endphp

                        <div class="flex text-amber-400">
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
    
                        @if ($halfStar)
                            <i class="fas fa-star-half-alt"></i>
                        @endif
                        </div>
                        <span class="ml-1 text-gray-600 dark:text-gray-400 text-sm">{{ $AverageRating }}</span>
                    </div>
                </div>
                
                <nav class="mt-6 space-y-1">
                    <a href="#dashboard" data-target="dashboard" class="sidebar-link active flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Tableau de bord
                    </a>
                    <a href="#equipment" data-target="AllMyEquipement" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-campground w-5 mr-3"></i>
                        Mes équipements
                    </a>
                    <a href="#annonces" data-target="MesAnnonces" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-bullhorn w-5 mr-3"></i>
                        Mes annonces
                    </a>
                    <a href="#rental-requests" data-target="AllMyReservation" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-clipboard-list w-5 mr-3"></i>
                        Demandes de location
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{$NumberPendingReservation}}</span>
                    </a>
                    <a href="#current-rentals" data-target="LocationsEncours" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-exchange-alt w-5 mr-3"></i>
                        Locations en cours
                        <span class="ml-auto bg-blue-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{$NumberLocationsEncours}}</span>
                    </a>
                    
                 
                    <a href="#reviews" data-target="AvisRecu" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-star w-5 mr-3"></i>
                        Avis reçus
                    </a>
                </nav>
                <div class="mt-6 px-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-300">
                            <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Mobile sidebar toggle -->
        <div id="mobile-sidebar-overlay" class="md:hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden"></div>
        
        <div class="md:hidden fixed bottom-4 right-4 z-50">
            <button id="mobile-sidebar-toggle" class="w-14 h-14 rounded-full bg-forest text-white shadow-lg flex items-center justify-center">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        
        <div id="mobile-sidebar" class="md:hidden fixed inset-y-0 left-0 transform -translate-x-full w-64 bg-white dark:bg-gray-800 shadow-xl z-50 transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Mon compte</h2>
                    <button id="close-mobile-sidebar" class="text-gray-600 dark:text-gray-400 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mb-6 px-3 flex flex-col items-center">
                    <div class="relative">
                        <img src="{{$user->avatar_url}}"  
                             alt="{{$user->username}}"  
                             class="w-20 h-20 rounded-full border-4 border-forest dark:border-meadow object-cover" />
                        <div class="absolute bottom-1 right-1 bg-green-500 p-1 rounded-full border-2 border-white dark:border-gray-800">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mt-3">{{$user->username}}</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Partenaire depuis 2021</div>
                    <div class="flex items-center mt-1">
                        <div class="flex text-amber-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="ml-1 text-gray-600 dark:text-gray-400 text-sm">4.8</span>
                    </div>
                </div>
                
                <nav class="mt-6 space-y-1">
                    <a href="#dashboard" class="sidebar-link active flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Tableau de bord
                    </a>
                    <a href="#equipment" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-campground w-5 mr-3"></i>
                        Mes équipements
                    </a>
                    <a href="#annonces" data-target="MesAnnonces" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-bullhorn w-5 mr-3"></i>
                        Mes annonces
                    </a>
                    <a href="#rental-requests" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-clipboard-list w-5 mr-3"></i>
                        Demandes de location
                        <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </a>
                    <a href="#current-rentals" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-exchange-alt w-5 mr-3"></i>
                        Locations en cours
                        <span class="ml-auto bg-blue-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
                    </a>
                    <a href="#my-reservations" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        Mes réservations
                        <span class="ml-auto bg-purple-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
                    </a>
                
                    <a href="#reviews" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-star w-5 mr-3"></i>
                        Avis reçus
                    </a>
                    <a href="#calendar" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-calendar-alt w-5 mr-3"></i>
                        Calendrier
                    </a>
                    <a href="#analytics" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-chart-line w-5 mr-3"></i>
                        Statistiques
                    </a>
                    <a href="#settings" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Paramètres
                    </a>
                    <a href="#help" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-question-circle w-5 mr-3"></i>
                        Aide & Support
                    </a>
                </nav>
            </div>
        </div>
        <div id="dashboard" class="component ">
            @include ('Partenaire.Components.dashboard');
        </div>
        </div>

        <div id="AllMyReservation" class="component hidden">
            @include ('Partenaire.Components.toutes-les-demandes');
        </div>
        <div id="AllMyEquipement" class="component hidden">
            @include ('Partenaire.Components.toutes-les-equipement');
        </div>
        <div id="LocationsEncours" class="component hidden">
            @include ('Partenaire.Components.Reservation-En-cours');
        </div>
        <div id="AvisRecu" class="component hidden">
            @include ('Partenaire.Components.avis-recus');
        </div>
        <div id="profile" class="component hidden">
            @include ('Partenaire.Components.Profile');
        </div>
        <div id="MesAnnonces" class="component hidden">
            @include ('Partenaire.Components.mes-annonces');
        </div>


</body>
<script>
  const links = document.querySelectorAll(".sidebar-link");
  const components = document.querySelectorAll(".component");

  links.forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = link.getAttribute("data-target");
      
      // Ne rien faire si data-target n'est pas défini (cas du lien "Mes annonces")
      if (!targetId) return;

      // Supprimer active class de tous les liens
      links.forEach(l => l.classList.remove("active"));
      // Ajouter active class au lien cliqué
      link.classList.add("active");

      // Cacher tous les composants
      components.forEach(comp => {
        comp.classList.add("hidden");
      });

      // Afficher le composant cible
      document.getElementById(targetId).classList.remove("hidden");
      
      // Fermer le menu mobile si ouvert
      if (window.innerWidth < 768) {
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        if (mobileSidebar && mobileSidebarOverlay) {
          mobileSidebar.classList.add('transform', '-translate-x-full');
          mobileSidebarOverlay.classList.add('hidden');
        }
      }
    });
  });
</script>

</html>