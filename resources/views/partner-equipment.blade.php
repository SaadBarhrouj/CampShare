<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Équipements - CampShare | Louez du matériel de camping entre particuliers</title>
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
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Star rating */
        .star-rating {
            display: inline-flex;
            font-size: 1rem;
            color: #FFAA33;
        }
        
        /* Equipment card hover effect */
        .equipment-card {
            transition: all 0.3s ease;
        }
        
        .equipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Sidebar active */
        .sidebar-link.active {
            background-color: rgba(45, 95, 43, 0.1);
            color: #2D5F2B;
            border-left: 4px solid #2D5F2B;
        }
        
        .dark .sidebar-link.active {
            background-color: rgba(79, 121, 66, 0.2);
            color: #4F7942;
            border-left: 4px solid #4F7942;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-800 text-white min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gray-800 shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center">
                        <span class="text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                        <span class="text-xs text-gray-400 ml-1">by Kayantz</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}#comment-ca-marche" class="text-gray-300 hover:text-sunlight font-medium transition duration-300">Comment ça marche ?</a>
                    <a href="{{ url('/annonces') }}" class="text-gray-300 hover:text-sunlight font-medium transition duration-300">Explorer le matériel</a>
                    <a href="{{ url('/') }}#devenir-partenaire" class="text-gray-300 hover:text-sunlight font-medium transition duration-300">Devenir Partenaire</a>
                    
                    <div class="relative ml-4">
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button id="notifications-button" class="relative p-2 text-gray-300 hover:bg-gray-700 rounded-full transition-colors">
                                    <i class="fas fa-bell"></i>
                                    <span class="notification-badge">3</span>
                                </button>
                            </div>
                            
                            <!-- User profile menu -->
                            <div class="relative">
                                <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                    <img src="{{ $partner->avatar_url ?? 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80' }}" 
                                         alt="{{ $partner->username ?? 'Utilisateur' }}" 
                                         class="h-8 w-8 rounded-full object-cover">
                                    <span class="text-gray-300 font-medium">{{ $partner->username ?? 'Utilisateur' }}</span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-300 hover:text-sunlight focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen pt-16">
        <!-- Sidebar -->
        <aside class="hidden md:block w-64 bg-gray-800 shadow-md h-screen fixed overflow-y-auto">
            <div class="p-5">
                <div class="mb-6 px-3 flex flex-col items-center">
                    <div class="relative">
                        <img src="{{ $partner->avatar_url ?? 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80' }}" 
                             alt="{{ $partner->username ?? 'Utilisateur' }}" 
                             class="w-24 h-24 rounded-full object-cover border-4 border-gray-700 shadow-md">
                        <div class="absolute bottom-0 right-0 bg-green-500 rounded-full w-6 h-6 border-4 border-gray-800 flex items-center justify-center">
                            <span class="text-white text-xs">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="text-xl font-bold text-white">{{ $partner->username }}</h3>
                        <p class="text-sm text-gray-400">{{ $partner->city->name ?? 'Ville non spécifiée' }}</p>
                        <div class="flex items-center justify-center mt-2">
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($partner->avg_rating ?? 0))
                                        <i class="fas fa-star"></i>
                                    @elseif ($i - 0.5 <= ($partner->avg_rating ?? 0))
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-1 text-sm text-gray-400">{{ number_format($partner->avg_rating ?? 0, 1) }}</span>
                        </div>
                    </div>
                </div>
                
                <nav class="mt-6 space-y-1">
                    <a href="{{ route('partner.dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Tableau de bord
                    </a>
                    <a href="{{ route('partner.equipment') }}" class="sidebar-link active flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors">
                        <i class="fas fa-campground w-5 mr-3"></i>
                        Mes équipements
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <i class="fas fa-calendar-check w-5 mr-3"></i>
                        Demandes de location
                        <span class="ml-auto bg-red-900/30 text-red-300 px-2 py-0.5 text-xs font-medium rounded-full">3</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <i class="fas fa-exchange-alt w-5 mr-3"></i>
                        Locations en cours
                        <span class="ml-auto bg-blue-900/30 text-blue-300 px-2 py-0.5 text-xs font-medium rounded-full">2</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        Mes réservations
                        <span class="ml-auto bg-purple-900/30 text-purple-300 px-2 py-0.5 text-xs font-medium rounded-full">5</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <i class="fas fa-star w-5 mr-3"></i>
                        Avis reçus
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <i class="fas fa-calendar-alt w-5 mr-3"></i>
                        Calendrier
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-base font-medium text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <i class="fas fa-chart-line w-5 mr-3"></i>
                        Statistiques
                    </a>
                </nav>
            </div>
        </aside>
        
        <!-- Main content -->
        <main class="flex-1 md:ml-64 bg-gray-800 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Page header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">Mes équipements</h1>
                        <p class="text-gray-400 mt-1">Gérez vos équipements disponibles à la location</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('listing.create') }}" class="inline-flex items-center px-4 py-2 bg-meadow text-white font-medium rounded-md shadow-sm hover:bg-meadow/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-meadow transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un équipement
                        </a>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="bg-gray-700 rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-400 mb-1">Statut</label>
                            <select id="status" name="status" class="w-full bg-gray-600 border border-gray-600 rounded-md text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-meadow">
                                <option value="all">Tous les statuts</option>
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                                <option value="archived">Archivé</option>
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-400 mb-1">Catégorie</label>
                            <select id="category" name="category" class="w-full bg-gray-600 border border-gray-600 rounded-md text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-meadow">
                                <option value="all">Toutes les catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-400 mb-1">Ville</label>
                            <select id="city" name="city" class="w-full bg-gray-600 border border-gray-600 rounded-md text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-meadow">
                                <option value="all">Toutes les villes</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-400 mb-1">Trier par</label>
                            <select id="sort" name="sort" class="w-full bg-gray-600 border border-gray-600 rounded-md text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-meadow">
                                <option value="newest">Plus récent</option>
                                <option value="oldest">Plus ancien</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Equipment list -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($listings as $listing)
                        <div class="equipment-card bg-gray-700 rounded-lg shadow-sm overflow-hidden" data-id="{{ $listing->id }}">
                            <div class="relative h-48">
                                <img src="{{ $listing->images->isNotEmpty() ? asset('storage/'.$listing->images->first()->url) : 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80' }}" 
                                     alt="{{ $listing->title }}" 
                                     class="w-full h-full object-cover" />
                                
                                <!-- Status badge -->
                                <div class="absolute top-2 left-2">
                                    @if($listing->status == 'active')
                                        <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded-full">Actif</span>
                                    @elseif($listing->status == 'archived')
                                        <span class="inline-block bg-amber-500 text-white text-xs px-2 py-1 rounded-full">Archivé</span>
                                    @else
                                        <span class="inline-block bg-gray-500 text-white text-xs px-2 py-1 rounded-full">Inactif</span>
                                    @endif
                                </div>
                                
                                <!-- Premium badge -->
                                @if($listing->is_premium)
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-block bg-sunlight text-white text-xs px-2 py-1 rounded-full">Premium</span>
                                    </div>
                                @endif
                                
                                <!-- Title and condition overlay -->
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                    <h3 class="text-white font-bold text-lg">{{ $listing->title }}</h3>
                                    <p class="text-gray-300 text-sm">{{ $listing->category->name ?? 'MSR' }} - Excellent état</p>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-gray-700">
                                <div class="flex justify-between items-center mb-2">
                                    <div class="text-white font-bold text-xl">
                                        {{ $listing->price_per_day }} MAD <span class="text-gray-400 font-normal text-sm">/jour</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        <span class="text-white">{{ number_format($listing->avg_rating ?? 4.8, 1) }}</span>
                                        <span class="text-gray-400 ml-1">({{ $listing->review_count ?? 18 }})</span>
                                    </div>
                                </div>
                                
                                <div class="text-gray-300 text-sm mb-3">
                                    Dispo. du {{ $listing->available_from ? \Carbon\Carbon::parse($listing->available_from)->format('j M') : '1 août' }} au {{ $listing->available_until ? \Carbon\Carbon::parse($listing->available_until)->format('j M') : '1 oct.' }}
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    @if(rand(0, 1) == 1)
                                        <span class="inline-flex items-center text-purple-400 text-sm">
                                            <i class="fas fa-fire mr-1"></i> Populaire
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-green-400 text-sm">
                                            <i class="fas fa-circle mr-1 text-xs"></i> Disponible
                                        </span>
                                    @endif
                                    
                                    <div class="flex space-x-4">
                                        <a href="{{ route('listing.create') }}?edit={{ $listing->id }}" class="text-gray-400 hover:text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-gray-400 hover:text-white" onclick="openEquipmentSettings({{ $listing->id }}, '{{ $listing->title }}', '{{ $listing->status }}', '{{ $listing->price_per_day }}')">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                        <form id="delete-form-{{ $listing->id }}" action="{{ route('partner.equipment.destroy', $listing->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <div class="bg-gray-700 rounded-lg p-8">
                                <div class="w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-campground text-meadow text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-medium text-white mb-2">Aucun équipement trouvé</h3>
                                <p class="text-gray-400 mb-6">Vous n'avez pas encore ajouté d'équipements à louer.</p>
                                <a href="{{ route('listing.create') }}" class="inline-flex items-center px-4 py-2 bg-meadow text-white font-medium rounded-md shadow-sm hover:bg-meadow/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-meadow transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter un équipement
                                </a>
                            </div>
                        </div>
                    @endforelse
                    
                    <!-- Add new equipment card -->
                    <div class="equipment-card bg-gray-700 rounded-lg shadow-sm overflow-hidden border-2 border-dashed border-gray-600 flex flex-col items-center justify-center h-64">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-meadow/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-plus text-meadow text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">Ajouter un équipement</h3>
                            <p class="text-gray-400 mb-4">Augmentez vos revenus en ajoutant plus d'équipements à louer</p>
                            <a href="{{ route('listing.create') }}" class="inline-flex items-center px-4 py-2 bg-meadow text-white text-sm font-medium rounded-md shadow-sm hover:bg-meadow/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-meadow transition-colors">
                                Ajouter maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modal des paramètres d'équipement -->
    <div id="equipment-settings-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b border-gray-700 flex items-center justify-between sticky top-0 bg-gray-800 z-10">
                <h3 class="text-xl font-bold text-white">Paramètres de l'équipement</h3>
                <button id="close-equipment-settings" class="text-gray-400 hover:text-white focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-4">
                <div class="flex items-center mb-5">
                    <img id="equipment-image" src="" alt="Équipement" class="w-20 h-20 rounded-md object-cover mr-3">
                    <div>
                        <h4 id="equipment-title" class="text-lg font-medium text-white"></h4>
                        <p id="equipment-subtitle" class="text-sm text-gray-400">MSR - Excellent état</p>
                    </div>
                </div>
                
                <div class="space-y-5">
                    <!-- Statut de l'annonce -->
                    <div class="border-b border-gray-700 pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="font-medium text-white mb-1">Statut de l'annonce</h5>
                                <p class="text-sm text-gray-400">Activer ou désactiver l'annonce</p>
                            </div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="equipment-status-toggle" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Archiver l'annonce -->
                    <div class="border-b border-gray-700 pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="font-medium text-white mb-1">Archiver l'annonce</h5>
                                <p class="text-sm text-gray-400">L'annonce ne sera plus visible</p>
                            </div>
                            <button id="archive-equipment-btn" class="px-4 py-2 bg-gray-700 text-white font-medium rounded-md hover:bg-gray-600 transition-colors">
                                Archiver
                            </button>
                        </div>
                    </div>
                    
                    <!-- Dates de disponibilité -->
                    <div class="border-b border-gray-700 pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="font-medium text-white mb-1">Dates de disponibilité</h5>
                                <p id="equipment-availability-dates" class="text-sm text-gray-400">Du 1 août au 1 oct. 2023</p>
                            </div>
                            <button id="edit-dates-btn" class="px-4 py-2 bg-gray-700 text-white font-medium rounded-md hover:bg-gray-600 transition-colors">
                                Modifier
                            </button>
                        </div>
                    </div>
                    
                    <!-- Prix journalier -->
                    <div class="border-b border-gray-700 pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="font-medium text-white mb-1">Prix journalier</h5>
                                <p id="equipment-price" class="text-sm text-gray-400">450 MAD/jour</p>
                            </div>
                            <button id="edit-price-btn" class="px-4 py-2 bg-gray-700 text-white font-medium rounded-md hover:bg-gray-600 transition-colors">
                                Modifier
                            </button>
                        </div>
                    </div>
                    
                    <!-- Éditer les détails -->
                    <div class="border-b border-gray-700 pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="font-medium text-white mb-1">Éditer les détails</h5>
                                <p class="text-sm text-gray-400">Photos, description, etc.</p>
                            </div>
                            <button id="edit-details-btn" class="px-4 py-2 bg-gray-700 text-white font-medium rounded-md hover:bg-gray-600 transition-colors">
                                Éditer
                            </button>
                        </div>
                    </div>
                    
                    <!-- Supprimer l'équipement -->
                    <div>
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="font-medium text-red-400 mb-1">Supprimer l'équipement</h5>
                                <p class="text-sm text-gray-400">Cette action est irréversible</p>
                            </div>
                            <button id="delete-equipment-btn" class="px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition-colors">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t border-gray-700 flex justify-end sticky bottom-0 bg-gray-800 z-10">
                <button id="cancel-settings-btn" class="px-4 py-2 bg-gray-700 text-white font-medium rounded-md mr-3 hover:bg-gray-600 transition-colors">
                    Annuler
                </button>
                <button id="save-settings-btn" class="px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition-colors">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>

    <script>
        // Filtres
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('status');
            const categoryFilter = document.getElementById('category');
            const cityFilter = document.getElementById('city');
            const sortFilter = document.getElementById('sort');
            
            // Fonction pour filtrer les équipements
            function filterEquipment() {
                const status = statusFilter.value;
                const category = categoryFilter.value;
                const city = cityFilter.value;
                const sort = sortFilter.value;
                
                // Implémenter la logique de filtrage ici
                console.log('Filtres:', { status, category, city, sort });
            }
            
            // Ajouter les écouteurs d'événements
            statusFilter?.addEventListener('change', filterEquipment);
            categoryFilter?.addEventListener('change', filterEquipment);
            cityFilter?.addEventListener('change', filterEquipment);
            sortFilter?.addEventListener('change', filterEquipment);
            
            // Modal des paramètres d'équipement
            const modal = document.getElementById('equipment-settings-modal');
            const closeBtn = document.getElementById('close-equipment-settings');
            const cancelBtn = document.getElementById('cancel-settings-btn');
            const saveBtn = document.getElementById('save-settings-btn');
            const statusToggle = document.getElementById('equipment-status-toggle');
            const archiveBtn = document.getElementById('archive-equipment-btn');
            const deleteBtn = document.getElementById('delete-equipment-btn');
            
            // Variables pour stocker les informations de l'équipement actuel
            let currentEquipmentId = null;
            let currentEquipmentStatus = null;
            
            // Fonction pour ouvrir le modal des paramètres
            window.openEquipmentSettings = function(id, title, status, price) {
                currentEquipmentId = id;
                currentEquipmentStatus = status;
                
                // Mettre à jour les informations dans le modal
                document.getElementById('equipment-title').textContent = title;
                document.getElementById('equipment-price').textContent = price + ' MAD/jour';
                
                // Récupérer l'image de l'équipement
                const equipmentCard = document.querySelector(`.equipment-card[data-id="${id}"]`);
                if (equipmentCard) {
                    const imgElement = equipmentCard.querySelector('img');
                    if (imgElement) {
                        document.getElementById('equipment-image').src = imgElement.src;
                    }
                }
                
                // Mettre à jour l'état du toggle en fonction du statut
                statusToggle.checked = status === 'active';
                
                // Afficher le modal
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };
            
            // Fermer le modal
            const closeModal = function() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };
            
            closeBtn?.addEventListener('click', closeModal);
            cancelBtn?.addEventListener('click', closeModal);
            
            // Sauvegarder les modifications
            saveBtn?.addEventListener('click', function() {
                const newStatus = statusToggle.checked ? 'active' : 'inactive';
                
                // Si le statut a changé, mettre à jour via l'API
                if (newStatus !== currentEquipmentStatus) {
                    window.location.href = "{{ url('/mes-equipements') }}/" + currentEquipmentId + "/toggle-status";
                } else {
                    closeModal();
                }
            });
            
            // Archiver l'équipement
            archiveBtn?.addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir archiver cet équipement ?')) {
                    // Rediriger vers la route d'archivage (à implémenter)
                    window.location.href = "{{ url('/mes-equipements') }}/" + currentEquipmentId + "/archive";
                }
            });
            
            // Supprimer l'équipement
            deleteBtn?.addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir supprimer cet équipement ? Cette action est irréversible.')) {
                    document.getElementById('delete-form-' + currentEquipmentId).submit();
                }
            });
            
            // Rediriger vers l'édition des détails
            document.getElementById('edit-details-btn')?.addEventListener('click', function() {
                window.location.href = "{{ route('listing.create') }}?edit=" + currentEquipmentId;
            });
        });
    </script>
</body>
</html>
