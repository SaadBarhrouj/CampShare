<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
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
        
        .badge-purple {
            background-color: #EDE9FE;
            color: #6D28D9;
        }
        
        .dark .badge-purple {
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
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Tableau de bord
                        </a>
                        <a href="#clients" class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors">
                            <i class="fas fa-user w-5 mr-3 text-admin-primary dark:text-admin-secondary"></i>
                            Clients
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center"> {{ $stats['total'] }}</span>
                        </a>
                        <a href="#partners" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Partenaires
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">86</span>
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
                        <a href="#reports-gen" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-file-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Rapports
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
                        <a href="#system-logs" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-history w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Logs système
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
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <a href="#export-clients" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Exporter
                        </a>
                        <a href="#add-client" class="inline-flex items-center px-4 py-2 bg-admin-primary hover:bg-admin-dark text-white rounded-md shadow-sm transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un client
                        </a>
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
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Clients</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white"> {{ $stats['total'] }}</h3>
                                    <span class="text-green-600 dark:text-green-400 text-sm flex items-center ml-2">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        12.4%
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    vs mois précédent
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
                                    <span class="text-gray-600 dark:text-gray-400 text-sm flex items-center ml-2">
                                        (95.9%)
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    10 inactifs/suspendus
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 3 - Reservation Count -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900/30 mr-4">
                                <i class="fas fa-calendar-check text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Réservations</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">386</h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    Moyenne: 1.6 par client
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 4 - Spending -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/30 mr-4">
                                <i class="fas fa-money-bill-wave text-amber-600 dark:text-amber-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Dépenses totales</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">73.2K MAD</h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    302 MAD/client en moyenne
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
                                <div class="option" data-value="suspended">Suspendus</div>
                                <div class="option" data-value="new">Nouveaux (< 30j)</div>
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
                    
                    <!-- Advanced filters (collapsible) -->
                    <div class="mt-4">
                        <button id="advanced-filters-toggle" class="text-sm text-admin-primary dark:text-admin-secondary flex items-center">
                            <i class="fas fa-filter mr-1"></i> Filtres avancés
                            <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-200"></i>
                        </button>
                        
                        <div id="advanced-filters" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Registration date range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date d'inscription</label>
                                <div class="flex space-x-2">
                                    <input type="date" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="De">
                                    <input type="date" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="À">
                                </div>
                            </div>
                            
                            <!-- Reservation count range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de réservations</label>
                                <div class="flex space-x-2">
                                    <input type="number" min="0" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="Min">
                                    <input type="number" min="0" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="Max">
                                </div>
                            </div>
                            
                            <!-- Reserved equipment types -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type d'équipement réservé</label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                                    <option value="">Tous les types</option>
                                    <option value="tentes">Tentes</option>
                                    <option value="sacs-couchage">Sacs de couchage</option>
                                    <option value="matelas">Matelas</option>
                                    <option value="cuisine">Équipement de cuisine</option>
                                    <option value="eclairage">Éclairage</option>
                                    <option value="accessoires">Accessoires divers</option>
                                </select>
                            </div>
                            
                            <!-- Recent activity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activité récente</label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                                    <option value="">Tous</option>
                                    <option value="24h">Actif dans les 24h</option>
                                    <option value="7d">Actif dans les 7 jours</option>
                                    <option value="30d">Actif dans les 30 jours</option>
                                    <option value="inactive_30d">Inactif depuis 30+ jours</option>
                                    <option value="inactive_90d">Inactif depuis 90+ jours</option>
                                </select>
                            </div>
                            
                            <!-- Spending range -->
                          
                            
                            <!-- User loyalty -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fidélité</label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                                    <option value="">Tous les clients</option>
                                    <option value="new">Nouveaux (1ère réservation)</option>
                                    <option value="returning">Clients réguliers (2-5 réservations)</option>
                                    <option value="loyal">Clients fidèles (6+ réservations)</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Filter action buttons -->
                        <div id="filter-actions" class="hidden mt-4 flex justify-end space-x-3">
                            <button class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors text-sm">
                                Réinitialiser les filtres
                            </button>
                            <button class="px-4 py-2 bg-admin-primary hover:bg-admin-dark text-white rounded-md shadow-sm transition-colors text-sm">
                                Appliquer les filtres
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Clients table -->
                <table class="min-w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ville</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Réservations</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Avis</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach($clients as $client)
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4">{{ $client->username }}</td>
            <td class="px-6 py-4">{{ $client->email }}</td>
            <td class="px-6 py-4">
                @if($client->phone_number)
                    <span class="px-2 py-1 text-sm bg-gray-100 text-gray-800 rounded-full">
                        {{ $client->phone_number }}
                    </span>
                @else
                    <span class="text-gray-400">Non spécifié</span>
                @endif
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-sm rounded-full {{ $client->city ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $client->city ? $client->city->name : 'Non spécifié' }}
                </span>
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-sm bg-purple-100 text-purple-800 rounded-full">
                    {{ $client->client_reservations_count }}
                </span>
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                    {{ $client->received_reviews_count }}
                </span>
            </td>
            <td class="px-6 py-4">
                @if($client->avg_rating)
                    <div class="flex items-center">
                        <span class="mr-1">{{ number_format($client->avg_rating, 1) }}</span>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                @else
                    <span class="text-gray-400">-</span>
                @endif
            </td>
            <td class="px-6 py-4 flex space-x-2">
               
                <button class="text-purple-600 hover:text-purple-800" title="Voir réservations">
                    <i class="fas fa-calendar-alt"></i>
                </button>
                <button class="text-red-600 hover:text-red-800" title="Bloquer">
                    <i class="fas fa-ban"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- After the table closing tag -->
</table>

<!-- Pagination -->
<div class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
    <div class="flex-1 flex justify-between sm:hidden">
        @if ($clients->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-md">
                Précédent
            </span>
        @else
            <a href="{{ $clients->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Précédent
            </a>
        @endif
        
        @if ($clients->hasMorePages())
            <a href="{{ $clients->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Suivant
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-md">
                Suivant
            </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700 dark:text-gray-400">
                Affichage de <span class="font-medium">{{ $clients->firstItem() }}</span> à <span class="font-medium">{{ $clients->lastItem() }}</span> sur <span class="font-medium">{{ $clients->total() }}</span> clients
            </p>
        </div>

        <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                {{-- Previous Page Link --}}
                @if ($clients->onFirstPage())
                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $clients->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                    @if ($page == $clients->currentPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($clients->hasMorePages())
                    <a href="{{ $clients->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </nav>
        </div>
    </div>
</div>
            </div>
        </main>
    </div>
    
    <!-- Client Detail Modal (hidden by default) -->
    <div id="client-detail-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Leila Mansouri" 
                         class="w-12 h-12 rounded-full object-cover mr-4" />
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Leila Mansouri</h3>
                        <div class="flex items-center">
                            <span class="badge badge-success mr-2">Actif</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">ID: CL-32567</span>
                        </div>
                    </div>
                </div>
                <button id="close-client-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Client details content -->
            <div class="p-5 overflow-y-auto flex-grow">
                <!-- Client details tabs -->
                <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex overflow-x-auto">
                        <button class="admin-tab active">Profil</button>
                        <button class="admin-tab">Réservations (5)</button>
                        <button class="admin-tab">Avis laissés (3)</button>
                        <button class="admin-tab">Historique</button>
                    </div>
                </div>
                
                <!-- Tab content - Profile -->
                <div class="tab-content">
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
                                    <span class="font-medium text-gray-900 dark:text-white">01/05/2023</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Ville:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Casablanca</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Adresse:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">75 Boulevard Anfa</span>
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
                                    <span class="font-medium text-gray-900 dark:text-white">5 (2 actives, 3 terminées)</span>
                                </div>
                              
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Avis laissés:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">3 (moyenne: 4.2★)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Signalements:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Verification -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Vérification</h4>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 mr-3">
                                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Email vérifié</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">01/05/2023</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 mr-3">
                                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Téléphone vérifié</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">01/05/2023</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 mr-3">
                                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Pièce d'identité vérifiée</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">02/05/2023</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Current Reservations -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Réservations actives</h4>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg overflow-hidden">
                            <table class="w-full admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Équipement</th>
                                        <th>Partenaire</th>
                                        <th>Dates</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-sm font-medium text-admin-primary dark:text-admin-secondary">#RS-56789</span>
                                        </td>
                                        <td>Grande Tente 6 Personnes</td>
                                        <td>
                                            <div class="flex items-center">
                                                <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                     alt="Omar Tazi" 
                                                     class="w-6 h-6 rounded-full object-cover mr-2" />
                                                <span>Omar Tazi</span>
                                            </div>
                                        </td>
                                        <td>5 - 10 Août 2023</td>
                                        <td>1 250 MAD</td>
                                        <td><span class="badge badge-success">Confirmée</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-sm font-medium text-admin-primary dark:text-admin-secondary">#RS-56923</span>
                                        </td>
                                        <td>Réchaud Camping + Kit Cuisine</td>
                                        <td>
                                            <div class="flex items-center">
                                                <img src="https://images.unsplash.com/photo-1548544149-4835e62ee5b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                     alt="Salma Benani" 
                                                     class="w-6 h-6 rounded-full object-cover mr-2" />
                                                <span>Salma Benani</span>
                                            </div>
                                        </td>
                                        <td>15 - 18 Août 2023</td>
                                        <td>450 MAD</td>
                                        <td><span class="badge badge-warning">En attente</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Recent activity -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Activité récente</h4>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg overflow-hidden">
                            <table class="w-full admin-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Action</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01/08/2023 10:15</td>
                                        <td>Connexion</td>
                                        <td>Connexion depuis Chrome/Windows</td>
                                    </tr>
                                    <tr>
                                        <td>01/08/2023 10:18</td>
                                        <td>Recherche</td>
                                        <td>A recherché "équipement camping Agadir"</td>
                                    </tr>
                                    <tr>
                                        <td>01/08/2023 10:32</td>
                                        <td>Visualisation</td>
                                        <td>A consulté l'équipement "Réchaud Camping + Kit Cuisine"</td>
                                    </tr>
                                    <tr>
                                        <td>01/08/2023 10:45</td>
                                        <td>Réservation</td>
                                        <td>A envoyé une demande de réservation pour "Réchaud Camping + Kit Cuisine"</td>
                                    </tr>
                                </tbody>
                            </table>
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
                                </div>
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
                            <textarea class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm" rows="3" placeholder="Ajouter une note concernant ce client..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-5 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button id="cancel-client-details" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md mr-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Fermer
                </button>
                <button class="px-4 py-2 bg-admin-primary hover:bg-admin-dark text-white font-medium rounded-md shadow-sm transition-colors">
                    Sauvegarder les modifications
                </button>
            </div>
        </div>
    </div>
    
    <!-- Client Reservations Modal (hidden by default) -->
    <div id="client-reservations-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Leila Mansouri" 
                         class="w-12 h-12 rounded-full object-cover mr-4" />
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Réservations de Leila Mansouri</h3>
                        <div class="text-sm text-gray-600 dark:text-gray-400">5 réservations au total</div>
                    </div>
                </div>
                <button id="close-reservations-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Reservations content -->
            <div class="p-5 overflow-y-auto flex-grow">
                <!-- Filters -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="flex items-center space-x-4">
                        <button class="px-3 py-1.5 bg-admin-primary text-white text-sm rounded-md">Toutes (5)</button>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md">Actives (2)</button>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md">Terminées (3)</button>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <select class="pl-3 pr-8 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm appearance-none">
                                <option value="newest">Plus récentes</option>
                                <option value="oldest">Plus anciennes</option>
                                <option value="highest">Montant le plus élevé</option>
                                <option value="lowest">Montant le plus bas</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="pl-8 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 dark:text-gray-500 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Reservations -->
                <div class="mb-8">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-4">Réservations actives</h4>
                    
                    <!-- Reservation Card 1 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden mb-4 shadow-sm">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-48 h-48 md:h-auto relative">
                                <img src="https://images.unsplash.com/photo-1530541930197-ff16ac917b0e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Grande Tente 6 Personnes" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute top-2 left-2">
                                    <span class="badge badge-success">Confirmée</span>
                                </div>
                            </div>
                            
                            <div class="flex-1 p-4">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                                    <div>
                                        <h5 class="font-semibold text-lg text-gray-900 dark:text-white">Grande Tente 6 Personnes</h5>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Quechua - Comme Neuf</p>
                                        
                                        <div class="flex items-center mt-2">
                                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                 alt="Omar Tazi" 
                                                 class="w-6 h-6 rounded-full object-cover mr-2" />
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Omar Tazi</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 md:mt-0 text-right">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">Réf:</span> #RS-56789
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            <span class="font-medium">Réservé le:</span> 25/07/2023
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-800 rounded p-3 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Dates</p>
                                            <p class="font-medium text-gray-900 dark:text-white">5 - 10 Août 2023</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Durée</p>
                                            <p class="font-medium text-gray-900 dark:text-white">5 jours</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Montant total</p>
                                            <p class="font-medium text-gray-900 dark:text-white">1 250 MAD</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <span>Marrakech</span>
                                    </div>
                                    
                                    <div class="flex mt-3 sm:mt-0 space-x-2">
                                        <button class="px-3 py-1 text-xs bg-admin-primary text-white rounded">
                                            <i class="fas fa-eye mr-1"></i> Détails
                                        </button>
                                        <button class="px-3 py-1 text-xs border border-amber-300 dark:border-amber-700 text-amber-700 dark:text-amber-400 rounded">
                                            <i class="fas fa-edit mr-1"></i> Modifier
                                        </button>
                                        <button class="px-3 py-1 text-xs border border-red-300 dark:border-red-700 text-red-700 dark:text-red-400 rounded">
                                            <i class="fas fa-ban mr-1"></i> Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reservation Card 2 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden mb-4 shadow-sm">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-48 h-48 md:h-auto relative">
                                <img src="https://images.unsplash.com/photo-1510312305653-8ed496efae75?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Réchaud Camping + Kit Cuisine" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute top-2 left-2">
                                    <span class="badge badge-warning">En attente</span>
                                </div>
                            </div>
                            
                            <div class="flex-1 p-4">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                                    <div>
                                        <h5 class="font-semibold text-lg text-gray-900 dark:text-white">Réchaud Camping + Kit Cuisine</h5>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Coleman - Bon état</p>
                                        
                                        <div class="flex items-center mt-2">
                                            <img src="https://images.unsplash.com/photo-1548544149-4835e62ee5b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                 alt="Salma Benani" 
                                                 class="w-6 h-6 rounded-full object-cover mr-2" />
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Salma Benani</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 md:mt-0 text-right">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">Réf:</span> #RS-56923
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            <span class="font-medium">Réservé le:</span> 01/08/2023
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-800 rounded p-3 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Dates</p>
                                            <p class="font-medium text-gray-900 dark:text-white">15 - 18 Août 2023</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Durée</p>
                                            <p class="font-medium text-gray-900 dark:text-white">3 jours</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Montant total</p>
                                            <p class="font-medium text-gray-900 dark:text-white">450 MAD</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <span>Agadir</span>
                                    </div>
                                    
                                    <div class="flex mt-3 sm:mt-0 space-x-2">
                                        <button class="px-3 py-1 text-xs bg-admin-primary text-white rounded">
                                            <i class="fas fa-eye mr-1"></i> Détails
                                        </button>
                                        <button class="px-3 py-1 text-xs border border-amber-300 dark:border-amber-700 text-amber-700 dark:text-amber-400 rounded">
                                            <i class="fas fa-edit mr-1"></i> Modifier
                                        </button>
                                        <button class="px-3 py-1 text-xs border border-red-300 dark:border-red-700 text-red-700 dark:text-red-400 rounded">
                                            <i class="fas fa-ban mr-1"></i> Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Past Reservations -->
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-4">Réservations terminées</h4>
                    
                    <!-- Past Reservation Table -->
                    <div class="overflow-x-auto bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <table class="w-full admin-table">
                            <thead>
                                <tr>
                                    <th>Réf.</th>
                                    <th>Équipement</th>
                                    <th>Partenaire</th>
                                    <th>Dates</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#RS-45678</td>
                                    <td>Matelas Gonflable Double</td>
                                    <td>Omar Tazi</td>
                                    <td>10-15 Juil. 2023</td>
                                    <td>600 MAD</td>
                                    <td><span class="badge badge-info">Terminée</span></td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#RS-42367</td>
                                    <td>Tente 2 Personnes</td>
                                    <td>Salma Benani</td>
                                    <td>20-23 Juin 2023</td>
                                    <td>400 MAD</td>
                                    <td><span class="badge badge-info">Terminée</span></td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#RS-39845</td>
                                    <td>Kit de Cuisine Complet</td>
                                    <td>Karim Lamrani</td>
                                    <td>5-10 Juin 2023</td>
                                    <td>200 MAD</td>
                                    <td><span class="badge badge-info">Terminée</span></td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="p-5 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button id="close-reservations-details" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Fermer
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
</body>
</html>