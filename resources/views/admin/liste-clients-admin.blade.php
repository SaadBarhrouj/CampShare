<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients - CampShare | Administration</title>
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
                        'admin': {
                            'primary': '#1E40AF',
                            'secondary': '#3B82F6',
                            'accent': '#60A5FA',
                            'light': '#DBEAFE',
                            'dark': '#1E3A8A'
                        }
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
        /* Sidebar active */
        .sidebar-link.active {
            background-color: rgba(30, 64, 175, 0.1);
            color: #1E40AF;
            border-left: 4px solid #1E40AF;
        }
        
        .dark .sidebar-link.active {
            background-color: rgba(59, 130, 246, 0.2);
            color: #3B82F6;
            border-left: 4px solid #3B82F6;
        }
        
        /* Custom table styles */
        .admin-table th {
            font-weight: 600;
            text-align: left;
            padding: 0.75rem 1rem;
            background-color: #F3F4F6;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .dark .admin-table th {
            background-color: #374151;
            border-bottom: 1px solid #4B5563;
        }
        
        .admin-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .dark .admin-table td {
            border-bottom: 1px solid #4B5563;
        }
        
        .admin-table tr:hover {
            background-color: #F9FAFB;
        }
        
        .dark .admin-table tr:hover {
            background-color: #1F2937;
        }
        
        /* Badge styles */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.125rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: capitalize;
        }
        
        .badge-success {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .dark .badge-success {
            background-color: rgba(6, 95, 70, 0.2);
            color: #34D399;
        }
        
        .badge-warning {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .dark .badge-warning {
            background-color: rgba(146, 64, 14, 0.2);
            color: #FBBF24;
        }
        
        .badge-danger {
            background-color: #FEE2E2;
            color: #B91C1C;
        }
        
        .dark .badge-danger {
            background-color: rgba(185, 28, 28, 0.2);
            color: #F87171;
        }
        
        .badge-info {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .dark .badge-info {
            background-color: rgba(30, 64, 175, 0.2);
            color: #60A5FA;
        }
        
        .badge-neutral {
            background-color: #F3F4F6;
            color: #4B5563;
        }
        
        .dark .badge-neutral {
            background-color: rgba(75, 85, 99, 0.2);
            color: #9CA3AF;
        }
        
        .badge-blue {
            background-color: #EDE9FE;
            color: #6D28D9;
        }
        
        .dark .badge-blue {
            background-color: rgba(109, 40, 217, 0.2);
            color: #A78BFA;
        }
        
        /* Custom switch toggle */
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
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
        
        .slider:before {
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
        
        input:checked + .slider {
            background-color: #1E40AF;
        }
        
        .dark input:checked + .slider {
            background-color: #3B82F6;
        }
        
        input:focus + .slider {
            box-shadow: 0 0 1px #1E40AF;
        }
        
        input:checked + .slider:before {
            transform: translateX(24px);
        }
        
        /* Filter dropdown */
        .filter-dropdown {
            position: absolute;
            z-index: 10;
            min-width: 12rem;
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            border: 1px solid #E5E7EB;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .dark .filter-dropdown {
            background-color: #1F2937;
            border-color: #4B5563;
        }
        
        .filter-dropdown .option {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            color: #4B5563;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .dark .filter-dropdown .option {
            color: #D1D5DB;
        }
        
        .filter-dropdown .option:hover {
            background-color: #F3F4F6;
        }
        
        .dark .filter-dropdown .option:hover {
            background-color: #374151;
        }
        
        .filter-dropdown .option.active {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .dark .filter-dropdown .option.active {
            background-color: rgba(59, 130, 246, 0.2);
            color: #3B82F6;
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
                    <a href="{{ route('index') }}" class="flex items-center">
                        <span class="text-admin-primary dark:text-admin-secondary text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                        <span class="text-xs ml-2 text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">ADMIN</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">


                    <!-- User menu -->
                    <div class="relative ml-4">
                        <div class="flex items-center space-x-4">
                            


                            @auth
                                @php
                                    $user = $user ?? Auth::user();
                                @endphp
                                @if($user)

                                
                            <!-- User profile menu -->
                                <div class="relative">
                                    <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                        <img src="{{ asset(auth()->user()->avatar_url) }}"
                                         alt="Admin User" 
                                         class="h-8 w-8 rounded-full object-cover" />
                                        <div class="flex flex-col items-start">
                                            <span class="font-medium text-gray-800 dark:text-gray-200 text-sm"> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} </span>
                                            <span
                                                class="text-xs text-admin-primary dark:text-admin-secondary font-medium">
                                                {{ ucfirst(auth()->user()->role) ?? 'Utilisateur' }}
                                            </span>
                                        </div>
                                        <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                    </button>

                                    <!-- User dropdown menu -->
                                    <div id="user-dropdown"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600 py-1">
                                    <a href="{{ route('admin.profile.edit') }}"
                                        class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                            </a>
                                    <div class="border-t border-gray-200 dark:border-gray-700"></div>

                                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>


                            @endif
                            @endauth
                      
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 hover:text-admin-primary dark:hover:text-admin-secondary focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-800 pb-4 shadow-lg">
            <div class="pt-2 pb-3 px-3">
                <!-- Mobile search -->
                <div class="relative mb-3">
                    <input type="text" placeholder="Recherche rapide..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                    </div>
                </div>
            </div>

            <!-- Mobile profile menu -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-3">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Admin User" class="h-10 w-10 rounded-full" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800 dark:text-white">Mohamed Alami</div>
                        <div class="text-sm font-medium text-admin-primary dark:text-admin-secondary">Super Admin</div>
                    </div>
                    <div class="ml-auto flex items-center space-x-4">
                        <button
                            class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-bell text-lg"></i>
                            <span
                                class="absolute -mt-1 -mr-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">5</span>
                        </button>
                        <button
                            class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-cog text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#profile"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                    </a>
                    <a href="#account-settings"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-cog mr-2 opacity-70"></i> Paramètres
                    </a>
                    <a href="#admin-logs"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-history mr-2 opacity-70"></i> Historique d'actions
                    </a>
                    <a href="#logout"
                        class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
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
                <div class="mb-6 px-3">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Menu Principal</h5>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors">
                            <i class="fas fa-tachometer-alt  w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Tableau de bord
                        </a>
                        
                        
                        
                    </nav>
                </div>

                <div class="mb-6 px-3">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Utilisateurs</h5>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.partners') }}"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Partenaires
                            <span
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center"> {{ $partnersCount }} </span>
                        </a>
                        <a href="{{ route('admin.clients') }}"
                            class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Clients
                            <span
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center"> {{ $stats['total'] }}</span>
                        </a>

                    </nav>
                </div>

                <div class="mb-6 px-3">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Equi. Réserv. & Avis</h5>
                    <nav class="space-y-1">
                        <a href="{{ route('equipements.index') }}"
   class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
   <i class="fas fa-campground w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
   Équipements
</a>
                        <a href="{{ route('admin.reservations.index') }}" 
   class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-calendar-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
    Réservations
</a>

                      <a href="{{ route('admin.reviews') }}"
   class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-star w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
    Avis
    <span class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-1.5 flex items-center justify-center">
        {{ \App\Models\Review::count() }}
    </span>
</a>

                    </nav>
                </div>

            </div>
        </aside>
        
        <!-- Mobile sidebar toggle -->
        <div id="mobile-sidebar-overlay" class="md:hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden"></div>
        
        <div class="md:hidden fixed bottom-4 right-4 z-50">
            <button id="mobile-sidebar-toggle" class="w-14 h-14 rounded-full bg-admin-primary dark:bg-admin-secondary text-white shadow-lg flex items-center justify-center">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        
        <div id="mobile-sidebar" class="md:hidden fixed inset-y-0 left-0 transform -translate-x-full w-64 bg-white dark:bg-gray-800 shadow-xl z-50 transition-transform duration-300">
            <!-- Mobile sidebar content (same as desktop) - Abbreviated for brevity -->
        </div>
        
        <!-- Main content -->
        <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Dashboard header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Gestion des Clients</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Liste de tous les clients de la plateforme</p>
                    </div>
                </div>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats card 1 - Total Clients -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-admin-light dark:bg-admin-dark mr-4">
                                <i class="fas fa-user text-admin-primary dark:text-admin-secondary"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Clients</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white"> {{ $stats['total'] }}</h3>
                                    
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    (100% total)
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 2 - Active Clients -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 mr-4">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Clients Actifs</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">232</h3>
                                    
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    (100% par rapport total)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats card 2 - Active Clients -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900/30 mr-4">
                                <i class="fas fa-x text-red-600 dark:text-red-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Clients Inactifs</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">232</h3>
                                    
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    (100% par rapport total)
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                </div>
                
                <!-- Filters and search -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-8 p-5">
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                        <!-- Search bar -->
                       <!-- Search bar -->
<div class="flex-1">
    <form action="{{ route('admin.clients') }}" method="GET">
        <div class="relative">
            <!-- Recherchez cette partie dans votre code -->
<input 
    type="text" 
    name="search" 
    id="client-search" 
    placeholder="Rechercher un client par nom, email ou ville..." 
    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary text-sm"
    value="{{ request('search') }}"
>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
            </div>
        </div>
    </form>
</div>
                        <!-- Status filter -->
                        <div class="relative inline-block text-left" id="status-filter-container">
                            <button id="status-filter-button" class="inline-flex justify-between items-center w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-primary dark:focus:ring-admin-secondary">
                                <span>Statut: Tous</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div id="status-filter-dropdown" class="filter-dropdown right-0 hidden">
                                <div class="option active" data-value="all">Tous les statuts</div>
                                <div class="option" data-value="active">Actifs</div>
                                <div class="option" data-value="inactive">Inactifs</div>
                            </div>
                        </div>
                        
                        <div class="relative inline-block text-left" id="sort-filter-container">
    <button id="sort-filter-button" class="inline-flex justify-between items-center w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-primary dark:focus:ring-admin-secondary">
        <span>
            @switch(request('sort', 'recent'))
                @case('recent') Trier par: Récents @break
                @case('oldest') Trier par: Anciens @break
                @case('name-asc') Trier par: Nom (A-Z) @break
                @case('name-desc') Trier par: Nom (Z-A) @break
                @case('reservation-count') Trier par: Réservations @break
                @default Trier par: Récents
            @endswitch
        </span>
        <i class="fas fa-chevron-down ml-2"></i>
    </button>
    
    <div id="sort-filter-dropdown" class="filter-dropdown right-0 hidden w-full">
        <div class="flex flex-col">
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'recent']) }}" 
               class="option {{ request('sort', 'recent') == 'recent' ? 'active' : '' }} block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                Plus récents
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}" 
               class="option {{ request('sort') == 'oldest' ? 'active' : '' }} block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                Plus anciens
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name-asc']) }}" 
               class="option {{ request('sort') == 'name-asc' ? 'active' : '' }} block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                Nom (A-Z)
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name-desc']) }}" 
               class="option {{ request('sort') == 'name-desc' ? 'active' : '' }} block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                Nom (Z-A)
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'reservation-count']) }}" 
               class="option {{ request('sort') == 'reservation-count' ? 'active' : '' }} block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                Nombre de réservations
            </a>
        </div>
    </div>
