
       <style>
        @layer utilities {
  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
}
    </style>
        
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
                    
                    
                    <!-- Stats card 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                                <i class="fa-regular fa-circle-check text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Locations réalisées</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$NumberReservationCompleted}}</h3>
                                <p class="text-blue-600 dark:text-blue-400 text-sm flex items-center mt-1">
                                    
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <!-- Stats card 4 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                                <i class="fa-solid fa-campground text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Équipements actifs</p>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$TotalListingActive}} / {{$TotalListing}}</h3>
                                <p class="text-purple-600 dark:text-purple-400 text-sm flex items-center mt-1">
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
                                @if(isset($AverageRating) && $AverageRating != 0)
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$AverageRating}} / 5</h3>
                                    <p class="text-amber-600 dark:text-amber-400 text-sm flex items-center mt-1"></p>
                                @else
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Not Rated</h3>

                                @endif

                                    
                                
                            </div>
                        </div>
                    </div>

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
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-800  flex items-center justify-center">
                                            <i class="fas fa-star text-amber-600 dark:text-amber-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{$avis->username}} -  Equipment : {{$avis->object_title}}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                              {{$avis->comment}}
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">

                                            <div class="flex items-center text-sm">
                                                    <i class="fas fa-star text-amber-400 mr-1"></i>
                                                    <span>{{ $avis->rating }}</span>
                                                </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 text-center">
                            <a href="{{ route('HomePartenaie.avis') }}" class="text-forest dark:text-meadow hover:underline text-sm font-medium">
                                Voir tous les avis
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
                        @forelse ($pendingReservation as $Reservation)
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
                                                <span class="text-gray-600 dark:text-gray-400">Durée de résérvation</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{$Reservation->start_date}} -> {{$Reservation->end_date}}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600 dark:text-gray-400">Montant total</span>
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
                        @empty
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="px-6 py-4 text-sm text-gray-500">
                                Vous n'avez aucune demande de location dans ce moment.
                            </div>
                        </div>
                        
                        @endforelse
                        @if($pendingReservation->count()!=0)
                        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 text-center">
                            <a href="{{ route('HomePartenaie.demandes') }}" class="text-forest dark:text-meadow hover:underline text-sm font-medium">
                                Voir toutes les demandes
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                

                
                <!-- My equipment section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Mes équipements</h2>
                        <a href="{{ route('MesEquipement') }}" data-target="AllMyEquipement" class="sidebar-link text-forest dark:text-meadow hover:underline text-sm font-medium">
                            Voir tous mes équipements
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($RecentListing as $Listing)


                        <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                            <div class="relative h-48">
                                @if($Listing->images && count($Listing->images) > 0)
                                    <img src="{{ asset($Listing->images[0]->url) }}" 
                                        alt="Pack Camping Complet 2p" 
                                        class="w-full h-full object-cover" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                @endif    

                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="text-white font-bold text-lg truncate">{{$Listing->title}}p</h3>
                                    <p class="text-gray-200 text-sm">{{$Listing->category_name}} - Excellent état</p>
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
                                        @if($Listing->review_count != 0) 
                                            <span>{{ number_format($Listing->avg_rating, 1) }}<span class="text-gray-500 dark:text-gray-400">({{$Listing->review_count}})</span></span>
                                        @else 
                                            <span> No Rating </span>
                                        @endif

                                    </div>
                                </div>
                                
                               
                                
                                <div class="flex items-center justify-between">                      
                                    <div class="flex items-center space-x-2">
                                         <button class="view-details-btn px-3 py-2 text-forest dark:border-meadow dark:text-meadow hover:bg-forest dark:hover:text-white dark:hover:bg-meadow rounded-md text-sm font-medium flex items-center justify-center" 
                                            data-id="{{ $Listing->id }}">
                                            <i class="fas fa-eye mr-2"></i>
                                        </button>
                                         <button class="edit-equipment-btn p-2 bg-white dark:bg-gray-700 rounded-full shadow-md text-forest dark:text-meadow hover:bg-forest hover:text-white dark:hover:bg-meadow transition-colors" 
                                            data-id="{{ $Listing->id }}" 
                                            data-title="{{ $Listing->title }}" 
                                            data-description="{{ $Listing->description }}" 
                                            data-price="{{ $Listing->price_per_day }}" 
                                            data-category="{{ $Listing->category_id }}">
                                            <i class="fas fa-edit"></i>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        
                        
                       
                        
                        <!-- Add Equipment Card -->
                        <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center h-80">
                            <div class="flex flex-col  items-center justify-center p-6 text-center">
                                <div class="w-16 h-16 bg-forest/10 dark:bg-forest/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-plus text-forest dark:text-meadow text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Ajouter un équipement</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                    Vous pouvez ajouter un nouvel équipement pour le proposer à la location.
                                </p>
                                 <button id="add-equipment-button" class="px-4 py-3 bg-forest hover:bg-meadow text-white rounded-md shadow-lg flex items-center font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter 
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Latest reviews -->
                
            </div>
        </main>
    
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
<div id="equipment-details-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-6xl w-full max-h-screen overflow-y-auto no-scrollbar">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800 z-10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="detail-title">Détails de l'équipement</h3>
            <button id="close-details-modal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Colonne de gauche: Images et informations de base -->
                <div>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden mb-4">
                        <div id="detail-image-slider" class="w-full h-64 flex overflow-x-auto snap-x snap-mandatory scrollbar-hide no-scrollbar">
                            <!-- Images will be added here dynamically -->
                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 snap-center flex items-center justify-center">
                                <i class="fas fa-campground text-5xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Informations générales</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">Catégorie</h5>
                                    <p class="text-gray-900 dark:text-white" id="detail-category">-</p>
                                </div>
                                <div>
                                    <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">Prix par jour</h5>
                                    <p class="text-xl font-bold text-forest dark:text-meadow" id="detail-price">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Description</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-700 dark:text-gray-300" id="detail-description">-</p>
                        </div>
                    </div>
                </div>
                
                <!-- Colonne de droite: Statistiques et avis -->
                <div>
                    <div class="mb-4">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Statistiques</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                                <h5 class="text-sm font-medium text-blue-800 dark:text-blue-300">Nombre d'annonces</h5>
                                <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mt-1" id="detail-annonces-count">0</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400" id="detail-active-annonces">0 actives</p>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                                <h5 class="text-sm font-medium text-green-800 dark:text-green-300">Réservations</h5>
                                <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1" id="detail-reservations-count">0</p>
                                <p class="text-xs text-green-600 dark:text-green-400" id="detail-completed-reservations">0 terminées</p>
                            </div>
                            
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3">
                                <h5 class="text-sm font-medium text-purple-800 dark:text-purple-300">Évaluation moyenne</h5>
                                <div class="flex items-center mt-1">
                                    <span class="text-xl font-bold text-purple-600 dark:text-purple-400 mr-1" id="detail-avg-rating">0</span>
                                    <div class="text-amber-400">
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-purple-600 dark:text-purple-400" id="detail-review-count">0 avis</p>
                            </div>
                            
                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-3">
                                <h5 class="text-sm font-medium text-amber-800 dark:text-amber-300">Revenus générés</h5>
                                <p class="text-xl font-bold text-amber-600 dark:text-amber-400 mt-1" id="detail-revenue">0 MAD</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-lg text-gray-900 dark:text-white">Avis</h4>
                            <span class="text-sm text-gray-500 dark:text-gray-400" id="detail-reviews-summary">Chargement...</span>
                        </div>
                        
                        <div id="detail-reviews-container" class="space-y-4 max-h-96 overflow-y-auto pr-2 no-scrollbar">
                            <!-- Reviews will be loaded here dynamically -->
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400" id="no-reviews-message">
                                <i class="far fa-comment-alt text-3xl mb-2"></i>
                                <p>Aucun avis pour le moment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4 flex justify-end">
                <a id="detail-create-annonce-link" href="#" class="px-4 py-2 bg-forest hover:bg-meadow dark:bg-meadow dark:hover:bg-forest/partenaire/annonces/create/ text-white font-medium rounded-md shadow-sm transition-colors">
                    <i class="fas fa-bullhorn mr-2"></i>
                    Créer une annonce
                </a>
            </div>
        </div>
    </div>
