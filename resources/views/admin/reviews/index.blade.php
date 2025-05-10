@extends('layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<!-- Navbar -->
<nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
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
                            <a href="#"
                                class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                            </a>
                            <form action="#" method="POST" class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
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

<!-- Main Content with Sidebar -->
<div class="flex pt-16">
    <!-- Sidebar -->
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
                    <a href="#"
                        class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                        Partenaires
                    </a>
                    <a href="#"
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
                        <span class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-1.5 flex items-center justify-center">
                            {{ \App\Models\Review::count() }}
                        </span>
                    </a>
                </nav>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="md:ml-64 flex-1 p-6 mt-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h1 class="font-extrabold text-3xl text-[#173BCA] dark:text-white flex items-center space-x-2">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span>Évaluations des utilisateurs</span>
                    </h1>

                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $reviews->total() }} évaluations au total
                    </div>
                </div>
            </div>
            
            <!-- Barre de recherche -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/20">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Rechercher par email ou nom..." 
                           class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary">
                </div>
            </div>
            
            <!-- Container pour le tableau -->
            <div class="overflow-x-auto" id="reviewsTableContainer">
                @include('admin.reviews.partials.reviews_table', ['reviews' => $reviews])
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/20">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // User dropdown toggle
    document.getElementById('user-menu-button').addEventListener('click', function() {
        document.getElementById('user-dropdown').classList.toggle('hidden');
    });

    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#user-menu-button')) {
            const dropdown = document.getElementById('user-dropdown');
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        }
    });

    // Fonction de recherche avec AJAX
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value;
        const url = new URL(window.location.href);
        
        fetch(`{{ route('admin.reviews') }}?search=${encodeURIComponent(searchTerm)}&ajax=1`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('reviewsTableContainer').innerHTML = data.html;
            
            // Mettre à jour la pagination
            const paginationContainer = document.querySelector('.pagination');
            if (paginationContainer && data.pagination) {
                paginationContainer.innerHTML = data.pagination;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Optionnel: Afficher un message d'erreur à l'utilisateur
        });
    });

    // Gestion du clic sur la pagination après une recherche
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;
            
            fetch(`${url}&ajax=1`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('reviewsTableContainer').innerHTML = data.html;
                
                // Mettre à jour la pagination
                const paginationContainer = document.querySelector('.pagination');
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                }
                
                // Mettre à jour l'URL dans la barre d'adresse sans recharger la page
                window.history.pushState({}, '', url.split('&ajax=1')[0]);
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>
@endsection