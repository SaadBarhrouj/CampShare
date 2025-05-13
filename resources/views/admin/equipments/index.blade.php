@extends('layouts.app')
<!-- Version gratuite via CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


@section('content')
    <!-- Navigation avec style amélioré -->
    <nav
        class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
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
                        <button id="notifications-button"
                            class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                            <i class="fas fa-bell"></i>
                            <span
                                class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">5</span>
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
                                <i
                                    class="fas fa-chevron-down text-xs text-gray-500 group-hover:text-admin-primary transition-colors"></i>
                            </button>

                            <!-- Dropdown -->
                            <div id="user-dropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg z-50 overflow-hidden border border-gray-100 dark:border-gray-700">
                                <div class="py-2">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                    </a>
                                    <form action="#" method="POST"
                                        class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
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

        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button"
                class="text-gray-600 dark:text-gray-300 hover:text-admin-primary dark:hover:text-admin-secondary focus:outline-none">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
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
                        <div
                            class="h-10 w-10 rounded-full bg-admin-primary/20 flex items-center justify-center text-admin-primary">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800 dark:text-white">Mohamed Alami</div>
                        <div class="text-sm font-medium text-admin-primary dark:text-admin-secondary">Super Admin</div>
                    </div>
                    <div class="ml-auto flex items-center space-x-4">
                        <button
                            class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 relative">
                            <i class="fas fa-bell text-lg"></i>
                            <span
                                class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">5</span>
                        </button>
                        <button
                            class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                            <i class="fas fa-cog text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#profile"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                    </a>
                    <a href="#account-settings"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-cog mr-2 opacity-70"></i> Paramètres
                    </a>
                    <a href="#admin-logs"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-history mr-2 opacity-70"></i> Historique d'actions
                    </a>

                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

                    <a href="#logout"
                        class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content with Sidebar -->
    <div class="flex pt-16">
        <!-- Sidebar amélioré -->
        <aside
            class="hidden md:block w-64 bg-white dark:bg-gray-800 shadow-md h-screen fixed overflow-y-auto border-r border-gray-100 dark:border-gray-700">
            <div class="p-5">
                <div class="mb-6 px-2">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 pl-3">
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
                        </a>

                        <a href="{{ route('admin.clients') }}"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Clients
                        </a>

                    </nav>
                </div>



                <div class="mb-6 px-2">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 pl-3">
                        Equi. Réserv. & Avis</h5>
                    <nav class="space-y-1">
                        <a href="#"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-admin-primary dark:text-admin-secondary rounded-lg bg-blue-50 dark:bg-blue-900/20 font-semibold transition-colors">
                            <i class="fas fa-campground w-5 mr-3 text-admin-primary dark:text-admin-secondary"></i>
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
                            <span
                                class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-1.5 flex items-center justify-center">
                                {{ \App\Models\Review::count() }}
                            </span>
                        </a>
                    </nav>
                </div>
            </div>
        </aside>


        <div class="w-full md:pl-64">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">
                        <i class="fas fa-campground text-blue-500 mr-2"></i>
                        Les Équipements Disponibles
                    </h1>

                    <div class="flex items-center space-x-2">
                        <button
                            class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Filtrer
                        </button>

                        <button
                            class="px-3 py-1.5 bg-admin-primary text-white rounded-lg text-sm font-medium hover:bg-admin-primary/90 transition-colors">
                            <i class="fas fa-sync-alt mr-1"></i> Actualiser
                        </button>
                    </div>
                </div>


                <form method="GET" action="{{ route('equipements.index') }}" class="mb-8">
                    <div class="relative">
                        <input type="text" name="search"
                            placeholder="Rechercher un équipement par nom, type ou partenaire..."
                            value="{{ request('search') }}"
                            class="w-full sm:w-2/3 lg:w-1/2 px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                        </div>
                    </div>
                </form>


                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($equipments as $item)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-100 dark:border-gray-700 transition duration-300 overflow-hidden group">

                            <div class="relative h-48 overflow-hidden">
                                @if($item->images->first())
                                    <img src="{{ asset($item->images->first()->url) }}" alt="{{ $item->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <i class="fas fa-camping-tent text-4xl"></i>
                                    </div>
                                @endif


                                <div
                                    class="absolute bottom-0 right-0 bg-yellow-500 text-white px-3 py-1 text-sm font-bold rounded-tl-lg">
                                    {{ $item->price_per_day }} DH <span class="text-xs font-normal">/ jour</span>
                                </div>


                                <a href="{{ route('admin.annonces.show', $item->id) }}"
                                    class="absolute top-2 right-2 bg-white/90 dark:bg-gray-700/90 text-gray-800 dark:text-white p-2 rounded-full shadow-md hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200 transform hover:scale-110"
                                    title="Voir les détails">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                            </div>

                            <div class="p-4">
                                <h2
                                    class="text-lg font-bold text-gray-800 dark:text-white mb-2 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $item->title }}
                                </h2>

                                <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2 mb-3">
                                    {{ $item->description }}
                                </p>

                                <div
                                    class="flex justify-between items-center pt-2 border-t border-gray-100 dark:border-gray-700">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-user text-blue-400 mr-1"></i>
                                        {{ $item->partner->email ?? 'Inconnu' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-blue-50 dark:bg-blue-900/20 rounded-lg p-8 text-center">
                            <i class="fas fa-camping-tent text-blue-400 text-4xl mb-4"></i>
                            <p class="text-blue-600 dark:text-blue-400 font-medium text-lg">Aucun équipement disponible
                                actuellement.</p>
                            <p class="text-gray-500 dark:text-gray-400 mt-2">Les équipements ajoutés apparaîtront ici.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex justify-center">
                    <nav class="inline-flex rounded-md shadow">
                        <a href="#"
                            class="py-2 px-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-l-md border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                        <a href="#"
                            class="py-2 px-4 bg-blue-500 text-white font-medium border border-blue-500 hover:bg-blue-600 transition-colors">1</a>
                        <a href="#"
                            class="py-2 px-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">2</a>
                        <a href="#"
                            class="py-2 px-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-r-md border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour la gestion des menus et des interactions -->
    <script>
        // User dropdown toggle
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

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
@endsection