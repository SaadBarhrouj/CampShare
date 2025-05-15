<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de bord Administrateur - CampShare | Louez du matériel de camping entre particuliers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

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

        /* Custom tabs */
        .admin-tab {
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .admin-tab:hover {
            color: #1E40AF;
            border-bottom-color: #DBEAFE;
        }

        .dark .admin-tab:hover {
            color: #3B82F6;
            border-bottom-color: #1E3A8A;
        }

        .admin-tab.active {
            color: #1E40AF;
            border-bottom-color: #1E40AF;
        }

        .dark .admin-tab.active {
            color: #3B82F6;
            border-bottom-color: #3B82F6;
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

        input:checked+.slider {
            background-color: #1E40AF;
        }

        .dark input:checked+.slider {
            background-color: #3B82F6;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #1E40AF;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        /* Chart containers */
        .chart-container {
            width: 100%;
            height: 300px;
            position: relative;
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
                            class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
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
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">{{ $partnersCount }}</span>
                        </a>
                        <a href="{{ route('admin.clients') }}"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Clients
                            <span
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">{{ $clientsCount}}</span>
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
            <button id="mobile-sidebar-toggle"
                class="w-14 h-14 rounded-full bg-admin-primary dark:bg-admin-secondary text-white shadow-lg flex items-center justify-center">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <div id="mobile-sidebar"
            class="md:hidden fixed inset-y-0 left-0 transform -translate-x-full w-64 bg-white dark:bg-gray-800 shadow-xl z-50 transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Menu Admin</h2>
                    <button id="close-mobile-sidebar" class="text-gray-600 dark:text-gray-400 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Menu Principal</h5>
                    <nav class="space-y-1">
                        <a href="#dashboard"
                            class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-admin-primary dark:text-admin-secondary"></i>
                            Tableau de bord
                        </a>
                        <!-- Dans la section MENU PRINCIPAL -->
                        <div class="sidebar-link flex items-center px-3 py-2.5" id="clients-link">
                            <i class="fas fa-users w-5 mr-3"></i>
                            <span>Clients</span>
                            <span class="ml-auto bg-blue-100 text-blue-800 rounded-full px-2">{{ $clientsCount }}</span>
                        </div>
                        <a href="{{ route('admin.partners') }}" id="partners-link"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            id="partners-link">
                            <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Partenaires
                            <span
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">{{ $partnersCount ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.clients') }}" id="partners-link"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            id="partners-link">
                            <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            hhhhhhh
                            <span
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">{{ $partnersCount ?? 0 }}</span>
                        </a>
                        <a href="#reservations"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-calendar-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Réservations
                            <span
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">278</span>
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
                
                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Utilisateurs</h5>
                    <nav class="space-y-1">
                        <a href="#analytics"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chart-line w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Statistiques
                        </a>
                        <a href="#financial"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-money-bill-wave w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Finances
                        </a>
                        <a href="#reports-gen"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-file-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Rapports
                        </a>
                    </nav>
                </div>

                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Equi. Réserv. & Avis</h5>
                    <nav class="space-y-1">
                        <a href="#analytics"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chart-line w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Statistiques
                        </a>
                        <a href="#financial"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-money-bill-wave w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Finances
                        </a>
                        <a href="#reports-gen"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-file-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Rapports
                        </a>
                    </nav>
                </div>

            </div>
        </div>

        <!-- Main content -->
        <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Dashboard header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Tableau de bord</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Bienvenue, Mohamed! Voici une vue d'ensemble de
                            la plateforme.</p>
                    </div>
                </div>

                <!-- Stats cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats card 1 - Utilisateurs -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-admin-light dark:bg-admin-dark mr-4">
                                <i class="fas fa-users text-admin-primary dark:text-admin-secondary"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Utilisateurs</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ $clientsCount + $partnersCount }}
                                    </h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    {{$clientsCount }} clients, {{$partnersCount}} partenaires
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats card 2 - Équipements -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900/30 mr-4">
                                <i class="fas fa-campground text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Annonces</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $annonces->count() }}</h3>
                                    
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    {{ $annonces->where('status', 'active')->count() }} actifs, {{ $annonces->where('status', 'archived')->count() }} inactifs
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats card 3 - Réservations -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 mr-4">
                                <i class="fas fa-calendar-check text-green-600 dark:text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Réservations</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $reservations->count() }}</h3>
                                    
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    {{ $reservations->where('status', 'ongoing')->count() }} en cours, {{ $reservations->where('status', 'completed')->count() }} terminées
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats card 4 - Revenu -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/30 mr-4">
                                <i class="fas fa-money-bill-wave text-amber-600 dark:text-amber-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Revenu (MAD)</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">86.4K</h3>
                                    
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    &nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent activity and issues -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Graph card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h2 class="font-bold text-lg text-gray-900 dark:text-white">Graphique des utilisateurs</h2>
                                <div class="flex space-x-2">
                                    <button
                                        class="px-3 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded">Nombre Total : {{ $clientsCount+$partnersCount }} utilisateurs</button>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- Chart container -->
                        <div class="p-4">
                            <div class="chart-container">
                                <!-- Placeholder for chart -->
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="chart-container bg-white dark:bg-gray-800 p-4 rounded-lg flex justify-center items-center">
                                        <canvas id="userPieChart"></canvas>
                                    </div>
                                </div>

                                    
                                
                            </div>
                        </div>
                    </div>
                    
                    
                    <script>
                        // Register the plugin globally
                        Chart.register(ChartDataLabels);
                    
                        const ctx = document.getElementById('userPieChart').getContext('2d');
                        const userPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ['Clients', 'Partners'],
                                datasets: [{
                                    data: [{{ $clientsCount }}, {{ $partnersCount }}],
                                    backgroundColor: ['#3b82f6', '#ffaa33'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    datalabels: {
                                        formatter: (value, context) => {
                                            const data = context.chart.data.datasets[0].data;
                                            const total = data.reduce((sum, val) => sum + val, 0);
                                            const percentage = (value / total * 100).toFixed(1);
                                            return `${percentage}%`;
                                        },
                                        color: '#fff',
                                        font: {
                                            weight: 'bold',
                                            size: 14
                                        }
                                    },
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: '#6b7280'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });
                    </script>
                    
                    

                    <!-- Graph card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h2 class="font-bold text-lg text-gray-900 dark:text-white">Graphique des résérvations</h2>
                                <div class="flex space-x-2">
                                    <button
                                        class="px-3 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded">Nombre Total : {{ $reservations->count() }} Résérvation</button>
                                    
                                </div>
                            </div>
                        </div>
                        @php
                            $pendingCount = $reservations->where('status', 'pending')->count();
                            $confirmedCount = $reservations->where('status', 'confirmed')->count();
                            $ongoingCount = $reservations->where('status', 'ongoing')->count();
                            $canceledCount = $reservations->where('status', 'canceled')->count();
                            $completedCount = $reservations->where('status', 'completed')->count();
                        @endphp
                    
                        <!-- Chart container -->
                        <div class="p-4">
                            <div class="chart-container">
                                <!-- Placeholder for chart -->
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="rounded-lg p-4 w-max">
                                        <canvas id="reservationBarChart" height="200" width="500"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const ctx = document.getElementById('reservationBarChart').getContext('2d');
                        
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: ['Pending', 'Confirmed', 'Ongoing', 'Canceled', 'Completed'],
                                        datasets: [{
                                            label: 'Number of Reservations',
                                            data: [{{ $pendingCount }}, {{ $confirmedCount }}, {{ $ongoingCount }}, {{ $canceledCount }}, {{ $completedCount }}],
                                            backgroundColor: ['#fbbf24', '#3b82f6', '#10b981', '#ef4444', '#6366f1'],
                                            borderRadius: 5,
                                            barThickness: 40
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            },
                                        },
                                        plugins: {
                                            datalabels: {
                                            color: '#fff',
                                            font: {
                                                weight: 'bold',
                                                size: 14
                                        }
                                    },
                                            legend: { display: false }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>

                <!-- Tabs for quick access sections -->
                <!-- Onglets -->
                <!-- Onglets de navigation -->
                <div class="mb-6">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <div class="flex overflow-x-auto">
                            <button id="users-tab" class="admin-tab active">Utilisateurs récents</button>
                            <button id="equipment-tab" class="admin-tab">Équipements récents</button>
                            <button id="reservations-tab" class="admin-tab">Dernières réservations</button>
                        </div>
                    </div>
                </div>

                <!-- Utilisateurs récents -->
                <div id="recent-users-section"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h2 class="font-bold text-lg text-gray-900 dark:text-white">Utilisateurs récents</h2>
                        <form id="user-search-form" method="GET" action="{{ route('admin.clients') }}"
                            class="flex items-center">
                            <div class="relative mr-2">
                                <input type="text" id="user-search-input" name="search" value="{{ request('search') }}"
                                    placeholder="Rechercher par nom, email..."
                                    class="pl-8 pr-4 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 dark:text-gray-500 text-xs"></i>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if(request()->has('search'))
                        <div class="px-6 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 text-sm">
                            Résultats de recherche pour : "{{ request('search') }}"
                            <a href="{{ route('admin.clients') }}"
                                class="ml-2 text-blue-600 dark:text-blue-300 hover:underline">Effacer</a>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full admin-table">
                            <thead>
                                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 pl-6">Utilisateur</th>
                                    <th class="pb-3">Type</th>
                                    <th class="pb-3">Inscrit le</th>
                                    <th class="pb-3 pr-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                    <trclass="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="flex items-center py-5 pl-6">
                                            <img src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('images/default-avatar.jpg') }}"
                                                alt="{{ $user->first_name }} {{ $user->last_name }}"
                                                class="w-14 h-14 rounded-full object-cover mr-4 shadow" />
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white text-base">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </p>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="py-5">
                                            @if($user->role === 'client')
                                                <span class="badge badge-info">Client</span>
                                            @else
                                                <span class="badge badge-success">Partenaire</span>
                                            @endif
                                        </td>
                                        <td class="py-5">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-5 pr-6">
                                            <button onclick="showUserDetails({{ $user->id }})"
                                                class="mr-6 p-2 text-xs rounded-md bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir le client">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Affichage de <span class="font-medium">1-{{ $recentUsers->count() }}</span> sur <span
                                    class="font-medium">{{ $totalUsers }}</span> utilisateurs
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.clients') }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    Voir tous les clients
                                </a>
                                <a href="{{ route('admin.partners') }}"
                                    class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    Voir tous les partenaires
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Équipements récents -->
                <div id="recent-equipments-section"
                    class="hidden bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="font-bold text-lg text-gray-900 dark:text-white">Équipements récents</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full admin-table">
                            <thead>
                                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 pl-6">Nom</th>
                                    <th class="pb-3">Nombre</th>
                                    <th class="pb-3">Prix/jour</th>
                                    <th class="pb-3">Catégorie</th>
                                    <th class="pb-3 pr-6">Date d'ajout</th>
                                </tr>
                            </thead>
                            <tbody id="equipments-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Réservations récentes -->
                <div id="recent-reservations-section"
                    class="hidden bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="font-bold text-lg text-gray-900 dark:text-white">Dernières réservations</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full admin-table">
                            <thead>
                                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-3 pl-6">delivery</th>
                                    <th class="pb-3">update reservation</th>
                                    <th class="pb-3">Dates</th>
                                    <th class="pb-3">partner number</th>
                                    <th class="pb-3 pr-6">Statut</th>
                                </tr>
                            </thead>
                            <tbody id="reservations-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const tabs = {
                            users: document.getElementById('users-tab'),
                            equipment: document.getElementById('equipment-tab'),
                            reservations: document.getElementById('reservations-tab')
                        };

                        const sections = {
                            users: document.getElementById('recent-users-section'),
                            equipment: document.getElementById('recent-equipments-section'),
                            reservations: document.getElementById('recent-reservations-section')
                        };

                        Object.entries(tabs).forEach(([key, tab]) => {
                            tab.addEventListener('click', () => {
                                Object.values(tabs).forEach(t => t.classList.remove('active'));
                                Object.values(sections).forEach(s => s.classList.add('hidden'));
                                tab.classList.add('active');
                                sections[key].classList.remove('hidden');
                            });
                        });
                    });
                </script>

                <!-- Script pour la gestion des onglets -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const usersTab = document.getElementById('users-tab');
                        const equipmentTab = document.getElementById('equipment-tab');

                        const usersSection = document.getElementById('recent-users-section');
                        const equipmentSection = document.getElementById('recent-equipments-section');

                        usersTab.addEventListener('click', () => {
                            usersTab.classList.add('active');
                            equipmentTab.classList.remove('active');
                            usersSection.classList.remove('hidden');
                            equipmentSection.classList.add('hidden');
                        });

                        equipmentTab.addEventListener('click', () => {
                            equipmentTab.classList.add('active');
                            usersTab.classList.remove('active');
                            equipmentSection.classList.remove('hidden');
                            usersSection.classList.add('hidden');

                            // Vous pouvez appeler ici une fonction pour charger les équipements via AJAX
                            // ex: loadRecentEquipments();
                        });
                    });
                </script>



                
            </div>
    </div>
    </main>

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

