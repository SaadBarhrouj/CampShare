<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - Dashboard Partenaire</title>

    <!-- Styles / Scripts -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    

    <link rel="icon" href="{{ asset('images/favicon_io/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/favicon_io/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="CampShare - Louez facilement le matériel de camping dont vous avez besoin
    directement entre particuliers.">
    <meta name="keywords" content="camping, location, matériel, aventure, plein air, partage, communauté">

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

    <style>
        /* Navigation hover effects */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: currentColor;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Active link style */
        .active-nav-link {
            position: relative;
        }
        
        .active-nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #FFAA33;
        }
        
        /* Input styles */
        .custom-input {
            transition: all 0.3s ease;
            border-width: 2px;
        }
        
        .custom-input:focus {
            box-shadow: 0 0 0 3px rgba(45, 95, 43, 0.2);
        }
        
        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-switch .slider {
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
        
        .toggle-switch .slider:before {
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
        
        .toggle-switch input:checked + .slider {
            background-color: #2D5F2B;
        }
        
        .dark .toggle-switch input:checked + .slider {
            background-color: #4F7942;
        }
        
        .toggle-switch input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        /* Sidebar active */
        .sidebar-link.active {
            background-color: rgba(45, 95, 43, 0.1);
            color: #2D5F2B;
            border-left: 4px solid #2D5F2B;
        }
        
        .dark .sidebar-link.active {
            background-color: rgba(79, 121, 66, 0.2);
            color: #4F7942;
            border-left: 4px solid #4F7942;
        }
        
        /* Equipment card hover effect */
        .equipment-card {
            transition: all 0.3s ease;
        }
        
        .equipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Chat styles */
        .chat-container {
            max-height: 400px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        
        .chat-message {
            margin-bottom: 15px;
            display: flex;
        }
        
        .chat-message.outgoing {
            justify-content: flex-end;
        }
        
        .chat-bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 80%;
        }
        
        .chat-message.incoming .chat-bubble {
            background-color: #f3f4f6;
            border-bottom-left-radius: 5px;
        }
        
        .dark .chat-message.incoming .chat-bubble {
            background-color: #374151;
        }
        
        .chat-message.outgoing .chat-bubble {
            background-color: #2D5F2B;
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .dark .chat-message.outgoing .chat-bubble {
            background-color: #4F7942;
        }

        /* Styles pour les boutons principaux - action buttons */
        button[type="submit"],
        a.inline-flex,
        button.px-4.py-2,
        button.px-6.py-2,
        .w-full.md\\:w-auto.px-4.py-2,
        button.inline-flex {
            background-color: #2D5F2B !important; /* forest color */
            color: white !important;
            transition: all 0.3s ease;
        }
        
        /* Exceptions pour les boutons retour/annuler */
        button[id^="back-to-step"],
        button[onclick="toggleEditMode(false)"] {
            background-color: white !important;
            color: #374151 !important;
            border: 1px solid #D1D5DB !important;
        }
        
        /* Hover state for action buttons */
        button[type="submit"]:hover,
        a.inline-flex:hover,
        button.px-4.py-2:hover,
        button.px-6.py-2:hover,
        .w-full.md\\:w-auto.px-4.py-2:hover,
        button.inline-flex:hover {
            background-color: #215A1A !important; /* darker forest */
        }


    </style>
    <style>
        .filter-chip {
        @apply px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer transition-colors mr-2 mb-2;
        @apply bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300;
    }

    .filter-chip.active {
        @apply bg-forest dark:bg-meadow text-white;
    }

    .filter-chip:hover {
        @apply bg-gray-200 dark:bg-gray-600;
    }

    .filter-chip.active:hover {
        @apply bg-green-700 dark:bg-green-600;
    }

    /* Filter chip styles */
    .filter-chip {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 0.75rem;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                font-weight: 500;
                margin-right: 0.5rem;
                margin-bottom: 0.5rem;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .filter-chip.active {
                background-color: #2D5F2B;
                color: white;
            }

            .dark .filter-chip.active {
                background-color: #4F7942;
            }

            .filter-chip:not(.active) {
                background-color: #f3f4f6;
                color: #374151;
                border: 1px solid #e5e7eb;
            }

            .dark .filter-chip:not(.active) {
                background-color: #374151;
                color: #e5e7eb;
                border: 1px solid #4b5563;
            }

            .filter-chip:hover:not(.active) {
                background-color: #e5e7eb;
            }

            .dark .filter-chip:hover:not(.active) {
                background-color: #4b5563;
            }

    </style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
@include('Partenaire.side-bar');



    <div class="flex flex-col md:flex-row pt-16">
        <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Page header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Demandes de Réservation</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez toutes vos demandes de location entrantes.</p>
                    </div>
                </div>

                <!-- Filters and search -->
                <form  id="filters-form" >
                @csrf

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2 md:mb-0">Filtrer les demandes</h2>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Rechercher..." 
                                    class="px-4 py-2 pr-10 w-full md:w-64 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-base custom-input"
                                >
                                <input type="hidden" id="partner-email" name="email" value="{{ $user->email }}">

                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @php
                                $statuses = ['all' => 'Toutes', 'Pending' => 'En Attente', 'confirmed' => 'Confirmée', 'ongoing' => 'ongoing', 'canceled' => 'canceled', 'completed' => 'completed'];
                            @endphp

                            @foreach($statuses as $key => $label)
                                <button 
                                    type="button"
                                    name="status"
                                    value="{{ $key }}"
                                    class="filter-chip {{ request('status', 'all') === $key ? 'active' : '' }}"
                                >
                                    <span>{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="status" id="selected-status" value="{{ request('status', 'all') }}">

                        <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="flex items-center">
                                <label for="date-filter" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Date:</label>
                                <select 
                                    id="date-filter" 
                                    name="date" 
                                    class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-sm custom-input"
                                >
                                    <option value="all" {{ request('date') == 'all' ? 'selected' : '' }}>Toutes les dates</option>
                                    <option value="this-month" {{ request('date') == 'this-month' ? 'selected' : '' }}>Ce mois-ci</option>
                                    <option value="last-month" {{ request('date') == 'last-month' ? 'selected' : '' }}>Mois dernier</option>
                                    <option value="last-3-months" {{ request('date') == 'last-3-months' ? 'selected' : '' }}>3 derniers mois</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <label for="sort-by" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Trier par:</label>
                                <select 
                                    id="sort-by" 
                                    name="sort" 
                                    class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-sm custom-input"
                                >
                                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Date (plus récent)</option>
                                    <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Date (plus ancien)</option>
                                
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Rental requests list -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h2 class="font-bold text-xl text-gray-900 dark:text-white">Liste des demandes</h2>
                        <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-3 py-1 text-xs font-medium rounded-full">
                           {{$NumberReservationCompleted}} demandes au total
                        </span>
                    </div>

                    <!-- Request items -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div id="reservations">
                            @foreach($AllReservationForPartner as $Reservation)
                                <div class="px-6 py-4">
                                    <div class="flex flex-col lg:flex-row lg:items-start">


                                        <div class="flex-grow grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4 lg:mb-0">
                                            <div>
                                            <div class="flex-shrink-0 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">
    
                                                <div class="flex items-center lg:w-16">
                                                    <img src="{{$Reservation->avatar_url}}"
                                                        alt="Mehdi Idrissi" 
                                                        class="w-12 h-12 rounded-full object-cover" />
                                                    <div class="lg:hidden ml-1">
                                                        <h3 class="font-medium text-gray-900 dark:text-white">{{$Reservation->username}}</h3>
                                                        <div class="flex text-sm">
                                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                                            <span>4.8 <span class="text-gray-500 dark:text-gray-400">(14)</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hidden lg:block mt-2">
                                                    <h3 class="font-medium text-gray-900 dark:text-white">{{$Reservation->username}}</h3>
                                                    <div class="flex items-center justify-center text-xs mt-1">
                                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                                        <span>4.8</span>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>     
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Équipement</p>
                                                <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                                    <span class="truncate">{{$Reservation->title}}</span>
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Dates</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{$Reservation->start_date}} - {{$Reservation->end_date}}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">({{$Reservation->number_days}})</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Montant</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{$Reservation->montant_total}} MAD</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">({{$Reservation->price_per_day }}MAD/jour)</p>
                                            </div>
                                        </div>

                                        <div class="flex flex-col items-start lg:items-end lg:ml-6 space-y-3">
                                            @if($Reservation->status == "pending")
                                                <div class="status-badge bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300">
                                                    <i class="fas fa-clock mr-1"></i> {{$Reservation->status}}
                                                </div>
                                                
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{$Reservation->created_at}}</p>
                                                <div class="flex space-x-2 w-full lg:w-auto">
                                                <form method="POST" action="{{ route('partenaire.reservations.accept', $Reservation->id) }}" class="flex-1 lg:flex-initial">
                                                    @csrf 
                                                    <button type="submit" class="w-full px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                                        Accepter
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('partenaire.reservations.reject', $Reservation->id) }}" class="flex-1 lg:flex-initial">
                                                        @csrf
                                                        <button type="submit" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                            Refuser
                                                        </button>
                                                 </form>
                                                    <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                        <i class="fas fa-comment-alt"></i>
                                                    </button>
                                                </div>
                                            
                                            @elseif($Reservation->status == "confirmed")
                                            <div class="status-badge bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300"">
                                                <i class="fas fa-clock mr-1"></i> {{$Reservation->status}}
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{$Reservation->created_at}}</p>
                                            @elseif($Reservation->status == "ongoing")
                                            <div class="status-badge bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300"">
                                                <i class="fas fa-clock mr-1"></i> {{$Reservation->status}}
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{$Reservation->created_at}}</p>
                                            @elseif($Reservation->status == "canceled")
                                            <div class="status-badge bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300"">
                                                <i class="fas fa-clock mr-1"></i> {{$Reservation->status}}
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{$Reservation->created_at}}</p>
                                            @else
                                            <div class="status-badge bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300">
                                                <i class="fas fa-clock mr-1"></i> {{$Reservation->status}}
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{$Reservation->created_at}}</p>
                                            @endif
                                        


                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>



                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-between">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Affichage de 
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $AllReservationForPartner->firstItem() }}
                            </span> 
                            à 
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $AllReservationForPartner->lastItem() }}
                            </span> 
                            sur 
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $AllReservationForPartner->total() }}
                            </span> demandes
                        </div>
                        <div>
                            {{ $AllReservationForPartner->links() }}
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </main>
    </div>



