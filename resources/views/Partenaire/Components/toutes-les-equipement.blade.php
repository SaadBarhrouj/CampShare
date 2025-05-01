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
                    <button id="add-equipment-button" class="px-4 py-2 bg-forest hover:bg-meadow text-white rounded-md shadow-sm flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter un équipement
                    </button>
                </div>
            </div>

            <!-- Filters and search -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2 md:mb-0">Filtrer les équipements</h2>
                    <div class="relative">
                        <input type="text" id="search-input" placeholder="Rechercher..." class="px-4 py-2 pr-10 w-full md:w-64 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-base">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="category-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie</label>
                        <select id="category-filter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="price-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix</label>
                        <select id="price-filter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <option value="">Tous les prix</option>
                            <option value="0-50">0 - 50 MAD</option>
                            <option value="50-100">50 - 100 MAD</option>
                            <option value="100-200">100 - 200 MAD</option>
                            <option value="200+">Plus de 200 MAD</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="sort-by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trier par</label>
                        <select id="sort-by" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow">
                            <option value="">Par défaut</option>
                            <option value="price-asc">Prix croissant</option>
                            <option value="price-desc">Prix décroissant</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button id="apply-filter" class="w-full px-4 py-2 bg-forest hover:bg-meadow text-white rounded-md shadow-sm flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i> Appliquer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Equipment Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="equipment-grid">
                @foreach($AllEquipement as $equipment)
                <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="relative h-48">
                        @if($equipment->images && count($equipment->images) > 0)
                            <img src="{{ asset('storage/' . $equipment->images[0]->url) }}" 
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
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('partenaire.annonces.create', ['equipment_id' => $equipment->id]) }}" 
                                   class="px-2 py-1 bg-forest hover:bg-meadow text-white text-xs rounded-md shadow-sm flex items-center">
                                    <i class="fas fa-bullhorn mr-1"></i> Ajouter une annonce
                                </a>
                                <button class="view-details-btn text-forest dark:text-meadow hover:underline text-sm font-medium" 
                                        data-id="{{ $equipment->id }}">
                                    Voir détails
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
                <button id="add-first-equipment" class="px-4 py-2 bg-forest hover:bg-meadow text-white rounded-md shadow-sm flex items-center">
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Images</label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md px-6 pt-5 pb-6 cursor-pointer" id="image-drop-area">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="images" class="relative cursor-pointer rounded-md font-medium text-forest dark:text-meadow hover:text-meadow focus-within:outline-none">
                                    <span>Télécharger des fichiers</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF jusqu'à 2MB
                            </p>
                        </div>
                    </div>
                    <div id="image-preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Images</label>
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
                                PNG, JPG, GIF jusqu'à 2MB
                            </p>
                        </div>
                    </div>
                    <div id="edit-image-preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
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
                <div>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden mb-4">
                        <div id="detail-image-slider" class="w-full h-64 flex overflow-x-auto snap-x snap-mandatory scrollbar-hide">
                            <!-- Images will be added here dynamically -->
                            <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 snap-center flex items-center justify-center">
                                <i class="fas fa-campground text-5xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h4 class="font-bold text-lg text-gray-900 dark:text-white">Prix</h4>
                            <p class="text-xl font-bold text-forest dark:text-meadow" id="detail-price">0 MAD/jour</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900 dark:text-white">Catégorie</h4>
                            <span class="inline-block bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-300" id="detail-category">Catégorie</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Description</h4>
                        <p class="text-gray-700 dark:text-gray-300" id="detail-description"></p>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center">
                        Avis
                        <span class="ml-2 text-amber-400 flex items-center">
                            <span id="detail-avg-rating">0</span>
                            <i class="fas fa-star ml-1"></i>
                        </span>
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400" id="detail-review-count">(0 avis)</span>
                    </h4>
                    
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
    </div>
