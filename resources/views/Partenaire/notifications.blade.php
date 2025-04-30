<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notifications - CampShare | Louez du matériel de camping entre particuliers</title>
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
        
        /* Custom checkbox */
        .custom-checkbox {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            display: inline-block;
            line-height: 20px;
        }
        
        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .dark .checkmark {
            background-color: #374151;
        }
        
        .custom-checkbox:hover input ~ .checkmark {
            background-color: #ccc;
        }
        
        .dark .custom-checkbox:hover input ~ .checkmark {
            background-color: #4B5563;
        }
        
        .custom-checkbox input:checked ~ .checkmark {
            background-color: #2D5F2B;
        }
        
        .dark .custom-checkbox input:checked ~ .checkmark {
            background-color: #4F7942;
        }
        
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }
        
        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }
        
        .custom-checkbox .checkmark:after {
            left: 8px;
            top: 4px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
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
        
        /* Notification items hover */
        .notification-item {
            transition: all 0.2s ease;
        }
        
        .notification-item:hover {
            background-color: rgba(249, 250, 251, 0.8);
        }
        
        .dark .notification-item:hover {
            background-color: rgba(55, 65, 81, 0.3);
        }
        
        /* Notification item animation */
        .notification-item.new {
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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

    <!-- Main content -->
    <main class="flex-1 pt-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header with breadcrumbs -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <nav class="flex mb-3" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="dashboard.html" class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">
                                        <i class="fas fa-home mr-2"></i>
                                        Tableau de bord
                                    </a>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-300">Notifications</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Toutes les notifications</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Consultez et gérez toutes vos notifications</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0 flex space-x-2">
                        <button id="mark-all-read" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-check-double mr-2"></i>
                            Tout marquer comme lu
                        </button>
                        <button id="delete-selected" class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Supprimer sélection
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Notifications container -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
                <!-- Filters -->
                <div class="border-b border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center space-x-2">
                            <label class="custom-checkbox text-sm font-medium text-gray-700 dark:text-gray-300">
                                <input type="checkbox" id="select-all">
                                <span class="checkmark"></span>
                                Tout sélectionner
                            </label>
                            
                            <span class="text-gray-400 dark:text-gray-500 mx-1">|</span>
                            
                            <div id="notification-counter" class="text-sm text-gray-600 dark:text-gray-400">
                                2 non lues
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <label for="filter-select" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Filtrer par:</label>
                            <select id="filter-select" class="py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow">
                                <option value="all">Toutes les notifications</option>
                                <option value="unread">Non lues</option>
                                <option value="reservation">Réservations</option>
                                <option value="payment">Paiements</option>
                                <option value="message">Messages</option>
                                <option value="promo">Promotions</option>
                            </select>
                            
                            <label for="sort-select" class="text-sm font-medium text-gray-700 dark:text-gray-300 ml-4 mr-2">Trier par:</label>
                            <select id="sort-select" class="py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow">
                                <option value="newest">Plus récentes</option>
                                <option value="oldest">Plus anciennes</option>
                                <option value="important">Importantes d'abord</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications list -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[600px] overflow-y-auto" id="notifications-list">
                    <!-- Notification 1 - Unread, Reservation -->
                    {{-- <div class="notification-item flex p-5 bg-blue-50 dark:bg-blue-900/20" data-type="reservation" data-read="false" data-date="2023-08-01T10:30:00">
                        <div class="flex-shrink-0 self-start pt-1">
                            <label class="custom-checkbox">
                                <input type="checkbox" class="notification-checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        
                        <div class="flex flex-1 ml-3">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center text-blue-500 dark:text-blue-300">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white flex items-center">
                                        Réservation confirmée
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-300">
                                            Réservation
                                        </span>
                                    </h3>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Il y a 1 heure</span>
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-300">
                                    Votre réservation "Grande Tente 6 Personnes" a été confirmée par Omar Tazi pour la période du 5 au 10 août 2023. Vous pouvez contacter le propriétaire pour organiser la récupération du matériel.
                                </p>
                                
                                <div class="mt-3 flex items-center">
                                    <button class="text-sm text-forest dark:text-meadow hover:underline mr-4">
                                        <i class="fas fa-eye mr-1"></i> Voir les détails
                                    </button>
                                    <button class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                        <i class="fas fa-check mr-1"></i> Marquer comme lu
                                    </button>
                                    <button class="text-sm text-red-600 dark:text-red-400 hover:underline ml-auto">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification 2 - Unread, Promotion -->
                    <div class="notification-item flex p-5 bg-blue-50 dark:bg-blue-900/20" data-type="promo" data-read="false" data-date="2023-07-31T16:45:00">
                        <div class="flex-shrink-0 self-start pt-1">
                            <label class="custom-checkbox">
                                <input type="checkbox" class="notification-checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        
                        <div class="flex flex-1 ml-3">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-800 flex items-center justify-center text-indigo-500 dark:text-indigo-300">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white flex items-center">
                                        Offre spéciale été
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 dark:bg-indigo-800 text-indigo-800 dark:text-indigo-300">
                                            Promotion
                                        </span>
                                    </h3>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Il y a 1 jour</span>
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-300">
                                    Profitez de -20% sur votre prochaine location avec le code SUMMER23. Offre valable jusqu'au 15 août pour toute réservation de 3 jours minimum.
                                </p>
                                
                                <div class="mt-3 flex items-center">
                                    <button class="text-sm text-forest dark:text-meadow hover:underline mr-4">
                                        <i class="fas fa-tag mr-1"></i> Utiliser le code
                                    </button>
                                    <button class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                        <i class="fas fa-check mr-1"></i> Marquer comme lu
                                    </button>
                                    <button class="text-sm text-red-600 dark:text-red-400 hover:underline ml-auto">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification 3 - Read, Payment -->
                    <div class="notification-item flex p-5" data-type="payment" data-read="true" data-date="2023-07-30T14:20:00">
                        <div class="flex-shrink-0 self-start pt-1">
                            <label class="custom-checkbox">
                                <input type="checkbox" class="notification-checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        
                        <div class="flex flex-1 ml-3">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800 flex items-center justify-center text-green-500 dark:text-green-300">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white flex items-center">
                                        Paiement effectué
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-300">
                                            Paiement
                                        </span>
                                    </h3>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Il y a 2 jours</span>
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-300">
                                    Votre paiement de 1250 MAD pour "Grande Tente 6 Personnes" a été traité avec succès. Un reçu a été envoyé à votre adresse email.
                                </p>
                                
                                <div class="mt-3 flex items-center">
                                    <button class="text-sm text-forest dark:text-meadow hover:underline mr-4">
                                        <i class="fas fa-file-invoice mr-1"></i> Voir la facture
                                    </button>
                                    <button class="text-sm text-red-600 dark:text-red-400 hover:underline ml-auto">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification 4 - Read, Reservation -->
                    <div class="notification-item flex p-5" data-type="reservation" data-read="true" data-date="2023-07-30T09:15:00">
                        <div class="flex-shrink-0 self-start pt-1">
                            <label class="custom-checkbox">
                                <input type="checkbox" class="notification-checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        
                        <div class="flex flex-1 ml-3">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-800 flex items-center justify-center text-amber-500 dark:text-amber-300">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white flex items-center">
                                        Nouvelle réservation
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 dark:bg-amber-800 text-amber-800 dark:text-amber-300">
                                            Réservation
                                        </span>
                                    </h3>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Il y a 2 jours</span>
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-300">
                                    Vous avez réservé "Réchaud Camping + Kit Cuisine" auprès de Salma Benani pour la période du 15 au 18 août 2023. En attente de confirmation du propriétaire.
                                </p>
                                
                                <div class="mt-3 flex items-center">
                                    <button class="text-sm text-forest dark:text-meadow hover:underline mr-4">
                                        <i class="fas fa-eye mr-1"></i> Voir les détails
                                    </button>
                                    <button class="text-sm text-red-600 dark:text-red-400 hover:underline ml-auto">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notification 5 - Read, Message -->
                    <div class="notification-item flex p-5" data-type="message" data-read="true" data-date="2023-07-29T11:30:00">
                        <div class="flex-shrink-0 self-start pt-1">
                            <label class="custom-checkbox">
                                <input type="checkbox" class="notification-checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        
                        <div class="flex flex-1 ml-3">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-800 flex items-center justify-center text-purple-500 dark:text-purple-300">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white flex items-center">
                                        Nouveau message
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-300">
                                            Message
                                        </span>
                                    </h3>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Il y a 3 jours</span>
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-300">
                                    Omar Tazi vous a envoyé un message concernant votre réservation "Grande Tente 6 Personnes".
                                </p>
                                
                                <div class="mt-3 flex items-center">
                                    <button class="text-sm text-forest dark:text-meadow hover:underline mr-4">
                                        <i class="fas fa-reply mr-1"></i> Répondre
                                    </button>
                                    <button class="text-sm text-red-600 dark:text-red-400 hover:underline ml-auto">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    
                    <!-- Notification 6 - Read, System -->
                    @foreach ( $notifications as $notification)
                        
                    
                    <div class="notification-item flex p-5" data-type="system" data-read="true" data-date="2023-07-25T08:45:00">
                        <div class="flex-shrink-0 self-start pt-1">
                            <label class="custom-checkbox">
                                <input type="checkbox" class="notification-checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        
                        <div class="flex flex-1 ml-3">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white flex items-center">
                                        Bienvenue sur CampShare
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                            Système
                                        </span>
                                    </h3>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Il y a 1 semaine</span>
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ $notification->message }}
                                </p>
                                
                                <div class="mt-3 flex items-center">
                                    <button class="text-sm text-forest dark:text-meadow hover:underline mr-4">
                                        <i class="fas fa-book mr-1"></i> Guide d'utilisation
                                    </button>
                                    <button class="text-sm text-red-600 dark:text-red-400 hover:underline ml-auto">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-5 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Affichage de <span class="font-medium">1-6</span> sur <span class="font-medium">16</span> notifications
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <button class="px-3 py-1 rounded-md bg-forest text-white font-medium">
                            1
                        </button>
                        
                        <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            2
                        </button>
                        
                        <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            3
                        </button>
                        
                        <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>


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
        
        // Hide dropdown when clicking outside
        document.addEventListener('click', (e) => {
            // User dropdown
            if (userMenuButton && !userMenuButton.contains(e.target) && userDropdown && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
        
        // Select all notifications toggle
        const selectAllCheckbox = document.getElementById('select-all');
        const notificationCheckboxes = document.querySelectorAll('.notification-checkbox');
        
        selectAllCheckbox?.addEventListener('change', () => {
            notificationCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
        
        // Mark all as read
        const markAllReadButton = document.getElementById('mark-all-read');
        
        markAllReadButton?.addEventListener('click', () => {
            const unreadItems = document.querySelectorAll('.notification-item[data-read="false"]');
            
            unreadItems.forEach(item => {
                item.setAttribute('data-read', 'true');
                item.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
            });
            
            document.getElementById('notification-counter').textContent = '0 non lues';
        });
        
        // Delete selected notifications
        const deleteSelectedButton = document.getElementById('delete-selected');
        
        deleteSelectedButton?.addEventListener('click', () => {
            const selectedCheckboxes = document.querySelectorAll('.notification-checkbox:checked');
            
            selectedCheckboxes.forEach(checkbox => {
                const notificationItem = checkbox.closest('.notification-item');
                if (notificationItem) {
                    notificationItem.remove();
                }
            });
            
            // Update counter and select all checkbox state
            updateNotificationCounter();
            selectAllCheckbox.checked = false;
        });
        
        // Mark individual notification as read
        document.querySelectorAll('.notification-item').forEach(item => {
            const markAsReadButton = item.querySelector('button:nth-of-type(2)');
            
            if (markAsReadButton && item.getAttribute('data-read') === 'false') {
                markAsReadButton.addEventListener('click', () => {
                    item.setAttribute('data-read', 'true');
                    item.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                    updateNotificationCounter();
                });
            }
        });
        
        // Delete individual notification
        document.querySelectorAll('.notification-item').forEach(item => {
            const deleteButton = item.querySelector('button:last-child');
            
            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                    item.remove();
                    updateNotificationCounter();
                });
            }
        });
        
        // Filter notifications
        const filterSelect = document.getElementById('filter-select');
        
        filterSelect?.addEventListener('change', () => {
            const selectedValue = filterSelect.value;
            const notificationItems = document.querySelectorAll('.notification-item');
            
            notificationItems.forEach(item => {
                if (selectedValue === 'all' || item.getAttribute('data-type') === selectedValue) {
                    item.style.display = 'flex';
                } else if (selectedValue === 'unread' && item.getAttribute('data-read') === 'false') {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        
        // Sort notifications
        const sortSelect = document.getElementById('sort-select');
        const notificationsList = document.getElementById('notifications-list');
        
        sortSelect?.addEventListener('change', () => {
            const selectedValue = sortSelect.value;
            const notificationItems = Array.from(document.querySelectorAll('.notification-item'));
            
            // Sort based on selected option
            notificationItems.sort((a, b) => {
                const dateA = new Date(a.getAttribute('data-date'));
                const dateB = new Date(b.getAttribute('data-date'));
                
                if (selectedValue === 'oldest') {
                    return dateA - dateB;
                } else if (selectedValue === 'newest') {
                    return dateB - dateA;
                } else if (selectedValue === 'important') {
                    // For "important" sort, prioritize unread items, then by date (newest first)
                    const readA = a.getAttribute('data-read') === 'true';
                    const readB = b.getAttribute('data-read') === 'true';
                    
                    if (readA !== readB) {
                        return readA ? 1 : -1;
                    } else {
                        return dateB - dateA;
                    }
                }
            });
            
            // Re-append sorted items
            notificationItems.forEach(item => {
                notificationsList.appendChild(item);
            });
        });
        
        // Helper function to update notification counter
        function updateNotificationCounter() {
            const unreadCount = document.querySelectorAll('.notification-item[data-read="false"]').length;
            document.getElementById('notification-counter').textContent = ${unreadCount} non lues;
        }
    </script>
</body>
</html>