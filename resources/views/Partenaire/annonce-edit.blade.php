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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">

@include('Partenaire.side-bar');

<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">

    <div class="max-w-6xl mx-auto">
     

        <!-- Page header -->
        <div class="mb-8">
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
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $item->title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <p class="text-gray-800 dark:text-gray-200">{{ $item->description }}</p>
                        </div>
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
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position exacte</label>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">Cliquez sur la carte pour indiquer où vous pouvez mettre l'équipement à disposition.</p>
                            
                            <div id="map-container" class="z-0 w-full h-80 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600 mb-3"></div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" value="{{ $listing->latitude }}" placeholder="Ex: 33.5731104" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" readonly>
                                </div>
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" value="{{ $listing->longitude }}" placeholder="Ex: -7.5898434" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" readonly>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                <i class="fas fa-info-circle mr-1"></i> L'emplacement exact ne sera partagé qu'avec les locataires après confirmation de la réservation.
                            </p>
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
                    <a href="{{ route('HomePartenaie.mesannonces') }}" class="btn-cancel px-6 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-md shadow-sm border border-gray-300 dark:border-gray-600 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn-save px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

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
        
        // Initialisation de la carte
        let map, marker;
        initMap();
        
        function initMap() {
            // Vérifier si la carte est déjà initialisée
            if (map) return;
            
            // Coordonnées par défaut (Maroc) ou coordonnées existantes
            const lat = document.getElementById('latitude').value || 31.7917;
            const lng = document.getElementById('longitude').value || -7.0926;
            const defaultZoom = lat && lng && lat != 31.7917 ? 12 : 5;
            
            // Créer la carte
            map = L.map('map-container').setView([lat, lng], defaultZoom);
            
            // Ajouter la couche de tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Ajouter un marqueur si des coordonnées sont déjà définies
            if (lat && lng && lat != 31.7917) {
                marker = L.marker([lat, lng]).addTo(map);
            }
            
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
            
            // Récupérer la position de l'utilisateur si aucune position n'est définie
            if ((!lat || !lng || lat == 31.7917) && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Mettre à jour la vue de la carte
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        map.setView([userLat, userLng], 12);
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
