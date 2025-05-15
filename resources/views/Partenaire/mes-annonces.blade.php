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

</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
@include('Partenaire.side-bar');

<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">

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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Prix</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lieu</th>
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
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset($firstImage) }}" alt="{{ $annonce->title }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                        <i class="fas fa-campground text-gray-400 dark:text-gray-500"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $annonce->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($annonce->status == 'active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                Active
                                            </span>
                                        @elseif($annonce->status == 'archived')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                Archivée
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $annonce->price_per_day }} MAD / jour</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $annonce->city_name }}</div>
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
                                                <input type="hidden" name="status" value="{{ $annonce->status === 'active' ? 'archived' : 'active' }}">
                                                <button type="submit" class="{{ $annonce->status === 'active' ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 hover:bg-orange-200 dark:hover:bg-orange-800/50' : 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-800/50' }} px-2 py-1 rounded" title="{{ $annonce->status === 'active' ? 'Désactiver l\'annonce' : 'Activer l\'annonce' }}">
                                                    @if($annonce->status === 'active')
                                                        <i class="fas fa-toggle-off mr-1"></i> Archiver
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
                <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $annonces->withQueryString()->links() }}
                </div>
            @endif
        </div>
</main>