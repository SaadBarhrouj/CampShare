@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Retour -->
        <div class="mb-6">
            <a href="{{ route('partenaire.mes-annonces') }}" class="inline-flex items-center text-forest dark:text-meadow hover:underline">
                <i class="fas fa-arrow-left mr-2"></i> Retour à mes annonces
            </a>
        </div>

        <!-- En-tête -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $item->title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ $item->category->name }} - {{ $item->price_per_day }} MAD/jour
                    </p>
                </div>
                
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <a href="{{ route('partenaire.annonces.edit', $listing->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white font-medium rounded-md shadow-sm transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier l'annonce
                    </a>
                    <a href="{{ route('client.listings.show', $listing->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <i class="far fa-eye mr-2"></i>
                        Voir côté client
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Informations d'annonce -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Détails de base -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Détails de l'annonce</h2>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</h3>
                        <div class="mt-1">
                            @if($listing->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    <i class="fas fa-circle text-xs mr-1"></i> Active
                                </span>
                            @elseif($listing->status == 'inactive')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    <i class="fas fa-circle text-xs mr-1"></i> Inactive
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    <i class="fas fa-circle text-xs mr-1"></i> Archivée
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Période de disponibilité</h3>
                        <p class="mt-1 text-gray-900 dark:text-white">
                            Du {{ \Carbon\Carbon::parse($listing->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($listing->end_date)->format('d/m/Y') }}
                            <span class="text-gray-500 dark:text-gray-400 text-sm">({{ $availableDays }} jours)</span>
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Localisation</h3>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $city->name }}</p>
                        
                        @if($listing->latitude && $listing->longitude)
                        <div class="mt-2">
                            <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400">Position GPS</h4>
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $listing->latitude }}, {{ $listing->longitude }}
                            </p>
                            <div id="map-container" class="w-full h-40 rounded-md mt-2 border border-gray-200 dark:border-gray-700"></div>
                        </div>
                        @endif
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Option de livraison</h3>
                        <p class="mt-1 text-gray-900 dark:text-white">
                            @if($listing->delivery_option)
                                <span class="inline-flex items-center">
                                    <i class="fas fa-truck text-forest dark:text-meadow mr-2"></i> Livraison disponible
                                </span>
                            @else
                                <span class="inline-flex items-center">
                                    <i class="fas fa-store text-forest dark:text-meadow mr-2"></i> Récupération sur place uniquement
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Option premium</h3>
                        <p class="mt-1 text-gray-900 dark:text-white">
                            @if($listing->is_premium)
                                <span class="inline-flex items-center">
                                    <i class="fas fa-crown text-amber-500 mr-2"></i> {{ $listing->premium_type }}
                                </span>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">Aucune option premium sélectionnée</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Statistiques</h2>
                </div>
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Revenus potentiels</h3>
                            <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ number_format($potentialRevenue, 2) }} MAD</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">pour {{ $availableDays }} jours</p>
                        </div>
                        
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                            <h3 class="text-sm font-medium text-green-800 dark:text-green-300">Prix par jour</h3>
                            <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $item->price_per_day }} MAD</p>
                        </div>
                        
                        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3">
                            <h3 class="text-sm font-medium text-purple-800 dark:text-purple-300">Nombre de vues</h3>
                            <p class="text-xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $viewCount }}</p>
                        </div>
                        
                        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-3">
                            <h3 class="text-sm font-medium text-amber-800 dark:text-amber-300">Réservations</h3>
                            <p class="text-xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $reservationCount }}</p>
                            <p class="text-xs text-amber-600 dark:text-amber-400">dont {{ $completedReservationCount }} terminées</p>
                        </div>
                    </div>
                    
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Dates clés</h3>
                        <div class="flex flex-col space-y-1">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Date de création</span>
                                <span class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($listing->created_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Dernière mise à jour</span>
                                <span class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($listing->updated_at)->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Détails de l'équipement -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Détails de l'équipement</h2>
            </div>
            <div class="p-4">
                <div class="flex flex-col md:flex-row md:space-x-4">
                    <div class="md:w-1/3 mb-4 md:mb-0">
                        @if($item->images->isNotEmpty())
                            <div class="rounded-lg overflow-hidden h-48">
                                <img src="{{ asset('storage/' . $item->images->first()->url) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-48 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <i class="fas fa-campground text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:w-2/3">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $item->title }}</h3>
                        <div class="flex items-center space-x-2 mt-1 mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                {{ $item->category->name }}
                            </span>
                            <span class="text-forest dark:text-meadow font-medium">{{ $item->price_per_day }} MAD/jour</span>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-400">{{ $item->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Actions</h2>
            </div>
            <div class="p-4 flex flex-wrap gap-3">
                <a href="{{ route('partenaire.annonces.edit', $listing->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white font-medium rounded-md shadow-sm transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier l'annonce
                </a>
                
                @if($listing->status == 'active')
                    <form action="{{ route('partenaire.annonces.update', $listing->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="inactive">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Désactiver
                        </button>
                    </form>
                    
                    <form action="{{ route('partenaire.annonces.archive', $listing->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 dark:bg-yellow-700 dark:hover:bg-yellow-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            <i class="fas fa-archive mr-2"></i>
                            Archiver
                        </button>
                    </form>
                @elseif($listing->status == 'inactive')
                    <form action="{{ route('partenaire.annonces.update', $listing->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            <i class="fas fa-toggle-on mr-2"></i>
                            Activer
                        </button>
                    </form>
                @else
                    <form action="{{ route('partenaire.annonces.update', $listing->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            <i class="fas fa-redo mr-2"></i>
                            Réactiver
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('partenaire.annonces.delete', $listing->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white font-medium rounded-md shadow-sm transition-colors">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($listing->latitude && $listing->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Coordonnées de la position
        const lat = {{ $listing->latitude }};
        const lng = {{ $listing->longitude }};
        
        // Créer la carte
        const map = L.map('map-container').setView([lat, lng], 13);
        
        // Ajouter la couche de tuiles OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);
        
        // Ajouter un marqueur
        L.marker([lat, lng]).addTo(map);
    });
</script>
@endif
@endsection 