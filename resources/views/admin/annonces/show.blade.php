@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<div class="flex h-screen bg-gray-50 dark:bg-gray-900">

    <aside class="hidden md:flex flex-col w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
   
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-end items-center">
                <div class="flex items-center">
                    <span class="text-2xl font-bold leading-none">
                        <span class="text-[#173BCA]">Camp</span><span class="text-[#FDAA2A]">Share</span>
                    </span>
                    <span class="text-xs ml-2 text-gray-600 bg-gray-100 px-2 py-1 rounded-full font-medium dark:bg-gray-700 dark:text-gray-300">
                        ADMIN
                    </span>
                </div>
            </div>
        </div>

      
        <div class="flex-grow overflow-y-auto">
            <div class="p-4">
                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 px-2">
                        Menu Principal
                    </h5>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Tableau de bord
                        </a>
                    </nav>
                </div>


                 <div class="mb-6 px-3">
                <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                    Utilisateurs</h5>
                <nav class="space-y-1">
                   <a href="{{ route('admin.partners') }}"
    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
    Partenaires
</a>

<a href="{{ route('admin.clients') }}"
    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
    Clients
</a>

                </nav>
            </div>

            
                <div class="mb-6">
                    <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 px-2">
                        Équipements & Gestion
                    </h5>
                    <nav class="space-y-1">
                        <a href="#"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-blue-600 dark:text-blue-400 rounded-lg bg-blue-50 dark:bg-blue-900/20 font-semibold transition-colors">
                            <i class="fas fa-campground w-5 mr-3 text-blue-600 dark:text-blue-400"></i>
                            Équipements
                        </a>
                        <a href="{{ route('admin.reservations.index') }}" 
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-calendar-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Réservations
                        </a>
                        <a href="{{ route('admin.reviews') }}"
                            class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-star w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                            Avis
                            <span class="ml-auto bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-full h-5 px-2 flex items-center justify-center">
                                {{ \App\Models\Review::count() }}
                            </span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </aside>


    <div class="flex-1 flex flex-col overflow-hidden">
     
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
            
                    <div class="flex items-center md:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <span class="sr-only">Open sidebar</span>
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    
 
                    <div class="md:hidden flex items-center">
                        <span class="text-lg font-semibold text-gray-800 dark:text-white">Détails de l'équipement</span>
                    </div>

               
                    <div class="flex items-center space-x-4">
                       
                   
                        @auth
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-3 focus:outline-none group">
                                <div class="flex items-center space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="hidden md:flex flex-col items-start">
                                        <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">
                                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                        </span>
                                        <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                                            {{ ucfirst(auth()->user()->role) ?? 'Utilisateur' }}
                                        </span>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-500 group-hover:text-blue-600 transition-colors"></i>
                            </button>
                            
                       
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-100 dark:border-gray-700">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-circle mr-2 text-gray-500 dark:text-gray-400"></i>
                                    Mon profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    <i class="fas fa-cog mr-2 text-gray-500 dark:text-gray-400"></i>
                                    Paramètres
                                </a>
                                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 md:p-6">
     
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                                <i class="fas fa-home mr-2"></i>
                                Accueil
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                                <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Équipements</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $equipment->title }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

          
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
             
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div class="flex items-center">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $equipment->title }}</h2>
                        <span class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $equipment->listings->first() ? ($equipment->listings->first()->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400') : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400' }}">
                            {{ $equipment->listings->first() ? ucfirst($equipment->listings->first()->status) : 'Aucune annonce' }}
                        </span>
                    </div>
                  
                </div>

               
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                       
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-images mr-2 text-gray-500 dark:text-gray-400"></i>
                                    Images
                                </h3>
                                
                               
                                <div class="mb-4">
                                    @if($equipment->images->count() > 0)
                                        <div class="relative group">
                                            <img src="{{ asset($equipment->images->first()->url) }}" alt="Image principale de l'équipement" 
                                                class="w-full h-48 object-cover rounded-lg cursor-pointer" onclick="openImageModal('{{ asset($equipment->images->first()->url) }}')">
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                                <button onclick="openImageModal('{{ asset($equipment->images->first()->url) }}')" class="text-white p-2 rounded-full bg-gray-800 bg-opacity-70 hover:bg-opacity-100 transition-all">
                                                    <i class="fas fa-expand"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="h-48 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-500 dark:text-gray-400">Aucune image disponible</span>
                                        </div>
                                    @endif
                                </div>
                                
                         
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($equipment->images->skip(1)->take(3) as $image)
                                    <div class="relative group">
                                        <img src="{{ asset($image->url) }}" alt="Image de l'équipement" 
                                            class="w-full h-16 object-cover rounded-lg cursor-pointer" onclick="openImageModal('{{ asset($image->url) }}')">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                            <button onclick="openImageModal('{{ asset($image->url) }}')" class="text-white p-1 rounded-full bg-gray-800 bg-opacity-70 hover:bg-opacity-100 transition-all">
                                                <i class="fas fa-search-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    @if($equipment->images->count() > 4)
                                    <div class="relative group cursor-pointer" onclick="openGalleryModal()">
                                        <div class="w-full h-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-600 dark:text-gray-400 text-xs font-medium">+{{ $equipment->images->count() - 4 }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                 
                        <div class="lg:col-span-2 space-y-6">
                          
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-gray-500 dark:text-gray-400"></i>
                                    Informations
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Description</h4>
                                            <p class="text-gray-800 dark:text-gray-200">{{ $equipment->description }}</p>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Prix par jour</h4>
                                                <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $equipment->price_per_day }} MAD</p>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Catégorie</h4>
                                                <p class="text-gray-800 dark:text-gray-200">{{ $equipment->category->name ?? 'Non spécifié' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Partenaire</h4>
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-2">
                                                    <p class="text-gray-800 dark:text-gray-200">{{ $equipment->partner->username }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $equipment->partner->id }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date de création</h4>
                                            <p class="text-gray-800 dark:text-gray-200">{{ $equipment->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                 
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-list mr-2 text-gray-500 dark:text-gray-400"></i>
                                    Annonces
                                </h3>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-100 dark:bg-gray-800">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Période</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Livraison</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @if($equipment->listings->count() > 0)
                                                @foreach($equipment->listings as $listing)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $listing->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' }}">
                                                            {{ ucfirst($listing->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                        {{ \Carbon\Carbon::parse($listing->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($listing->end_date)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                        {{ $listing->delivery_option ? 'Oui' : 'Non' }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
    <div class="flex space-x-2">
        <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')"
                    class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                        Aucune annonce disponible pour cet équipement
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
     
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
        <span>ID: {{ $equipment->id }}</span>
        <span>•</span>
        <span>Mis à jour le {{ $equipment->updated_at->format('d/m/Y à H:i') }}</span>
    </div>
    <div>
        <form action="{{ route('admin.equipements.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet équipement et toutes ses données associées?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition-colors">
                <i class="fas fa-trash-alt mr-1.5"></i> Supprimer
            </button>
        </form>
    </div>
</div>
        </main>
    </div>
</div>


<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl w-full mx-auto p-4">
        <button onclick="closeImageModal()" class="absolute top-0 right-0 -mt-12 -mr-4 text-white hover:text-gray-300 text-2xl">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="Image agrandie" class="max-w-full max-h-90vh rounded-lg shadow-xl">
    </div>
</div>


<div id="galleryModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden overflow-y-auto">
    <div class="relative max-w-6xl mx-auto p-4 pt-16">
        <button onclick="closeGalleryModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-white text-xl font-bold mb-6">Toutes les images de {{ $equipment->title }}</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($equipment->images as $image)
            <div class="relative group">
                <img src="{{ asset($image->url) }}" alt="Image de l'équipement" 
                    class="w-full h-40 object-cover rounded-lg cursor-pointer" onclick="openImageModal('{{ asset($image->url) }}')">
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
  
    document.getElementById('user-menu-button')?.addEventListener('click', function() {
        document.getElementById('user-dropdown').classList.toggle('hidden');
    });
    
   
    document.addEventListener('click', function(event) {
        if (!document.getElementById('user-menu-button')?.contains(event.target)) {
            document.getElementById('user-dropdown')?.classList.add('hidden');
        }
    });

    function openImageModal(imgUrl) {
        document.getElementById('modalImage').src = imgUrl;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    function openGalleryModal() {
        document.getElementById('galleryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeGalleryModal() {
        document.getElementById('galleryModal').classList.add('hidden');
        document.body.style.overflow = '';
    }
    

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
            closeGalleryModal();
        }
    });
 
    document.getElementById('imageModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeImageModal();
        }
    });
</script>
@endsection