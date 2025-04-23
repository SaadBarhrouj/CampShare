<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur - CampShare | Louez du matériel de camping entre particuliers</title>
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
                    <a href="admin-dashboard.html" class="flex items-center">
                        <span class="text-admin-primary dark:text-admin-secondary text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                        <span class="text-xs ml-2 text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">ADMIN</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Quick search -->
                    <div class="relative">
                        <input type="text" placeholder="Recherche rapide..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary w-64 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                        </div>
                    </div>
                    
                    <!-- User menu -->
                    <div class="relative ml-4">
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button id="notifications-button" class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                    <i class="fas fa-bell"></i>
                                    <span class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">5</span>
                                </button>
                            </div>
                            
                            <!-- Settings -->
                            <div class="relative">
                                <button id="settings-button" class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                    <i class="fas fa-cog"></i>
                                </button>
                            </div>
                            
                            <!-- User profile menu -->
                            <div class="relative">
                                <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                    <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                                         alt="Admin User" 
                                         class="h-8 w-8 rounded-full object-cover" />
                                    <div class="flex flex-col items-start">
                                        <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">Mohamed Alami</span>
                                        <span class="text-xs text-admin-primary dark:text-admin-secondary font-medium">Super Admin</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                </button>
                                
                                <!-- User dropdown menu -->
                                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600 py-1">
                                    <a href="#profile" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                    </a>
                                    <a href="#account-settings" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-cog mr-2 opacity-70"></i> Paramètres
                                    </a>
                                    <a href="#admin-logs" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-history mr-2 opacity-70"></i> Historique d'actions
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
                    <input type="text" placeholder="Recherche rapide..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                    </div>
                </div>
            </div>
            
            <!-- Mobile profile menu -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-3">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                             alt="Admin User" 
                             class="h-10 w-10 rounded-full" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800 dark:text-white">Mohamed Alami</div>
                        <div class="text-sm font-medium text-admin-primary dark:text-admin-secondary">Super Admin</div>
                    </div>
                    <div class="ml-auto flex items-center space-x-4">
                        <button class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -mt-1 -mr-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">5</span>
                        </button>
                        <button class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-cog text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                    </a>
                    <a href="#account-settings" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-cog mr-2 opacity-70"></i> Paramètres
                    </a>
                    <a href="#admin-logs" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-history mr-2 opacity-70"></i> Historique d'actions
                    </a>
                    <a href="#logout" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
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
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Menu Principal</h5>
                    <nav class="space-y-1">
                        <a href="#dashboard" class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-admin-primary dark:text-admin-secondary"></i>
                            Tableau de bord
                        </a>
                        <a href="{{ route('admin.clients') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
    Clients
    <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">{{ $clientsCount}}</span>
</a>
<a href="{{ route('admin.partners') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
    Partenaires
    <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">{{ $partnersCount }}</span>