<script>
    function sendFilterRequest() {
        var formData = new FormData(document.getElementById('filters-form'));  // Get all the form data

        // Send the data via AJAX
        fetch('{{ route("demandes.filter") }}', {  
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF token
            },
            body: formData  // Send the form data
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response data (e.g., update the UI)
            console.log(data);  // For debugging

            if (data.success) {
                console.log("here");
                const reservaion = document.getElementById("reservations");
                reservaion.innerHTML = ""; 

                if (data.demandes.length > 0) {
                    data.demandes.forEach(reservation => {
                        let newReservation = `
                        <div class="px-6 py-4">
                            <div class="flex flex-col lg:flex-row lg:items-start">
                                <div class="flex-shrink-0 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">
                                    <div class="flex items-center lg:w-16">
                                        <img src="${reservation.avatar_url}" 
                                            alt="Mehdi Idrissi" 
                                            class="w-12 h-12 rounded-full object-cover" />
                                        <div class="lg:hidden ml-3">
                                            <h3 class="font-medium text-gray-900 dark:text-white">${reservation.username}</h3>
                                            <div class="flex items-center text-sm">
                                                <i class="fas fa-star text-amber-400 mr-1"></i>
                                                <span>4.8 <span class="text-gray-500 dark:text-gray-400">(14)</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden lg:block mt-2">
                                        <h3 class="font-medium text-gray-900 dark:text-white text-center">${reservation.username}</h3>
                                        <div class="flex items-center justify-center text-xs mt-1">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span>4.8</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-grow grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4 lg:mb-0">
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Équipement</p>
                                        <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                            <span class="truncate">${reservation.title}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Dates</p>
                                        <p class="font-medium text-gray-900 dark:text-white">${reservation.start_date} - ${reservation.end_date}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">(${reservation.number_days})</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Montant</p>
                                        <p class="font-medium text-gray-900 dark:text-white">${reservation.montant_total} MAD</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">(${reservation.price_per_day} MAD/jour)</p>
                                    </div>
                                </div>

                                <div class="flex flex-col items-start lg:items-end lg:ml-6 space-y-3">
                                    ${getStatusBadge(reservation.status, reservation.created_at,reservation.id)}
                                </div>
                            </div>
                        </div>`;

                        reservaion.insertAdjacentHTML('beforeend', newReservation);
                    });
                }
            }
        })
        .catch(error => console.error('Error:', error));  // Catch any errors
    }

    function getStatusBadge(status, createdAt,id) {
        let statusClass = '';
        let textColor = '';
        let buttons = '';

        switch (status) {
            case "pending":
                statusClass = "bg-amber-100 dark:bg-amber-900/30";
                textColor = "text-amber-800 dark:text-amber-300";
                buttons = `
                    <div class="flex space-x-2 w-full lg:w-auto">
                        <form action="{{ route('reservation.action') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="reservation_id" value="${id}">
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm rounded-md w-full">
                                Accepter
                            </button>
                        </form>

                        <!-- Refuse Button -->
                        <form action="{{ route('reservation.action') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="reservation_id" value="${id}">
                            <input type="hidden" name="action" value="refuse">
                            <button type="submit" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 w-full">
                                Refuser
                            </button>
                        </form>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-comment-alt"></i>
                        </button>
                    </div>`;
                break;
            case "confirmed":
            case "ongoing":
                statusClass = "bg-green-100 dark:bg-green-900/30";
                textColor = "text-green-800 dark:text-green-300";
                break;
            case "canceled":
                statusClass = "bg-green-100 dark:bg-green-900/30";
                textColor = "text-green-800 dark:text-green-300";
                break;
            default:
                statusClass = "bg-amber-100 dark:bg-amber-900/30";
                textColor = "text-amber-800 dark:text-amber-300";
        }

        return `
            <div class="flex flex-col items-start lg:items-end lg:ml-6 space-y-3">
                <div class="status-badge ${statusClass} ${textColor}">
                    <i class="fas fa-clock mr-1"></i> ${status}
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">${createdAt}</p>
                ${buttons}
            </div>
        `;
    }
    document.querySelectorAll('.filter-chip').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('selected-status').value = this.value;

            document.querySelectorAll('.filter-chip').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Trigger the AJAX request
            sendFilterRequest();
        });
    });
    document.getElementById('filters-form').addEventListener('change', function(event) {
        // Check if the event target is an input or select element
        if (event.target.matches('input, select, textarea')) {
            sendFilterRequest(); 
        }
    });

    document.getElementById('filters-form').addEventListener('input', function(event) {
        // Trigger on typing inside input or textarea
        if (event.target.matches('input, textarea')) {
            sendFilterRequest(); 
        }
    });
    document.getElementById('filters-form').addEventListener('click', function(event) {
        // Check if the event target is a button (e.g., reset button or apply button)
        if (event.target.matches('button')) {
            event.preventDefault(); // Prevent the default action (e.g., form submission)
            sendFilterRequest();  // Call the function to send the request
        }
    });
