@extends('layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
   
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

   
    <div class="flex pt-16">
      
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
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-[#1E40AF] dark:text-[#3B82F6] text-xs rounded-full h-5 px-1.5 flex items-center justify-center"></span>
                        </a>
                        <a href="{{ route('admin.clients') }}"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Clients
                            <span
                                class="ml-auto bg-admin-light dark:bg-admin-dark text-[#1E40AF] dark:text-[#3B82F6] text-xs rounded-full h-5 px-1.5 flex items-center justify-center"></span>
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

        <div class="md:ml-64 w-full">
            <div class="max-w-7xl mx-auto px-4 text-gray-800 dark:text-gray-200 dark:bg-gray-900 sm:px-6 lg:px-8 py-8">
             
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Statistiques des Réservations</h2>



              
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @forelse ($reservationStats as $status => $total)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
                            <p class="text-sm uppercase font-semibold text-gray-600 dark:text-gray-300">{{ ucfirst($status) }}
                            </p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $total }}</p>
                        </div>
                    @empty
                        <p class="text-gray-600 dark:text-gray-300">Aucune donnée disponible.</p>
                    @endforelse
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 text-gray-800 dark:text-gray-200 dark:bg-gray-900 sm:px-6 lg:px-8 py-8">
                <form method="GET" action="{{ route('admin.reservations.index') }}" class="mb-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="relative w-full sm:w-1/2">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400" aria-hidden="true"></i>
                            </div>
                            <input type="text" name="search" placeholder="Rechercher par nom, prénom..."
                                value="{{ request('search') }}"
                                class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg w-full dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#1E40AF]"
                                aria-label="Rechercher des réservations">
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-[#0055A4] text-white rounded-lg hover:bg-[#00448a] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0055A4]">
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>

       
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Liste des Réservations</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                        aria-label="Liste des réservations">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    #</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Client</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Partenaire</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Statut</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Début</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Fin</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($reservations->reverse() as $reservation)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                                            {{ $reservation->id }}</td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                                            {{ $reservation->client->first_name }} {{ $reservation->client->last_name }}</td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                                            {{ $reservation->partner->first_name }} {{ $reservation->partner->last_name }}</td>
                                                        <td class="px-4 py-4 whitespace-nowrap">
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                                        {{ match ($reservation->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'ongoing' => 'bg-purple-100 text-purple-800',
                                    'canceled' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-200 text-gray-800'
                                } }} ">
                                                                {{ ucfirst($reservation->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                                            {{ $reservation->start_date }}</td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                                            {{ $reservation->end_date }}</td>
                                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

             
                @if(isset($reservations) && $reservations->hasPages())
                    <div class="mt-6">
                        {{ $reservations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
     
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');

            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function () {
                    const expanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                    userMenuButton.setAttribute('aria-expanded', !expanded);
                    userDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function (event) {
                    if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                        userDropdown.classList.add('hidden');
                        userMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
            }

          
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                    mobileMenuButton.setAttribute('aria-expanded', !expanded);
                    mobileMenu.classList.toggle('hidden');
                });
            }

            const ctx = document.getElementById('reservationsChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_keys($reservationStats)) !!},
                        datasets: [{
                            label: 'Nombre de Réservations',
                            data: {!! json_encode(array_values($reservationStats)) !!},
                            backgroundColor: [
                                '#facc15', // pending
                                '#3b82f6', // confirmed
                                '#8b5cf6', // ongoing
                                '#ef4444', // canceled
                                '#22c55e', // completed
                            ],
                            borderRadius: 6,
                            barThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return `${context.dataset.label}: ${context.formattedValue}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(156, 163, 175, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection