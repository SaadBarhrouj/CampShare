<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil | Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Utilisé si Vite est configuré --}}
</head>

<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900">

<!-- Navigation -->
    <nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('index') }}" class="flex items-center">
                        <span class="text-[#1E40AF] dark:text-[#3B82F6] text-3xl font-extrabold">Camp<span class="text-[#FFAA33]">Share</span></span>
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
                                                class="text-xs text-[#1E40AF] dark:text-[#3B82F6] font-medium">
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
                    <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 hover:text-[#1E40AF] dark:hover:text-[#3B82F6] focus:outline-none">
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
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#1E40AF] dark:focus:ring-[#3B82F6] text-sm">
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
                        <div class="text-sm font-medium text-[#1E40AF] dark:text-[#3B82F6]">Super Admin</div>
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

<!-- Sidebar -->
<aside class="hidden md:block w-64 bg-white dark:bg-gray-800 shadow-md h-screen fixed left-0 top-16 overflow-y-auto">
    <div class="p-5">
        <div class="mb-6 px-3">
            <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                Menu Principal</h5>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors">
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
                    class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Partenaires
                </a>
                <a href="{{ route('admin.clients') }}"
                    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Clients
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
                </a>
            </nav>
        </div>
    </div>
</aside>

<!-- Main Content - Correctly positioned to account for sidebar -->
<main class="md:ml-64 bg-white dark:bg-gray-900 min-h-screen">
    <div class="pt-16 px-4 sm:px-6 lg:px-8">
        <section class="py-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                    Mon profil administrateur
                </h2>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900 text-green-600 dark:text-green-400 p-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 sm:p-8">
                    <!-- Profil admin -->
                    <div class="flex flex-col md:flex-row items-start gap-8">
                        <!-- Photo de profil -->
                        <div class="w-full md:w-1/3 flex flex-col items-center">
                            <div class="relative mb-4">
                                @if($admin->avatar_url)
                                    <img src="{{ asset($admin->avatar_url) }}" alt="Photo de profil" 
                                         class="w-40 h-40 object-cover rounded-full border-4 border-white shadow-md">
                                @else
                                    <div class="w-40 h-40 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-4 border-white shadow-md">
                                        <i class="fas fa-user text-gray-400 dark:text-gray-500 text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $admin->first_name }} {{ $admin->last_name }}
                                </h3>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ ucfirst($admin->role) }}
                                </span>
                            </div>
                        </div>

                        <!-- Informations du profil -->
                        <div class="w-full md:w-2/3 mt-6 md:mt-0">
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom d'utilisateur</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white">{{ $admin->username }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white">{{ $admin->email }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléphone</dt>
                                    <dd class="text-sm text-gray-900 dark:text-white">{{ $admin->phone_number ?? 'Non renseigné' }}</dd>
                                </div>
                            </dl>

                            <div class="mt-6 flex">
                                <a href="{{ route('admin.profile.edit.form') }}" 
                                   class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="fas fa-edit mr-2"></i> Modifier mon profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- JavaScript pour le menu déroulant et autres fonctionnalités -->
<script>
    // Toggle user dropdown
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    }
</script>

</body>
</html> 