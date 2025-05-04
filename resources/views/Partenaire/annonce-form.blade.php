@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <a href="{{ route('HomePartenaie') }}" class="inline-flex items-center text-forest dark:text-meadow hover:underline mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Publier une annonce pour "{{ $equipment->title }}"</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Remplissez ce formulaire pour rendre votre équipement disponible à la location.
            </p>
        </div>
        
        <!-- Progress bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                    <div class="bg-forest dark:bg-meadow h-2.5 rounded-full progress-bar" style="width: 25%"></div>
                </div>
            </div>
            <div class="flex justify-between mt-2 text-sm text-gray-600 dark:text-gray-400">
                <div class="step-indicator active" data-step="1">
                    <span class="font-medium text-forest dark:text-meadow">1. Informations</span>
                </div>
                <div class="step-indicator" data-step="2">
                    <span>2. Disponibilité</span>
                </div>
                <div class="step-indicator" data-step="3">
                    <span>3. Options</span>
                </div>
                <div class="step-indicator" data-step="4">
                    <span>4. Publication</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-10">
            <form id="listing-form" action="{{ route('partenaire.annonces.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="item_id" value="{{ $equipment->id }}">
                
                <!-- Step 1: Informations de base -->
                <div class="form-step active" id="step-1">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informations de l'équipement</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            Vérifiez les détails de votre équipement de camping.
                        </p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Aperçu de l'équipement -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-start">
                                @if($equipment->images && count($equipment->images) > 0)
                                    <img src="{{ asset('storage/' . $equipment->images[0]->url) }}" alt="{{ $equipment->title }}" class="w-24 h-24 object-cover rounded-md mr-4">
                                @else
                                    <div class="w-24 h-24 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center mr-4">
                                        <i class="fas fa-campground text-gray-400 dark:text-gray-500 text-2xl"></i>
                                    </div>
                                @endif
                                
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $equipment->title }}</h3>
                                    <p class="text-forest dark:text-meadow font-medium">{{ $equipment->price_per_day }} MAD / jour</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ $equipment->description }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-md p-4">
                            <h4 class="font-medium text-blue-800 dark:text-blue-300 flex items-center mb-2">
                                <i class="fas fa-info-circle mr-2"></i>
                                Information
                            </h4>
                            <p class="text-sm text-blue-700 dark:text-blue-200">
                                Les informations de base de votre équipement sont déjà renseignées. Vous allez maintenant définir la disponibilité pour créer votre annonce.
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-4">
                        <button type="button" id="next-to-step-2" class="btn-continue px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            Continuer vers Disponibilité
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Disponibilité et localisation -->
                <div class="form-step" id="step-2" style="display: none;">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Disponibilité et localisation</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            Définissez quand et où votre équipement sera disponible.
                        </p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Période de disponibilité -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Période de disponibilité</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disponible à partir du</label>
                                    <input type="date" id="start_date" name="start_date" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" required>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disponible jusqu'au</label>
                                    <input type="date" id="end_date" name="end_date" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" required>
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Options de livraison -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Options de livraison</h3>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="delivery_option_pickup" name="delivery_option" type="radio" value="pickup" class="h-4 w-4 text-forest dark:text-meadow focus:ring-forest dark:focus:ring-meadow border-gray-300 dark:border-gray-600" checked>
                                    </div>
                                    <div class="ml-3">
                                        <label for="delivery_option_pickup" class="text-sm font-medium text-gray-700 dark:text-gray-300">Récupération sur place uniquement</label>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Les locataires devront venir chercher l'équipement à l'adresse indiquée.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="delivery_option_delivery" name="delivery_option" type="radio" value="delivery" class="h-4 w-4 text-forest dark:text-meadow focus:ring-forest dark:focus:ring-meadow border-gray-300 dark:border-gray-600">
                                    </div>
                                    <div class="ml-3">
                                        <label for="delivery_option_delivery" class="text-sm font-medium text-gray-700 dark:text-gray-300">Livraison uniquement</label>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Vous vous engagez à livrer l'équipement au locataire.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="delivery_option_both" name="delivery_option" type="radio" value="both" class="h-4 w-4 text-forest dark:text-meadow focus:ring-forest dark:focus:ring-meadow border-gray-300 dark:border-gray-600">
                                    </div>
                                    <div class="ml-3">
                                        <label for="delivery_option_both" class="text-sm font-medium text-gray-700 dark:text-gray-300">Les deux options</label>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Le locataire pourra choisir entre récupération sur place ou livraison.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @error('delivery_option')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Localisation -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Localisation</h3>
                            <div class="mb-4">
                                <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ville</label>
                                <select id="city_id" name="city_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" required>
                                    <option value="">Sélectionnez une ville</option>
                                    @foreach(\App\Models\City::all() as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position exacte</label>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Cliquez sur la carte pour indiquer où vous pouvez mettre l'équipement à disposition.</p>
                                
                                <div id="map-container" class="w-full h-80 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600 mb-3"></div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                        <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Latitude</label>
                                        <input type="text" id="latitude" name="latitude" placeholder="Ex: 33.5731104" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" readonly>
                                    @error('latitude')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                        <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Longitude</label>
                                        <input type="text" id="longitude" name="longitude" placeholder="Ex: -7.5898434" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" readonly>
                                    @error('longitude')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i> L'emplacement exact ne sera partagé qu'avec les locataires après confirmation de la réservation.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between space-x-4">
                        <button type="button" id="back-to-step-1" class="btn-back px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </button>
                        <button type="button" id="next-to-step-3" class="btn-continue px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            Continuer vers Options
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Options premium -->
                <div class="form-step" id="step-3" style="display: none;">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Options de mise en avant</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            Augmentez la visibilité de votre annonce pour attirer plus de locataires.
                        </p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Toggle pour activer les options premium -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">Mettre en avant mon annonce</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Augmentez la visibilité et obtenez plus de locations
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="is_premium" name="is_premium" class="sr-only peer" value="1">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-forest/20 dark:peer-focus:ring-meadow/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-forest dark:peer-checked:bg-meadow"></div>
                            </label>
                        </div>
                        
                        <!-- Options premium (affichées uniquement si la case est cochée) -->
                        <div id="premium-options" class="space-y-4" style="display: none;">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Choisissez votre formule</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Option 7 jours -->
                                <div class="premium-option border border-gray-200 dark:border-gray-700 rounded-lg p-4 cursor-pointer hover:border-forest dark:hover:border-meadow transition-colors" data-value="7 jours">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Basique</h4>
                                        <span class="bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs px-2 py-1 rounded-full">7 jours</span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Apparaît en haut des résultats de recherche pendant 7 jours.</p>
                                    <p class="font-bold text-forest dark:text-meadow">+ 49 MAD</p>
                                    <input type="radio" name="premium_type" value="7 jours" class="hidden premium-radio">
                                </div>
                                
                                <!-- Option 15 jours -->
                                <div class="premium-option border border-gray-200 dark:border-gray-700 rounded-lg p-4 cursor-pointer hover:border-forest dark:hover:border-meadow transition-colors" data-value="15 jours">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Standard</h4>
                                        <span class="bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs px-2 py-1 rounded-full">15 jours</span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Apparaît en haut des résultats et dans les recommandations pendant 15 jours.</p>
                                    <p class="font-bold text-forest dark:text-meadow">+ 89 MAD</p>
                                    <input type="radio" name="premium_type" value="15 jours" class="hidden premium-radio">
                                </div>
                                
                                <!-- Option 30 jours -->
                                <div class="premium-option border border-gray-200 dark:border-gray-700 rounded-lg p-4 cursor-pointer hover:border-forest dark:hover:border-meadow transition-colors" data-value="30 jours">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Premium</h4>
                                        <span class="bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs px-2 py-1 rounded-full">30 jours</span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Apparaît en haut des résultats, dans les recommandations et sur la page d'accueil pendant 30 jours.</p>
                                    <p class="font-bold text-forest dark:text-meadow">+ 149 MAD</p>
                                    <input type="radio" name="premium_type" value="30 jours" class="hidden premium-radio">
                                </div>
                            </div>
                            
                            <!-- Message d'information -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-md p-4 mt-4">
                                <h4 class="font-medium text-blue-800 dark:text-blue-300 flex items-center mb-2">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Information
                                </h4>
                                <p class="text-sm text-blue-700 dark:text-blue-200">
                                    Les annonces mises en avant sont vues jusqu'à 5 fois plus que les annonces standards. Le paiement sera prélevé une fois l'annonce publiée.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between space-x-4">
                        <button type="button" id="back-to-step-2" class="btn-back px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </button>
                        <button type="button" id="next-to-step-4" class="btn-continue px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            Continuer vers Publication
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 4: Publication (Récapitulatif) -->
                <div class="form-step" id="step-4" style="display: none;">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Récapitulatif de votre annonce</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            Vérifiez les détails de votre annonce avant de la publier.
                        </p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Informations de l'équipement -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Votre équipement</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <div class="flex items-start">
                                    @if($equipment->images && count($equipment->images) > 0)
                                        <img src="{{ asset('storage/' . $equipment->images[0]->url) }}" alt="{{ $equipment->title }}" class="w-24 h-24 object-cover rounded-md mr-4">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center mr-4">
                                            <i class="fas fa-campground text-gray-400 dark:text-gray-500 text-2xl"></i>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white" id="recap-equipment-title">{{ $equipment->title }}</h4>
                                        <p class="text-forest dark:text-meadow font-medium" id="recap-equipment-price">{{ $equipment->price_per_day }} MAD / jour</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                        <!-- Détails de l'annonce -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Détails de l'annonce</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-3">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Période de disponibilité</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-dates">-</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Localisation</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-location">-</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Option de livraison</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-delivery">-</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Mise en avant</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-premium">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Conditions -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Conditions d'utilisation</h3>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5 mt-1">
                                        <input id="terms_agree" name="terms_agree" type="checkbox" class="h-4 w-4 text-forest dark:text-meadow focus:ring-forest dark:focus:ring-meadow border-gray-300 dark:border-gray-600" required>
                                    </div>
                                    <div class="ml-3">
                                        <label for="terms_agree" class="text-sm text-gray-700 dark:text-gray-300">
                                            Je confirme avoir lu et accepté les <a href="#" class="text-forest dark:text-meadow hover:underline">conditions générales d'utilisation</a> et les <a href="#" class="text-forest dark:text-meadow hover:underline">conditions de location</a> de CampShare.
                                        </label>
                                    </div>
                            </div>
                                
                                @error('terms_agree')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between space-x-4">
                        <button type="button" id="back-to-step-3" class="btn-back px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </button>
                        <button type="submit" id="publish-button" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Publier l'annonce
                        </button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables
        const form = document.getElementById('listing-form');
        const formSteps = document.querySelectorAll('.form-step');
        const stepIndicators = document.querySelectorAll('.step-indicator');
        const progressBar = document.querySelector('.progress-bar');
        let currentStep = 1;
        
        // Fonction pour aller à une étape spécifique
        function goToStep(step) {
            // Masquer toutes les étapes
            formSteps.forEach(formStep => {
                formStep.classList.remove('active');
                formStep.style.display = 'none';
            });
            
            // Afficher l'étape actuelle
            const activeStep = document.getElementById(`step-${step}`);
            if (activeStep) {
                activeStep.classList.add('active');
                activeStep.style.display = 'block';
            }
            
            // Mettre à jour les indicateurs d'étape
            stepIndicators.forEach(indicator => {
                const indicatorStep = parseInt(indicator.dataset.step);
                indicator.classList.remove('active');
                
                if (indicatorStep === step) {
                    indicator.classList.add('active');
                    indicator.querySelector('span').classList.add('font-medium', 'text-forest', 'dark:text-meadow');
                } else if (indicatorStep < step) {
                    indicator.classList.add('completed');
                    indicator.querySelector('span').classList.remove('font-medium', 'text-forest', 'dark:text-meadow');
                } else {
                    indicator.classList.remove('completed');
                    indicator.querySelector('span').classList.remove('font-medium', 'text-forest', 'dark:text-meadow');
                }
            });
            
            // Mettre à jour la barre de progression
            const progressPercentage = ((step - 1) / (formSteps.length - 1)) * 100;
            progressBar.style.width = `${progressPercentage}%`;
            
            // Faire défiler vers le haut
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            // Mettre à jour l'étape actuelle
            currentStep = step;
            
            // Si on passe à l'étape de la carte, initialiser la carte
            if (step === 2) {
                initMap();
            }
        }
        
        // Initialisation : afficher uniquement la première étape
        goToStep(1);
        
        // Événement pour le bouton "Continuer vers Disponibilité"
        const nextToStep2Button = document.getElementById('next-to-step-2');
        if (nextToStep2Button) {
            nextToStep2Button.addEventListener('click', function() {
                goToStep(2);
            });
        }
        
        // Événement pour le bouton "Retour" (étape 2 vers étape 1)
        const backToStep1Button = document.getElementById('back-to-step-1');
        if (backToStep1Button) {
            backToStep1Button.addEventListener('click', function() {
                goToStep(1);
            });
        }
        
        // Événement pour le bouton "Continuer vers Options"
        const nextToStep3Button = document.getElementById('next-to-step-3');
        if (nextToStep3Button) {
            nextToStep3Button.addEventListener('click', function() {
                goToStep(3);
            });
        }
        
        // Événement pour le bouton "Retour" (étape 3 vers étape 2)
        const backToStep2Button = document.getElementById('back-to-step-2');
        if (backToStep2Button) {
            backToStep2Button.addEventListener('click', function() {
                goToStep(2);
            });
        }
        
        // Événement pour le bouton "Continuer vers Publication"
        const nextToStep4Button = document.getElementById('next-to-step-4');
        if (nextToStep4Button) {
            nextToStep4Button.addEventListener('click', function() {
                    goToStep(4);
                updateRecapitulatif();
            });
        }
        
        // Événement pour le bouton "Retour" (étape 4 vers étape 3)
        const backToStep3Button = document.getElementById('back-to-step-3');
        if (backToStep3Button) {
            backToStep3Button.addEventListener('click', function() {
                goToStep(3);
            });
        }
        
        // Gestion des options premium
        const isPremiumCheckbox = document.getElementById('is_premium');
        const premiumOptions = document.getElementById('premium-options');
        const premiumOptionCards = document.querySelectorAll('.premium-option');
        
        // Afficher/masquer les options premium en fonction de la case à cocher
        isPremiumCheckbox.addEventListener('change', function() {
            if (this.checked) {
                premiumOptions.style.display = 'block';
                // Sélectionner la première option par défaut
                if (premiumOptionCards.length > 0) {
                    premiumOptionCards[0].click();
                }
            } else {
                premiumOptions.style.display = 'none';
                // Désélectionner toutes les options
                document.querySelectorAll('.premium-radio').forEach(radio => {
                    radio.checked = false;
                });
                premiumOptionCards.forEach(card => {
                    card.classList.remove('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
                });
            }
        });
        
        // Sélection d'une option premium
        premiumOptionCards.forEach(card => {
            card.addEventListener('click', function() {
                // Désélectionner toutes les options
                premiumOptionCards.forEach(c => {
                    c.classList.remove('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
                });
                
                // Sélectionner l'option cliquée
                this.classList.add('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
                
                // Cocher le radio button correspondant
                const radio = this.querySelector('.premium-radio');
                radio.checked = true;
            });
        });
        
        // Fonction pour mettre à jour le récapitulatif
        function updateRecapitulatif() {
            // Récupérer les valeurs
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const cityId = document.getElementById('city_id').value;
            const cityName = document.getElementById('city_id').options[document.getElementById('city_id').selectedIndex].text;
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;
            
            // Options de livraison
            let deliveryOption = '';
            if (document.getElementById('delivery_option_pickup').checked) {
                deliveryOption = 'Récupération sur place uniquement';
            } else if (document.getElementById('delivery_option_delivery').checked) {
                deliveryOption = 'Livraison uniquement';
            } else if (document.getElementById('delivery_option_both').checked) {
                deliveryOption = 'Récupération sur place ou livraison';
            }
            
            // Options premium
            let premiumOption = 'Aucune option premium sélectionnée';
            if (document.getElementById('is_premium').checked) {
                const premiumType = document.querySelector('input[name="premium_type"]:checked').value;
                premiumOption = `Option premium: ${premiumType}`;
            }
            
            // Mettre à jour le récapitulatif
            document.getElementById('recap-equipment-title').textContent = document.querySelector('.bg-gray-50 h3').textContent;
            document.getElementById('recap-equipment-price').textContent = document.querySelector('.bg-gray-50 .text-forest').textContent;
            
            document.getElementById('recap-dates').textContent = `Du ${formatDate(startDate)} au ${formatDate(endDate)}`;
            
            let locationText = cityName;
            if (latitude && longitude) {
                locationText += ` (Position GPS: ${latitude}, ${longitude})`;
            }
            document.getElementById('recap-location').textContent = locationText;
            
            document.getElementById('recap-delivery').textContent = deliveryOption;
            document.getElementById('recap-premium').textContent = premiumOption;
        }
        
        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR');
        }
        
        // Validation du formulaire avant soumission
        const publishButton = document.getElementById('publish-button');
        
        publishButton.addEventListener('click', function(e) {
            const termsAgree = document.getElementById('terms_agree').checked;
            
            if (!termsAgree) {
                e.preventDefault();
                alert('Vous devez accepter les conditions générales pour publier votre annonce.');
                return;
            }
            
            // Soumettre le formulaire si tout est valide
            form.submit();
        });
        
        // Initialisation de la carte
        let map, marker;
        
        function initMap() {
            // Vérifier si la carte est déjà initialisée
            if (map) return;
            
            // Coordonnées par défaut (Maroc)
            const defaultLat = 31.7917;
            const defaultLng = -7.0926;
            const defaultZoom = 5;
            
            // Créer la carte
            map = L.map('map-container').setView([defaultLat, defaultLng], defaultZoom);
            
            // Ajouter la couche de tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Gérer le clic sur la carte
            map.on('click', function(e) {
                // Mettre à jour les coordonnées dans les champs
                document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
                
                // Ajouter ou déplacer le marqueur
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
            
            // Récupérer la position de l'utilisateur si disponible
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Mettre à jour la vue de la carte
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        map.setView([userLat, userLng], 12);
                        
                        // Ajouter un marqueur pour la position de l'utilisateur
                        if (marker) {
                            marker.setLatLng([userLat, userLng]);
                        } else {
                            marker = L.marker([userLat, userLng]).addTo(map);
                        }
                        
                        // Mettre à jour les champs
                        document.getElementById('latitude').value = userLat.toFixed(6);
                        document.getElementById('longitude').value = userLng.toFixed(6);
                    },
                    function(error) {
                        // Gérer les erreurs
                        console.log('Erreur de géolocalisation:', error.message);
                    }
                );
            }
            
            // Redimensionner la carte après son chargement
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        }
        
        // Événement quand on sélectionne une ville
        const citySelect = document.getElementById('city_id');
        if (citySelect) {
            citySelect.addEventListener('change', function() {
                if (!map) return;
                
                const selectedCity = this.options[this.selectedIndex].text;
                if (selectedCity && selectedCity !== 'Sélectionnez une ville') {
                    // Utiliser l'API de géocodage pour trouver les coordonnées de la ville
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(selectedCity)},Maroc`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lng = parseFloat(data[0].lon);
                                
                                // Mettre à jour la vue de la carte
                                map.setView([lat, lng], 12);
                                
                                // Ne pas ajouter automatiquement de marqueur ni mettre à jour les coordonnées
                                // car l'utilisateur doit cliquer pour définir l'emplacement exact
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la géolocalisation de la ville:', error);
                        });
                }
            });
        }
    });
</script>
@endsection