</a>
                        <a href="#equipment" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-campground w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Équipements
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">432</span>
                        </a>
                        <a href="#reservations" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-calendar-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Réservations
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">278</span>
                        </a>
                        <a href="#reviews" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-star w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Avis
                            <span class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-1.5 flex items-center justify-center">12</span>
                        </a>
                        <a href="#reports" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-flag w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Signalements
                            <span class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-1.5 flex items-center justify-center">5</span>
                        </a>
                    </nav>
                </div>
                
                <div class="mb-6 px-3">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Analyse & Rapports</h5>
                    <nav class="space-y-1">
                        <a href="#analytics" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chart-line w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Statistiques
                        </a>
                        <a href="#financial" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-money-bill-wave w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Finances
                        </a>

                    </nav>
                </div>
                
                <div class="mb-6 px-3">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Configuration</h5>
                    <nav class="space-y-1">
                        <a href="#site-settings" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-cog w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Paramètres du site
                        </a>
                        <a href="#admin-users" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-user-shield w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Administrateurs
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">6</span>
                        </a>
                    </nav>
                </div>
                
                <div class="mt-auto px-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center px-2 py-3 mb-2 bg-admin-light/40 dark:bg-admin-dark/40 rounded-lg">
                        <div class="flex-shrink-0 mr-3">
                            <i class="fas fa-shield-alt text-admin-primary dark:text-admin-secondary"></i>
                        </div>
                        <div class="text-sm">
                            <p class="font-medium text-admin-primary dark:text-admin-secondary">Mode maintenance</p>
                            <label class="switch mt-1">
                                <input type="checkbox" id="maintenance-mode">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 px-2">
                        <p>Version: <span class="font-medium">2.4.1</span></p>
                        <p>Dernière mise à jour: <span class="font-medium">01/08/2023</span></p>
                    </div>
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
            <div class="p-5">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Menu Admin</h2>
                    <button id="close-mobile-sidebar" class="text-gray-600 dark:text-gray-400 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Menu Principal</h5>
                    <nav class="space-y-1">
                        <a href="#dashboard" class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-admin-primary dark:text-admin-secondary"></i>
                            Tableau de bord
                        </a>
                       <!-- Dans la section MENU PRINCIPAL -->
                       <div class="sidebar-link flex items-center px-3 py-2.5" id="clients-link">
    <i class="fas fa-users w-5 mr-3"></i>
    <span>Clients</span>
    <span class="ml-auto bg-blue-100 text-blue-800 rounded-full px-2">{{ $clientsCount }}</span>
</div>
<a href="{{ route('admin.partners') }}" id="partners-link" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"id="partners-link">
    <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
    Partenaires
    <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">{{ $partnersCount ?? 0 }}</span>
