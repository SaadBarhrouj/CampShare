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
                                <label for="date-filter" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Date</label>
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
                                <label for="sort-by" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Trier par</label>
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
                                            
                                            <div class="flex gap-2 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">
    
                                                <div class="flex items-center lg:w-16">
                                                    <img src="{{ asset($Reservation->avatar_url)}}"
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

                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Équipement</p>
                                                <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                                    <span class="truncate">{{$Reservation->title}}</span>
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Durée de résérvation</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{$Reservation->start_date}} - {{$Reservation->end_date}}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">( {{$Reservation->number_days}} jours )</p>
                                            </div>

                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Montant</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{$Reservation->montant_total}} MAD</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">( {{$Reservation->price_per_day }} MAD /jour )</p>
                                            </div>

                                        </div>

                                        <div class="flex flex-col items-start lg:ml-6 space-y-3">
                                            @if($Reservation->status == "pending")
                                                <div class="status-badge bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300">
                                                    <i class="fas fa-clock mr-1"></i> En attente
                                                </div>
                                                
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mr-12 text-nowrap">{{ $Reservation->created_at }}</p>
                                                <div class="flex space-x-2 w-full lg:w-auto">
                                                    <form method="POST" action="{{ route('partenaire.reservations.accept', $Reservation->id) }}" class="flex-1 lg:flex-initial">
                                                        @csrf 
                                                        <button type="submit" class="w-full px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                                            Accepter
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('partenaire.reservations.reject', $Reservation->id) }}" class="flex-1 lg:flex-initial">
                                                        @csrf
                                                        <button type="submit" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                            Refuser
                                                        </button>
                                                    </form>
                                                </div>

                                            @elseif($Reservation->status == "confirmed")
                                                <div class="status-badge bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                                    <i class="fas fa-check-circle mr-1"></i> Confirmée
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mr-12 text-nowrap">{{ $Reservation->created_at }}</p>

                                            @elseif($Reservation->status == "ongoing")
                                                <div class="status-badge bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                                    <i class="fas fa-spinner mr-1"></i> En cours
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mr-12 text-nowrap">{{ $Reservation->created_at }}</p>

                                            @elseif($Reservation->status == "canceled")
                                                <div class="status-badge bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                                    <i class="fas fa-times-circle mr-1"></i> Annulée
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mr-12 text-nowrap">{{ $Reservation->created_at }}</p>

                                            @elseif($Reservation->status == "completed")
                                                <div class="status-badge bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                    <i class="fas fa-check-circle mr-1"></i> Terminée
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mr-12 text-nowrap">{{ $Reservation->created_at }}</p>

                                            @else
                                                <div class="status-badge bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300">
                                                    <i class="fas fa-question-circle mr-1"></i> {{ ucfirst($Reservation->status) }}
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mr-12 text-nowrap">{{ $Reservation->created_at }}</p>
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
                        const date = new Date(reservation.created_at);
                        const formattedCreatedAt = date.toLocaleString('fr-FR', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        const avatarUrl = "{{ asset('') }}";
                        const fullUrl = avatarUrl + reservation.avatar_url;
                        let newReservation = `
                        <div class="px-6 py-4">
                            <div class="flex flex-col lg:flex-row lg:items-start">

                                <div class="flex-grow grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4 lg:mb-0">

                                    <div class="flex gap-2 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">

                                        <div class="flex items-center lg:w-16">
                                            <img src="${fullUrl}" 
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

                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Équipement</p>
                                        <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                            <span class="truncate">${reservation.title}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Durée de résérvation</p>
                                        <p class="font-medium text-gray-900 dark:text-white">${reservation.start_date} - ${reservation.end_date}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">( ${reservation.number_days} jours )</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Montant</p>
                                        <p class="font-medium text-gray-900 dark:text-white">${reservation.montant_total} MAD</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">( ${reservation.price_per_day} MAD /jour )</p>
                                    </div>
                                </div>

                                <div class="flex flex-col items-start lg:ml-6 space-y-3">
                                


                                    ${getStatusBadge(reservation.status, formattedCreatedAt,reservation.id)}
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
                statusLabel = "En attente";
                icon = "fa-clock";
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
                        <form action="{{ route('reservation.action') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="reservation_id" value="${id}">
                            <input type="hidden" name="action" value="refuse">
                            <button type="submit" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 w-full">
                                Refuser
                            </button>
                        </form>
                    </div>`;
                break;
                
            case "confirmed":
                statusClass = "bg-blue-100 dark:bg-blue-900/30";
                textColor = "text-blue-800 dark:text-blue-300";
                statusLabel = "Confirmée";
                icon = "fa-check-circle";
                buttons = '';
                break;
                
            case "ongoing":
                statusClass = "bg-purple-100 dark:bg-purple-900/30";
                textColor = "text-purple-800 dark:text-purple-300";
                statusLabel = "En cours";
                icon = "fa-spinner";
                buttons = '';
                break;
                
            case "canceled":
                statusClass = "bg-red-100 dark:bg-red-900/30";
                textColor = "text-red-800 dark:text-red-300";
                statusLabel = "Annulée";
                icon = "fa-times-circle";
                buttons = '';
                break;
                
            case "completed":
                statusClass = "bg-green-100 dark:bg-green-900/30";
                textColor = "text-green-800 dark:text-green-300";
                statusLabel = "Terminée";
                icon = "fa-check-circle";
                buttons = '';
                break;
                
            default:
                statusClass = "bg-gray-100 dark:bg-gray-900/30";
                textColor = "text-gray-800 dark:text-gray-300";
                statusLabel = status.charAt(0).toUpperCase() + status.slice(1);
                icon = "fa-question-circle";
                buttons = '';
        }

        return `
            <div class="flex flex-col items-start lg:ml-6 space-y-3">
                <div class="status-badge ${statusClass} ${textColor}">
                    <i class="fas ${icon} mr-1"></i> ${statusLabel}
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">${createdAt}</p>
                ${buttons || ''}
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



</html>




