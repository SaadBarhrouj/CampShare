<div class="flex flex-col md:flex-row pt-16">
       
        
        <!-- Main content -->
        <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Dashboard header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Tableau de bord</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Bienvenue, {{$user->username}} ! Voici un résumé de votre activité.</p>
                    </div>
                </div>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats card 1 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                                <i class="fas fa-coins text-green-600 dark:text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Revenus du mois</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$sumPayment}} MAD</h3>
                                <p class="text-green-600 dark:text-green-400 text-sm flex items-center mt-1">
                                    
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                                <i class="fas fa-exchange-alt text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Locations réalisées</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$NumberReservationCompleted}}</h3>
                                <p class="text-blue-600 dark:text-blue-400 text-sm flex items-center mt-1">
                                    
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 3 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-amber-100 dark:bg-amber-900 mr-4">
                                <i class="fas fa-star text-amber-600 dark:text-amber-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Note moyenne</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$AverageRating}} / 5</h3>
                                <p class="text-amber-600 dark:text-amber-400 text-sm flex items-center mt-1">
                                    
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats card 4 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                                <i class="fas fa-campground text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Listings actifs</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$TotalListingActive}} / {{$TotalListing}}</h3>
                                <p class="text-purple-600 dark:text-purple-400 text-sm flex items-center mt-1">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent activity and rental requests -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Recent activity -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="font-bold text-xl text-gray-900 dark:text-white">Avis Recent</h2>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($lastAvisPartnerForObjet as $avis)
                            <div class="px-6 py-4">
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                            <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{$avis->username}} -  Equipment : {{$avis->object_title}}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                              commentaire: {{$avis->comment}}
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                                        @php
                                            $rating = $avis->rating;  
                                            $fullStars = floor($rating); 
                                            $halfStar = $rating - $fullStars !=0
                                        @endphp

                                            <div class="flex text-amber-400">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                        
                                            @if ($halfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 text-center">
                            <a href="#all-activity" class="text-forest dark:text-meadow hover:underline text-sm font-medium">
                                Voir toute l'activité
                            </a>
                        </div>
                    </div>
                    
                    <!-- Rental requests -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h2 class="font-bold text-xl text-gray-900 dark:text-white">Demandes de location</h2>
                            <span class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 px-3 py-1 text-xs font-medium rounded-full">
                               {{$NumberPendingReservation}} en attente
                            </span>
                        </div>
                        @foreach ($pendingReservation as $Reservation)
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="px-6 py-4">
                                <div class="flex items-start">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                         alt="Mehdi Idrissi" 
                                         class="w-10 h-10 rounded-full object-cover mr-4" />
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h3 class="font-medium text-gray-900 dark:text-white">{{$Reservation->username}}</h3>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{$Reservation->created_at}}</span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                            Souhaite louer <span class="font-medium">{{$Reservation->title}}</span>
                                        </p>
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded p-2 mb-3">
                                            <div class="flex justify-between text-sm mb-1">
                                                <span class="text-gray-600 dark:text-gray-400">Dates:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{$Reservation->start_date}} - {{$Reservation->end_date}}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600 dark:text-gray-400">Montant total:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{$Reservation->montant_total}} MAD ({{$Reservation->number_days}} jours)</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                        <form action="{{ route('reservation.action') }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="reservation_id" value="{{ $Reservation->id }}">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm rounded-md w-full">
                                                    Accepter
                                                </button>
                                            </form>

                                            <!-- Refuse Button -->
                                            <form action="{{ route('reservation.action') }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="reservation_id" value="{{ $Reservation->id }}">
                                                <input type="hidden" name="action" value="refuse">
                                                <button type="submit" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 w-full">
                                                    Refuser
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                        </div>
                        @endforeach
                        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 text-center">
                            <a href="toutes-les-demandes" class="text-forest dark:text-meadow hover:underline text-sm font-medium">
                                Voir toutes les demandes
                            </a>
                        </div>
                    </div>
                </div>
                

                
                <!-- My equipment section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Mes équipements</h2>
                        <a href="#equipment" data-target="AllMyEquipement" class="sidebar-link text-forest dark:text-meadow hover:underline text-sm font-medium">
                            Voir tous mes équipements
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($RecentListing as $Listing)


                        <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                     alt="Pack Camping Complet 2p" 
                                     class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                @if($Listing->status == "active")
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">{{$Listing->status}}</span>
                                    </div>
                                @elseif($Listing->status == "inactive")
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{$Listing->status}}</span>
                                    </div>
                                @else
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">{{$Listing->status}}</span>
                                    </div>
                                @endif
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg truncate">{{$Listing->title}}p</h3>
                                    <p class="text-gray-200 text-sm">{{$Listing->name}} - Excellent état</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <div>
                                        <span class="font-bold text-lg text-gray-900 dark:text-white">{{$Listing->price_per_day}} MAD</span>
                                        <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                        <span>4.8 <span class="text-gray-500 dark:text-gray-400">(18)</span></span>
                                    </div>
                                </div>
                                
                                <div class="text-sm mb-3">
                                    <span class="text-gray-600 dark:text-gray-300">Dispo. du 1 août au 1 oct.</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-medium text-purple-600 dark:text-purple-400">
                                            <i class="fas fa-fire-alt mr-1"></i> Populaire
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="#edit-equipment" class="p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#equipment-status" class="p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        
                        
                       
                        
                        <!-- Add Equipment Card -->
                        <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center h-80">
                            <div class="p-6 text-center">
                                <div class="w-16 h-16 bg-forest/10 dark:bg-forest/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-plus text-forest dark:text-meadow text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Ajouter un équipement</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                    Vous pouvez ajouter un nouvel équipement pour le proposer à la location.
                                </p>
                                <a href="#add-equipment" class="inline-flex items-center px-4 py-2 bg-forest hover:bg-green-700 text-white rounded-md shadow-sm transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Latest reviews -->
                
            </div>
        </main>
    </div>
    
    <!-- Equipment Settings Modal (hidden by default) -->
    <div id="equipment-settings-modal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full mx-4">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Paramètres de l'équipement</h3>
                <button id="close-equipment-settings" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-5">
                <div class="flex items-center mb-6">
                    <img src="https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Pack Camping Complet 2p" 
                         class="w-14 h-14 rounded-md object-cover mr-4" />
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Pack Camping Complet 2p</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">MSR - Excellent état</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <!-- Status toggle -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white">Statut de l'annonce</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Activer ou désactiver l'annonce</p>
                        </div>
                        <div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Archive option -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white">Archiver l'annonce</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">L'annonce ne sera plus visible</p>
                        </div>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Archiver
                        </button>
                    </div>
                    
                    <!-- Availability dates -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white">Dates de disponibilité</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Du 1 août au 1 oct. 2023</p>
                        </div>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Modifier
                        </button>
                    </div>
                    
                    <!-- Price setting -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white">Prix journalier</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">450 MAD/jour</p>
                        </div>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Modifier
                        </button>
                    </div>
                    
                    <!-- Equipment details edit -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white">Éditer les détails</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Photos, description, etc.</p>
                        </div>
                        <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Éditer
                        </button>
                    </div>
                    
                    <!-- Delete equipment -->
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <h5 class="font-medium text-red-600 dark:text-red-400">Supprimer l'équipement</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cette action est irréversible</p>
                        </div>
                        <button class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition-colors">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="p-5 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button id="cancel-equipment-settings" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md mr-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Annuler
                </button>
                <button class="px-4 py-2 bg-forest hover:bg-green-700 text-white font-medium rounded-md shadow-sm transition-colors">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    <!-- Message Modal (hidden by default) -->
    <div id="message-modal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Mehdi Idrissi" 
                         class="w-10 h-10 rounded-full object-cover mr-3" />
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Mehdi Idrissi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pack Camping Complet 2p</p>
                    </div>
                </div>
                <button id="close-message-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-5 overflow-y-auto flex-grow">
                <div class="chat-container">
                    <!-- Message thread -->
                    <div class="chat-message incoming">
                        <div class="chat-bubble">
                            <p class="text-gray-800 dark:text-gray-200">Bonjour ! Je suis intéressé par votre Pack Camping Complet 2p pour un séjour au lac Lalla Takerkoust du 10 au 15 août. Est-ce qu'il est disponible durant cette période ?</p>
                            <p class="text-xs text-gray-500 mt-1">11:42 AM</p>
                        </div>
                    </div>
                    
                    <div class="chat-message outgoing">
                        <div class="chat-bubble">
                            <p class="text-white">Bonjour Mehdi, oui le pack est disponible pour ces dates ! Avez-vous besoin d'informations supplémentaires sur le contenu du pack ?</p>
                            <p class="text-xs text-gray-300 mt-1">11:48 AM</p>
                        </div>
                    </div>
                    
                    <div class="chat-message incoming">
                        <div class="chat-bubble">
                            <p class="text-gray-800 dark:text-gray-200">Super ! Est-ce que le pack inclut des assiettes et des couverts ? Nous serons 2 personnes.</p>
                            <p class="text-xs text-gray-500 mt-1">11:53 AM</p>
                        </div>
                    </div>
                    
                    <div class="chat-message outgoing">
                        <div class="chat-bubble">
                            <p class="text-white">Oui, le pack comprend 2 sets d'assiettes, bols, couverts et tasses en plastique réutilisable. Il y a aussi une petite casserole, une poêle et une bouilloire.</p>
                            <p class="text-xs text-gray-300 mt-1">11:57 AM</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <form id="message-form" class="flex items-end">
                    <div class="flex-grow">
                        <textarea id="message-input" placeholder="Tapez votre message..." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-base resize-none custom-input" rows="3"></textarea>
                    </div>
                    <div class="ml-3 flex flex-col space-y-2">
                        <button type="button" class="p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <button type="submit" class="p-2 bg-forest hover:bg-green-700 text-white rounded-md shadow-sm transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