</div>

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
        const card = button.closest('.equipment-card');
        
        // Get data from the card
        const title = card.querySelector('h3').textContent;
        const price = card.querySelector('.text-forest').textContent;
        const categoryElement = card.querySelector('.text-sm.text-gray-500.bg-gray-100');
        const categoryName = categoryElement ? categoryElement.textContent.trim() : '';
        const description = card.querySelector('p.text-gray-600, p.text-gray-600.dark\\:text-gray-400').textContent;
        
        // Set data in the modal
        document.getElementById('detail-title').textContent = title;
        document.getElementById('detail-price').textContent = price;
        document.getElementById('detail-category').textContent = categoryName;
        document.getElementById('detail-description').textContent = description;
        
        // Clear previous images
        const imageSlider = document.getElementById('detail-image-slider');
        imageSlider.innerHTML = '';
        
        // Add image if available
        const cardImage = card.querySelector('.relative.h-48 img');
        if (cardImage) {
            const imgDiv = document.createElement('div');
            imgDiv.className = 'relative';
            imgDiv.innerHTML = `<img src="${cardImage.src}" alt="${title}" class="w-full h-32 object-cover rounded-md">`;
            imageSlider.appendChild(imgDiv);
        } else {
            // Add placeholder
            const placeholderDiv = document.createElement('div');
            placeholderDiv.className = 'w-full h-32 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-md';
            placeholderDiv.innerHTML = '<i class="fas fa-campground text-5xl text-gray-400 dark:text-gray-500"></i>';
            imageSlider.appendChild(placeholderDiv);
        }
        
        // Load reviews
        fetch(`/partenaire/equipements/${id}/reviews`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement des avis');
                }
                return response.json();
            })
            .then(data => {
                const reviewsContainer = document.getElementById('detail-reviews-container');
                const noReviewsMessage = document.getElementById('no-reviews-message');
                
                // Set average rating
                document.getElementById('detail-avg-rating').textContent = data.average_rating || '0';
                document.getElementById('detail-review-count').textContent = `(${data.reviews ? data.reviews.length : 0} avis)`;
                
                // Clear previous reviews
                reviewsContainer.innerHTML = '';
                
                if (!data.reviews || data.reviews.length === 0) {
                    noReviewsMessage.classList.remove('hidden');
                    reviewsContainer.appendChild(noReviewsMessage);
                } else {
                    noReviewsMessage.classList.add('hidden');
                    data.reviews.forEach(review => {
                        const reviewDiv = document.createElement('div');
                        reviewDiv.className = 'bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4';
                        
                        // Create stars
                        let stars = '';
                        for (let i = 0; i < 5; i++) {
                            if (i < review.rating) {
                                stars += '<i class="fas fa-star text-amber-400"></i>';
                            } else {
                                stars += '<i class="far fa-star text-amber-400"></i>';
                            }
                        }
                        
                        const reviewerName = review.reviewer ? review.reviewer.name || 'Utilisateur' : 'Utilisateur';
                        const reviewerAvatar = review.reviewer && review.reviewer.avatar_url ? review.reviewer.avatar_url : '/images/default-avatar.png';
                        
                        reviewDiv.innerHTML = `
                            <div class="flex items-center mb-2">
                                <img src="${reviewerAvatar}" alt="${reviewerName}" class="w-8 h-8 rounded-full mr-2">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">${reviewerName}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">${new Date(review.created_at).toLocaleDateString()}</div>
                                </div>
                            </div>
                            <div class="flex mb-2">
                                ${stars}
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">${review.comment}</p>
                        `;
                        
                        reviewsContainer.appendChild(reviewDiv);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                const reviewsContainer = document.getElementById('detail-reviews-container');
                reviewsContainer.innerHTML = '<p class="text-red-500">Erreur lors du chargement des avis. Veuillez réessayer.</p>';
            });
        
        detailsModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });
});

// Close Details Modal
if (closeDetailsModal) {
    closeDetailsModal.addEventListener('click', () => {
        detailsModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
}

// Image upload preview
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
    previewContainer.innerHTML = '';
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
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
            });
            imgContainer.appendChild(removeBtn);
            
            previewContainer.appendChild(imgContainer);
        };
        
        reader.readAsDataURL(file);
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
        
        fileInput.files = files;
        
        handleFileSelect(files, previewContainer);
    }
}

