<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Partenaires - CampShare | Administration</title>
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
                        <a href="admin-dashboard.html" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Tableau de bord
                        </a>
                        <a href="#users" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Utilisateurs
                            <span class="ml-auto bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary text-xs rounded-full h-5 px-1.5 flex items-center justify-center">328</span>
                        </a>
                        <a href="{{ route('admin.partners') }}" class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
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
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Gestion des Partenaires</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Liste de tous les partenaires de la plateforme</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <a href="#export-partners" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Exporter
                        </a>
                        <a href="#add-partner" class="inline-flex items-center px-4 py-2 bg-admin-primary hover:bg-admin-dark text-white rounded-md shadow-sm transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un partenaire
                        </a>
                    </div>
                </div>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats card 1 - Total Partners -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-admin-light dark:bg-admin-dark mr-4">
                                <i class="fas fa-handshake text-admin-primary dark:text-admin-secondary"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Partenaires</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">86</h3>
                                    <span class="text-green-600 dark:text-green-400 text-sm flex items-center ml-2">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        8.6%
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    vs mois précédent
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 2 - Active Partners -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30 mr-4">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Partenaires Actifs</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">76</h3>
                                    <span class="text-gray-600 dark:text-gray-400 text-sm flex items-center ml-2">
                                        (88.4%)
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    10 inactifs/suspendus
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 3 - Equipment Count -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900/30 mr-4">
                                <i class="fas fa-campground text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Équipements listés</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">432</h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    Moyenne: 5.02 par partenaire
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 4 - Revenue -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900/30 mr-4">
                                <i class="fas fa-money-bill-wave text-amber-600 dark:text-amber-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Revenus générés</p>
                                <div class="flex items-center">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">65.8K MAD</h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">
                                    Commission: 9.87K MAD
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Filters and search -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-8 p-5">
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                        <!-- Search bar -->
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" id="partner-search" placeholder="Rechercher un partenaire par nom, email ou téléphone..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                                </div>
                            </div>
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
                                <div class="option" data-value="pending">En attente de vérification</div>
                            </div>
                        </div>
                        
                        <!-- Sort filter -->
                        <div class="relative inline-block text-left" id="sort-filter-container">
                            <button id="sort-filter-button" class="inline-flex justify-between items-center w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-primary dark:focus:ring-admin-secondary">
                                <span>Trier par: Récents</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div id="sort-filter-dropdown" class="filter-dropdown right-0 hidden">
                                <div class="option active" data-value="recent">Plus récents</div>
                                <div class="option" data-value="oldest">Plus anciens</div>
                                <div class="option" data-value="name-asc">Nom (A-Z)</div>
                                <div class="option" data-value="name-desc">Nom (Z-A)</div>
                                <div class="option" data-value="equipment-count">Nombre d'équipements</div>
                                <div class="option" data-value="reservation-count">Nombre de réservations</div>
                                <div class="option" data-value="revenue">Revenus générés</div>
                            </div>
                        </div>
                        
                        <!-- City filter -->
                       
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
                            
                            <!-- Equipment count range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre d'équipements</label>
                                <div class="flex space-x-2">
                                    <input type="number" min="0" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="Min">
                                    <input type="number" min="0" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="Max">
                                </div>
                            </div>
                            
                            <!-- Average rating -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Note moyenne</label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                                    <option value="">Toutes les notes</option>
                                    <option value="4.5">4.5 étoiles et plus</option>
                                    <option value="4">4 étoiles et plus</option>
                                    <option value="3">3 étoiles et plus</option>
                                    <option value="2">2 étoiles et plus</option>
                                    <option value="1">1 étoile et plus</option>
                                </select>
                            </div>
                            
                            <!-- Signal flags -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Signalements</label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                                    <option value="">Tous</option>
                                    <option value="no_signals">Sans signalements</option>
                                    <option value="has_signals">Avec signalements</option>
                                    <option value="multiple_signals">Signalements multiples</option>
                                </select>
                            </div>
                            
                            <!-- Verification status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut de vérification</label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                                    <option value="">Tous</option>
                                    <option value="verified">Vérifié</option>
                                    <option value="not_verified">Non vérifié</option>
                                    <option value="pending">En attente</option>
                                </select>
                            </div>
                            
                            <!-- Revenue range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Revenus générés (MAD)</label>
                                <div class="flex space-x-2">
                                    <input type="number" min="0" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="Min">
                                    <input type="number" min="0" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm" placeholder="Max">
                                </div>
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
                
                <!-- Partners table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h2 class="font-bold text-lg text-gray-900 dark:text-white">Liste des partenaires</h2>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400 mr-4">86 partenaires au total</span>
                            <div class="relative">
                                <select class="pl-3 pr-8 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm appearance-none">
                                    <option value="10">10 par page</option>
                                    <option value="25">25 par page</option>
                                    <option value="50">50 par page</option>
                                    <option value="100">100 par page</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full admin-table">
                            <thead>
                                <tr>
                                    <th class="w-12">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-admin-primary focus:ring-admin-primary dark:border-gray-600 dark:bg-gray-700">
                                        </label>
                                    </th>
                                    <th>Partenaire</th>
                                    <th>Contact</th>
                                    <th>Localisation</th>
                                    <th>Statistiques</th>
                                    <th>Inscription</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Partner row 1 -->
                                <tr>
                                    <td>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-admin-primary focus:ring-admin-primary dark:border-gray-600 dark:bg-gray-700">
                                        </label>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                 alt="Omar Tazi" 
                                                 class="w-10 h-10 rounded-full object-cover mr-3" />
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Omar Tazi</p>
                                                <div class="flex items-center text-amber-400 dark:text-amber-400 mt-0.5">
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star-half-alt text-xs"></i>
                                                    <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">4.8</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">omar.tazi@example.com</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">+212 6 12 34 56 78</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Marrakech</p>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-sm">
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Équipements:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">8</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations reçues:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">32</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations faites:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">5</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">04/01/2022</p>
                                        <p class="text-green-600 dark:text-green-400 text-xs">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            En ligne il y a 30 min
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">Signalé</span>
                                    </td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-200 dark:hover:bg-purple-900/40" title="Voir les équipements">
                                                <i class="fas fa-campground"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/40" title="Voir les réservations">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/40" title="Suspendre le compte">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Partner row 2 -->
                                <tr>
                                    <td>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-admin-primary focus:ring-admin-primary dark:border-gray-600 dark:bg-gray-700">
                                        </label>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                                                 alt="Fatima Benali" 
                                                 class="w-10 h-10 rounded-full object-cover mr-3" />
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Fatima Benali</p>
                                                <div class="flex items-center text-amber-400 dark:text-amber-400 mt-0.5">
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">5.0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">fatima.benali@example.com</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">+212 6 98 76 54 32</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Casablanca</p>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-sm">
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Équipements:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">5</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations reçues:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">25</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations faites:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">3</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">12/03/2022</p>
                                        <p class="text-green-600 dark:text-green-400 text-xs">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            En ligne il y a 5 heures
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Actif</span>
                                    </td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-200 dark:hover:bg-purple-900/40" title="Voir les équipements">
                                                <i class="fas fa-campground"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/40" title="Voir les réservations">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/40" title="Suspendre le compte">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Partner row 3 -->
                                <tr>
                                    <td>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-admin-primary focus:ring-admin-primary dark:border-gray-600 dark:bg-gray-700">
                                        </label>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1548544149-4835e62ee5b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                 alt="Salma Benani" 
                                                 class="w-10 h-10 rounded-full object-cover mr-3" />
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Salma Benani</p>
                                                <div class="flex items-center text-amber-400 dark:text-amber-400 mt-0.5">
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star-half-alt text-xs"></i>
                                                    <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">4.7</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">salma.benani@example.com</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">+212 6 65 43 21 09</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Agadir</p>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-sm">
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Équipements:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">3</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations reçues:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">14</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations faites:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">8</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">05/04/2022</p>
                                        <p class="text-green-600 dark:text-green-400 text-xs">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            En ligne il y a 2 jours
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Actif</span>
                                    </td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-200 dark:hover:bg-purple-900/40" title="Voir les équipements">
                                                <i class="fas fa-campground"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/40" title="Voir les réservations">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/40" title="Suspendre le compte">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Partner row 4 -->
                                <tr>
                                    <td>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-admin-primary focus:ring-admin-primary dark:border-gray-600 dark:bg-gray-700">
                                        </label>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1605462863863-10d9e47e15ee?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                                                 alt="Mohammed Ziani" 
                                                 class="w-10 h-10 rounded-full object-cover mr-3" />
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Mohammed Ziani</p>
                                                <div class="flex items-center text-amber-400 dark:text-amber-400 mt-0.5">
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="far fa-star text-xs"></i>
                                                    <i class="far fa-star text-xs"></i>
                                                    <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">3.0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">mohammed.ziani@example.com</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">+212 6 54 32 10 98</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Rabat</p>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-sm">
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Équipements:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">4</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations reçues:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">9</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations faites:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">2</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">15/05/2022</p>
                                        <p class="text-red-600 dark:text-red-400 text-xs">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            Dernière activité il y a 15 jours
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">Suspendu</span>
                                    </td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-200 dark:hover:bg-purple-900/40" title="Voir les équipements">
                                                <i class="fas fa-campground"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/40" title="Voir les réservations">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/40" title="Réactiver le compte">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Partner row 5 -->
                                <tr>
                                    <td>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-admin-primary focus:ring-admin-primary dark:border-gray-600 dark:bg-gray-700">
                                        </label>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1566753323558-f4e0952af115?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                                                 alt="Karim Lamrani" 
                                                 class="w-10 h-10 rounded-full object-cover mr-3" />
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Karim Lamrani</p>
                                                <div class="flex items-center text-amber-400 dark:text-amber-400 mt-0.5">
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="far fa-star text-xs"></i>
                                                    <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">4.2</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">karim.lamrani@example.com</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">+212 6 87 65 43 21</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Tanger</p>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-sm">
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Équipements:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">7</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations reçues:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">28</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations faites:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">0</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">22/02/2022</p>
                                        <p class="text-green-600 dark:text-green-400 text-xs">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            En ligne il y a 8 heures
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Actif</span>
                                    </td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-200 dark:hover:bg-purple-900/40" title="Voir les équipements">
                                                <i class="fas fa-campground"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/40" title="Voir les réservations">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/40" title="Suspendre le compte">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Partner row 6 -->
                                <tr>
                                    <td>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="rounded border-gray-300 text-admin-primary focus:ring-admin-primary dark:border-gray-600 dark:bg-gray-700">
                                        </label>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                                                 alt="Nadia Amrani" 
                                                 class="w-10 h-10 rounded-full object-cover mr-3" />
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Nadia Amrani</p>
                                                <div class="flex items-center text-amber-400 dark:text-amber-400 mt-0.5">
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <i class="fas fa-star text-xs"></i>
                                                    <span class="ml-1 text-gray-600 dark:text-gray-400 text-xs">4.9</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">nadia.amrani@example.com</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">+212 6 10 98 76 54</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">Marrakech</p>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-sm">
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Équipements:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">6</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations reçues:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">38</span>
                                            </p>
                                            <p class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Réservations faites:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">5</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">10/12/2021</p>
                                        <p class="text-green-600 dark:text-green-400 text-xs">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            En ligne il y a 1 jour
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Actif</span>
                                    </td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <button class="p-1.5 text-xs rounded-md bg-admin-light dark:bg-admin-dark text-admin-primary dark:text-admin-secondary hover:bg-blue-200 dark:hover:bg-blue-900/40" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-200 dark:hover:bg-purple-900/40" title="Voir les équipements">
                                                <i class="fas fa-campground"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/40" title="Voir les réservations">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="p-1.5 text-xs rounded-md bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/40" title="Suspendre le compte">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 sm:mb-0">
                            Affichage de <span class="font-medium">1-6</span> sur <span class="font-medium">86</span> partenaires
                        </div>
                        
                        <div class="flex items-center justify-center space-x-2">
                            <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <button class="px-3 py-1 rounded-md bg-admin-primary text-white font-medium">
                                1
                            </button>
                            
                            <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                2
                            </button>
                            
                            <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                3
                            </button>
                            
                            <span class="text-gray-500">...</span>
                            
                            <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                15
                            </button>
                            
                            <button class="px-3 py-1 rounded-md border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Partner Detail Modal (hidden by default) -->
    <div id="partner-detail-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Omar Tazi" 
                         class="w-12 h-12 rounded-full object-cover mr-4" />
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Omar Tazi</h3>
                        <div class="flex items-center">
                            <span class="badge badge-warning mr-2">Signalé</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">ID: #PT-24789</span>
                        </div>
                    </div>
                </div>
                <button id="close-partner-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Partner details content -->
            <div class="p-5 overflow-y-auto flex-grow">
                <!-- Partner details tabs -->
                <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex overflow-x-auto">
                        <button class="admin-tab active">Profil</button>
                        <button class="admin-tab">Équipements (8)</button>
                        <button class="admin-tab">Réservations reçues (32)</button>
                        <button class="admin-tab">Réservations faites (5)</button>
                        <button class="admin-tab">Avis (24)</button>
                        <button class="admin-tab">Signalements (2)</button>
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
                                    <span class="font-medium text-gray-900 dark:text-white">Omar Tazi</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Email:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">omar.tazi@example.com</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Téléphone:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">+212 6 12 34 56 78</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Date d'inscription:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">04/01/2022</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Ville:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Marrakech</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Adresse:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">135 Avenue Mohammed V</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account stats -->
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Statistiques du compte</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Statut du compte:</span>
                                    <span class="badge badge-warning">Signalé</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Dernière connexion:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Il y a 30 min</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Équipements listés:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">8 (7 actifs, 1 inactif)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Réservations reçues:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">32 (3 en cours)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Réservations faites:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">5 (1 en cours)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Revenus générés:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">9 850 MAD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Verification and identity -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Vérification et identité</h4>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 mr-3">
                                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Email vérifié</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">04/01/2022</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 mr-3">
                                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Téléphone vérifié</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">04/01/2022</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 mr-3">
                                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Pièce d'identité vérifiée</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">05/01/2022</p>
                                    </div>
                                </div>
                            </div>
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
                                        <td>03/08/2023 14:32</td>
                                        <td>Réservation confirmée</td>
                                        <td>A confirmé la réservation #RS-12345 pour "Grande Tente 6 Personnes"</td>
                                    </tr>
                                    <tr>
                                        <td>03/08/2023 10:15</td>
                                        <td>Ajout d'équipement</td>
                                        <td>A ajouté un nouvel équipement "Matelas confort double"</td>
                                    </tr>
                                    <tr>
                                        <td>02/08/2023 16:48</td>
                                        <td>Paiement reçu</td>
                                        <td>A reçu un paiement de 750 MAD pour la location de "Réchaud camping"</td>
                                    </tr>
                                    <tr>
                                        <td>31/07/2023 09:22</td>
                                        <td>Message envoyé</td>
                                        <td>A envoyé un message à Leila Mansouri concernant sa réservation</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Signalements -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg mb-3">Signalements (2)</h4>
                        <div class="space-y-4">
                            <div class="bg-red-50 dark:bg-red-900/10 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <div class="p-2 rounded-full bg-red-100 dark:bg-red-900/30 mr-3 mt-1">
                                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Comportement inapproprié</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">Signalé par Younes Hadri le 01/08/2023</p>
                                            </div>
                                            <span class="badge badge-danger">Non résolu</span>
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                                            Le partenaire a été impoli lors de la remise du matériel et a refusé de me montrer comment utiliser l'équipement. Il a également cherché à me facturer des frais supplémentaires qui n'étaient pas mentionnés dans l'annonce.
                                        </p>
                                        <div class="mt-3 flex justify-end space-x-2">
                                            <button class="px-3 py-1 text-xs bg-admin-primary text-white rounded-md">Traiter</button>
                                            <button class="px-3 py-1 text-xs border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md">Ignorer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-red-50 dark:bg-red-900/10 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <div class="p-2 rounded-full bg-red-100 dark:bg-red-900/30 mr-3 mt-1">
                                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">Équipement défectueux</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">Signalé par Ahmed Kaddour le 20/07/2023</p>
                                            </div>
                                            <span class="badge badge-danger">Non résolu</span>
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                                            La tente louée avait plusieurs déchirures qui n'étaient pas mentionnées dans l'annonce. Quand j'ai contacté le propriétaire, il a refusé de me rembourser ou de proposer une solution alternative.
                                        </p>
                                        <div class="mt-3 flex justify-end space-x-2">
                                            <button class="px-3 py-1 text-xs bg-admin-primary text-white rounded-md">Traiter</button>
                                            <button class="px-3 py-1 text-xs border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md">Ignorer</button>
                                        </div>
                                    </div>
                                </div>
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
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-envelope mr-1"></i> Envoyer email
                                </button>
                                <button class="px-3 py-1.5 border border-orange-300 dark:border-orange-700 text-orange-700 dark:text-orange-400 text-sm rounded-md hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Avertir
                                </button>
                                <button class="px-3 py-1.5 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-400 text-sm rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <i class="fas fa-ban mr-1"></i> Suspendre
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Notes administratives:</label>
                            <textarea class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm" rows="3" placeholder="Ajouter une note concernant ce partenaire...">L'utilisateur a reçu deux signalements en moins d'un mois. Un avertissement a été envoyé le 02/08/2023. Surveiller de près ses activités.</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-5 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button id="cancel-partner-details" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md mr-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
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
            
            // Status filter dropdown
            if (statusFilterButton && !statusFilterButton.contains(e.target) && !statusFilterDropdown.contains(e.target)) {
                statusFilterDropdown.classList.add('hidden');
            }
            
            // Sort filter dropdown
            if (sortFilterButton && !sortFilterButton.contains(e.target) && !sortFilterDropdown.contains(e.target)) {
                sortFilterDropdown.classList.add('hidden');
            }
            
            // City filter dropdown
            if (cityFilterButton && !cityFilterButton.contains(e.target) && !cityFilterDropdown.contains(e.target)) {
                cityFilterDropdown.classList.add('hidden');
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
        const cityFilterButton = document.getElementById('city-filter-button');
        const cityFilterDropdown = document.getElementById('city-filter-dropdown');
        
        // Status filter
        statusFilterButton?.addEventListener('click', () => {
            statusFilterDropdown.classList.toggle('hidden');
            sortFilterDropdown.classList.add('hidden');
            cityFilterDropdown.classList.add('hidden');
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
            cityFilterDropdown.classList.add('hidden');
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
        
        // City filter
        cityFilterButton?.addEventListener('click', () => {
            cityFilterDropdown.classList.toggle('hidden');
            statusFilterDropdown.classList.add('hidden');
            sortFilterDropdown.classList.add('hidden');
        });
        
        // City filter options
        const cityOptions = cityFilterDropdown?.querySelectorAll('.option');
        cityOptions?.forEach(option => {
            option.addEventListener('click', () => {
                cityOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');
                cityFilterButton.querySelector('span').textContent = `Ville: ${option.textContent}`;
                cityFilterDropdown.classList.add('hidden');
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
        
        // Partner detail modal
        const partnerViewButtons = document.querySelectorAll('button .fas.fa-eye');
        const partnerDetailModal = document.getElementById('partner-detail-modal');
        const closePartnerModal = document.getElementById('close-partner-modal');
        const cancelPartnerDetails = document.getElementById('cancel-partner-details');
        
        partnerViewButtons.forEach(button => {
            button.parentElement.addEventListener('click', (e) => {
                e.preventDefault();
                partnerDetailModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });
        
        closePartnerModal?.addEventListener('click', () => {
            partnerDetailModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        cancelPartnerDetails?.addEventListener('click', () => {
            partnerDetailModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Close modal when clicking outside
        partnerDetailModal?.addEventListener('click', (e) => {
            if (e.target === partnerDetailModal) {
                partnerDetailModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Partner detail tabs
        const adminTabs = document.querySelectorAll('.admin-tab');
        
        adminTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                adminTabs.forEach(el => el.classList.remove('active'));
                
                tab.classList.add('active');
                
            });
        });
    </script>
</body>
</html>