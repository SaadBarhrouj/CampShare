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

</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
@include('Partenaire.side-bar');
<div class="flex flex-col md:flex-row pt-16">
    <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="py-8 px-4 md:px-8">
            <!-- Page header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Vos Équipements</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez toutes vos équipements.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <button id="add-equipment-button" class="px-4 py-3 bg-forest hover:bg-meadow text-white rounded-md shadow-lg flex items-center font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter un équipement
                    </button>
                </div>
            </div>

            <!-- Filters and search -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
                <form action="{{ route('partenaire.equipements') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                    
                    <!-- Catégorie -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                        <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Prix -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Intervalle de prix</label>
                        <div class="flex space-x-2 items-center">
                            <div class="flex-1">
                                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="Prix min" min="0" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            </div>
                            <span class="text-gray-500 dark:text-gray-400">-</span>
                            <div class="flex-1">
                                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Prix max" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            </div>
                            <span class="text-gray-500 dark:text-gray-400">MAD</span>
                        </div>
                    </div>
                    
                    <!-- Tri -->
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trier par</label>
                        <select name="sort_by" id="sort_by" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                            <option value="price-asc" {{ request('sort_by') == 'price-asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price-desc" {{ request('sort_by') == 'price-desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="title-asc" {{ request('sort_by') == 'title-asc' ? 'selected' : '' }}>Titre A-Z</option>
                            <option value="title-desc" {{ request('sort_by') == 'title-desc' ? 'selected' : '' }}>Titre Z-A</option>
                        </select>
                    </div>
                    
                    <!-- Bouton filtrer -->
                    <div class="flex items-end md:col-span-4">
                        <button type="submit" class="w-full md:w-auto px-4 py-2 bg-forest hover:bg-meadow text-white rounded-md shadow-sm flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i> Filtrer
                        </button>
                    </div>
                </form>
            </div>

            <!-- Equipment Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8" id="equipment-grid">
                @foreach($AllEquipement as $equipment)
                <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="relative h-48">
                        @if($equipment->images && count($equipment->images) > 0)
                            <img src="{{ asset($equipment->images[0]->url) }}" 
                                 alt="{{ $equipment->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-campground text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        @endif
                        
                        <div class="absolute top-2 right-2 flex space-x-2">
                            <button class="edit-equipment-btn p-2 bg-white dark:bg-gray-700 rounded-full shadow-md text-forest dark:text-meadow hover:bg-forest hover:text-white dark:hover:bg-meadow transition-colors" 
                                    data-id="{{ $equipment->id }}" 
                                    data-title="{{ $equipment->title }}" 
                                    data-description="{{ $equipment->description }}" 
                                    data-price="{{ $equipment->price_per_day }}" 
                                    data-category="{{ $equipment->category_id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-equipment-btn p-2 bg-white dark:bg-gray-700 rounded-full shadow-md text-red-500 hover:bg-red-500 hover:text-white transition-colors" 
                                    data-id="{{ $equipment->id }}" 
                                    data-title="{{ $equipment->title }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate">{{ $equipment->title }}</h3>
                                <span class="text-forest dark:text-meadow font-bold">{{ number_format($equipment->price_per_day, 2) }} MAD/jour</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center mb-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-full px-2 py-1" data-category-id="{{ $equipment->category_id }}">
                                {{ $equipment->category_name }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-3">{{ $equipment->description }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-amber-400 flex">
                                    @php
                                        $rating = 0;
                                        $reviewCount = 0;
                                        if(isset($equipment->reviews) && count($equipment->reviews) > 0) {
                                            $rating = $equipment->reviews->avg('rating');
                                            $reviewCount = $equipment->reviews->count();
                                        }
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars > 0;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                    @endphp
                                    
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    
                                    @if($halfStar)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                    
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </div>
                                <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">{{ $reviewCount }}</span>
                            </div>
                            
                            <div class="flex flex-col space-y-2 mt-2">
                                <a href="{{ route('partenaire.annonces.create', ['equipment_id' => $equipment->id]) }}" 
                                   class="px-3 py-2 bg-forest hover:bg-meadow text-white rounded-md shadow-sm flex items-center justify-center text-sm font-medium">
                                    <i class="fas fa-bullhorn mr-2"></i> Ajouter une annonce
                                </a>
                                <button class="view-details-btn px-3 py-2 border border-forest text-forest dark:border-meadow dark:text-meadow hover:bg-forest hover:text-white dark:hover:bg-meadow rounded-md text-sm font-medium flex items-center justify-center" 
                                        data-id="{{ $equipment->id }}">
                                    <i class="fas fa-eye mr-2"></i> Voir détails
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Empty state if no equipment -->
            @if(count($AllEquipement) === 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 flex flex-col items-center justify-center">
                <i class="fas fa-campground text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Vous n'avez aucun équipement</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center mb-6">Commencez par ajouter votre premier équipement de camping pour le proposer à la location.</p>
                <button id="add-first-equipment" class="px-5 py-3 bg-forest hover:bg-meadow text-white rounded-md shadow-lg flex items-center font-medium text-lg">
                    <i class="fas fa-plus mr-2"></i> Ajouter un équipement
                </button>
            </div>
            @endif
        </div>
    </main>
</div><!-- Add Equipment Modal -->
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
                    <input type="text" id="title" name="title" required
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
                    <input type="number" id="price_per_day" name="price_per_day" min="0" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="4" required
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
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-screen overflow-y-auto">
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
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                </div>
                
                <div>
                    <label for="edit-category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                    <select id="edit-category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
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
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow"></textarea>
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
<div id="delete-equipment-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Confirmer la suppression</h3>
            <button id="close-delete-modal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Êtes-vous sûr de vouloir supprimer l'équipement <span id="delete-equipment-name" class="font-bold"></span> ? Cette action est irréversible et supprimera également toutes les images et avis associés.
            </p>
            
            <form id="delete-equipment-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-delete" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow-sm">
                        Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><!-- Delete All Equipment Modal -->
<div id="delete-all-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Confirmer la suppression de tous les équipements</h3>
            <button id="close-delete-all-modal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                <strong>Attention :</strong> Vous êtes sur le point de supprimer <strong>tous</strong> vos équipements. Cette action est irréversible et supprimera également toutes les images et avis associés.
            </p>
            
            <form id="delete-all-form" action="{{ route('partenaire.equipements.delete-all') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-delete-all" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow-sm">
                        Tout supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><!-- Equipment Details Modal -->
<div id="equipment-details-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto">
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
                        <div id="detail-image-slider" class="w-full h-64 flex overflow-x-auto snap-x snap-mandatory scrollbar-hide">
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
                        
                        <div id="detail-reviews-container" class="space-y-4 max-h-96 overflow-y-auto pr-2">
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
                <a id="detail-create-annonce-link" href="#" class="px-4 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                    <i class="fas fa-bullhorn mr-2"></i>
                    Créer une annonce
                </a>
            </div>
        </div>
    </div>
</div>
</body>
<script>
  const links = document.querySelectorAll(".sidebar-link");
  const components = document.querySelectorAll(".component");

  links.forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = link.getAttribute("data-target");
      
      // Ne rien faire si data-target n'est pas défini (cas du lien "Mes annonces")
      if (!targetId) return;

      // Supprimer active class de tous les liens
      links.forEach(l => l.classList.remove("active"));
      // Ajouter active class au lien cliqué
      link.classList.add("active");

      // Cacher tous les composants
      components.forEach(comp => {
        comp.classList.add("hidden");
      });

      // Afficher le composant cible
      document.getElementById(targetId).classList.remove("hidden");
      
      // Fermer le menu mobile si ouvert
      if (window.innerWidth < 768) {
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        if (mobileSidebar && mobileSidebarOverlay) {
          mobileSidebar.classList.add('transform', '-translate-x-full');
          mobileSidebarOverlay.classList.add('hidden');
        }
      }
    });
  });
</script>

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
                    ? `${equipment.reviews.length} avis, ${avgRating.toFixed(1)}/5` 
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
                        const reviewerAvatar = review.reviewer && review.reviewer.avatar_url ? review.reviewer.avatar_url : '/images/default-avatar.png';
                        
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


</html>