</script>
</body>
<script>
  const links = document.querySelectorAll(".sidebar-link");
  const components = document.querySelectorAll(".component");

  links.forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = link.getAttribute("data-target");
      
      // Ne rien faire si data-target n'est pas défini (cas du lien "Mes annonces")
      if (!targetId) return;

      // Supprimer active class de tous les liens
      links.forEach(l => l.classList.remove("active"));
      // Ajouter active class au lien cliqué
      link.classList.add("active");

      // Cacher tous les composants
      components.forEach(comp => {
        comp.classList.add("hidden");
      });

      // Afficher le composant cible
      document.getElementById(targetId).classList.remove("hidden");
      
      // Fermer le menu mobile si ouvert
      if (window.innerWidth < 768) {
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        if (mobileSidebar && mobileSidebarOverlay) {
          mobileSidebar.classList.add('transform', '-translate-x-full');
          mobileSidebarOverlay.classList.add('hidden');
        }
      }
    });
  });
</script>
<script>
    // Dropdown toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // User dropdown toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        
        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
                document.getElementById('notifications-dropdown').classList.add('hidden');
            });
        }

        // Notifications dropdown toggle
        const notificationsButton = document.getElementById('notifications-button');
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        
        if (notificationsButton && notificationsDropdown) {
            notificationsButton.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationsDropdown.classList.toggle('hidden');
                document.getElementById('user-dropdown').classList.add('hidden');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            if (userDropdown) userDropdown.classList.add('hidden');
            if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
        });

        // Prevent dropdown from closing when clicking inside
        if (userDropdown) {
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
        
        if (notificationsDropdown) {
            notificationsDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>


</html>




