<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - ParentCo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/styles.css', 'resources/js/script.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
</head>


<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900">

    @include('partials.header')

    <!-- Page Header -->
    <header class="pt-24 pb-10 bg-gray-50 dark:bg-gray-800 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Découvrir le matériel de camping</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Trouvez le matériel idéal pour votre prochaine aventure en plein air.
                </p>
            </div>
            
        </div>
    </header>

    <main class="bg-white dark:bg-gray-900 transition-all duration-300">
        <!-- Filter Panel -->
        <div class="border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-16 bg-white dark:bg-gray-800 z-40 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="py-4 flex flex-wrap items-center justify-between gap-4">
                        <!-- Category Filter Pills -->
                        <div class="flex items-center space-x-3 overflow-x-auto scrollbar-hide">
                            <a href="{{ route('client.listings.index') }}">
                                <button class="whitespace-nowrap px-4 py-2 text-sunlight rounded-full font-medium border border-sunlight hover:bg-opacity-20 transition-all">
                                    Tous les articles
                                </button>
                            </a>
                            <a href="{{ route('client.listings.index', ['category' => 'autem']) }}">
                                <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    Tentes
                                </button>
                            </a>
                            <a href="{{ route('client.listings.index', ['category' => 'autem']) }}">
                                <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    Sacs de couchage
                                </button>
                            </a>
                            <a href="{{ route('client.listings.index', ['category' => 'autem']) }}">
                                <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    Matelas
                                </button>
                            </a>
                            <a href="{{ route('client.listings.index', ['category' => 'autem']) }}">
                                <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    Cuisine
                                </button>
                            </a>
                            <a href="{{ route('client.listings.index', ['category' => 'autem']) }}">
                                <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    Mobilier
                                </button>
                            </a>
                            <a href="{{ route('client.listings.index', ['category' => 'autem']) }}">
                                <button class="whitespace-nowrap px-4 py-2 bg-white dark:bg-gray-700 rounded-full font-medium border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-all">
                                    Éclairage
                                </button>
                            </a>
                        </div>
                        
                        <!-- Sort and Map View Options -->
                        <div class="flex space-x-4">
                            <div class="relative">
                                <button id="sort-button" class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all w-46">
                                    <i class="fas fa-sort mr-2"></i>
                                        @php
                                            $sortLabels = [
                                                'price_asc' => 'Prix croissant',
                                                'price_desc' => 'Prix décroissant',
                                                'oldest' => 'Plus anciens',
                                                'latest' => 'Plus récents',
                                            ];
                                        @endphp

                                        <span>
                                            {{ $sortLabels[$sort] ?? 'Plus récents' }}
                                        </span>
                                    <i class="fas fa-chevron-down ml-2"></i>
                                </button>
                                
                                <!-- Sort Dropdown -->
                                <div id="sort-dropdown" class="hidden absolute right-0 mt-1 w-46 bg-white dark:bg-gray-700 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600">
                                    <div class="py-1">
                                        <a href="{{ route('client.listings.index', ['sort' => 'price_asc']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix croissant</a>
                                        <a href="{{ route('client.listings.index', ['sort' => 'price_desc']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Prix décroissant</a>
                                        <a href="{{ route('client.listings.index', ['sort' => 'oldest']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus anciens</a>
                                        <a href="{{ route('client.listings.index', ['sort' => 'latest']) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Plus récents</a>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                                <i class="fas fa-map-marked-alt mr-2"></i>
                                <span>Voir la carte</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Premium Listings Section -->
        <section class="py-8 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-gray-800 dark:to-gray-800 border-b border-amber-100 dark:border-gray-700 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-crown text-sunlight mr-2"></i>
                            Annonces Premium ({{ $premiumListingsCount }})
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Équipements mis en avant par nos partenaires de confiance.</p>
                    </div>
                    
                    <a href="{{ route('client.listings.indexPremium') }}" class="text-forest dark:text-sunlight font-medium hover:underline">
                        Tout voir <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Premium Listings -->
                    @forelse ($premiumListings as $premiumListing)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:shadow-lg hover:-translate-y-1 relative">
                            <div class="absolute top-4 left-4 z-10 bg-sunlight text-white rounded-full px-3 py-1 font-medium text-xs flex items-center">
                                <i class="fas fa-crown mr-1"></i> 
                                PREMIUM
                            </div>
                            <a href="{{ route('client.listings.show', $premiumListing->id) }}">
                                <div class="relative h-52">
                                    <img src="https://images.unsplash.com/photo-1571687949921-1306bfb24b72?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                        alt="Tente 4 places premium" 
                                        class="w-full h-full object-cover" />

                                        
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ $premiumListing->title }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Catégorie - {{ $premiumListing->category->name }}</p>
                                        </div>
                                        <div class="flex items-center text-sm flex-nowrap">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span class="flex flex-nowrap">{{ $premiumListing->averageRating() }} <span class="text-gray-500 dark:text-gray-400">({{ $premiumListing->reviews->count() }})</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i>
                                        <a href="/profile/mohammed-alami" class="hover:text-forest dark:hover:text-sunlight">{{ $premiumListing->partner->username }}</a>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                        <span>{{ $premiumListing->partner->address }}</span>
                                    </div>
                                    
                                    <div class="text-sm mb-3">
                                        <span class="text-gray-600 dark:text-gray-300">Disponible du  au </span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-xl text-gray-900 dark:text-white">{{ $premiumListing->price_per_day }} MAD</span>
                                            <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                        </div>
                                        <a href="{{ route('client.listings.show', $premiumListing->id) }}" class="inline-block">
                                            <button class="px-4 py-2 bg-forest hover:bg-green-700 text-white rounded-md transition-colors shadow-sm">
                                                Voir détails
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucun annonce prémium encore.</p>
                    @endforelse

                    
                </div>
            </div>
        </section>
        
        <!-- Regular Listings Section -->
        <section class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="fa-solid fa-screwdriver-wrench text-forest mr-2"></i>
                            Équipements disponibles ({{ $listingsCount }})
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300">Trouvez le matériel idéal avec nos partenaires.</p>
                    </div>
                    
                    <a href="{{ route('client.listings.indexAll') }}" class="text-forest dark:text-sunlight font-medium hover:underline">
                        Tout voir <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Regular Listings -->
                    @forelse ($listings as $listing)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transform transition duration-300 hover:shadow-md hover:-translate-y-1 relative">
                            <div class="absolute top-4 left-4 z-10 bg-forest text-white rounded-full px-3 py-1 font-medium text-xs flex items-center">
                                {{ $listing->category->name }}
                            </div>
                            <a href="{{ route('client.listings.show', $listing->id) }}">
                                <div class="relative h-48">
                                    <img src="https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                        alt="Tente 2 places" 
                                        class="w-full h-full object-cover" />
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-white">{{ $listing->title }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Catégorie - {{ $listing->category->name }}</p>
                                        </div>
                                        <div class="flex items-center text-sm flex-nowrap">
                                            <i class="fas fa-star text-amber-400 mr-1"></i>
                                            <span class="flex flex-nowrap">{{ $listing->averageRating() }} <span class="text-gray-500 dark:text-gray-400">({{ $listing->reviews->count() }})</span></span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-user mr-1 text-gray-400"></i>
                                        <a href="/profile/karim-ouazzani" class="hover:text-forest dark:hover:text-sunlight">{{ $listing->partner->username }}</a>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                        <span>{{ $listing->partner->address }}</span>
                                    </div>
                                    
                                    <div class="text-sm mb-3">
                                        <span class="text-gray-600 dark:text-gray-300">Disponible du  au </span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-lg text-gray-900 dark:text-white">{{ $listing->price_per_day }} MAD</span>
                                            <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                                        </div>
                                        <a href="{{ route('client.listings.show', $listing->id) }}" class="inline-block">
                                            <button class="px-4 py-2 bg-forest hover:bg-green-700 text-white rounded-md transition-colors shadow-sm">
                                                Voir détails
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucun annonce publiée encore.</p>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $listings->links() }}
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

