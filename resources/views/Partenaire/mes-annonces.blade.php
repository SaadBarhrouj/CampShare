@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête de page -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Mes annonces</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Gérez vos annonces d'équipements de camping publiées
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-4">
                <a href="{{ route('partenaire.equipements') }}" class="inline-flex items-center px-4 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Créer une annonce
                </a>
                <a href="{{ route('HomePartenaie') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:focus:ring-meadow">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au tableau de bord
                </a>
            </div>
        </div>

        <!-- Alertes -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtres et recherche -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <form action="{{ route('partenaire.mes-annonces') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rechercher</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ $search }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white" placeholder="Rechercher par titre, description ou ville...">
                    </div>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut</label>
                    <select id="status" name="status" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Actives</option>
                        <option value="archived" {{ $status == 'archived' ? 'selected' : '' }}>Archivées</option>
                    </select>
                </div>
                
                <div>
                    <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trier par</label>
                    <select id="sort_by" name="sort_by" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 dark:text-white">
                        <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Plus récentes</option>
                        <option value="oldest" {{ $sortBy == 'oldest' ? 'selected' : '' }}>Plus anciennes</option>
                        <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>
                </div>
                
                <div>
                    <button type="submit" class="btn-filter w-full md:w-auto px-4 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                        <i class="fas fa-filter mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des annonces -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            @if($annonces->isEmpty())
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                        <i class="fas fa-clipboard-list text-2xl text-gray-500 dark:text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Aucune annonce trouvée</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Vous n'avez pas encore publié d'annonces ou aucune annonce ne correspond à vos critères de recherche.</p>
                    <a href="{{ route('partenaire.equipements') }}" class="btn-publish inline-flex items-center px-4 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Publier une annonce
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Équipement</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Disponibilité</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Localisation</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Premium</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($annonces as $annonce)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @php
                                                    $imageUrls = explode(',', $annonce->image_urls);
                                                    $firstImage = !empty($imageUrls[0]) ? $imageUrls[0] : null;
                                                @endphp
                                                
                                                @if($firstImage)
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $annonce->title }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                        <i class="fas fa-campground text-gray-400 dark:text-gray-500"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $annonce->title }}</div>
                                                <div class="text-sm text-gray-900 dark:text-white">{{ $annonce->price_per_day }} MAD / jour</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            Du {{ \Carbon\Carbon::parse($annonce->start_date)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Au {{ \Carbon\Carbon::parse($annonce->end_date)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $annonce->city_name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            @if($annonce->delivery_option)
                                                <span class="inline-flex items-center">
                                                    <i class="fas fa-truck text-xs mr-1"></i> Livraison disponible
                                                </span>
                                            @else
                                                <span class="inline-flex items-center">
                                                    <i class="fas fa-store text-xs mr-1"></i> Récupération sur place
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($annonce->status == 'active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                Archivée
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($annonce->is_premium)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300">
                                                {{ $annonce->premium_type }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Non</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-col space-y-2">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('partenaire.annonces.details', $annonce->id) }}" class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded hover:bg-blue-200 dark:hover:bg-blue-800/50" title="Voir les détails">
                                                    <i class="fas fa-eye mr-1"></i> Voir
                                                </a>
                                                
                                                <a href="{{ route('partenaire.annonces.edit', $annonce->id) }}" class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded hover:bg-indigo-200 dark:hover:bg-indigo-800/50" title="Modifier l'annonce">
                                                    <i class="fas fa-edit mr-1"></i> Modifier
                                                </a>
                                            </div>
                                            
                                            <div class="flex space-x-2">
                                                @if($annonce->status == 'active')
                                                    <form action="{{ route('partenaire.annonces.update', $annonce->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="inactive">
                                                        <button type="submit" class="px-2 py-1 bg-gray-100 dark:bg-gray-900/30 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-200 dark:hover:bg-gray-800/50" title="Désactiver l'annonce">
                                                            <i class="fas fa-toggle-off mr-1"></i> Désactiver
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('partenaire.annonces.archive', $annonce->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 rounded hover:bg-yellow-200 dark:hover:bg-yellow-800/50" title="Archiver l'annonce">
                                                            <i class="fas fa-archive mr-1"></i> Archiver
                                                        </button>
                                                    </form>
                                                @elseif($annonce->status == 'inactive')
                                                    <form action="{{ route('partenaire.annonces.update', $annonce->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="active">
                                                        <button type="submit" class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded hover:bg-green-200 dark:hover:bg-green-800/50" title="Activer l'annonce">
                                                            <i class="fas fa-toggle-on mr-1"></i> Activer
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('partenaire.annonces.archive', $annonce->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 rounded hover:bg-yellow-200 dark:hover:bg-yellow-800/50" title="Archiver l'annonce">
                                                            <i class="fas fa-archive mr-1"></i> Archiver
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('partenaire.annonces.update', $annonce->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="active">
                                                        <button type="submit" class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded hover:bg-green-200 dark:hover:bg-green-800/50" title="Réactiver l'annonce">
                                                            <i class="fas fa-redo mr-1"></i> Réactiver
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            
                                            <div>
                                                <form action="{{ route('partenaire.annonces.delete', $annonce->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded hover:bg-red-200 dark:hover:bg-red-800/50" title="Supprimer l'annonce">
                                                        <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $annonces->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
