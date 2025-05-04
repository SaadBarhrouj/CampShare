@php
    // Récupérer les annonces de l'utilisateur connecté
    $user = Auth::user();
    $annonces = App\Models\Listing::select('listings.*', 'items.title', 'items.description', 'items.price_per_day', 'cities.name as city_name')
        ->join('items', 'listings.item_id', '=', 'items.id')
        ->join('cities', 'listings.city_id', '=', 'cities.id')
        ->where('items.partner_id', $user->id)
        ->with('item.images')
        ->distinct()
        ->orderBy('listings.updated_at', 'desc')
        ->paginate(5);
@endphp

<div class="flex flex-col md:flex-row pt-16">
    <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="py-8 px-4 md:px-8">
            <!-- Page header -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Mes annonces</h1>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        Gérez vos annonces d'équipements de camping publiées
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-4">
                    <a href="{{ route('partenaire.equipements') }}" class="inline-flex items-center px-4 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Publier une annonce
                    </a>
                </div>
            </div>

            <!-- Filtres -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <form action="{{ route('partenaire.mes-annonces') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rechercher</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Rechercher par titre, description..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Statut -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tous les statuts</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actives</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactives</option>
                        </select>
                    </div>
                    
                    <!-- Tri -->
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trier par</label>
                        <select name="sort_by" id="sort_by" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Plus récentes</option>
                            <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Plus anciennes</option>
                            <option value="price-asc" {{ request('sort_by') == 'price-asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price-desc" {{ request('sort_by') == 'price-desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>
                    
                    <!-- Bouton Filtrer -->
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
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                            <i class="fas fa-bullhorn text-gray-400 dark:text-gray-500 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Vous n'avez aucune annonce</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Commencez par ajouter votre équipement, puis publiez votre première annonce.</p>
                        <a href="{{ route('partenaire.equipements') }}" class="inline-flex items-center px-4 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm">
                            <i class="fas fa-campground mr-2"></i>
                            Gérer mes équipements
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Annonce</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($annonces as $annonce)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($annonce->item->images->isNotEmpty())
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $annonce->item->images->first()->url) }}" alt="{{ $annonce->title }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                        <i class="fas fa-campground text-gray-400 dark:text-gray-500"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $annonce->title }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">
                                                    {{ $annonce->description }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($annonce->status === 'active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 dark:text-white font-medium">{{ number_format($annonce->price_per_day, 0) }} MAD</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">/jour</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $annonce->city_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span title="Dernière mise à jour: {{ $annonce->updated_at->format('d/m/Y H:i') }}">
                                            {{ $annonce->created_at->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-2 justify-end">
                                            <a href="{{ route('partenaire.annonces.details', $annonce->id) }}" class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded hover:bg-blue-200 dark:hover:bg-blue-800/50" title="Voir les détails">
                                                <i class="fas fa-eye mr-1"></i> Voir
                                            </a>
                                            
                                            <a href="{{ route('partenaire.annonces.edit', $annonce->id) }}" class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded hover:bg-indigo-200 dark:hover:bg-indigo-800/50" title="Modifier l'annonce">
                                                <i class="fas fa-edit mr-1"></i> Modifier
                                            </a>
                                            
                                            <form action="{{ route('partenaire.annonces.update', $annonce) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ $annonce->status === 'active' ? 'inactive' : 'active' }}">
                                                <button type="submit" class="{{ $annonce->status === 'active' ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 hover:bg-orange-200 dark:hover:bg-orange-800/50' : 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-800/50' }} px-2 py-1 rounded" title="{{ $annonce->status === 'active' ? 'Désactiver l\'annonce' : 'Activer l\'annonce' }}">
                                                    @if($annonce->status === 'active')
                                                        <i class="fas fa-toggle-off mr-1"></i> Désactiver
                                                    @else
                                                        <i class="fas fa-toggle-on mr-1"></i> Activer
                                                    @endif
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('partenaire.annonces.delete', $annonce) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded hover:bg-red-200 dark:hover:bg-red-800/50" title="Supprimer l'annonce">
                                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $annonces->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div> 