</a>
                        <a href="#equipment" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-campground w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Équipements
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">432</span>
                        </a>
                        <a href="#reservations" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-calendar-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Réservations
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">278</span>
                        </a>
                        <a href="#reviews" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-star w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Avis
                            <span class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-1.5 flex items-center justify-center">12</span>
                        </a>
                        <a href="#reports" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-flag w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Signalements
                            <span class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-1.5 flex items-center justify-center">5</span>
                        </a>
                    </nav>
                </div>
                
                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Analyse & Rapports</h5>
                    <nav class="space-y-1">
                        <a href="#analytics" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chart-line w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Statistiques
                        </a>
                        <a href="#financial" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-money-bill-wave w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Finances
                        </a>
                        <a href="#reports-gen" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-file-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Rapports
                        </a>
                    </nav>
                </div>
                
                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Configuration</h5>
                    <nav class="space-y-1">
                        <a href="#site-settings" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-cog w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Paramètres du site
                        </a>
                        <a href="#admin-users" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-user-shield w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Administrateurs
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">6</span>
                        </a>
                        <a href="#system-logs" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-history w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Logs système
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
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Bienvenue, Mohamed! Voici une vue d'ensemble de la plateforme.</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <div class="relative">
                            <select class="pl-3 pr-8 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-sm appearance-none">
                                <option>Aujourd'hui</option>
                                <option>Cette semaine</option>
                                <option selected>Ce mois</option>
                                <option>Ce trimestre</option>
                                <option>Cette année</option>
                                <option>Personnaliser...</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        <a href="#export-data" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Exporter
                        </a>
                        <a href="#refresh-data" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Actualiser
                        </a>
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
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $clientsCount + $partnersCount }}</h3>
                                <span class="text-green-600 dark:text-green-400 text-sm flex items-center ml-2">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        12.8%
                                    </span>
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
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Équipements</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">432</h3>
                                    <span class="text-green-600 dark:text-green-400 text-sm flex items-center ml-2">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        8.4%
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    386 actifs, 46 inactifs
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
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">278</h3>
                                    <span class="text-green-600 dark:text-green-400 text-sm flex items-center ml-2">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        15.6%
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    42 en cours, 236 terminées
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
                                    <span class="text-green-600 dark:text-green-400 text-sm flex items-center ml-2">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        22.3%
                                    </span>
                                </div>
                               
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
                                <h2 class="font-bold text-lg text-gray-900 dark:text-white">Tendances de l'activité</h2>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 text-xs font-medium bg-admin-primary text-white rounded">Réservations</button>
                                    <button class="px-3 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded">Utilisateurs</button>
                                    <button class="px-3 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded">Revenus</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Chart container -->
                        <div class="p-4">
                            <div class="chart-container">
                                <!-- Placeholder for chart -->
                                <div class="w-full h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="text-center">
                                        <i class="fas fa-chart-line text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Graphique de tendances des réservations</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent issues -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h2 class="font-bold text-lg text-gray-900 dark:text-white">Problèmes récents</h2>
                                <a href="#all-issues" class="text-sm text-admin-primary dark:text-admin-secondary hover:underline">Voir tous</a>
                            </div>
                        </div>
                        
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Issue 1 -->
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                            Signalement d'utilisateur
                                            <span class="ml-2 badge badge-danger">Urgent</span>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            Younes a signalé le partenaire "Omar Tazi" pour comportement inapproprié
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                            Il y a 1 heure
                                        </p>
                                        <div class="mt-2">
                                            <button class="text-xs font-medium px-2 py-1 bg-admin-primary text-white rounded-md hover:bg-admin-dark">
                                                Examiner
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Issue 2 -->
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                            <i class="fas fa-flag text-amber-600 dark:text-amber-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                            Contenu inapproprié
                                            <span class="ml-2 badge badge-warning">Modération</span>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            Annonce "Pack Camping Ultra Premium" signalée pour photos trompeuses
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                            Il y a 3 heures
                                        </p>
                                        <div class="mt-2">
                                            <button class="text-xs font-medium px-2 py-1 bg-admin-primary text-white rounded-md hover:bg-admin-dark">
                                                Vérifier
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Issue 3 -->
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                            <i class="fas fa-comment-slash text-red-600 dark:text-red-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                            Avis négatif
                                            <span class="ml-2 badge badge-danger">À examiner</span>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            Avis 1 étoile laissé par Fatima sur l'équipement "Tente 4 Personnes Deluxe"
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                            Il y a 5 heures
                                        </p>
                                        <div class="mt-2">
                                            <button class="text-xs font-medium px-2 py-1 bg-admin-primary text-white rounded-md hover:bg-admin-dark">
                                                Modérer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabs for quick access sections -->
                <div class="mb-6">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <div class="flex overflow-x-auto">
                            <button class="admin-tab active">Utilisateurs récents</button>
                            <button class="admin-tab">Équipements récents</button>
                            <button class="admin-tab">Dernières réservations</button>
                            <button class="admin-tab">Derniers avis</button>
                        </div>
                    </div>
                </div>
                
                <!-- Users table -->
              <!-- Users table -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h2 class="font-bold text-lg text-gray-900 dark:text-white">Utilisateurs récents</h2>
        <div class="flex items-center">
            <div class="relative mr-2">
                <input type="text" placeholder="Rechercher un utilisateur..." class="pl-8 pr-4 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 dark:text-gray-500 text-xs"></i>
                </div>
            </div>
            <a href="#all-users" class="text-sm text-admin-primary dark:text-admin-secondary hover:underline">Voir tous</a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full admin-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Type</th>
                    <th>Inscrit le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $user)
                <tr>
                    <td class="flex items-center py-4">
                        <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->username).'&color=7F9CF5&background=EBF4FF' }}" 
                             alt="{{ $user->username }}" 
                             class="w-10 h-10 rounded-full object-cover mr-3" />
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->username }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->email }}</p>
                        </div>
                    </td>
                    <td>
                        @if($user->role === 'client')
                            <span class="badge badge-info">Client</span>
                        @else
                            <span class="badge badge-success">Partenaire</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    
                    <td>
                        <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40">
                            <i class="fas fa-eye"></i>
                        </button>
                    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Affichage de <span class="font-medium">1-{{ $recentUsers->count() }}</span> sur <span class="font-medium">{{ $totalUsers }}</span> utilisateurs
        </div>
        
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.clients') }}" class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Voir tous les clients
            </a>
            <a href="{{ route('admin.partners') }}" class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                Voir tous les partenaires
            </a>
        </div>
    </div>
