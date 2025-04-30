@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <a href="{{ route('partenaire.mes-annonces') }}" class="inline-flex items-center text-forest dark:text-meadow hover:underline mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Retour à mes annonces
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Modifier l'annonce pour "{{ $item->title }}"</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                Modifiez les informations de votre annonce.
            </p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-10">
            <form id="listing-form" action="{{ route('partenaire.annonces.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                
                <!-- Informations de base -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informations de l'équipement</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Titre et description</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $item->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Le titre ne peut pas être modifié ici. Pour modifier le titre, veuillez mettre à jour votre équipement.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <p class="text-gray-800 dark:text-gray-200">{{ $item->description }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">La description ne peut pas être modifiée ici. Pour modifier la description, veuillez mettre à jour votre équipement.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Photos de l'équipement -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Photos de l'équipement</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Photos actuelles</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->url) }}" alt="Photo de l'équipement" class="w-full h-32 object-cover rounded-lg">
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">Pour modifier les photos, veuillez mettre à jour votre équipement.</p>
                    </div>
                </div>
                
                <!-- Disponibilité et localisation -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Disponibilité et localisation</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Période de disponibilité -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Période de disponibilité</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de début</label>
                                <input type="date" id="start_date" name="start_date" value="{{ $listing->start_date }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de fin</label>
                                <input type="date" id="end_date" name="end_date" value="{{ $listing->end_date }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Options de livraison -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Options de livraison</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="delivery_pickup" name="delivery_option" type="radio" value="pickup" {{ (!$listing->delivery_option) ? 'checked' : '' }} class="focus:ring-forest dark:focus:ring-meadow h-4 w-4 text-forest dark:text-meadow border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="delivery_pickup" class="font-medium text-gray-700 dark:text-gray-300">Récupération sur place uniquement</label>
                                    <p class="text-gray-500 dark:text-gray-400">Les locataires devront venir chercher l'équipement à l'adresse indiquée</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="delivery_both" name="delivery_option" type="radio" value="both" {{ ($listing->delivery_option) ? 'checked' : '' }} class="focus:ring-forest dark:focus:ring-meadow h-4 w-4 text-forest dark:text-meadow border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="delivery_both" class="font-medium text-gray-700 dark:text-gray-300">Récupération sur place ou livraison</label>
                                    <p class="text-gray-500 dark:text-gray-400">Vous proposez les deux options aux locataires</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Localisation -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Localisation</h3>
                        <div class="mb-4">
                            <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ville</label>
                            <select id="city_id" name="city_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" required>
                                <option value="">Sélectionnez une ville</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $listing->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse précise</label>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">L'adresse exacte sera partagée uniquement avec les locataires après confirmation de la réservation.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Options premium -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Options de mise en avant</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Toggle pour activer les options premium -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Mettre en avant mon annonce</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Augmentez la visibilité de votre annonce pour attirer plus de locataires</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_premium" name="is_premium" value="1" class="sr-only peer" {{ $listing->is_premium ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-forest/20 dark:peer-focus:ring-meadow/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-forest dark:peer-checked:bg-meadow"></div>
                        </label>
                    </div>
                    
                    <div id="premium-options" class="space-y-4" style="{{ $listing->is_premium ? '' : 'display: none;' }}">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Choisissez votre formule</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Option 7 jours -->
                            <div class="premium-option-card border-2 rounded-lg p-4 cursor-pointer transition-all {{ $listing->premium_type == '7 jours' ? 'border-forest dark:border-meadow bg-green-50 dark:bg-green-900/10' : 'border-gray-200 dark:border-gray-700' }}" data-premium-type="7 jours" data-premium-price="50">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-gray-900 dark:text-white">7 jours</h4>
                                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 rounded-full text-xs font-semibold">+50 MAD</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Idéal pour les locations courtes durée</p>
                                <ul class="mt-3 space-y-2 text-sm">
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Apparaît en haut des résultats
                                    </li>
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Badge "Annonce premium"
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Option 15 jours -->
                            <div class="premium-option-card border-2 rounded-lg p-4 cursor-pointer transition-all {{ $listing->premium_type == '15 jours' ? 'border-forest dark:border-meadow bg-green-50 dark:bg-green-900/10' : 'border-gray-200 dark:border-gray-700' }}" data-premium-type="15 jours" data-premium-price="90">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-gray-900 dark:text-white">15 jours</h4>
                                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 rounded-full text-xs font-semibold">+90 MAD</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Notre option la plus populaire</p>
                                <ul class="mt-3 space-y-2 text-sm">
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Apparaît en haut des résultats
                                    </li>
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Badge "Annonce premium"
                                    </li>
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Mise en avant sur la page d'accueil
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Option 30 jours -->
                            <div class="premium-option-card border-2 rounded-lg p-4 cursor-pointer transition-all {{ $listing->premium_type == '30 jours' ? 'border-forest dark:border-meadow bg-green-50 dark:bg-green-900/10' : 'border-gray-200 dark:border-gray-700' }}" data-premium-type="30 jours" data-premium-price="150">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-gray-900 dark:text-white">30 jours</h4>
                                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 rounded-full text-xs font-semibold">+150 MAD</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Visibilité maximale</p>
                                <ul class="mt-3 space-y-2 text-sm">
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Apparaît en haut des résultats
                                    </li>
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Badge "Annonce premium"
                                    </li>
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Mise en avant sur la page d'accueil
                                    </li>
                                    <li class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-check text-green-500 mr-2"></i> Envoi d'une notification aux utilisateurs
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <input type="hidden" id="premium_type" name="premium_type" value="{{ $listing->premium_type }}">
                    </div>
                </div>
                
                <!-- Boutons de soumission -->
                <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between space-x-4">
                    <a href="{{ route('partenaire.mes-annonces') }}" class="px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2 bg-forest hover:bg-forest-dark dark:bg-meadow dark:hover:bg-meadow-dark text-white font-medium rounded-md shadow-sm transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des options premium
        const isPremiumCheckbox = document.getElementById('is_premium');
        const premiumOptionsContainer = document.getElementById('premium-options');
        const premiumOptionCards = document.querySelectorAll('.premium-option-card');
        const premiumTypeInput = document.getElementById('premium_type');
        
        // Afficher/masquer les options premium
        if (isPremiumCheckbox) {
            isPremiumCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    premiumOptionsContainer.style.display = 'block';
                } else {
                    premiumOptionsContainer.style.display = 'none';
                    premiumTypeInput.value = '';
                }
            });
        }
        
        // Sélection d'une option premium
        premiumOptionCards.forEach(card => {
            card.addEventListener('click', function() {
                // Désélectionner toutes les options
                premiumOptionCards.forEach(c => {
                    c.classList.remove('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
                    c.classList.add('border-gray-200', 'dark:border-gray-700');
                });
                
                // Sélectionner l'option cliquée
                this.classList.remove('border-gray-200', 'dark:border-gray-700');
                this.classList.add('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
                
                // Mettre à jour la valeur dans le champ caché
                const premiumType = this.getAttribute('data-premium-type');
                premiumTypeInput.value = premiumType;
            });
        });
    });
</script>
@endsection