// Hide dropdowns when clicking outside
document.addEventListener('click', (e) => {
// User dropdown
if (userMenuButton && !userMenuButton.contains(e.target) && userDropdown && !userDropdown.contains(e.target)) {
    userDropdown.classList.add('hidden');
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
// Supprimez l'ancien gestionnaire d'événements pour les liens de la sidebar
// Et remplacez par ceci :
document.querySelectorAll('.sidebar-link').forEach(link => {
link.addEventListener('click', function(e) {
    // Enlevez la gestion de la classe active
    sidebarLinks.forEach(el => el.classList.remove('active'));
    this.classList.add('active');
    
    // Si c'est un lien interne, ne pas empêcher le comportement par défaut
    if (this.getAttribute('href').startsWith('#')) {
        e.preventDefault();
        // Gestion des ancres ici si nécessaire
    }
});
});

// Sidebar link active state (Improved)
const sidebarLinks = document.querySelectorAll('.sidebar-link');

// Remove initial active state (Important: Only if you want no link active on initial load)
sidebarLinks.forEach(el => el.classList.remove('active')); 

// Handle Clients link click
document.getElementById('clients-link')?.addEventListener('click', function(e) {
e.preventDefault();
window.location.href = '{{ route("admin.clients") }}';
});

// Handle Partners link click
document.getElementById('partners-link')?.addEventListener('click', function(e) {
e.preventDefault();
window.location.href = '{{ route("admin.partners") }}';
});

// Generic sidebar link click handling (for all other links)
sidebarLinks.forEach(link => {
if (!link.id || (link.id !== 'clients-link' && link.id !== 'partners-link')) {
    link.addEventListener('click', () => {
        sidebarLinks.forEach(el => el.classList.remove('active'));
        link.classList.add('active');
    });
}
});



// Tab switching
const adminTabs = document.querySelectorAll('.admin-tab');

adminTabs.forEach(tab => {
tab.addEventListener('click', () => {
    // Remove active class from all tabs
    adminTabs.forEach(el => el.classList.remove('active'));

    // Add active class to clicked tab
    tab.classList.add('active');

    // Here you would normally also update the visible content
    // For this demo, we're not implementing full tab functionality
});
});


// Maintenance mode toggle
const maintenanceMode = document.getElementById('maintenance-mode');

maintenanceMode?.addEventListener('change', () => {
// In a real system, you would send an AJAX request to update the server
if (maintenanceMode.checked) {
    alert('Maintenance mode enabled (simulated)');
} else {
    alert('Maintenance mode disabled (simulated)');
}
});

// User detail modal
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
</script>

</body>

</html>