<!-- Modal pour changer l'image de profil -->
<div id="avatar-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="relative mx-auto p-6 w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl">
        <div class="text-center">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                Modifier l'image de profil
            </h3>
            <div class="mt-4 px-6 py-4">
                <p class="text-sm text-gray-500 dark:text-gray-300 mb-6">
                    Changer la photo de profil pour <span class="font-semibold">@{{ username }}</span>
                </p>

                <form id="avatar-form" method="POST" action="{{ route('profile.update-avatar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6 flex justify-center">
                        <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*">
                        <label for="avatar-input" class="cursor-pointer inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-full shadow-md transition">
                            Sélectionner une image
                        </label>
                    </div>
                    <div class="preview-container mb-6 hidden">
                        <img id="avatar-preview" class="mx-auto h-32 w-32 rounded-full object-cover border-4 border-gray-300 dark:border-gray-600" src="" alt="Aperçu">
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <button type="button" id="cancel-btn" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-full transition">
                            Annuler
                        </button>
                        <button type="submit" id="save-btn" class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-full transition disabled:opacity-50" disabled>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</body>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du modal
    const modal = document.getElementById('avatar-modal');
    if (!modal) return; // Si le modal n'existe pas, on ne fait rien
    
    const avatarForm = document.getElementById('avatar-form');
    const avatarInput = document.getElementById('avatar-input');
    const previewContainer = document.querySelector('.preview-container');
    const avatarPreview = document.getElementById('avatar-preview');
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    
    // Vérifier que tous les éléments existent avant de continuer
    if (!avatarForm || !avatarInput || !previewContainer || !avatarPreview || !saveBtn || !cancelBtn) {
        return;
    }
    
    // Ouvre le modal quand on clique sur l'avatar (si les éléments existent)
    const avatarElements = document.querySelectorAll('.avatar-clickable');
    if (avatarElements.length > 0) {
        avatarElements.forEach(avatar => {
            avatar.addEventListener('click', function() {
                const username = this.dataset.username;
                const modalText = modal.querySelector('p');
                if (modalText) {
                    modalText.textContent = `Changer la photo de profil pour ${username}`;
                }
                modal.classList.remove('hidden');
            });
        });
    }
    
    // Ferme le modal
    cancelBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
        resetForm();
    });
    
    // Gestion de la sélection d'image
    avatarInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(event) {
                avatarPreview.src = event.target.result;
                previewContainer.classList.remove('hidden');
                saveBtn.disabled = false;
            };
            
            reader.readAsDataURL(file);
        }
    });
    
    // Soumission du formulaire
    avatarForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken.content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Met à jour toutes les images d'avatar sur la page
                const avatarImages = document.querySelectorAll('.user-avatar');
                if (avatarImages.length > 0) {
                    avatarImages.forEach(img => {
                        img.src = data.avatar_url + '?' + new Date().getTime(); // Cache busting
                    });
                }
                modal.classList.add('hidden');
                resetForm();
                // Afficher un message de succès
                alert('Avatar mis à jour avec succès!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue lors de la mise à jour de l\'avatar.');
        });
    });
    
    function resetForm() {
        avatarForm.reset();
        previewContainer.classList.add('hidden');
        saveBtn.disabled = true;
    }
});
</script>


</html>