</div>
                       
                    </div>
                    
                </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">

                <!-- Clients table -->
                <table class="w-full admin-table">
    <thead>
        <tr>
            <th>Client</th>
            <th>Contact</th>
            <th>Ville</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CIN Recto</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CIN Verso</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <!-- Client avatar et nom -->
            <td>
                <div class="flex items-center">
                    <img src="{{ $client->avatar_url ? asset($client->avatar_url) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $client->username }}" 
                         class="w-10 h-10 rounded-full object-cover mr-3" />
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $client->username }}</p>
                        <div class="flex items-center text-amber-400 dark:text-amber-400 mt-0.5">
                            @php
                                $avgRating = $client->receivedReviews->avg('rating') ?? 0;
                                $fullStars = floor($avgRating);
                                $hasHalfStar = $avgRating - $fullStars >= 0.5;
                            @endphp
                            
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fas fa-star text-xs"></i>
                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                    <i class="fas fa-star-half-alt text-xs"></i>
                                @else
                                    <i class="far fa-star text-xs"></i>
                                @endif
                            @endfor
                            <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">{{ number_format($avgRating, 1) }}</span>
                        </div>
                    </div>
                </div>
            </td>

            <!-- Contact -->
            <td>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $client->email }}</p>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $client->phone_number }}</p>
            </td>

            <!-- Ville -->
            <td>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $client->city->name ?? 'Non spécifié' }}</p>
            </td>

            <!-- CIN Recto -->
           <td class="px-6 py-4">
    <img src="{{ asset($client->cin_recto) }}"
         alt="CIN Recto"
         class="w-12 h-12 object-cover rounded cursor-pointer hover:scale-105 transition">