// Système de filtrage corrigé
if (applyFilterButton) {
    applyFilterButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Récupérer les valeurs des filtres
        const search = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const category = categoryFilter ? categoryFilter.value : '';
        const priceRange = priceFilter ? priceFilter.value : '';
        const sortBy = sortByFilter ? sortByFilter.value : '';

        console.log('Filtres appliqués:', { search, category, priceRange, sortBy });
        
        // Récupérer toutes les cartes
        const cards = document.querySelectorAll('.equipment-card');
        const container = document.getElementById('equipment-grid');
        let hasVisibleCards = false;

        // Fonction pour extraire le prix d'un élément
        const extractPrice = (card) => {
            try {
                // Sélectionner spécifiquement l'élément qui contient le prix
                const priceElement = card.querySelector('.text-forest.dark\\:text-meadow.font-bold, .text-forest');
                if (!priceElement) return 0;
                
                const priceText = priceElement.textContent.trim();
                // Amélioration de la regex pour extraire le prix (inclut maintenant MAD/jour)
                const priceMatch = priceText.match(/(\d+(?:[.,]\d+)?)\s*MAD(?:\/jour)?/);
                if (priceMatch) {
                    // Remplacer la virgule par un point si nécessaire
                    const priceStr = priceMatch[1].replace(',', '.');
                    const price = parseFloat(priceStr);
                    console.log('Prix extrait:', price, 'depuis:', priceText);
                    return price;
                }
                console.log('Pas de prix trouvé dans:', priceText);
                return 0;
            } catch (error) {
                console.error('Erreur lors de l\'extraction du prix:', error);
                return 0;
            }
        };
        
        // Filtrer les cartes
        cards.forEach(card => {
            let show = true;
            
            try {
                // Récupérer les données de la carte
                const title = card.querySelector('h3').textContent.toLowerCase();
                const desc = card.querySelector('p.text-gray-600, p.text-gray-600.dark\\:text-gray-400').textContent.toLowerCase();
                const categoryTag = card.querySelector('[data-category-id]');
                const price = extractPrice(card);

                // Vérifier le filtre de recherche
                if (search) {
                    show = title.includes(search) || desc.includes(search);
                }

                // Vérifier le filtre de catégorie
                if (show && category && categoryTag) {
                    const cardCategory = categoryTag.getAttribute('data-category-id');
                    show = cardCategory.toString() === category.toString();
                }

                // Vérifier le filtre de prix
                if (show && priceRange) {
                    console.log('Vérification du prix:', price, 'pour la plage:', priceRange);

                    if (price === 0) {
                        show = false;
                    } else {
                        switch(priceRange) {
                            case '0-50':
                                show = price >= 0 && price <= 50;
                                break;
                            case '50-100':
                                show = price > 50 && price <= 100;
                                break;
                            case '100-200':
                                show = price > 100 && price <= 200;
                                break;
                            case '200+':
                                show = price > 200;
                                break;
                            default:
                                // Si le format est "min-max"
                                const rangeMatch = priceRange.match(/(\d+)-(\d+)/);
                                if (rangeMatch) {
                                    const min = parseInt(rangeMatch[1]);
                                    const max = parseInt(rangeMatch[2]);
                                    show = price >= min && price <= max;
                                    console.log(`Filtre personnalisé: ${min}-${max}, prix: ${price}, résultat: ${show}`);
                                }
                                break;
                        }
                    }
                    console.log('Résultat du filtrage:', show);
                }

                // Mettre à jour l'affichage de la carte
                card.style.display = show ? '' : 'none';
                if (show) {
                    hasVisibleCards = true;
                }

            } catch (error) {
                console.error('Erreur lors du filtrage de la carte:', error);
                card.style.display = 'none';
            }
        });

        // Trier les cartes visibles
        if (sortBy && container) {
            const visibleCards = Array.from(cards).filter(card => card.style.display !== 'none');
            
            visibleCards.sort((a, b) => {
                const priceA = extractPrice(a);
                const priceB = extractPrice(b);
                
                if (sortBy === 'price-asc') {
                    return priceA - priceB;
                } else if (sortBy === 'price-desc') {
                    return priceB - priceA;
                }
                return 0;
            });

            // Réorganiser les cartes
            visibleCards.forEach(card => container.appendChild(card));
        }

        // Afficher un message si aucun résultat
        const noResultsMessage = document.querySelector('.empty-state');
        if (noResultsMessage) {
            noResultsMessage.style.display = hasVisibleCards ? 'none' : 'block';
        }
    });
}

// Recherche en temps réel (si pas de bouton Appliquer)
if (searchInput && !applyFilterButton) {
    searchInput.addEventListener('input', function() {
        const search = this.value.toLowerCase().trim();
        document.querySelectorAll('.equipment-card').forEach(card => {
            try {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const desc = card.querySelector('p.text-gray-600, p.text-gray-600.dark\\:text-gray-400').textContent.toLowerCase();
                card.style.display = title.includes(search) || desc.includes(search) ? '' : 'none';
            } catch (error) {
                console.error('Erreur lors de la recherche:', error);
                card.style.display = 'none';
            }
        });
    });
}
</script>