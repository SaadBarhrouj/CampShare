<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Client - CampShare | Louez du matériel de camping entre particuliers</title>
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
                        <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#comment-ca-marche" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Comment ça marche ?</a>
                    <a href="annonces.html" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Explorer le matériel</a>
                    <a href="#trouver-equipement" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Trouver du matériel</a>
                    
                    <!-- User menu -->
                    <div class="relative ml-4">
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button id="notifications-button" class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                    <i class="fas fa-bell"></i>
                                    <span class="notification-badge">2</span>
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
                                        <!-- Notification items -->
                                        <a href="#" class="block px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                            <div class="flex">
                                                <div class="flex-shrink-0 mr-3">
                                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center text-blue-500 dark:text-blue-300">
                                                        <i class="fas fa-calendar-check"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Réservation confirmée</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Votre réservation "Grande Tente 6 Personnes" a été confirmée</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Il y a 1 heure</p>
                                                </div>
                                            </div>
                                        </a>
                                        
                                        <a href="#" class="block px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                            <div class="flex">
                                                <div class="flex-shrink-0 mr-3">
                                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-800 flex items-center justify-center text-indigo-500 dark:text-indigo-300">
                                                        <i class="fas fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Offre spéciale</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">-20% sur votre prochaine location avec le code SUMMER23</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Il y a 1 jour</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="p-3 text-center border-t border-gray-200 dark:border-gray-700">
                                        <a href="#all-notifications" class="text-sm font-medium text-forest dark:text-meadow hover:underline">Voir toutes les notifications</a>
                                    </div>
                                </div>
                            </div>
                            <!-- User profile menu -->
                            <div class="relative">
                                <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                    <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                                         alt="Fatima Benali" 
                                         class="h-8 w-8 rounded-full object-cover" />
                                    <span class="font-medium text-gray-800 dark:text-gray-200">Fatima</span>
                                    <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                </button>
                                
                                <!-- User dropdown menu -->
                                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600">
                                    <div class="py-1">
                                        <a href="#profile" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                        </a>
                                        <a href="#account-settings" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-cog mr-2 opacity-70"></i> Paramètres
                                        </a>
                                        <a href="#favorites" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-heart mr-2 opacity-70"></i> Mes favoris
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
                <a href="#trouver-equipement" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Trouver du matériel</a>
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
                        <div class="text-base font-medium text-gray-800 dark:text-white">Fatima Benali</div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">fatima.benali@example.com</div>
                    </div>
                    <div class="ml-auto flex items-center space-x-4">
                        <button class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="notification-badge">2</span>
                        </button>
                        <button class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-envelope text-lg"></i>
                            <span class="notification-badge">1</span>
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
                    <a href="#favorites" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                        <i class="fas fa-heart mr-2 opacity-70"></i> Mes favoris
                    </a>
                    <a href="#logout" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                        <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard container -->
    <div class="flex flex-col md:flex-row pt-16">
        <!-- Sidebar (hidden on mobile) -->
        <aside class="hidden md:block w-64 bg-white dark:bg-gray-800 shadow-md h-screen fixed overflow-y-auto">
            <div class="p-5">
                <div class="mb-6 px-3 flex flex-col items-center">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                             alt="Fatima Benali" 
                             class="w-24 h-24 rounded-full border-4 border-forest dark:border-meadow object-cover" />
                        <div class="absolute bottom-1 right-1 bg-green-500 p-1 rounded-full border-2 border-white dark:border-gray-800">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-4">Fatima Benali</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Membre depuis 2021</div>
                </div>
                
                <nav class="mt-6 space-y-1">
                    <a href="#dashboard" class="sidebar-link active flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Tableau de bord
                    </a>
                    <a href="#my-reservations" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        Mes réservations
                        <span class="ml-auto bg-purple-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
                    </a>
                    <a href="#reviews" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-star w-5 mr-3"></i>
                        Mes avis
                    </a>
                    <a href="#my-favorites" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-heart w-5 mr-3"></i>
                        Mes favoris
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
                
                <div class="mt-8 px-4 py-5 bg-forest dark:bg-meadow bg-opacity-10 dark:bg-opacity-10 rounded-lg">
                    <h3 class="text-forest dark:text-meadow font-medium mb-2">Parrainez vos amis</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Recevez 15% de réduction sur votre prochaine location en parrainant un ami.</p>
                    <a href="#refer-friend" class="inline-flex items-center px-3 py-1.5 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white text-sm rounded-md transition-colors">
                        Parrainer maintenant
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
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
                        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                             alt="Fatima Benali" 
                             class="w-20 h-20 rounded-full border-4 border-forest dark:border-meadow object-cover" />
                        <div class="absolute bottom-1 right-1 bg-green-500 p-1 rounded-full border-2 border-white dark:border-gray-800">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Fatima Benali</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Membre depuis 2021</div>
                </div>
                
                <nav class="mt-6 space-y-1">
                    <a href="#dashboard" class="sidebar-link active flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Tableau de bord
                    </a>
                    <a href="#my-reservations" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        Mes réservations
                        <span class="ml-auto bg-purple-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
                    </a>
                    <a href="#upcoming-trips" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-hiking w-5 mr-3"></i>
                        Mes voyages à venir
                        <span class="ml-auto bg-blue-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">1</span>
                    </a>
                    <a href="#past-trips" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-history w-5 mr-3"></i>
                        Historique des voyages
                    </a>
                    <a href="#messages" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-comments w-5 mr-3"></i>
                        Messages
                        <span class="ml-auto bg-green-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">1</span>
                    </a>
                    <a href="#reviews" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-star w-5 mr-3"></i>
                        Mes avis
                    </a>
                    <a href="#my-favorites" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-heart w-5 mr-3"></i>
                        Mes favoris
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
        
        <!-- Main content -->
        <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Dashboard header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Tableau de bord</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Bienvenue, Fatima ! Voici un résumé de vos réservations.</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <a href="annonces.html" class="inline-flex items-center px-4 py-2 bg-forest hover:bg-green-700 text-white rounded-md shadow-sm transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Trouver du matériel
                        </a>
                    </div>
                </div>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Stats card 1 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                                <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Réservations à venir</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">2</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center mt-1">
                                    Prochaine: <span class="text-forest dark:text-meadow ml-1">5 - 10 Août</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                                <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Dépenses du mois</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">1 700 MAD</h3>
                                <p class="text-green-600 dark:text-green-400 text-sm flex items-center mt-1">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    15% <span class="text-gray-500 dark:text-gray-400 ml-1">vs mois dernier</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 3 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                                <i class="fas fa-campground text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Voyages réalisés</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">3</h3>
                                <p class="text-purple-600 dark:text-purple-400 text-sm flex items-center mt-1">
                                    <i class="fas fa-plus mr-1"></i>
                                    <span class="text-gray-500 dark:text-gray-400">1 voyage ce mois-ci</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- My reservations section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Mes réservations</h2>
                        <a href="#all-reservations" class="text-forest dark:text-meadow hover:underline text-sm font-medium">
                            Voir toutes mes réservations
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Reservation 1 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                            <div class="relative h-40">
                                <img src="https://images.unsplash.com/photo-1530541930197-ff16ac917b0e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Grande Tente 6 Personnes" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">Confirmée</span>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg truncate">Grande Tente 6 Personnes</h3>
                                    <p class="text-gray-200 text-sm">Quechua - Comme Neuf</p>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <div class="flex items-start mb-4">
                                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                         alt="Omar Tazi" 
                                         class="w-8 h-8 rounded-full object-cover mr-3" />
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Omar Tazi</p>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span>4.9 <span class="text-gray-500 dark:text-gray-400">(26 avis)</span></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded p-3 mb-4">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Dates:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">5 - 10 Août 2023</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Prix:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">250 MAD/jour</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">1 250 MAD (5 jours)</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex-1">
                                        <i class="fas fa-calendar-alt mr-2"></i> Modifier
                                    </button>
                                    <button class="px-3 py-1.5 border border-red-300 dark:border-red-800 text-red-700 dark:text-red-400 text-sm rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex-1">
                                        <i class="fas fa-times mr-2"></i> Annuler
                                    </button>
                                    <button class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                        <i class="fas fa-comment-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Reservation 2 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                            <div class="relative h-40">
                                <img src="https://images.unsplash.com/photo-1510312305653-8ed496efae75?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Réchaud Camping + Kit Cuisine" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-amber-500 text-white text-xs px-2 py-1 rounded-full">En attente</span>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg truncate">Réchaud Camping + Kit Cuisine</h3>
                                    <p class="text-gray-200 text-sm">Coleman - Bon état</p>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <div class="flex items-start mb-4">
                                    <img src="https://images.unsplash.com/photo-1548544149-4835e62ee5b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                         alt="Salma Benani" 
                                         class="w-8 h-8 rounded-full object-cover mr-3" />
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Salma Benani</p>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span>4.7 <span class="text-gray-500 dark:text-gray-400">(18 avis)</span></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded p-3 mb-4">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Dates:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">15 - 18 Août 2023</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Prix:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">150 MAD/jour</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">450 MAD (3 jours)</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <button class="px-3 py-1.5 border border-red-300 dark:border-red-800 text-red-700 dark:text-red-400 text-sm rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex-1">
                                        <i class="fas fa-times mr-2"></i> Annuler
                                    </button>
                                    <button class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors flex-1">
                                        <i class="fas fa-comment-alt mr-2"></i> Contacter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent activity -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Activité récente</h2>
                        <a href="#all-activity" class="text-forest dark:text-meadow hover:underline text-sm font-medium">
                            Voir toute l'activité
                        </a>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center">
                                            <i class="fas fa-calendar-check text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            Réservation confirmée
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            Omar Tazi a confirmé votre réservation "Grande Tente 6 Personnes"
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                            Il y a 1 heure
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-800 flex items-center justify-center">
                                            <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            Paiement effectué
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            Vous avez payé 1250 MAD pour "Grande Tente 6 Personnes"
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                            Il y a 2 heures
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-800 flex items-center justify-center">
                                            <i class="fas fa-shopping-cart text-amber-600 dark:text-amber-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            Nouvelle réservation
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            Vous avez réservé "Réchaud Camping + Kit Cuisine" auprès de Salma Benani
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                            Il y a 1 jour
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-800 flex items-center justify-center">
                                            <i class="fas fa-search text-indigo-600 dark:text-indigo-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            Recherche effectuée
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            Vous avez recherché "matériel camping Agadir" pour 15-18 août
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                            Il y a 2 jours
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Equipment recommendations -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Équipements recommandés</h2>
                        <a href="#all-recommendations" class="text-forest dark:text-meadow hover:underline text-sm font-medium">
                            Voir plus de recommandations
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Recommendation 1 -->
                        <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Pack Camping Complet 2p" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute top-4 right-4">
                                    <button class="p-2 bg-white bg-opacity-80 dark:bg-gray-900 dark:bg-opacity-80 rounded-full text-amber-400 hover:text-amber-500 dark:hover:text-amber-300 transition-colors focus:outline-none">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg truncate">Pack Camping Complet 2p</h3>
                                    <p class="text-gray-200 text-sm">MSR - Excellent état</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <div>
                                        <span class="font-bold text-lg text-gray-900 dark:text-white">450 MAD</span>
                                        <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                        <span>4.8 <span class="text-gray-500 dark:text-gray-400">(18)</span></span>
                                    </div>
                                </div>
                                
                                <div class="text-sm mb-3">
                                    <span class="text-gray-600 dark:text-gray-300">Dispo. du 1 août au 1 oct.</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-medium text-purple-600 dark:text-purple-400">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Marrakech
                                        </span>
                                    </div>
                                    <a href="#view-details" class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                        Voir les détails
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recommendation 2 -->
                        <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1520100504277-3c63ebf5c2c6?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Sacs de couchage ultra confort" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute top-4 right-4">
                                    <button class="p-2 bg-white bg-opacity-80 dark:bg-gray-900 dark:bg-opacity-80 rounded-full text-amber-400 hover:text-amber-500 dark:hover:text-amber-300 transition-colors focus:outline-none">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg truncate">Sacs de Couchage Ultra Confort</h3>
                                    <p class="text-gray-200 text-sm">Therm-a-Rest - Bon état</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <div>
                                        <span class="font-bold text-lg text-gray-900 dark:text-white">150 MAD</span>
                                        <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                        <span>4.7 <span class="text-gray-500 dark:text-gray-400">(12)</span></span>
                                    </div>
                                </div>
                                
                                <div class="text-sm mb-3">
                                    <span class="text-gray-600 dark:text-gray-300">Dispo. du 5 août au 15 sept.</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-medium text-blue-600 dark:text-blue-400">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Agadir
                                        </span>
                                    </div>
                                    <a href="#view-details" class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                        Voir les détails
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recommendation 3 -->
                        <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1474044159687-1ee9f3a51722?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Matelas gonflable" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute top-4 right-4">
                                    <button class="p-2 bg-white bg-opacity-80 dark:bg-gray-900 dark:bg-opacity-80 rounded-full text-amber-400 hover:text-amber-500 dark:hover:text-amber-300 transition-colors focus:outline-none">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg truncate">Matelas Gonflable Double</h3>
                                    <p class="text-gray-200 text-sm">Intex - Neuf</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <div>
                                        <span class="font-bold text-lg text-gray-900 dark:text-white">120 MAD</span>
                                        <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                        <span>4.9 <span class="text-gray-500 dark:text-gray-400">(6)</span></span>
                                    </div>
                                </div>
                                
                                <div class="text-sm mb-3">
                                    <span class="text-gray-600 dark:text-gray-300">Dispo. du 10 août au 10 oct.</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-medium text-green-600 dark:text-green-400">
                                            <i class="fas fa-map-marker-alt mr-1"></i> Casablanca
                                        </span>
                                    </div>
                                    <a href="#view-details" class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                        Voir les détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Message Modal (hidden by default) -->
    <div id="message-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Omar Tazi" 
                         class="w-10 h-10 rounded-full object-cover mr-3" />
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Omar Tazi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Grande Tente 6 Personnes</p>
                    </div>
                </div>
                <button id="close-message-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-5 overflow-y-auto flex-grow">
                <div class="chat-container">
                    <!-- Message thread -->
                    <div class="chat-message incoming">
                        <div class="chat-bubble">
                            <p class="text-gray-800 dark:text-gray-200">Bonjour Fatima ! Votre réservation a été confirmée. La tente est prête, il faudra juste prévoir des sardines supplémentaires en cas de vent fort.</p>
                            <p class="text-xs text-gray-500 mt-1">11:42 AM</p>
                        </div>
                    </div>
                    
                    <div class="chat-message outgoing">
                        <div class="chat-bubble">
                            <p class="text-white">Bonjour Omar, merci beaucoup pour la confirmation ! Est-ce que je dois apporter des sardines moi-même ou vous en avez quelques-unes en plus ?</p>
                            <p class="text-xs text-gray-300 mt-1">11:48 AM</p>
                        </div>
                    </div>
                    
                    <div class="chat-message incoming">
                        <div class="chat-bubble">
                            <p class="text-gray-800 dark:text-gray-200">J'en ai quelques-unes en plus que je peux vous fournir, mais c'est toujours mieux d'en avoir un peu de rechange. Je préparerai tout pour votre arrivée le 5 août.</p>
                            <p class="text-xs text-gray-500 mt-1">11:53 AM</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <form id="message-form" class="flex items-end">
                    <div class="flex-grow">
                        <textarea id="message-input" placeholder="Tapez votre message..." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-base resize-none custom-input" rows="3"></textarea>
                    </div>
                    <div class="ml-3 flex flex-col space-y-2">
                        <button type="button" class="p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <button type="submit" class="p-2 bg-forest hover:bg-green-700 text-white rounded-md shadow-sm transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // User dropdown toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        
        userMenuButton?.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });
        
        // Notifications dropdown toggle
        const notificationsButton = document.getElementById('notifications-button');
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        
        notificationsButton?.addEventListener('click', () => {
            notificationsDropdown.classList.toggle('hidden');
        });
        
        // Messages dropdown toggle
        const messagesButton = document.getElementById('messages-button');
        const messagesDropdown = document.getElementById('messages-dropdown');
        
        messagesButton?.addEventListener('click', () => {
            messagesDropdown.classList.toggle('hidden');
        });
        
        // Hide dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            // User dropdown
            if (userMenuButton && !userMenuButton.contains(e.target) && userDropdown && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
            
            // Notifications dropdown
            if (notificationsButton && !notificationsButton.contains(e.target) && notificationsDropdown && !notificationsDropdown.contains(e.target)) {
                notificationsDropdown.classList.add('hidden');
            }
            
            // Messages dropdown
            if (messagesButton && !messagesButton.contains(e.target) && messagesDropdown && !messagesDropdown.contains(e.target)) {
                messagesDropdown.classList.add('hidden');
            }
        });
        
        // Mobile sidebar toggle
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const closeMobileSidebar = document.getElementById('close-mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        
        mobileSidebarToggle?.addEventListener('click', () => {
            mobileSidebar.classList.toggle('-translate-x-full');
            mobileSidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        });
        
        closeMobileSidebar?.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        mobileSidebarOverlay?.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Sidebar link active state
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                // Remove active class from all links
                sidebarLinks.forEach(el => el.classList.remove('active'));
                
                // Add active class to clicked link
                link.classList.add('active');
            });
        });
        
        // Message modal
        const messageButtons = document.querySelectorAll('button .fas.fa-comment-alt, .fas.fa-envelope');
        const messageModal = document.getElementById('message-modal');
        const closeMessageModal = document.getElementById('close-message-modal');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        
        messageButtons.forEach(button => {
            button.parentElement.addEventListener('click', (e) => {
                e.preventDefault();
                messageModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                // Scroll to bottom of chat
                const chatContainer = document.querySelector('.chat-container');
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
                // Focus input
                messageInput?.focus();
            });
        });
        
        closeMessageModal?.addEventListener('click', () => {
            messageModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Close modal when clicking outside
        messageModal?.addEventListener('click', (e) => {
            if (e.target === messageModal) {
                messageModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Handle message form submission
        messageForm?.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (message) {
                // Create and append new message
                const chatContainer = document.querySelector('.chat-container');
                const newMessage = document.createElement('div');
                newMessage.className = 'chat-message outgoing';
                
                const now = new Date();
                const hours = now.getHours();
                const minutes = now.getMinutes();
                const timeString = `${hours}:${minutes < 10 ? '0' + minutes : minutes}`;
                
                newMessage.innerHTML = `
                    <div class="chat-bubble">
                        <p class="text-white">${message}</p>
                        <p class="text-xs text-gray-300 mt-1">${timeString}</p>
                    </div>
                `;
                
                chatContainer.appendChild(newMessage);
                messageInput.value = '';
                
                // Scroll to bottom of chat
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });
        
        // Add to favorites functionality
        const heartButtons = document.querySelectorAll('.far.fa-heart');
        
        heartButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                if (button.classList.contains('far')) {
                    button.classList.remove('far');
                    button.classList.add('fas');
                } else {
                    button.classList.remove('fas');
                    button.classList.add('far');
                }
            });
        });
    </script>
</body>
</html>