</td>

<!-- CIN Verso -->
<td class="px-6 py-4">
    <img src="{{ asset($client->cin_verso) }}"
         alt="CIN Verso"
         class="w-12 h-12 object-cover rounded cursor-pointer hover:scale-105 transition">
</td>

            <!-- Actions -->
            <td class="px-6 py-4">
                <div class="flex space-x-2">
                
                    <!-- Voir client via fonction JS -->
                    <button onclick="showUserDetails({{ $client->id }})"
                        class="p-2 text-xs rounded-md bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/40"
                        title="Voir client">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- After the table closing tag -->

<!-- Pagination --> 

    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 sm:mb-0">
            Affichage de <span class="font-medium">{{ $clients->firstItem() }}-{{ $clients->lastItem() }}</span> sur <span class="font-medium">{{ $clients->total() }}</span> clients
        </div>
        
        <div class="flex items-center justify-center space-x-2">
            @if($clients->onFirstPage())
                <span class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $clients->previousPageUrl() }}" class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif
            
            @foreach($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                @if($page == $clients->currentPage())
                    <span class="px-3 py-1 rounded-md bg-admin-primary text-white font-medium">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
            
            @if($clients->hasMorePages())
                <a href="{{ $clients->nextPageUrl() }}" class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
</div>

 <!-- User Detail Modal (dynamique) -->
 <div id="user-detail-modal"
 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
 <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-5xl w-full mx-4 max-h-[90vh] flex flex-col">
     <!-- Header -->
     <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
         <div class="flex items-center">
             <img id="user-avatar" src="" alt="User Avatar" class="w-12 h-12 rounded-full object-cover mr-4" />
             <div>
                 <h3 id="user-fullname" class="text-xl font-bold text-gray-900 dark:text-white"></h3>
                 <div class="flex items-center">
                     <span id="user-role-badge" class="badge badge-info mr-2">Client or partner</span>
                     <span class="text-sm text-gray-600 dark:text-gray-400">ID - <span
                             id="user-id"></span></span>
                 </div>
             </div>
         </div>
         <button id="close-user-modal"
             class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
             <i class="fas fa-times"></i>
         </button>
     </div>

     <!-- Content -->
     <div class="p-5 overflow-y-auto flex-grow">
         <!-- Personal Info and Stats -->
         <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-6">
             <!-- Personal info -->
             <div>
                 <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Informations
                     personnelles</h4>
                 <div class="space-y-2">
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Nom complet</span>
                         <span id="user-fullname-text" class="font-medium text-gray-900 dark:text-white"></span>
                     </div>
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Email</span>
                         <span id="user-email" class="font-medium text-gray-900 dark:text-white"></span>
                     </div>
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Téléphone</span>
                         <span id="user-phone" class="font-medium text-gray-900 dark:text-white"></span>
                     </div>
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Ville</span>
                         <span id="user-city" class="font-medium text-gray-900 dark:text-white"></span>
                     </div>
                     <div class="flex justify-between gap-4">
                         <span class="text-gray-600 dark:text-gray-400">Adresse</span>
                         <span id="user-address" class="font-medium text-gray-900 dark:text-white text-right"></span>
                     </div>
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Date d'inscription</span>
                         <span id="user-created-at" class="font-medium text-gray-900 dark:text-white"></span>
                     </div>

                     <!-- Partner specific info (hidden by default) -->
                     <div id="partner-info-container" class="hidden">
                     </div>
                 </div>
             </div>

             <!-- Account stats -->
             <div>
                 <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Statistiques du compte
                 </h4>
                 <div class="space-y-2">
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Statut du compte</span>
                         <span id="user-status-badge" class="badge"></span>
                     </div>
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Rôle</span>
                         <span id="user-role" class="font-medium text-gray-900 dark:text-white"></span>
                     </div>
                     <div class="flex justify-between">
                         <span class="text-gray-600 dark:text-gray-400">Réservations</span>
                         <span id="user-reservations-count"
                             class="font-medium text-gray-900 dark:text-white">0</span>
                     </div>

                     <!-- Partner specific stats (hidden by default) -->
                     <div id="partner-stats-container" class="hidden">
                         <div class="flex justify-between">
                             <span class="text-gray-600 dark:text-gray-400">Équipements</span>
                             <span id="user-equipments-count"
                                 class="font-medium text-gray-900 dark:text-white">0</span>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <!-- User reservations -->
         <div id="user-reservations-section" class="mb-6">
             <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Réservations</h4>
             <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg overflow-hidden">
                 <table id="user-reservations" class="w-full admin-table">
                     <thead>
                         <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                             <th class="py-3">Listing ID</th>
                             <th class="py-3">Client ID</th>
                             <th class="py-3">Partenaire ID</th>
                             <th class="py-3">Durée résérvation</th>
                             <th class="py-3 pl-6">Livraison</th>
                             <th class="py-3 pr-6">Statut</th>
                         </tr>
                     </thead>
                     <tbody>
                         <!-- Les réservations seront ajoutées dynamiquement ici -->
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Partner equipment section (hidden by default) -->
         <div id="partner-equipment-section" class="mb-6 hidden">
             <div class="flex items-center justify-between mb-3">
                 <h4 class="font-semibold text-gray-900 dark:text-white text-lg">Équipements</h4>
                 <a href="#" id="view-all-equipments"
                     class="text-sm text-admin-primary dark:text-admin-secondary hover:underline">
                     Voir tous
                 </a>
             </div>
             <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg overflow-hidden">
                 <table id="partner-equipments" class="w-full admin-table">
                     <thead>
                         <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                             <th class="py-3 pl-6">Nom</th>
                             <th class="py-3">Catégorie</th>
                             <th class="py-3">Prix/jour</th>
                             <th class="py-3 pr-6">Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         <!-- Les équipements seront ajoutés dynamiquement ici -->
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- Account actions -->
         <div class="mt-6 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
             <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Actions administratives
             </h4>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                     <label class="flex items-center">
                         <span class="text-gray-700 dark:text-gray-300 mr-3">Statut du compte</span>
                         <label class="switch">
                             <input id="user-active-toggle" type="checkbox">
                             <span class="slider"></span>
                         </label>
                     </label>
                 </div>
                 <div class="flex space-x-2">
                     <button id="toggle-partner-btn">
                     </button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Footer -->
     <div class="p-5 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
         <button id="save-user-details"
             class="px-6 py-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out focus:ring-2 focus:ring-blue-400 focus:outline-none">
             Sauvegarder les modifications
         </button>
     </div>
 </div>
</div>
    
    

    <script>

const userButtons = document.querySelectorAll('button .fas.fa-eye'); // Select eye icons within buttons
const userDetailModal = document.getElementById('user-detail-modal');
const closeUserModal = document.getElementById('close-user-modal');
const cancelUserDetails = document.getElementById('cancel-user-details');

userButtons.forEach(button => {
button.parentElement.addEventListener('click', (e) => { // Attach listener to the parent <button>
    e.preventDefault(); // Prevent any default button action if needed
    userDetailModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden'); // Prevent background scrolling
});
});

closeUserModal?.addEventListener('click', () => {
userDetailModal.classList.add('hidden');
document.body.classList.remove('overflow-hidden');
});

cancelUserDetails?.addEventListener('click', () => {
userDetailModal.classList.add('hidden');
document.body.classList.remove('overflow-hidden');
});


userDetailModal?.addEventListener('click', (e) => {
if (e.target === userDetailModal) {
    userDetailModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}
});


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
        
        // Hide dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            // User dropdown
            if (userMenuButton && !userMenuButton.contains(e.target) && userDropdown && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
            
            // Status filter dropdown
            if (statusFilterButton && !statusFilterButton.contains(e.target) && !statusFilterDropdown.contains(e.target)) {
                statusFilterDropdown.classList.add('hidden');
            }
            
            // Sort filter dropdown
            if (sortFilterButton && !sortFilterButton.contains(e.target) && !sortFilterDropdown.contains(e.target)) {
                sortFilterDropdown.classList.add('hidden');
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
        
        // Filter dropdowns
        const statusFilterButton = document.getElementById('status-filter-button');
        const statusFilterDropdown = document.getElementById('status-filter-dropdown');
        const sortFilterButton = document.getElementById('sort-filter-button');
        const sortFilterDropdown = document.getElementById('sort-filter-dropdown');
       
        
        
        // Status filter
        statusFilterButton?.addEventListener('click', () => {
            statusFilterDropdown.classList.toggle('hidden');
            sortFilterDropdown.classList.add('hidden');
         
            
        });
        
        // Status filter options
        const statusOptions = statusFilterDropdown?.querySelectorAll('.option');
        statusOptions?.forEach(option => {
            option.addEventListener('click', () => {
                statusOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');
                statusFilterButton.querySelector('span').textContent = `Statut: ${option.textContent}`;
                statusFilterDropdown.classList.add('hidden');
            });
        });
        
        // Sort filter
        sortFilterButton?.addEventListener('click', () => {
            sortFilterDropdown.classList.toggle('hidden');
            statusFilterDropdown.classList.add('hidden');
           
            
        });
        
        // Sort filter options
        const sortOptions = sortFilterDropdown?.querySelectorAll('.option');
        sortOptions?.forEach(option => {
            option.addEventListener('click', () => {
                sortOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');
                sortFilterButton.querySelector('span').textContent = `Trier par: ${option.textContent}`;
                sortFilterDropdown.classList.add('hidden');
            });
        });
        
        
     
        
        
        // Advanced filters toggle
        const advancedFiltersToggle = document.getElementById('advanced-filters-toggle');
        const advancedFilters = document.getElementById('advanced-filters');
        const filterActions = document.getElementById('filter-actions');
        const chevronIcon = advancedFiltersToggle?.querySelector('.fa-chevron-down');
        
        advancedFiltersToggle?.addEventListener('click', () => {
            advancedFilters.classList.toggle('hidden');
            filterActions.classList.toggle('hidden');
            chevronIcon.classList.toggle('rotate-180');
        });
        
        // Client detail modal
        const clientViewButtons = document.querySelectorAll('button .fas.fa-eye');
        const clientDetailModal = document.getElementById('client-detail-modal');
        const closeClientModal = document.getElementById('close-client-modal');
        const cancelClientDetails = document.getElementById('cancel-client-details');
        
        clientViewButtons.forEach(button => {
            button.parentElement.addEventListener('click', (e) => {
                e.preventDefault();
                clientDetailModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });
        
        closeClientModal?.addEventListener('click', () => {
            clientDetailModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        cancelClientDetails?.addEventListener('click', () => {
            clientDetailModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Close modal when clicking outside
        clientDetailModal?.addEventListener('click', (e) => {
            if (e.target === clientDetailModal) {
                clientDetailModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Client detail tabs
        const adminTabs = document.querySelectorAll('.admin-tab');
        
        adminTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                adminTabs.forEach(el => el.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // In a real app, you would show/hide the corresponding tab content here
            });
        });
        
        // Client reservations modal
        const reservationsButtons = document.querySelectorAll('button .fas.fa-calendar-alt');
        const clientReservationsModal = document.getElementById('client-reservations-modal');
        const closeReservationsModal = document.getElementById('close-reservations-modal');
        const closeReservationsDetails = document.getElementById('close-reservations-details');
        
        reservationsButtons.forEach(button => {
            button.parentElement.addEventListener('click', (e) => {
                e.preventDefault();
                clientReservationsModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });
        
        closeReservationsModal?.addEventListener('click', () => {
            clientReservationsModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        closeReservationsDetails?.addEventListener('click', () => {
            clientReservationsModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Close modal when clicking outside
        clientReservationsModal?.addEventListener('click', (e) => {
            if (e.target === clientReservationsModal) {
                clientReservationsModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        // Recherche dynamique
// Recherche dynamique
const searchInput = document.getElementById('client-search');
const searchForm = searchInput.closest('form');

searchInput.addEventListener('input', function(e) {
    // Option 1: Soumission automatique du formulaire
    // searchForm.submit();
    
    // Option 2: Recherche AJAX (plus avancée)
    if (this.value.length > 2 || this.value.length === 0) {
        fetch(`${searchForm.action}?search=${this.value}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.querySelector('table');
                if (newTable) {
                    document.querySelector('table').replaceWith(newTable);
                }
                
                // Mettez à jour la pagination si nécessaire
                const newPagination = doc.querySelector('.flex.items-center.justify-between.border-t');
                if (newPagination) {
                    const oldPagination = document.querySelector('.flex.items-center.justify-between.border-t');
                    if (oldPagination) {
                        oldPagination.replaceWith(newPagination);
                    }
                }
            });
    }
    
});
    </script>

<script>

    
    // Affiche les détails d'un utilisateur
    async function showUserDetails(userId) {
        try {
            openModal();

            const response = await fetch(`/admin/users/${userId}/details`);
            if (!response.ok) throw new Error('Erreur réseau');
            const data = await response.json();

            if (data.error) return alert(data.error);

            const user = data.user;
            fillUserInfo(user);
            handlePartnerSections(user, data);
            console.log(data)
            fillReservations(data.reservations);

        } catch (error) {
            console.error('Erreur lors du chargement des détails:', error);
            alert('Erreur lors du chargement des détails');
        }
    }

    function openModal() {
        const modal = document.getElementById('user-detail-modal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        document.getElementById('user-detail-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function fillUserInfo(user) {
        const fullName = `${user.first_name} ${user.last_name}`;
        document.getElementById('user-avatar').src = user.avatar_url
            ? `/${user.avatar_url}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(fullName)}`;

        document.getElementById('user-fullname').textContent = fullName;
        document.getElementById('user-fullname-text').textContent = fullName;
        document.getElementById('user-email').textContent = user.email;
        document.getElementById('user-phone').textContent = user.phone_number;
        document.getElementById('user-address').textContent = user.address;
        document.getElementById('user-city').textContent = user.city_name || 'Non spécifié';
        document.getElementById('user-created-at').textContent = new Date(user.created_at).toLocaleDateString();
        document.getElementById('user-active-toggle').checked = user.is_active;
        document.getElementById('user-id').textContent = user.id;

        const isPartner = user.role === 'partner';
        document.getElementById('user-role').textContent = isPartner ? 'Partenaire' : 'Client';

        const roleBadge = document.getElementById('user-role-badge');
        if (isPartner) {
        roleBadge.className = 'badge badge-success mr-2';
        roleBadge.textContent = 'Partenaire';
        } else {
        roleBadge.className = 'badge badge-info mr-2';
        roleBadge.textContent = 'Client';
        }

        const statusBadge = document.getElementById('user-status-badge');
        statusBadge.className = user.is_active ? 'badge badge-success' : 'badge badge-danger';
        statusBadge.textContent = user.is_active ? 'Activé' : 'Désactivé';

        togglePartnerSections(isPartner);
    }

    function togglePartnerSections(isPartner) {
        ['partner-info-container', 'partner-stats-container', 'partner-equipment-section'].forEach(id => {
            document.getElementById(id).classList.toggle('hidden', !isPartner);
        });
        document.getElementById('toggle-partner-btn').classList.toggle('hidden', isPartner);
    }

    function handlePartnerSections(user, data) {
        if (user.role !== 'partner') return;

        document.getElementById('user-equipments-count').textContent = data.equipments_count || 0;

        const tbody = document.querySelector('#partner-equipments tbody');
        tbody.innerHTML = '';
        if (data.items && data.items.length > 0) {
            console.log(data)
            data.items.forEach(eq => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${eq.title}</td>
                <td>${eq.category_name}</td>
                <td>${eq.price_per_day} MAD</td>
                <td>
                    <button onclick="window.location.href='/admin/equipment/${eq.id}'" class="p-1 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition shadow-md hover:scale-105">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            `;
                tbody.appendChild(row);
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4">Aucun équipement</td></tr>';
        }

        document.getElementById('view-all-equipments').href = `/admin/partners/${user.id}/equipments`;
    }

    function fillReservations(reservations) {
        console.log(reservations)
        const tbody = document.querySelector('#user-reservations tbody');
        tbody.innerHTML = '';

        if (reservations && reservations.length > 0) {
            document.getElementById('user-reservations-count').textContent = reservations.length;

            reservations.forEach(res => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${res.listing_id} </td>
                <td>${res.client_id} </td>
                <td>${res.partner_id} </td>
                <td>${new Date(res.start_date).toLocaleDateString()} - ${new Date(res.end_date).toLocaleDateString()}</td>
                <td>${res.delivery_option == 0 ? 'Non' : 'Oui'}</td>
                <td><span class="badge ${getStatusBadgeClass(res.status)}">${getStatusText(res.status)}</span></td>
            `;
                tbody.appendChild(row);
            });
        } else {
            document.getElementById('user-reservations-count').textContent = '0';
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Aucune réservation</td></tr>';
        }
    }

    // Bascule du statut partenaire/client
    document.getElementById('toggle-partner-btn').addEventListener('click', async () => {
        const userId = document.getElementById('user-id').textContent;

        if (!confirm("Voulez-vous vraiment retirer le statut de partenaire à cet utilisateur ?")) return;

        try {
            const response = await fetch(`/admin/users/${userId}/toggle-partner`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Erreur lors de la modification');

            alert(data.message || 'Statut modifié avec succès');
            showUserDetails(userId);

        } catch (error) {
            console.error('Erreur toggle-partner:', error);
            alert(error.message || 'Erreur lors de la modification');
        }
    });

    // Activation/désactivation utilisateur
    document.getElementById('save-user-details').addEventListener('click', async () => {
        const userId = document.getElementById('user-id').textContent;
        const newIsActive = document.getElementById('user-active-toggle').checked ? 1 : 0;

        if (!userId) return alert('ID utilisateur manquant');

        if (!confirm(`Voulez-vous vraiment ${newIsActive ? 'activer' : 'désactiver'} cet utilisateur ?`)) return;

        try {

            const response = await fetch(`/admin/users/${userId}/toggle-activation`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ is_active: newIsActive }) 
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || `Erreur HTTP ${response.status}`);

            // Mettre à jour l'interface utilisateur
            document.getElementById('user-status-badge').className = data.is_active ? 'badge badge-success' : 'badge badge-danger';
            document.getElementById('user-active-toggle').checked = data.is_active;

            
            setTimeout(closeModal, 1000);

        } catch (error) {
            console.error('Erreur:', error);
            alert(`Échec de l'opération: ${error.message}`);
        }
    });


    function getStatusBadgeClass(status) {
        return {
            confirmed: 'badge-success',
            pending: 'badge-warning',
            cancelled: 'badge-danger',
            completed: 'badge-info'
        }[status] || 'badge-neutral';
    }

    function getStatusText(status) {
        return {
            confirmed: 'Confirmée',
            pending: 'En attente',
            cancelled: 'Annulée',
            completed: 'Terminée'
        }[status] || status;
    }

    document.getElementById('equipment-tab').addEventListener('click', async function () {
        // Activer l'onglet
        document.querySelectorAll('.admin-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        this.classList.add('active');

        // Masquer les autres sections
        document.getElementById('recent-users-section').classList.add('hidden');
        document.getElementById('recent-equipments-section').classList.remove('hidden');

        // Charger les équipements
        try {
            const response = await fetch('/admin/recent-equipments');
            if (!response.ok) throw new Error('Erreur réseau');
            const equipments = await response.json();

            const tbody = document.getElementById('equipments-table-body');
            tbody.innerHTML = '';

            if (equipments.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4">Aucun équipement récent</td></tr>';
                return;
            }

            equipments.forEach(equipment => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50';
                row.innerHTML = `
            <td class="py-4 pl-6 font-medium text-gray-900 dark:text-white">${equipment.title}</td>
            <td class="py-4">${equipment.partner_name}</td>
            <td class="py-4">${equipment.price_per_day} MAD</td>
            <td class="py-4">${equipment.category_name}</td>
            <td class="py-4 pr-6">${new Date(equipment.created_at).toLocaleDateString()}</td>
        `;
                tbody.appendChild(row);
            });

        } catch (error) {
            console.error('Erreur:', error);
            document.getElementById('equipments-table-body').innerHTML =
                '<tr><td colspan="5" class="text-center py-4 text-red-500">Erreur de chargement</td></tr>';
        }
    });

    document.getElementById('reservations-tab').addEventListener('click', async function() {
    // Activer l'onglet
    document.querySelectorAll('.admin-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    this.classList.add('active');

    // Masquer les autres sections
    document.getElementById('recent-users-section').classList.add('hidden');
    document.getElementById('recent-equipments-section').classList.add('hidden');
    document.getElementById('recent-reservations-section').classList.remove('hidden');

    // Charger les réservations
    try {
        const response = await fetch('/admin/recent-reservations', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Erreur réseau');
        const reservations = await response.json();
        
        const tbody = document.getElementById('reservations-table-body');
        tbody.innerHTML = '';
        
        if (reservations.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Aucune réservation récente</td></tr>';
            return;
        }
        
        reservations.forEach(reservation => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50';
            row.innerHTML = `
                <td class="py-4 pl-6">${reservation.client_name}</td>
                <td class="py-4">${reservation.equipment_title}</td>
                <td class="py-4">${reservation.start_date} - ${reservation.end_date}</td>
                <td class="py-4">${reservation.total_price} </td>
                <td class="py-4 pr-6"><span class="badge ${getStatusBadgeClass(reservation.status)}">${getStatusText(reservation.status)}</span></td>
            `;
            tbody.appendChild(row);
        });
        
    } catch (error) {
        console.error('Erreur:', error);
        document.getElementById('reservations-table-body').innerHTML = 
            '<tr><td colspan="5" class="text-center py-4 text-red-500">Erreur de chargement</td></tr>';
    }
    });



</script>


<!-- Image Modal -->
<!-- Image Modal -->
<!-- Image Modal -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl w-full mx-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Bouton de fermeture en haut à droite -->
        <button id="close-image-modal" 
                class="absolute top-4 right-4 z-50 text-gray-600 hover:text-gray-900 focus:outline-none bg-white bg-opacity-80 rounded-full p-2 transition-colors border border-gray-200">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <!-- Contenu de l'image -->
        <div class="p-4">
            <img id="modal-image-content" src="" alt="CIN Image" class="max-w-full max-h-[80vh] mx-auto rounded-md">
            <div class="text-center mt-2 text-gray-600 text-sm">CIN (Carte d'Identité Nationale)</div>
        </div>
    </div>
</div>


<script>
// Modal pour les images CIN
const cinImages = document.querySelectorAll('img[alt="CIN Recto"], img[alt="CIN Verso"]');
const imageModal = document.getElementById('image-modal');
const modalImageContent = document.getElementById('modal-image-content');
const closeImageModal = document.getElementById('close-image-modal');

// Ouvrir le modal quand on clique sur une image CIN
cinImages.forEach(img => {
    img.addEventListener('click', () => {
        modalImageContent.src = img.src;
        modalImageContent.alt = img.alt;
        imageModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
});

// Fermer le modal
closeImageModal.addEventListener('click', () => {
    imageModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

// Fermer en cliquant à l'extérieur
imageModal.addEventListener('click', (e) => {
    if (e.target === imageModal) {
        imageModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
});
</script>




</body>
</html>