</div>
        </main>
    </div>
    
    <!-- User Detail Modal (hidden by default) -->
    <div id="user-detail-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full mx-4 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Leila Mansouri" 
                         class="w-12 h-12 rounded-full object-cover mr-4" />
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Leila Mansouri</h3>
                        <div class="flex items-center">
                            <span class="badge badge-info mr-2">Client</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">ID: #CL-12345</span>
                        </div>
                    </div>
                </div>
                <button id="close-user-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- User details content -->
            <div class="p-5 overflow-y-auto flex-grow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Personal info -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Informations personnelles</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Nom complet:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Leila Mansouri</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                <span class="font-medium text-gray-900 dark:text-white">leila.mansouri@example.com</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Téléphone:</span>
                                <span class="font-medium text-gray-900 dark:text-white">+212 6 12 34 56 78</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Date d'inscription:</span>
                                <span class="font-medium text-gray-900 dark:text-white">01/08/2023</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Ville:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Casablanca</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account stats -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Statistiques du compte</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Statut du compte:</span>
                                <span class="badge badge-success">Actif</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Dernière connexion:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Il y a 25 min</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Réservations:</span>
                                <span class="font-medium text-gray-900 dark:text-white">8 (6 terminées, 2 en cours)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Dépenses totales:</span>
                                <span class="font-medium text-gray-900 dark:text-white">4 680 MAD</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Signalements:</span>
                                <span class="font-medium text-gray-900 dark:text-white">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User reservations -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Réservations récentes</h4>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg overflow-hidden">
                        <table class="w-full admin-table">
                            <thead>
                                <tr>
                                    <th>Équipement</th>
                                    <th>Dates</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Grande Tente 6 Personnes</td>
                                    <td>5 - 10 Août 2023</td>
                                    <td>1 250 MAD</td>
                                    <td><span class="badge badge-success">Confirmée</span></td>
                                </tr>
                                <tr>
                                    <td>Réchaud Camping + Kit Cuisine</td>
                                    <td>15 - 18 Août 2023</td>
                                    <td>450 MAD</td>
                                    <td><span class="badge badge-warning">En attente</span></td>
                                </tr>
                                <tr>
                                    <td>Matelas Gonflable Double</td>
                                    <td>10 - 15 Juil. 2023</td>
                                    <td>600 MAD</td>
                                    <td><span class="badge badge-info">Terminée</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Reviews given by user -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Avis donnés</h4>
                    <div class="space-y-4">
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <span class="font-medium text-gray-900 dark:text-white">Matelas Gonflable Double</span>
                                    <div class="flex items-center text-amber-400 dark:text-amber-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star-half-alt text-xs"></i>
                                        <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">4.5</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">15 Juil. 2023</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Très bon matelas, confortable et facilement gonflable. Je recommande !
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Account actions -->
                <div class="mt-6 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Actions administratives</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center">
                                <span class="text-gray-700 dark:text-gray-300 mr-3">Statut du compte:</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </label>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-envelope mr-1"></i> Envoyer email
                            </button>
                            <button class="px-3 py-1.5 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-400 text-sm rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <i class="fas fa-ban mr-1"></i> Suspendre
                            </button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Notes administratives:</label>
                        <textarea class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm" rows="3" placeholder="Ajouter une note concernant cet utilisateur..."></textarea>
                    </div>
                </div>
            </div>
            
            <div class="p-5 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button id="cancel-user-details" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md mr-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Fermer
                </button>
                <button class="px-4 py-2 bg-admin-primary hover:bg-admin-dark text-white font-medium rounded-md shadow-sm transition-colors">
                    Sauvegarder les modifications
                </button>
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