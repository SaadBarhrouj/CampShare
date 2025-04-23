<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un équipement - CampShare | Louez du matériel de camping entre particuliers</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Navigation hover effects */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: currentColor;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Input styles */
        .custom-input {
            transition: all 0.3s ease;
            border-width: 2px;
        }
        
        .custom-input:focus {
            box-shadow: 0 0 0 3px rgba(45, 95, 43, 0.2);
        }
        
        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-switch .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        .toggle-switch input:checked + .slider {
            background-color: #2D5F2B;
        }
        
        .dark .toggle-switch input:checked + .slider {
            background-color: #4F7942;
        }
        
        .toggle-switch input:checked + .slider:before {
            transform: translateX(26px);
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
        
        /* Progress steps */
        .step-connector {
            height: 3px;
            background-color: #e5e7eb;
            flex-grow: 1;
            transition: background-color 0.3s ease;
        }
        
        .dark .step-connector {
            background-color: #4b5563;
        }
        
        .step-connector.active {
            background-color: #2D5F2B;
        }
        
        .dark .step-connector.active {
            background-color: #4F7942;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3f4f6;
            border: 2px solid #e5e7eb;
            color: #6b7280;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .dark .step-circle {
            background-color: #374151;
            border-color: #4b5563;
            color: #9ca3af;
        }
        
        .step-circle.active {
            background-color: #2D5F2B;
            border-color: #2D5F2B;
            color: white;
        }
        
        .dark .step-circle.active {
            background-color: #4F7942;
            border-color: #4F7942;
        }
        
        .step-circle.completed {
            background-color: #2D5F2B;
            border-color: #2D5F2B;
            color: white;
        }
        
        .dark .step-circle.completed {
            background-color: #4F7942;
            border-color: #4F7942;
        }
        
        /* Form transitions */
        .form-step {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .form-step.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Photo uploader */
        .photo-uploader {
            border: 2px dashed #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .dark .photo-uploader {
            border-color: #4b5563;
        }
        
        .photo-uploader:hover {
            border-color: #2D5F2B;
            background-color: rgba(45, 95, 43, 0.05);
        }
        
        .dark .photo-uploader:hover {
            border-color: #4F7942;
            background-color: rgba(79, 121, 66, 0.1);
        }
        
        .photo-preview {
            position: relative;
            overflow: hidden;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        
        .photo-preview:hover .photo-actions {
            opacity: 1;
        }
        
        .photo-actions {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        /* Premium features section */
        .premium-feature {
            transition: all 0.3s ease;
        }
        
        .premium-feature:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <!-- Logo -->
                    <a href="index.html" class="flex items-center">
                        <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                        <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#comment-ca-marche" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Comment ça marche ?</a>
                    <a href="annonces.html" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Explorer le matériel</a>
                    <a href="#devenir-partenaire" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Devenir Partenaire</a>
                    
                    <!-- User menu -->
                    <div class="relative ml-4">
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button id="notifications-button" class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                    <i class="fas fa-bell"></i>
                                    <span class="notification-badge">3</span>
                                </button>
                            </div>
                            
                            <!-- User profile menu -->
                            <div class="relative">
                                <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                    <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                                         alt="Fatima Benali" 
                                         class="h-8 w-8 rounded-full object-cover" />
                                    <span class="font-medium text-gray-800 dark:text-gray-200">Fatima</span>
                                    <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main container -->
    <div class="flex flex-col pt-16 min-h-screen">
        <!-- Main content -->
        <main class="flex-1 bg-gray-50 dark:bg-gray-900 py-8 px-4 md:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Page header -->
                <div class="mb-8">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-forest dark:text-meadow hover:underline mb-4">
                        <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
                    </a>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">Ajouter un équipement</h1>
                    <p class="text-gray-600 dark:text-gray-400">Remplissez les informations pour mettre votre matériel de camping en location.</p>
                </div>
                
                <!-- Progress steps -->
                <div class="mb-10">
                    <div class="flex items-center justify-between">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center">
                            <div class="step-circle active" id="step-circle-1">
                                <span>1</span>
                            </div>
                            <span class="text-sm font-medium mt-2 text-forest dark:text-meadow" id="step-text-1">Informations</span>
                        </div>
                        
                        <div class="step-connector active" id="connector-1-2"></div>
                        
                        <!-- Step 2 -->
                        <div class="flex flex-col items-center">
                            <div class="step-circle" id="step-circle-2">
                                <span>2</span>
                            </div>
                            <span class="text-sm font-medium mt-2 text-gray-500 dark:text-gray-400" id="step-text-2">Photos</span>
                        </div>
                        
                        <div class="step-connector" id="connector-2-3"></div>
                        
                        <!-- Step 3 -->
                        <div class="flex flex-col items-center">
                            <div class="step-circle" id="step-circle-3">
                                <span>3</span>
                            </div>
                            <span class="text-sm font-medium mt-2 text-gray-500 dark:text-gray-400" id="step-text-3">Visibilité</span>
                        </div>
                        
                        <div class="step-connector" id="connector-3-4"></div>
                        
                        <!-- Step 4 -->
                        <div class="flex flex-col items-center">
                            <div class="step-circle" id="step-circle-4">
                                <span>4</span>
                            </div>
                            <span class="text-sm font-medium mt-2 text-gray-500 dark:text-gray-400" id="step-text-4">Publication</span>
                        </div>
                    </div>
                </div>
                
                <!-- Form container -->
                <form action="{{ isset($listing) ? route('listing.store', ['edit' => $listing->id]) : route('listing.store') }}" method="POST" enctype="multipart/form-data" id="listing-form">
                @csrf
                <input type="hidden" name="partner_id" value="21">
                @if(isset($listing))
                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                @endif
                
                <!-- Affichage des erreurs de validation -->
                @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                                Veuillez corriger les erreurs suivantes:
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-10">
                    <!-- Step 1: Informations de base -->
                    <div class="form-step active" id="step-1">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informations de l'équipement</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Renseignez les détails de votre équipement de camping.
                            </p>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Nom et catégorie -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="equipment_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Nom de l'équipement <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="equipment_name" name="equipment_name" value="{{ old('equipment_name', isset($listing) ? $listing->title : '') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 custom-input">
                                </div>
                                
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Catégorie <span class="text-red-500">*</span>
                                    </label>
                                    <select id="category" name="category" required
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 custom-input">
                                        <option value="" disabled {{ old('category') || (isset($listing) && $listing->category_id) ? '' : 'selected' }}>Sélectionnez une catégorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category') == $category->id ? 'selected' : '' }}
                                                {{ (isset($listing) && $listing->category_id == $category->id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                           
                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description" name="description" rows="5" required placeholder="Décrivez votre équipement en détail (caractéristiques, dimensions, couleur, etc.)"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base custom-input">{{ old('description', isset($listing) ? $listing->description : '') }}</textarea>
                            </div>
                            
                            <!-- Prix et ville -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Prix par jour <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <input type="number" id="price" name="price" value="{{ old('price', isset($listing) ? $listing->price_per_day : '') }}" min="0" step="0.01" required
                                               class="w-full pl-10 pr-16 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 custom-input">
                                        <div class="absolute inset-y-0 right-0 flex items-center">
                                            <span class="h-full flex items-center px-4 border-l border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-600 rounded-r-md text-gray-500 dark:text-gray-400 font-medium">
                                                DH/jour
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Ville <span class="text-red-500">*</span>
                                    </label>
                                    <select id="city" name="city" required
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow dark:bg-gray-700 custom-input">
                                        <option value="" disabled {{ old('city') || (isset($listing) && $listing->city_id) ? '' : 'selected' }}>Sélectionnez une ville</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" 
                                                {{ old('city') == $city->id ? 'selected' : '' }}
                                                {{ (isset($listing) && $listing->city_id == $city->id) ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Disponibilité -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Disponibilité <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="available-from" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            Disponible à partir du
                                        </label>
                                        <input type="date" id="available-from" name="available-from" value="{{ old('available-from', isset($listing) && $listing->available_from ? date('Y-m-d', strtotime($listing->available_from)) : '') }}" required
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base custom-input">
                                    </div>
                                    
                                    <div>
                                        <label for="available-until" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            Disponible jusqu'au
                                        </label>
                                        <input type="date" id="available-until" name="available-until" value="{{ old('available-until', isset($listing) && $listing->available_until ? date('Y-m-d', strtotime($listing->available_until)) : '') }}" required
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base custom-input">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Option de livraison -->
                            <div class="mt-6">
                                <div class="flex items-center">
                                    <input type="checkbox" id="delivery-option" name="delivery_option" value="1" 
                                           {{ old('delivery_option') ? 'checked' : '' }}
                                           {{ (isset($listing) && $listing->delivery_option) ? 'checked' : '' }}
                                           class="h-5 w-5 text-forest dark:text-meadow focus:ring-forest dark:focus:ring-meadow border-gray-300 dark:border-gray-600 rounded">
                                    <label for="delivery-option" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Proposer la livraison à domicile
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Vous pouvez facturer des frais supplémentaires pour ce service.
                                </p>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-4">
                            <button type="button" id="next-to-step-2" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                                Continuer vers Photos
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Photos -->
                    <div class="form-step" id="step-2">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Photos de l'équipement</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Ajoutez des photos de qualité de votre équipement (0 à 6). Les photos sont facultatives.
                            </p>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Photo upload area -->
                            <div class="photo-uploader rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-8 text-center">
                                <input type="file" id="photo-upload" name="photos[]" multiple accept="image/*" class="hidden">
                                <div class="mb-4">
                                    <i class="fas fa-camera text-4xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <h3 class="font-medium text-gray-900 dark:text-white mb-2">Déposez vos photos ici</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                    ou
                                </p>
                                <button type="button" id="browse-photos" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 rounded-md transition-colors">
                                    Parcourir mes fichiers
                                </button>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                                    Formats acceptés: JPG, PNG. Taille max: 5MB par photo. Vous pouvez ajouter jusqu'à 6 photos (facultatif).
                                </p>
                            </div>
                            
                            <!-- Preview area -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Photos ajoutées (<span id="photo-count">0</span>/6)</h3>
                                <div id="photo-previews" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <!-- Les prévisualisations des photos seront ajoutées ici dynamiquement -->
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Cliquez sur l'étoile pour définir la photo principale qui apparaîtra en premier dans votre annonce.
                                </p>
                            </div>
                            
                            <!-- Photo tips -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-md p-4">
                                <h4 class="font-medium text-blue-800 dark:text-blue-300 flex items-center mb-3">
                                    <i class="fas fa-lightbulb mr-2"></i>
                                    Conseils pour des photos attrayantes
                                </h4>
                                <ul class="text-sm text-blue-700 dark:text-blue-200 space-y-4">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mt-1 mr-2"></i>
                                        <span>Prenez des photos en pleine lumière naturelle pour une meilleure qualité</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mt-1 mr-2"></i>
                                        <span>Montrez l'équipement sous différents angles</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mt-1 mr-2"></i>
                                        <span>Incluez des photos de l'équipement monté/installé si possible</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mt-1 mr-2"></i>
                                        <span>Assurez-vous que l'équipement est propre et présentable sur les photos</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between">
                            <button type="button" id="back-to-step-1" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour
                            </button>
                            
                            <button type="button" id="next-to-step-3" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                                Continuer vers Visibilité
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Premium features (optional) -->
                    <div class="form-step" id="step-3">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Boostez votre visibilité (Optionnel)</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Améliorez votre annonce pour attirer plus de locataires potentiels.
                            </p>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <div class="bg-gradient-to-r from-forest/10 to-sunlight/10 dark:from-meadow/20 dark:to-sunlight/20 rounded-lg p-6 mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                        <i class="fas fa-crown text-sunlight mr-2"></i>
                                        Annonce Premium
                                    </h3>
                                    <div class="toggle-switch">
                                        <input type="checkbox" id="premium-toggle" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </div>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 mb-6">
                                    Maximisez vos chances de location avec notre pack premium. Votre annonce sera mise en avant et apparaîtra en priorité dans les résultats de recherche.
                                </p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <div class="premium-feature bg-white dark:bg-gray-800 rounded-md p-4 shadow-sm">
                                        <div class="text-forest dark:text-meadow mb-2">
                                            <i class="fas fa-search-plus text-2xl"></i>
                                        </div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-1">Visibilité x3</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Apparaissez en tête des résultats de recherche
                                        </p>
                                    </div>
                                    
                                    <div class="premium-feature bg-white dark:bg-gray-800 rounded-md p-4 shadow-sm">
                                        <div class="text-forest dark:text-meadow mb-2">
                                            <i class="fas fa-certificate text-2xl"></i>
                                        </div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-1">Badge "Premium"</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Distinguez-vous avec un badge exclusif
                                        </p>
                                    </div>
                                    
                                    <div class="premium-feature bg-white dark:bg-gray-800 rounded-md p-4 shadow-sm">
                                        <div class="text-forest dark:text-meadow mb-2">
                                            <i class="fas fa-chart-line text-2xl"></i>
                                        </div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-1">Statistiques avancées</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Analysez les performances de votre annonce
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-800 rounded-md p-4">
                                    <div class="mb-4 md:mb-0">
                                        <span class="block text-lg font-bold text-gray-900 dark:text-white">50 MAD <span class="text-sm font-normal text-gray-600 dark:text-gray-400">/ mois</span></span>
                                        <span class="text-sm text-green-600 dark:text-green-400">Annulable à tout moment</span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4 w-full md:w-auto">
                                        <label class="toggle-switch flex items-center cursor-pointer">
                                            <input type="checkbox" id="premium-option" name="premium_option" value="1" {{ old('premium_option') ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 whitespace-nowrap">Activer Premium</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Highlighted option -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                        <i class="fas fa-star text-amber-500 mr-2"></i>
                                        Mise en avant simple
                                    </h3>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Démarquez-vous avec une étiquette "Coup de cœur" sur votre annonce pour la faire ressortir dans les recherches.
                                </p>
                                
                                <div class="flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-800 rounded-md p-4">
                                    <div class="mb-4 md:mb-0">
                                        <span class="block text-lg font-bold text-gray-900 dark:text-white">25 MAD <span class="text-sm font-normal text-gray-600 dark:text-gray-400">/ mois</span></span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4 w-full md:w-auto">
                                        <label class="toggle-switch flex items-center cursor-pointer">
                                            <input type="checkbox" id="highlighted-option" name="highlighted_option" value="1" {{ old('highlighted_option') ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200 whitespace-nowrap">Activer la mise en avant</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                                Vous pouvez choisir de continuer sans options premium - votre annonce sera publiée normalement.
                            </p>
                        </div>
                        
                        <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between">
                            <button type="button" id="back-to-step-2" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour
                            </button>
                            
                            <button type="button" id="next-to-step-4" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                                Continuer vers Publication
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 4: Review and publish -->
                    <div class="form-step" id="step-4">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Vérification et publication</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Vérifiez les informations de votre annonce avant de la publier.
                            </p>
                        </div>
                        
                        <div class="p-6 space-y-8">
                            <!-- Summary of the listing -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Main preview image -->
                                <div class="md:col-span-1">
                                    <div class="aspect-square rounded-lg overflow-hidden shadow-sm">
                                        <img id="preview-main-photo" src="https://via.placeholder.com/400x400?text=Photo+principale" alt="Photo principale" class="w-full h-full object-cover">
                                    </div>
                                    <div id="preview-photo-thumbnails" class="flex mt-2 space-x-2 overflow-x-auto pb-2">
                                        <!-- Les miniatures seront ajoutées ici dynamiquement -->
                                    </div>
                                </div>
                                
                                <!-- Listing details -->
                                <div class="md:col-span-2 space-y-6">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="preview-title">Tente Quechua 2 Personnes</h3>
                                        <div class="flex items-center text-sm mt-1">
                                            <span class="text-gray-600 dark:text-gray-400 mr-2" id="preview-location">Casablanca</span>
                                            <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 px-2 py-0.5 rounded-full text-xs">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Disponible
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Catégorie</p>
                                            <p class="font-medium text-gray-900 dark:text-white" id="preview-category">Tentes</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Marque</p>
                                            <p class="font-medium text-gray-900 dark:text-white" id="preview-brand">Quechua</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Prix par jour</p>
                                            <p class="font-medium text-gray-900 dark:text-white" id="preview-price">150 MAD</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Disponibilité</p>
                                            <p class="font-medium text-gray-900 dark:text-white" id="preview-availability">Du 10/08/2023 au 30/09/2023</p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Description</p>
                                        <p class="text-gray-800 dark:text-gray-200" id="preview-description">
                                            Tente Quechua 2 secondes pour 2 personnes, très simple à monter et démonter. Imperméable, testée sous la pluie et le vent. Parfaite pour les randonnées et les weekends en camping. Inclut les sardines et les cordes.
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <div id="premium-badge" class="bg-gradient-to-r from-sunlight to-amber-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-sm hidden">
                                            <i class="fas fa-crown mr-1"></i> Premium
                                        </div>
                                        
                                        <div id="highlighted-badge" class="bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs px-3 py-1 rounded-full font-medium hidden">
                                            <i class="fas fa-star mr-1"></i> Coup de cœur
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Rules and guidelines -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-md p-4">
                                <h4 class="font-medium text-blue-800 dark:text-blue-300 flex items-center mb-3">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Informations importantes avant la publication
                                </h4>
                                <div class="text-sm text-blue-700 dark:text-blue-200 space-y-4">
                                    <p>
                                        En publiant cette annonce, vous acceptez les <a href="#" class="underline font-medium">Conditions Générales d'Utilisation</a> et les <a href="#" class="underline font-medium">Règles de la Communauté</a> de CampShare.
                                    </p>
                                    <p>
                                        Votre annonce sera examinée par notre équipe dans les 24 heures pour vérifier qu'elle respecte nos standards de qualité. Vous recevrez une notification dès qu'elle sera approuvée.
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Terms agreement -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms-agree" type="checkbox" name="terms_agree" {{ old('terms_agree') ? 'checked' : '' }} required
                                           class="w-4 h-4 rounded border-gray-300 text-forest focus:ring-meadow">
                                </div>
                                <label for="terms-agree" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    J'accepte les <a href="#" class="text-forest dark:text-meadow hover:underline">Conditions d'Utilisation</a> et la <a href="#" class="text-forest dark:text-meadow hover:underline">Politique de Confidentialité</a> de CampShare, et je confirme que je suis le propriétaire légal de cet équipement.
                                </label>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-between">
                            <button type="button" id="back-to-step-3" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour
                            </button>
                            
                            <button type="submit" id="publish-button" class="px-6 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                                <i class="fas fa-check mr-2"></i>
                                Publier l'annonce
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </main>
    </div>
    
    <!-- Success Modal (hidden by default) -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="text-center">
                <div class="mb-4 w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-check text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Annonce publiée avec succès !</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Votre équipement a été ajouté et sera examiné par notre équipe dans les 24 heures. Vous recevrez une notification dès qu'il sera approuvé.
                </p>
                <div class="flex flex-col sm:flex-row sm:justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="index.html" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Retour au tableau de bord
                    </a>
                    <button type="button" id="add-another-equipment" class="px-4 py-2 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                        Ajouter un autre équipement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Step navigation
        const steps = [1, 2, 3, 4];
        let currentStep = 1;
        
        // Handle step switching
        function goToStep(step) {
            // Hide all steps
            document.querySelectorAll('.form-step').forEach(el => {
                el.classList.remove('active');
            });
            
            // Show selected step
            document.getElementById(`step-${step}`).classList.add('active');
            
            // Update current step
            currentStep = step;
            
            // Update progress bar
            updateProgressBar();
        }
        
        // Update progress bar
        function updateProgressBar() {
            // Reset all step styles
            steps.forEach(step => {
                const circle = document.getElementById(`step-circle-${step}`);
                const text = document.getElementById(`step-text-${step}`);
                
                circle.classList.remove('active', 'completed');
                text.classList.remove('text-forest', 'dark:text-meadow');
                text.classList.add('text-gray-500', 'dark:text-gray-400');
                
                if (step < currentStep) {
                    // Completed steps
                    circle.classList.add('completed');
                    circle.innerHTML = '<i class="fas fa-check"></i>';
                    text.classList.remove('text-gray-500', 'dark:text-gray-400');
                    text.classList.add('text-forest', 'dark:text-meadow');
                } else if (step === currentStep) {
                    // Active step
                    circle.classList.add('active');
                    circle.innerHTML = `<span>${step}</span>`;
                    text.classList.remove('text-gray-500', 'dark:text-gray-400');
                    text.classList.add('text-forest', 'dark:text-meadow');
                } else {
                    // Future steps
                    circle.innerHTML = `<span>${step}</span>`;
                }
            });
            
            // Update connectors
            for (let i = 1; i < steps.length; i++) {
                const connector = document.getElementById(`connector-${i}-${i+1}`);
                if (currentStep > i) {
                    connector.classList.add('active');
                } else {
                    connector.classList.remove('active');
                }
            }
        }
        
        // Navigation buttons
        document.getElementById('next-to-step-2').addEventListener('click', () => {
            // Basic validation for Step 1
            const name = document.getElementById('equipment_name');
            const category = document.getElementById('category');
            const price = document.getElementById('price');
            const description = document.getElementById('description');
            
            if (!name.value || !category.value || !price.value || !description.value) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            
            goToStep(2);
        });
        
        document.getElementById('next-to-step-3').addEventListener('click', () => {
            // Here you would validate photos are uploaded
            goToStep(3);
        });
        
        document.getElementById('next-to-step-4').addEventListener('click', () => {
            goToStep(4);
            updatePreview();
        });
        
        document.getElementById('back-to-step-1').addEventListener('click', () => {
            goToStep(1);
        });
        
        document.getElementById('back-to-step-2').addEventListener('click', () => {
            goToStep(2);
        });
        
        document.getElementById('back-to-step-3').addEventListener('click', () => {
            goToStep(3);
        });
        
        // Photo uploader
        const photoUploader = document.querySelector('.photo-uploader');
        const photoInput = document.getElementById('photo-upload');
        const photoPreviews = document.getElementById('photo-previews');
        const browseButton = document.getElementById('browse-photos');
        
        browseButton.addEventListener('click', () => {
            photoInput.click();
        });
        
        // Variables pour stocker les fichiers
        let selectedFiles = [];
        
        // Photo upload handling
        photoInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length > 0) {
                // Ajouter les nouveaux fichiers à notre tableau de fichiers
                const existingPhotos = document.querySelectorAll('.photo-preview').length;
                const remainingSlots = 6 - existingPhotos;
                
                // Limiter à 6 photos maximum
                const maxNewPhotos = Math.min(files.length, remainingSlots);
                
                if (existingPhotos + files.length > 6) {
                    alert('Vous ne pouvez pas ajouter plus de 6 photos au total. Seules les premières photos seront ajoutées.');
                }
                
                // Add new previews
                for (let i = 0; i < maxNewPhotos; i++) {
                    const file = files[i];
                    selectedFiles.push(file);
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(event) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'photo-preview aspect-square relative';
                        
                        previewDiv.innerHTML = `
                            <img src="${event.target.result}" alt="Prévisualisation" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 flex flex-col items-center justify-center transition-opacity rounded-md">
                                <button type="button" class="text-white hover:text-yellow-300 transition-colors mb-2 set-main-photo">
                                    <i class="fas fa-star text-xl"></i>
                                </button>
                                <button type="button" class="text-white hover:text-red-500 transition-colors delete-photo">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </div>
                        `;
                        
                        photoPreviews.appendChild(previewDiv);
                        
                        // Add event listeners for the new buttons
                        previewDiv.querySelector('.set-main-photo').addEventListener('click', function() {
                            document.querySelectorAll('.photo-preview').forEach(p => {
                                p.classList.remove('main-photo');
                                p.style.border = 'none';
                            });
                            previewDiv.classList.add('main-photo');
                            previewDiv.style.border = '2px solid #2D5F2B';
                            
                            // Create a hidden input to mark this as the main photo
                            const mainPhotoInput = document.createElement('input');
                            mainPhotoInput.type = 'hidden';
                            mainPhotoInput.name = 'main_photo';
                            
                            // Get the index of this photo among all photo previews
                            const allPreviews = Array.from(document.querySelectorAll('.photo-preview'));
                            const photoIndex = allPreviews.indexOf(previewDiv);
                            mainPhotoInput.value = photoIndex;
                            
                            // Remove any existing main_photo inputs
                            document.querySelectorAll('input[name="main_photo"]').forEach(input => {
                                input.remove();
                            });
                            
                            document.getElementById('listing-form').appendChild(mainPhotoInput);
                            
                            // Update preview images when main photo changes
                            updatePreviewImages();
                        });
                        
                        previewDiv.querySelector('.delete-photo').addEventListener('click', function() {
                            // Trouver l'index de cette photo dans le tableau des prévisualisations
                            const allPreviews = Array.from(document.querySelectorAll('.photo-preview'));
                            const photoIndex = allPreviews.indexOf(previewDiv);
                            
                            // Supprimer le fichier correspondant du tableau selectedFiles
                            if (photoIndex !== -1) {
                                selectedFiles.splice(photoIndex, 1);
                            }
                            
                            // Supprimer la prévisualisation
                            previewDiv.remove();
                            
                            // Mettre à jour le compteur et les prévisualisations
                            updatePhotoCount();
                            updatePreviewImages();
                        });
                        
                        // Update preview images when new photos are added
                        updatePreviewImages();
                    };
                    
                    reader.readAsDataURL(file);
                }
                
                updatePhotoCount();
            }
        });
        
        function updatePhotoCount() {
            const count = document.querySelectorAll('.photo-preview').length;
            const photoCount = document.getElementById('photo-count');
            if (photoCount) {
                photoCount.textContent = count;
            }
        }
        
        // Premium option toggle
        document.getElementById('premium-option').addEventListener('change', function() {
            if (this.checked) {
                // If premium is checked, uncheck highlighted option as they're exclusive
                document.getElementById('highlighted-option').checked = false;
            }
        });
        
        document.getElementById('highlighted-option').addEventListener('change', function() {
            if (this.checked) {
                // If highlighted is checked, uncheck premium option as they're exclusive
                document.getElementById('premium-option').checked = false;
            }
        });
        
        // Update preview based on entered information
        function updatePreview() {
            // Get values from form fields
            const name = document.getElementById('equipment_name').value;
            const category = document.getElementById('category').options[document.getElementById('category').selectedIndex].text;
            const brand = document.getElementById('brand').value;
            const price = document.getElementById('price').value;
            const location = document.getElementById('city').options[document.getElementById('city').selectedIndex].text;
            const description = document.getElementById('description').value;
            const availableFrom = document.getElementById('available-from').value;
            const availableUntil = document.getElementById('available-until').value;
            
            // Format dates
            const fromDate = new Date(availableFrom);
            const untilDate = new Date(availableUntil);
            const dateOptions = { day: '2-digit', month: '2-digit', year: 'numeric' };
            
            // Update preview elements
            document.getElementById('preview-title').textContent = name;
            document.getElementById('preview-category').textContent = category;
            document.getElementById('preview-brand').textContent = brand || 'Non spécifiée';
            document.getElementById('preview-price').textContent = `${price} MAD`;
            document.getElementById('preview-location').textContent = location;
            document.getElementById('preview-description').textContent = description;
            document.getElementById('preview-availability').textContent = `Du ${fromDate.toLocaleDateString('fr-FR', dateOptions)} au ${untilDate.toLocaleDateString('fr-FR', dateOptions)}`;
            
            // Show premium/highlighted badge if selected
            if (document.getElementById('premium-option').checked) {
                document.getElementById('premium-badge').classList.remove('hidden');
            } else {
                document.getElementById('premium-badge').classList.add('hidden');
            }
            
            if (document.getElementById('highlighted-option').checked) {
                document.getElementById('highlighted-badge').classList.remove('hidden');
            } else {
                document.getElementById('highlighted-badge').classList.add('hidden');
            }
            
            // Update preview images
            updatePreviewImages();
        }
        
        // Update preview images
        function updatePreviewImages() {
            const photoPreviewsContainer = document.getElementById('photo-previews');
            const previewMainPhoto = document.getElementById('preview-main-photo');
            const previewPhotoThumbnails = document.getElementById('preview-photo-thumbnails');
            
            // Clear thumbnails
            if (previewPhotoThumbnails) {
                previewPhotoThumbnails.innerHTML = '';
            }
            
            if (photoPreviewsContainer && photoPreviewsContainer.children.length > 0) {
                // Get all photo previews
                const photoPreviews = photoPreviewsContainer.querySelectorAll('.photo-preview');
                
                // Find main photo or use first one
                const mainPhoto = photoPreviewsContainer.querySelector('.main-photo');
                const firstPhoto = mainPhoto || photoPreviews[0];
                
                if (firstPhoto) {
                    const mainImg = firstPhoto.querySelector('img');
                    if (mainImg && previewMainPhoto) {
                        previewMainPhoto.src = mainImg.src;
                    }
                }
                
                // Add thumbnails
                if (previewPhotoThumbnails) {
                    photoPreviews.forEach((preview, index) => {
                        const img = preview.querySelector('img');
                        if (img) {
                            const thumbnail = document.createElement('div');
                            thumbnail.className = 'w-16 h-16 flex-shrink-0 rounded-md overflow-hidden';
                            if (preview.classList.contains('main-photo')) {
                                thumbnail.classList.add('border-2', 'border-forest', 'dark:border-meadow');
                            }
                            thumbnail.innerHTML = `<img src="${img.src}" alt="Miniature ${index + 1}" class="w-full h-full object-cover">`;
                            previewPhotoThumbnails.appendChild(thumbnail);
                        }
                    });
                }
            }
        }
        
        // Drag and drop for photos
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            photoUploader.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            photoUploader.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            photoUploader.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            photoUploader.classList.add('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
        }
        
        function unhighlight() {
            photoUploader.classList.remove('border-forest', 'dark:border-meadow', 'bg-green-50', 'dark:bg-green-900/10');
        }
        
        photoUploader.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            // Set the files to the input element
            const fileInput = document.getElementById('photo-upload');
            
            // Create a new DataTransfer object
            const dataTransfer = new DataTransfer();
            
            // Add dropped files to the DataTransfer object
            for (let i = 0; i < files.length; i++) {
                dataTransfer.items.add(files[i]);
            }
            
            // Set the DataTransfer object as the files property of the file input
            fileInput.files = dataTransfer.files;
            
            // Trigger the change event
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
        
        // Form submission
        document.getElementById('listing-form').addEventListener('submit', function(e) {
            // Ne pas empêcher la soumission par défaut du formulaire
            
            // Check terms agreement
            if (!document.getElementById('terms-agree').checked) {
                e.preventDefault();
                alert('Veuillez accepter les conditions d\'utilisation pour publier votre annonce.');
                return;
            }
            
            // Mettre à jour les champs cachés pour les photos
            // Nous allons laisser le formulaire se soumettre normalement
            // car c'est la méthode la plus fiable pour l'envoi de fichiers
        });
        
        // Initialize progress bar
        updateProgressBar();
        
        // Update photo count on page load
        updatePhotoCount();
    </script>
    
    <!-- Script pour l'édition d'annonce -->
    @if(isset($editMode) && $editMode)
    <script>
        // Passer les données de l'annonce au script d'édition
        window.editMode = {{ $editMode ? 'true' : 'false' }};
        window.listing = @json($listing);
    </script>
    <script src="{{ asset('js/edit-listing.js') }}"></script>
    @endif
</body>
</html>