@extends('layouts.app')

@section('content')
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
                    <div class="bg-forest dark:bg-meadow h-2.5 rounded-full progress-bar" style="width: 20%"></div>
                </div>
            </div>
            <div class="flex justify-between mt-2 text-sm text-gray-600 dark:text-gray-400">
                <div class="step-indicator active" data-step="1">
                    <span class="font-medium text-forest dark:text-meadow">1. Informations</span>
                </div>
                <div class="step-indicator" data-step="2">
                    <span>2. Photos</span>
                </div>
                <div class="step-indicator" data-step="3">
                    <span>3. Disponibilité</span>
                </div>
                <div class="step-indicator" data-step="4">
                    <span>4. Options</span>
                </div>
                <div class="step-indicator" data-step="5">
                    <span>5. Publication</span>
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
                                Les informations de base de votre équipement sont déjà renseignées. Vous allez maintenant ajouter des photos et définir la disponibilité pour créer votre annonce.
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-4">
                        <button type="button" id="next-to-step-2" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            Continuer vers Photos
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Photos -->
                <div class="form-step" id="step-2" style="display: none;">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Photos de l'équipement</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            Ajoutez des photos de qualité pour mettre en valeur votre équipement.
                        </p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Zone de drop pour les photos -->
                        <div id="dropzone-container" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="space-y-4">
                                <div class="mx-auto flex justify-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="text-gray-700 dark:text-gray-300 font-medium">Déposez vos photos ici</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Glissez-déposez vos photos ou cliquez pour sélectionner des fichiers
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Formats acceptés: JPG, PNG, WEBP • Max 5 Mo par image
                                    </p>
                                </div>
                                <button type="button" id="browse-files" class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:focus:ring-meadow">
                                    Parcourir les fichiers
                                </button>
                                <input type="file" id="file-input" name="images[]" multiple accept="image/*" class="hidden">
                            </div>
                        </div>
                        
                        <!-- Prévisualisations des photos -->
                        <div id="preview-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-6" style="display: none;">
                            <!-- Les prévisualisations seront ajoutées ici dynamiquement -->
                        </div>
                        
                        <!-- Message d'aide -->
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-md p-4">
                            <h4 class="font-medium text-yellow-800 dark:text-yellow-300 flex items-center mb-2">
                                <i class="fas fa-lightbulb mr-2"></i>
                                Conseil
                            </h4>
                            <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                Ajoutez au moins 3 photos de qualité prises sous différents angles. La première photo sera utilisée comme image principale dans les résultats de recherche. Vous pouvez réorganiser vos photos en les faisant glisser.
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between space-x-4">
                        <button type="button" id="back-to-step-1" class="px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </button>
                        <button type="button" id="next-to-step-3" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            Continuer vers Disponibilité
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Disponibilité et localisation -->
                <div class="form-step" id="step-3" style="display: none;">
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
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Latitude (optionnel)</label>
                                    <input type="text" id="latitude" name="latitude" placeholder="Ex: 33.5731104" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white">
                                    @error('latitude')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Longitude (optionnel)</label>
                                    <input type="text" id="longitude" name="longitude" placeholder="Ex: -7.5898434" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white">
                                    @error('longitude')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between space-x-4">
                        <button type="button" id="back-to-step-2" class="px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </button>
                        <button type="button" id="next-to-step-4" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            Continuer vers Options
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 4: Options premium -->
                <div class="form-step" id="step-4" style="display: none;">
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
                        <button type="button" id="back-to-step-3" class="px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </button>
                        <button type="button" id="next-to-step-5" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            Continuer vers Publication
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 5: Publication (Récapitulatif) -->
                <div class="form-step" id="step-5" style="display: none;">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Récapitulatif de votre annonce</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            Vérifiez les informations avant de publier votre annonce.
                        </p>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Aperçu de l'annonce -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
                            <!-- En-tête avec image principale -->
                            <div id="recap-main-image" class="h-64 bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                                <div class="absolute inset-0 flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                                <!-- L'image principale sera insérée ici par JavaScript -->
                            </div>
                            
                            <!-- Informations de l'annonce -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $equipment->title }}</h3>
                                <p class="text-forest dark:text-meadow font-medium text-lg mb-4">{{ $equipment->price_per_day }} MAD / jour</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Disponibilité</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-dates">Du <span id="recap-start-date">--/--/----</span> au <span id="recap-end-date">--/--/----</span></p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Localisation</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-city">--</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Livraison</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-delivery">--</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Mise en avant</h4>
                                        <p class="text-gray-900 dark:text-white" id="recap-premium">Non</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Description</h4>
                                    <p class="text-gray-900 dark:text-white">{{ $equipment->description }}</p>
                                </div>
                            </div>
                            
                            <!-- Galerie d'images (miniatures) -->
                            <div class="px-6 pb-6">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Photos</h4>
                                <div id="recap-gallery" class="flex space-x-2 overflow-x-auto pb-2">
                                    <!-- Les miniatures seront insérées ici par JavaScript -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Conditions générales -->
                        <div class="flex items-start mt-6">
                            <div class="flex items-center h-5">
                                <input id="terms_agree" name="terms_agree" type="checkbox" class="h-4 w-4 text-forest dark:text-meadow focus:ring-forest dark:focus:ring-meadow border-gray-300 dark:border-gray-600 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms_agree" class="font-medium text-gray-700 dark:text-gray-300">J'accepte les conditions générales</label>
                                <p class="text-gray-500 dark:text-gray-400">En publiant cette annonce, j'accepte les <a href="#" class="text-forest dark:text-meadow hover:underline">conditions générales</a> et je certifie que toutes les informations fournies sont exactes.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between space-x-4">
                        <button type="button" id="back-to-step-4" class="px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour
                        </button>
                        <button type="submit" id="publish-button" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            <i class="fas fa-check mr-2"></i>
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
        }
        
        // Initialisation : afficher uniquement la première étape
        goToStep(1);
        
        // Événement pour le bouton "Continuer vers Photos"
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
        
        // Événement pour le bouton "Continuer vers Disponibilité"
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
        
        // Événement pour le bouton "Continuer vers Options"
        const nextToStep4Button = document.getElementById('next-to-step-4');
        if (nextToStep4Button) {
            nextToStep4Button.addEventListener('click', function() {
                // Valider les champs obligatoires avant de passer à l'étape suivante
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const cityId = document.getElementById('city_id').value;
                
                let isValid = true;
                let errorMessage = '';
                
                if (!startDate) {
                    isValid = false;
                    errorMessage += 'La date de début est requise.\n';
                    document.getElementById('start_date').classList.add('border-red-500');
                } else {
                    document.getElementById('start_date').classList.remove('border-red-500');
                }
                
                if (!endDate) {
                    isValid = false;
                    errorMessage += 'La date de fin est requise.\n';
                    document.getElementById('end_date').classList.add('border-red-500');
                } else {
                    document.getElementById('end_date').classList.remove('border-red-500');
                }
                
                if (!cityId) {
                    isValid = false;
                    errorMessage += 'La ville est requise.\n';
                    document.getElementById('city_id').classList.add('border-red-500');
                } else {
                    document.getElementById('city_id').classList.remove('border-red-500');
                }
                
                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    
                    if (end < start) {
                        isValid = false;
                        errorMessage += 'La date de fin doit être postérieure à la date de début.\n';
                        document.getElementById('end_date').classList.add('border-red-500');
                    }
                }
                
                if (isValid) {
                    goToStep(4);
                } else {
                    alert('Veuillez corriger les erreurs suivantes :\n' + errorMessage);
                }
            });
        }
        
        // Événement pour le bouton "Retour" (étape 4 vers étape 3)
        const backToStep3Button = document.getElementById('back-to-step-3');
        if (backToStep3Button) {
            backToStep3Button.addEventListener('click', function() {
                goToStep(3);
            });
        }
        
        // Événement pour le bouton "Continuer vers Publication"
        const nextToStep5Button = document.getElementById('next-to-step-5');
        if (nextToStep5Button) {
            nextToStep5Button.addEventListener('click', function() {
                goToStep(5);
                updateRecapitulatif();
            });
        }
        
        // Événement pour le bouton "Retour" (étape 5 vers étape 4)
        const backToStep4Button = document.getElementById('back-to-step-4');
        if (backToStep4Button) {
            backToStep4Button.addEventListener('click', function() {
                goToStep(4);
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
            // Dates
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate) {
                const formattedStartDate = new Date(startDate).toLocaleDateString('fr-FR');
                document.getElementById('recap-start-date').textContent = formattedStartDate;
            }
            
            if (endDate) {
                const formattedEndDate = new Date(endDate).toLocaleDateString('fr-FR');
                document.getElementById('recap-end-date').textContent = formattedEndDate;
            }
            
            // Ville
            const citySelect = document.getElementById('city_id');
            if (citySelect.selectedIndex > 0) {
                const selectedCity = citySelect.options[citySelect.selectedIndex].text;
                document.getElementById('recap-city').textContent = selectedCity;
            }
            
            // Option de livraison
            const deliveryOptions = document.querySelectorAll('input[name="delivery_option"]');
            deliveryOptions.forEach(option => {
                if (option.checked) {
                    let deliveryText = '';
                    if (option.value === 'pickup') {
                        deliveryText = 'Récupération sur place uniquement';
                    } else if (option.value === 'delivery') {
                        deliveryText = 'Livraison uniquement';
                    } else if (option.value === 'both') {
                        deliveryText = 'Récupération sur place ou livraison';
                    }
                    document.getElementById('recap-delivery').textContent = deliveryText;
                }
            });
            
            // Option premium
            const isPremium = document.getElementById('is_premium').checked;
            let premiumText = 'Non';
            
            if (isPremium) {
                const selectedPremiumOption = document.querySelector('input[name="premium_type"]:checked');
                if (selectedPremiumOption) {
                    const premiumType = selectedPremiumOption.value;
                    let premiumLabel = '';
                    
                    if (premiumType === '7 jours') {
                        premiumLabel = 'Basique (7 jours) - + 49 MAD';
                    } else if (premiumType === '15 jours') {
                        premiumLabel = 'Standard (15 jours) - + 89 MAD';
                    } else if (premiumType === '30 jours') {
                        premiumLabel = 'Premium (30 jours) - + 149 MAD';
                    }
                    
                    premiumText = premiumLabel;
                }
            }
            
            document.getElementById('recap-premium').textContent = premiumText;
            
            // Images
            updateRecapImages();
        }
        
        // Fonction pour mettre à jour les images dans le récapitulatif
        function updateRecapImages() {
            const recapMainImage = document.getElementById('recap-main-image');
            const recapGallery = document.getElementById('recap-gallery');
            
            // Vider la galerie
            recapGallery.innerHTML = '';
            
            // Récupérer toutes les images prévisualisées
            const previewImages = document.querySelectorAll('#preview-container .group');
            
            if (previewImages.length > 0) {
                // Trouver l'image principale (celle avec l'indicateur)
                let mainImageSrc = null;
                
                previewImages.forEach((preview, index) => {
                    const img = preview.querySelector('img');
                    const isMain = preview.querySelector('.main-image-indicator');
                    
                    // Créer une miniature pour la galerie
                    const thumbnail = document.createElement('div');
                    thumbnail.className = 'w-16 h-16 flex-shrink-0 rounded-md overflow-hidden border border-gray-200 dark:border-gray-700';
                    
                    const thumbImg = document.createElement('img');
                    thumbImg.src = img.src;
                    thumbImg.className = 'w-full h-full object-cover';
                    thumbImg.alt = 'Photo ' + (index + 1);
                    
                    thumbnail.appendChild(thumbImg);
                    recapGallery.appendChild(thumbnail);
                    
                    // Si c'est l'image principale
                    if (isMain) {
                        mainImageSrc = img.src;
                    }
                });
                
                // Mettre à jour l'image principale
                if (mainImageSrc) {
                    recapMainImage.innerHTML = '';
                    const mainImg = document.createElement('img');
                    mainImg.src = mainImageSrc;
                    mainImg.className = 'w-full h-full object-cover';
                    mainImg.alt = 'Image principale';
                    recapMainImage.appendChild(mainImg);
                }
            }
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
            
            // Vérifier si au moins une image a été ajoutée
            const hasImages = document.querySelectorAll('#preview-container .group').length > 0;
            
            if (!hasImages) {
                e.preventDefault();
                alert('Vous devez ajouter au moins une photo pour publier votre annonce.');
                return;
            }
            
            // Soumettre le formulaire si tout est valide
            form.submit();
        });
        
        // Gestion de l'upload des photos
        const dropzoneContainer = document.getElementById('dropzone-container');
        const fileInput = document.getElementById('file-input');
        const browseFilesButton = document.getElementById('browse-files');
        const previewContainer = document.getElementById('preview-container');
        const uploadedFiles = new Set();
        
        // Ouvrir le sélecteur de fichiers au clic sur le bouton ou la zone de drop
        browseFilesButton.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });
        
        dropzoneContainer.addEventListener('click', function() {
            fileInput.click();
        });
        
        // Gestion du drag & drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzoneContainer.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzoneContainer.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzoneContainer.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropzoneContainer.classList.add('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
        }
        
        function unhighlight() {
            dropzoneContainer.classList.remove('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
        }
        
        // Gestion du drop de fichiers
        dropzoneContainer.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        // Gestion de la sélection de fichiers via l'input
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
        
        function handleFiles(files) {
            if (files.length > 0) {
                previewContainer.style.display = 'grid';
                
                Array.from(files).forEach(file => {
                    if (!uploadedFiles.has(file.name) && file.type.match('image.*')) {
                        uploadedFiles.add(file.name);
                        createPreview(file);
                    }
                });
            }
        }
        
        function createPreview(file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            
            reader.onload = function() {
                const previewWrapper = document.createElement('div');
                previewWrapper.className = 'relative group';
                
                const previewImage = document.createElement('div');
                previewImage.className = 'relative aspect-square rounded-lg overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700';
                
                const img = document.createElement('img');
                img.src = reader.result;
                img.className = 'w-full h-full object-cover';
                img.alt = file.name;
                
                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity flex items-center justify-center';
                
                const actions = document.createElement('div');
                actions.className = 'absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-1';
                
                const mainButton = document.createElement('button');
                mainButton.type = 'button';
                mainButton.className = 'p-1.5 bg-white dark:bg-gray-800 rounded-full shadow-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors';
                mainButton.innerHTML = '<i class="fas fa-star text-xs"></i>';
                mainButton.title = 'Définir comme image principale';
                
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'p-1.5 bg-white dark:bg-gray-800 rounded-full shadow-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors';
                deleteButton.innerHTML = '<i class="fas fa-trash-alt text-xs"></i>';
                deleteButton.title = 'Supprimer cette image';
                
                // Événement pour supprimer l'image
                deleteButton.addEventListener('click', function() {
                    uploadedFiles.delete(file.name);
                    previewWrapper.remove();
                    
                    if (uploadedFiles.size === 0) {
                        previewContainer.style.display = 'none';
                    }
                });
                
                // Événement pour définir l'image principale
                mainButton.addEventListener('click', function() {
                    // Retirer la classe de toutes les images
                    document.querySelectorAll('.main-image-indicator').forEach(el => el.remove());
                    
                    // Ajouter l'indicateur d'image principale
                    const mainIndicator = document.createElement('div');
                    mainIndicator.className = 'absolute top-2 left-2 p-1 bg-forest dark:bg-meadow rounded-full shadow-sm text-white main-image-indicator';
                    mainIndicator.innerHTML = '<i class="fas fa-star text-xs"></i>';
                    
                    previewImage.appendChild(mainIndicator);
                    
                    // Déplacer cette image en première position
                    previewContainer.prepend(previewWrapper);
                });
                
                actions.appendChild(mainButton);
                actions.appendChild(deleteButton);
                
                previewImage.appendChild(img);
                previewImage.appendChild(overlay);
                
                previewWrapper.appendChild(previewImage);
                previewWrapper.appendChild(actions);
                
                previewContainer.appendChild(previewWrapper);
                
                // Si c'est la première image, la définir comme principale
                if (previewContainer.children.length === 1) {
                    mainButton.click();
                }
            };
        }
    });
</script>
@endsection