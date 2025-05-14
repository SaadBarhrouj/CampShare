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

<nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo stylisé -->
            <div class="flex-shrink-0 flex items-center">
                <a href="#" class="flex items-center">
                   <span class="text-3xl font-extrabold leading-none">
                       <span class="text-[#173BCA]">Camp</span><span class="text-[#FDAA2A]">Share</span>
                   </span>
                    <span class="text-xs ml-2 text-[#6B7280] bg-[#F1F2F6] px-2 py-1 rounded-full font-medium">
                        ADMIN
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative">
                    <button id="notifications-button" class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">5</span>
                    </button>
                </div>

                <!-- User menu -->
                @auth
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-3 focus:outline-none group">
                        <div class="flex flex-col items-start">
                            <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">
                                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                            </span>
                            <span class="text-xs text-admin-primary dark:text-admin-secondary font-medium">
                                {{ ucfirst(auth()->user()->role) ?? 'Utilisateur' }}
                            </span>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-500 group-hover:text-admin-primary transition-colors"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg z-50 overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="py-2">
                            <a href="{{ route('admin.profile.edit') }}"
                                class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
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