</div>

<div id="add-equipment-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-screen overflow-y-auto">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800 z-10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ajouter un équipement</h3>
            <button id="close-add-modal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="add-equipment-form" action="{{ route('partenaire.equipements.create') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                    <input type="text" id="title" name="title" required placeholder="Titre de l'équipement ..."
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="price_per_day" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix par jour (MAD)</label>
                    <input type="number" id="price_per_day" name="price_per_day" min="0" step="0.01" required placeholder="Prix /jour"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="4" required placeholder="Description de votre équipement ..."
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Images (Minimum 1, Maximum 5 images)</label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md px-6 pt-5 pb-6 cursor-pointer" id="image-drop-area">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="images" class="relative cursor-pointer rounded-md font-medium text-forest dark:text-meadow hover:text-meadow focus-within:outline-none">
                                    <span>Télécharger des fichiers</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*" required>
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF jusqu'à 2MB (1-5 images)
                            </p>
                        </div>
                    </div>
                    <div id="image-preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    <div id="image-count-error" class="mt-2 text-red-500 text-sm hidden">Veuillez sélectionner entre 1 et 5 images.</div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancel-add" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-forest hover:bg-meadow text-white rounded-md shadow-sm">
                    Ajouter l'équipement
                </button>
            </div>
        </form>
    </div>
</div><!-- Edit Equipment Modal -->
<div id="edit-equipment-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-5xl w-full max-h-screen overflow-y-auto no-scrollbar">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center sticky top-0 bg-white dark:bg-gray-800 z-10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Modifier l'équipement</h3>
            <button id="close-edit-modal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="edit-equipment-form" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-equipment-id" name="equipment_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="edit-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                    <input type="text" id="edit-title" name="title" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow no-scrollbar">
                </div>
                
                <div>
                    <label for="edit-category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                    <select id="edit-category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow ">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="edit-price_per_day" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix par jour (MAD)</label>
                    <input type="number" id="edit-price_per_day" name="price_per_day" min="0" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                </div>
                
                <div class="md:col-span-2">
                    <label for="edit-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="edit-description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow no-scrollbar"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Images actuelles</label>
                    <div id="current-images-container" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <!-- Les images existantes seront chargées ici dynamiquement -->
                    </div>
                    
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 mt-4">Ajouter de nouvelles images (Minimum 1, Maximum 5 images au total)</label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md px-6 pt-5 pb-6 cursor-pointer" id="edit-image-drop-area">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="edit-images" class="relative cursor-pointer rounded-md font-medium text-forest dark:text-meadow hover:text-meadow focus-within:outline-none">
                                    <span>Télécharger des fichiers</span>
                                    <input id="edit-images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF jusqu'à 2MB (1-5 images)
                            </p>
                        </div>
                    </div>
                    <div id="edit-image-preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    <div id="edit-image-count-error" class="mt-2 text-red-500 text-sm hidden">Veuillez sélectionner entre 1 et 5 images.</div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancel-edit" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-forest hover:bg-meadow text-white rounded-md shadow-sm">
                    Mettre à jour l'équipement
                </button>
            </div>
        </form>
    </div>
</div><!-- Delete Equipment Modal -->

<script>
// Modal controls
const addEquipmentButton = document.getElementById('add-equipment-button');
const addFirstEquipment = document.getElementById('add-first-equipment');
const searchInput = document.getElementById('search-input');
const categoryFilter = document.getElementById('category-filter');
const priceFilter = document.getElementById('price-filter');
const sortByFilter = document.getElementById('sort-by');
const applyFilterButton = document.getElementById('apply-filter');
const addEquipmentModal = document.getElementById('add-equipment-modal');
const editEquipmentModal = document.getElementById('edit-equipment-modal');
const deleteEquipmentModal = document.getElementById('delete-equipment-modal');
const deleteAllModal = document.getElementById('delete-all-modal');
const detailsModal = document.getElementById('equipment-details-modal');

// Close buttons
const closeAddModal = document.getElementById('close-add-modal');
const closeEditModal = document.getElementById('close-edit-modal');
const closeDeleteModal = document.getElementById('close-delete-modal');
const closeDeleteAllModal = document.getElementById('close-delete-all-modal');
const closeDetailsModal = document.getElementById('close-details-modal');

// Cancel buttons
const cancelAdd = document.getElementById('cancel-add');
const cancelEdit = document.getElementById('cancel-edit');
const cancelDelete = document.getElementById('cancel-delete');
const cancelDeleteAll = document.getElementById('cancel-delete-all');

// Forms
const addEquipmentForm = document.getElementById('add-equipment-form');
const editEquipmentForm = document.getElementById('edit-equipment-form');
const deleteEquipmentForm = document.getElementById('delete-equipment-form');
const deleteAllForm = document.getElementById('delete-all-form');

// Edit buttons
const editButtons = document.querySelectorAll('.edit-equipment-btn');
const deleteButtons = document.querySelectorAll('.delete-equipment-btn');
const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
const deleteAllButton = document.getElementById('delete-all-button');

// Image upload
const imageInput = document.getElementById('images');
const editImageInput = document.getElementById('edit-images');
const imagePreviewContainer = document.getElementById('image-preview-container');
const editImagePreviewContainer = document.getElementById('edit-image-preview-container');
const imageDropArea = document.getElementById('image-drop-area');
const editImageDropArea = document.getElementById('edit-image-drop-area');

// Show Add Equipment Modal
if (addEquipmentButton) {
    addEquipmentButton.addEventListener('click', () => {
        addEquipmentModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
}

if (addFirstEquipment) {
    addFirstEquipment.addEventListener('click', () => {
        addEquipmentModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
}

// Close Add Equipment Modal
if (closeAddModal) {
    closeAddModal.addEventListener('click', () => {
        addEquipmentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

if (cancelAdd) {
    cancelAdd.addEventListener('click', () => {
        addEquipmentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

// Show Edit Equipment Modal
editButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const description = button.getAttribute('data-description');
        const price = button.getAttribute('data-price');
        const category = button.getAttribute('data-category');
        
        document.getElementById('edit-equipment-id').value = id;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-price_per_day').value = price;
        document.getElementById('edit-category_id').value = category;
        
        // Vider les conteneurs d'images
        const currentImagesContainer = document.getElementById('current-images-container');
        currentImagesContainer.innerHTML = '<div class="col-span-4 text-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i> Chargement des images...</div>';
        document.getElementById('edit-image-preview-container').innerHTML = '';
        
        // Chargement des images existantes depuis l'API
        fetch(`/partenaire/equipements/${id}/details`)
            .then(response => response.json())
            .then(data => {
                currentImagesContainer.innerHTML = '';
                
                // Si l'équipement a des images, les afficher
                if (data.equipment.images && data.equipment.images.length > 0) {
                    // Pour chaque image, créer un élément d'aperçu
                    data.equipment.images.forEach(image => {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'relative';
                        imgContainer.dataset.imageId = image.id;
                        
                        const img = document.createElement('img');
                        img.src = `/${image.url}`;
                        img.alt = data.equipment.title;
                        img.className = 'w-full h-32 object-cover rounded-md';
                        imgContainer.appendChild(img);
                        
                        // Ajouter un bouton de suppression
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center';
                        removeBtn.innerHTML = '<i class="fas fa-times text-xs"></i>';
                        
                        // Créer un champ caché pour marquer les images à supprimer
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'keep_images[]';
                        hiddenInput.value = image.id;
                        imgContainer.appendChild(hiddenInput);
                        
                        // Gérer la suppression d'image
                        removeBtn.addEventListener('click', function() {
                            // Changer le nom du champ pour indiquer la suppression
                            hiddenInput.name = 'delete_images[]';
                            
                            // Ajouter une classe pour griser visuellement l'image
                            imgContainer.classList.add('opacity-30');
                            
                            // Remplacer le bouton de suppression par un bouton d'annulation
                            this.innerHTML = '<i class="fas fa-undo text-xs"></i>';
                            this.classList.remove('bg-red-500');
                            this.classList.add('bg-green-500');
                            
                            // Fonction pour restaurer l'image
                            this.addEventListener('click', function() {
                                hiddenInput.name = 'keep_images[]';
                                imgContainer.classList.remove('opacity-30');
                                this.innerHTML = '<i class="fas fa-times text-xs"></i>';
                                this.classList.remove('bg-green-500');
                                this.classList.add('bg-red-500');
                            }, { once: true });
                        });
                        
                        imgContainer.appendChild(removeBtn);
                        currentImagesContainer.appendChild(imgContainer);
                    });
                } else {
                    currentImagesContainer.innerHTML = '<div class="col-span-4 text-center py-4 text-gray-500 dark:text-gray-400">Aucune image existante</div>';
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des images:', error);
                currentImagesContainer.innerHTML = '<div class="col-span-4 text-center py-4 text-red-500">Erreur lors du chargement des images</div>';
            });
        
        // Set form action
        const form = document.getElementById('edit-equipment-form');
        form.action = `/partenaire/equipements/${id}`;
        
        editEquipmentModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
});

// Close Edit Equipment Modal
if (closeEditModal) {
    closeEditModal.addEventListener('click', () => {
        editEquipmentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

if (cancelEdit) {
    cancelEdit.addEventListener('click', () => {
        editEquipmentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

// Gestionnaire pour les boutons de suppression
document.querySelectorAll('.delete-equipment-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        
        // Mettre à jour le modal de suppression
        document.getElementById('delete-equipment-name').textContent = title;
        const form = document.getElementById('delete-equipment-form');
        form.action = `/partenaire/equipements/${id}`;
        
        // Afficher le modal de suppression
        deleteEquipmentModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
});

// Gestionnaire pour le formulaire de suppression
if (deleteEquipmentForm) {
    deleteEquipmentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        try {
            const response = await fetch(deleteEquipmentForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                // Fermer le modal
                deleteEquipmentModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                
                // Rafraîchir la page
                window.location.reload();
            } else {
                const data = await response.json();
                throw new Error(data.message || 'Erreur lors de la suppression');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la suppression de l\'équipement');
        }
    });
}

// Gestionnaires pour fermer le modal de suppression
if (closeDeleteModal) {
    closeDeleteModal.addEventListener('click', () => {
        deleteEquipmentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

if (cancelDelete) {
    cancelDelete.addEventListener('click', () => {
        deleteEquipmentModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

// Ajouter l'attribut data-id aux cartes d'équipement
document.querySelectorAll('.equipment-card').forEach(card => {
    const deleteBtn = card.querySelector('.delete-equipment-btn');
    if (deleteBtn) {
        const id = deleteBtn.getAttribute('data-id');
        card.setAttribute('data-id', id);
    }
});

// Show Delete All Equipment Modal
if (deleteAllButton) {
    deleteAllButton.addEventListener('click', () => {
        deleteAllModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
}

// Close Delete All Equipment Modal
if (closeDeleteAllModal) {
    closeDeleteAllModal.addEventListener('click', () => {
        deleteAllModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

if (cancelDeleteAll) {
    cancelDeleteAll.addEventListener('click', () => {
        deleteAllModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

// View Equipment Details
viewDetailsButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        const id = button.getAttribute('data-id');
        
        // Afficher le modal avec indicateur de chargement
        const modal = document.getElementById('equipment-details-modal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Initialiser les éléments avec des indicateurs de chargement
        document.getElementById('detail-title').textContent = 'Chargement...';
        document.getElementById('detail-price').textContent = '...';
        document.getElementById('detail-category').textContent = '...';
        document.getElementById('detail-description').textContent = 'Chargement des informations...';
        document.getElementById('detail-annonces-count').textContent = '...';
        document.getElementById('detail-active-annonces').textContent = '...';
        document.getElementById('detail-reservations-count').textContent = '...';
        document.getElementById('detail-completed-reservations').textContent = '...';
        document.getElementById('detail-avg-rating').textContent = '...';
        document.getElementById('detail-review-count').textContent = '...';
        document.getElementById('detail-revenue').textContent = '...';
        document.getElementById('detail-reviews-summary').textContent = 'Chargement...';
        
        // Vider le conteneur d'images et afficher un placeholder
        const imageSlider = document.getElementById('detail-image-slider');
        imageSlider.innerHTML = `
            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 snap-center flex items-center justify-center">
                <i class="fas fa-sync fa-spin text-5xl text-gray-400 dark:text-gray-500"></i>
            </div>
        `;
        
        // Charger les données détaillées de l'équipement
        fetch(`/partenaire/equipements/${id}/details`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement des détails');
                }
                return response.json();
            })
            .then(data => {
                // Mettre à jour les informations de base
                const equipment = data.equipment;
                const stats = data.stats;
                
                document.getElementById('detail-title').textContent = equipment.title;
                document.getElementById('detail-price').textContent = `${equipment.price_per_day} MAD/jour`;
                document.getElementById('detail-category').textContent = equipment.category ? equipment.category.name : 'Non catégorisé';
                document.getElementById('detail-description').textContent = equipment.description || 'Aucune description';
                
                // Statistiques
                document.getElementById('detail-annonces-count').textContent = stats.annonces_count;
                document.getElementById('detail-active-annonces').textContent = `${stats.active_annonce_count} actives`;
                document.getElementById('detail-reservations-count').textContent = stats.reservations_count;
                document.getElementById('detail-completed-reservations').textContent = `${stats.completed_reservations_count} terminées`;
                document.getElementById('detail-revenue').textContent = `${stats.revenue.toLocaleString()} MAD`;
                
                // Avis
                const avgRating = equipment.reviews && equipment.reviews.length > 0 
                    ? equipment.reviews.reduce((sum, review) => sum + review.rating, 0) / equipment.reviews.length 
                    : 0;
                document.getElementById('detail-avg-rating').textContent = avgRating.toFixed(1);
                document.getElementById('detail-review-count').textContent = `${equipment.reviews ? equipment.reviews.length : 0} avis`;
                document.getElementById('detail-reviews-summary').textContent = equipment.reviews && equipment.reviews.length > 0 
                    ? `${equipment.reviews.length} avis` 
                    : 'Aucun avis';
                
                // Images
                imageSlider.innerHTML = '';
                
                // Créer le carousel d'images
                if (equipment.images && equipment.images.length > 0) {
                    // Conteneur pour les indicateurs
                    const imageDots = document.createElement('div');
                    imageDots.className = 'flex justify-center mt-2 space-x-2';
                    imageDots.id = 'detail-image-dots';
                    
                    // Ajouter chaque image au slider
                    equipment.images.forEach((image, index) => {
                        // Créer la diapositive d'image
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'w-full h-64 flex-shrink-0 snap-center relative';
                        imgDiv.setAttribute('data-index', index);
                        imgDiv.innerHTML = `
                            <img src="/${image.url}" alt="${equipment.title}" class="w-full h-full object-cover">
                            <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                                ${index + 1}/${equipment.images.length}
                            </div>
                        `;
                        imageSlider.appendChild(imgDiv);
                        
                        // Créer l'indicateur (point) pour cette image
                        const dot = document.createElement('button');
                        dot.className = `w-3 h-3 rounded-full ${index === 0 ? 'bg-forest dark:bg-meadow' : 'bg-gray-300 dark:bg-gray-600'}`;
                        dot.setAttribute('data-index', index);
                        dot.addEventListener('click', () => {
                            // Faire défiler jusqu'à cette image
                            const imgElement = imageSlider.querySelector(`[data-index="${index}"]`);
                            if (imgElement) {
                                imgElement.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                            }
                            
                            // Mettre à jour les indicateurs
                            imageDots.querySelectorAll('button').forEach(btn => {
                                btn.classList.remove('bg-forest', 'dark:bg-meadow');
                                btn.classList.add('bg-gray-300', 'dark:bg-gray-600');
                            });
                            dot.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                            dot.classList.add('bg-forest', 'dark:bg-meadow');
                        });
                        imageDots.appendChild(dot);
                    });
                    
                    // Ajouter les indicateurs sous le slider
                    const sliderContainer = imageSlider.closest('.bg-gray-100, .dark\\:bg-gray-700');
                    sliderContainer.appendChild(imageDots);
                    
                    // Ajouter des contrôles de navigation (boutons précédent/suivant)
                    const prevButton = document.createElement('button');
                    prevButton.className = 'absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-opacity z-10';
                    prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
                    prevButton.addEventListener('click', () => {
                        // Trouver l'image visible actuelle
                        const scrollPosition = imageSlider.scrollLeft;
                        const imgWidth = imageSlider.offsetWidth;
                        const currentIndex = Math.round(scrollPosition / imgWidth);
                        
                        // Calculer l'index de l'image précédente
                        const prevIndex = (currentIndex - 1 + equipment.images.length) % equipment.images.length;
                        
                        // Faire défiler jusqu'à l'image précédente
                        const imgElement = imageSlider.querySelector(`[data-index="${prevIndex}"]`);
                        if (imgElement) {
                            imgElement.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                            
                            // Mettre à jour les indicateurs
                            imageDots.querySelectorAll('button').forEach(btn => {
                                btn.classList.remove('bg-forest', 'dark:bg-meadow');
                                btn.classList.add('bg-gray-300', 'dark:bg-gray-600');
                            });
                            const activeDot = imageDots.querySelector(`[data-index="${prevIndex}"]`);
                            if (activeDot) {
                                activeDot.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                                activeDot.classList.add('bg-forest', 'dark:bg-meadow');
                            }
                        }
                    });
                    
                    const nextButton = document.createElement('button');
                    nextButton.className = 'absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-opacity z-10';
                    nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
                    nextButton.addEventListener('click', () => {
                        // Trouver l'image visible actuelle
                        const scrollPosition = imageSlider.scrollLeft;
                        const imgWidth = imageSlider.offsetWidth;
                        const currentIndex = Math.round(scrollPosition / imgWidth);
                        
                        // Calculer l'index de l'image suivante
                        const nextIndex = (currentIndex + 1) % equipment.images.length;
                        
                        // Faire défiler jusqu'à l'image suivante
                        const imgElement = imageSlider.querySelector(`[data-index="${nextIndex}"]`);
                        if (imgElement) {
                            imgElement.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                            
                            // Mettre à jour les indicateurs
                            imageDots.querySelectorAll('button').forEach(btn => {
                                btn.classList.remove('bg-forest', 'dark:bg-meadow');
                                btn.classList.add('bg-gray-300', 'dark:bg-gray-600');
                            });
                            const activeDot = imageDots.querySelector(`[data-index="${nextIndex}"]`);
                            if (activeDot) {
                                activeDot.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                                activeDot.classList.add('bg-forest', 'dark:bg-meadow');
                            }
                        }
                    });
                    
                    // Ajouter les boutons de navigation directement au slider
                    sliderContainer.appendChild(prevButton);
                    sliderContainer.appendChild(nextButton);
                    sliderContainer.style.position = 'relative';
                    
                    // Détecter le changement d'image lors du défilement
                    imageSlider.addEventListener('scroll', () => {
                        // Calculer l'index de l'image actuellement visible
                        const scrollPosition = imageSlider.scrollLeft;
                        const imgWidth = imageSlider.offsetWidth;
                        const currentIndex = Math.round(scrollPosition / imgWidth);
                        
                        // Mettre à jour les indicateurs
                        imageDots.querySelectorAll('button').forEach(btn => {
                            btn.classList.remove('bg-forest', 'dark:bg-meadow');
                            btn.classList.add('bg-gray-300', 'dark:bg-gray-600');
                        });
                        const activeDot = imageDots.querySelector(`[data-index="${currentIndex}"]`);
                        if (activeDot) {
                            activeDot.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                            activeDot.classList.add('bg-forest', 'dark:bg-meadow');
                        }
                    });
                } else {
                    // Add placeholder if no images
                    const placeholderDiv = document.createElement('div');
                    placeholderDiv.className = 'w-full h-64 bg-gray-200 dark:bg-gray-700 flex-shrink-0 snap-center flex items-center justify-center';
                    placeholderDiv.innerHTML = '<i class="fas fa-campground text-5xl text-gray-400 dark:text-gray-500"></i>';
                    imageSlider.appendChild(placeholderDiv);
                }
                
                // Lien pour créer une annonce
                const createAnnonceLink = document.getElementById('detail-create-annonce-link');
                createAnnonceLink.href = `/partenaire/annonces/create/${equipment.id}`;
                
                // Avis
                const reviewsContainer = document.getElementById('detail-reviews-container');
                const noReviewsMessage = document.getElementById('no-reviews-message');
                
                // Clear previous reviews
                reviewsContainer.innerHTML = '';
                
                if (!equipment.reviews || equipment.reviews.length === 0) {
                    reviewsContainer.appendChild(noReviewsMessage);
                } else {
                    equipment.reviews.forEach(review => {
                        const reviewDiv = document.createElement('div');
                        reviewDiv.className = 'bg-gray-50 dark:bg-gray-700 p-4 rounded-lg';
                        
                        // Create stars
                        let stars = '';
                        for (let i = 0; i < 5; i++) {
                            if (i < review.rating) {
                                stars += '<i class="fas fa-star text-amber-400"></i>';
                            } else {
                                stars += '<i class="far fa-star text-amber-400"></i>';
                            }
                        }
                        
                        const reviewerName = review.reviewer ? review.reviewer.username || 'Utilisateur' : 'Utilisateur';

                        const reviewerAvata = "{{ asset('') }}";
                        const reviewerAvatar = reviewerAvata + review.reviewer.avatar_url;
                        
                        const reviewDate = new Date(review.created_at).toLocaleDateString('fr-FR');
                        
                        reviewDiv.innerHTML = `
                            <div class="flex items-center mb-2">
                                <img src="${reviewerAvatar}" alt="${reviewerName}" class="w-8 h-8 rounded-full mr-2">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">${reviewerName}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">${reviewDate}</div>
                                </div>
                            </div>
                            <div class="flex mb-2">
                                ${stars}
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">${review.comment || 'Aucun commentaire'}</p>
                        `;
                        
                        reviewsContainer.appendChild(reviewDiv);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                // Afficher un message d'erreur
                document.getElementById('detail-title').textContent = 'Erreur de chargement';
                document.getElementById('detail-description').textContent = 'Une erreur est survenue lors du chargement des détails de l\'équipement. Veuillez réessayer.';
                
                // Vider le conteneur d'images et afficher une icône d'erreur
                imageSlider.innerHTML = `
                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 snap-center flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-5xl text-red-500"></i>
                    </div>
                `;
            });
    });
});

// Close Details Modal
if (closeDetailsModal) {
    closeDetailsModal.addEventListener('click', () => {
        detailsModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

// Image upload
if (imageInput) {
    imageInput.addEventListener('change', function() {
        handleFileSelect(this.files, imagePreviewContainer);
    });
}

if (editImageInput) {
    editImageInput.addEventListener('change', function() {
        handleFileSelect(this.files, editImagePreviewContainer);
    });
}

function handleFileSelect(files, previewContainer) {
    // Ne pas vider le conteneur pour permettre l'ajout de plusieurs lots d'images
    // previewContainer.innerHTML = '';
    
    // Limiter à maximum 5 images au total
    const maxFiles = 5;
    const currentImages = previewContainer.querySelectorAll('.relative').length;
    const maxNewImages = maxFiles - currentImages;
    
    if (maxNewImages <= 0) {
        const errorDiv = previewContainer.id === 'image-preview-container' 
            ? document.getElementById('image-count-error') 
            : document.getElementById('edit-image-count-error');
        
        if (errorDiv) {
            errorDiv.textContent = "Maximum 5 images autorisées. Veuillez supprimer des images avant d'en ajouter d'autres.";
            errorDiv.classList.remove('hidden');
        }
        return;
    }
    
    const filesToProcess = files.length > maxNewImages ? Array.from(files).slice(0, maxNewImages) : files;
    
    for (let i = 0; i < filesToProcess.length; i++) {
        const file = filesToProcess[i];
        
        if (!file.type.match('image.*')) {
            continue;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'relative';
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-32 object-cover rounded-md';
            imgContainer.appendChild(img);
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center';
            removeBtn.innerHTML = '<i class="fas fa-times text-xs"></i>';
            removeBtn.addEventListener('click', function() {
                imgContainer.remove();
                
                // Masquer le message d'erreur après la suppression
                const errorDiv = previewContainer.id === 'image-preview-container' 
                    ? document.getElementById('image-count-error') 
                    : document.getElementById('edit-image-count-error');
                
                if (errorDiv) {
                    errorDiv.classList.add('hidden');
                }
            });
            imgContainer.appendChild(removeBtn);
            
            previewContainer.appendChild(imgContainer);
        };
        
        reader.readAsDataURL(file);
    }
    
    // Afficher message d'erreur si dépassement
    const errorDiv = previewContainer.id === 'image-preview-container' 
        ? document.getElementById('image-count-error') 
        : document.getElementById('edit-image-count-error');
    
    if (files.length > maxNewImages && errorDiv) {
        errorDiv.textContent = `Vous ne pouvez ajouter que ${maxNewImages} image(s) supplémentaire(s). Seules les ${maxNewImages} premières ont été sélectionnées.`;
        errorDiv.classList.remove('hidden');
    } else if (errorDiv) {
        errorDiv.classList.add('hidden');
    }
}

// Drag and drop for images
if (imageDropArea) {
    setupDragDrop(imageDropArea, imageInput, imagePreviewContainer);
}

if (editImageDropArea) {
    setupDragDrop(editImageDropArea, editImageInput, editImagePreviewContainer);
}

function setupDragDrop(dropArea, fileInput, previewContainer) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropArea.classList.add('border-forest', 'dark:border-meadow');
    }
    
    function unhighlight() {
        dropArea.classList.remove('border-forest', 'dark:border-meadow');
    }
    
    dropArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        // Au lieu de simplement remplacer les fichiers, créons un FileList personnalisé 
        // qui inclut à la fois les fichiers existants et les nouveaux fichiers
        if (fileInput.files && fileInput.files.length > 0) {
            // Créer un nouvel objet FormData pour combiner les fichiers
            const formData = new FormData();
            
            // Ajouter les fichiers existants
            Array.from(fileInput.files).forEach(file => {
                formData.append('images[]', file);
            });
            
            // Ajouter les nouveaux fichiers
            Array.from(files).forEach(file => {
                formData.append('images[]', file);
            });
            
            // Note: Nous ne pouvons pas directement modifier fileInput.files
            // mais nous pouvons traiter les fichiers sélectionnés individuellement
            handleFileSelect(files, previewContainer);
        } else {
            // S'il n'y a pas de fichiers existants, utilisez simplement les nouveaux
            fileInput.files = files;
            handleFileSelect(files, previewContainer);
        }
    }
}

if (addEquipmentForm) {
    addEquipmentForm.addEventListener('submit', function(e) {
        const imageCount = imagePreviewContainer.querySelectorAll('.relative').length;
        const errorDiv = document.getElementById('image-count-error');
        
        if (imageCount < 1 || imageCount > 5) {
            e.preventDefault();
            errorDiv.textContent = imageCount < 1 
                ? "Veuillez sélectionner au moins 1 image."
                : "Veuillez sélectionner au maximum 5 images.";
            errorDiv.classList.remove('hidden');
            return false;
        } else {
            errorDiv.classList.add('hidden');
        }
        
        // Créer un DataTransfer pour stocker les images à envoyer
        if (imageCount > 0) {
            // Nous devons préparer les images à envoyer via le formulaire
            // Cette étape est gérée automatiquement par le navigateur
            // car les prévisualisations sont simplement des représentations visuelles
            // Les fichiers originaux sont toujours attachés à l'élément input
            
            // Si la validation passe, nous pouvons soumettre le formulaire
            return true;
        }
    });
}

if (editEquipmentForm) {
    editEquipmentForm.addEventListener('submit', function(e) {
        const currentImagesContainer = document.getElementById('current-images-container');
        const newImagesPreviewContainer = document.getElementById('edit-image-preview-container');
        
        // Compter les images conservées (non marquées pour suppression)
        const keptImagesCount = currentImagesContainer.querySelectorAll('input[name="keep_images[]"]').length;
        
        // Compter les nouvelles images
        const newImagesCount = newImagesPreviewContainer.querySelectorAll('.relative').length;
        
        // Nombre total d'images
        const totalImagesCount = keptImagesCount + newImagesCount;
        
        const errorDiv = document.getElementById('edit-image-count-error');
        
        // Vérifier si des images ont été sélectionnées ou si des images préexistantes sont présentes
        if (totalImagesCount < 1 || totalImagesCount > 5) {
            e.preventDefault();
            errorDiv.textContent = totalImagesCount < 1 
                ? "Vous devez conserver au moins 1 image. Veuillez ajouter une image ou annuler la suppression."
                : "Le nombre total d'images ne peut pas dépasser 5. Veuillez en supprimer ou en ajouter moins.";
            errorDiv.classList.remove('hidden');
            return false;
        } else {
            errorDiv.classList.add('hidden');
        }
        
        // Si la validation passe, nous pouvons soumettre le formulaire
        return true;
    });
}
</script>
