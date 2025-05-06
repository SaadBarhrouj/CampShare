<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CampShare</title>
    <script src="https://cdn.tailwindcss.com"></script>

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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-in-out forwards',
                        'fade-out': 'fadeOut 0.3s ease-in-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            'from': { opacity: '0', transform: 'translateY(10px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeOut: {
                            'from': { opacity: '1', transform: 'translateY(0)' },
                            'to': { opacity: '0', transform: 'translateY(-10px)' }
                        }
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
        .fade-in {
            animation: fadeIn 0.4s ease-in-out forwards;
        }
        .fade-out {
            animation: fadeOut 0.3s ease-in-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        
        button:focus {
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(45, 95, 43, 0.5);
        }
        
        input::placeholder {
            padding-left: 0;
        }
        
        .footer-link {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .footer-link:hover {
            background-color: rgba(45, 95, 43, 0.1);
        }
        
        .dark .footer-link:hover {
            background-color: rgba(79, 121, 66, 0.2);
        }
        
        button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-900 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 transition-all duration-300">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="flex items-center">
                <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
            </div>
        </div>
        
        <h2 class="text-center text-2xl font-bold mb-4 text-gray-800 dark:text-white">Créer votre compte CampShare</h2>
        
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 dark:text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        Pour garantir la sécurité de notre communauté et faciliter vos transactions, nous demandons une vérification d'identité lors de la création de votre compte. Ces informations sont sécurisées et ne seront utilisées que pour valider votre identité conformément à notre politique de confidentialité.
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <div class="flex justify-between mb-2">
                <div class="flex items-center">
                    <div class="flex items-center">
                        <div id="step-1-indicator" class="flex items-center justify-center w-7 h-7 rounded-full bg-forest dark:bg-meadow text-white text-sm font-medium">
                            1
                        </div>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 hidden sm:inline">Informations</span>
                    </div>
                    <div class="w-12 h-1 mx-2 bg-gray-200 dark:bg-gray-700 sm:w-24"></div>
                    <div class="flex items-center">
                        <div id="step-2-indicator" class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium">
                            2
                        </div>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 hidden sm:inline">Identité</span>
                    </div>
                    <div class="w-12 h-1 mx-2 bg-gray-200 dark:bg-gray-700 sm:w-24"></div>
                    <div class="flex items-center">
                        <div id="step-3-indicator" class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium">
                            3
                        </div>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 hidden sm:inline">Accords</span>
                    </div>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400"><span id="progress-percentage">33</span>% complété</span>
            </div>
            
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                <div id="progress-bar" class="bg-forest dark:bg-meadow h-2.5 rounded-full transition-all duration-500 ease-in-out" style="width: 33%"></div>
            </div>
            
            <div id="current-step-title" class="text-sm font-medium text-forest dark:text-meadow">
                Étape 1 : Informations personnelles
            </div>
        </div>

        <!-- Error messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0 text-red-500 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Erreurs détectées :</h3>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-700 dark:text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div id="client-side-errors" class="hidden mb-6 p-4 bg-red-50 dark:bg-red-900/30 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0 text-red-500 dark:text-red-400">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Veuillez corriger :</h3>
                    <ul id="client-error-list"
                        class="mt-2 list-disc list-inside text-sm text-red-700 dark:text-red-300"></ul>
                </div>
            </div>
        </div>

        <form id="registration-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Step 1: Personal Info -->
            <section id="step-1" class="step-section">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-user-circle mr-2 text-forest dark:text-meadow"></i>
                    Informations personnelles
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prénom *</label>
                        <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                            placeholder="Votre prénom">
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom *</label>
                        <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                            placeholder="Votre nom">
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pseudonyme *</label>
                        <input type="text" id="username" name="username" required value="{{ old('username') }}"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                            placeholder="Votre pseudonyme">
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Photo de profil (Facultatif)</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 dark:file:bg-gray-600 file:text-forest dark:file:text-meadow hover:file:bg-gray-200 dark:hover:file:bg-gray-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                                placeholder="votre@email.com">
                        </div>
                    </div>
                    
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="text" id="phone_number" name="phone_number" required value="{{ old('phone_number') }}"
                                class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                                placeholder="Votre numéro de téléphone">
                        </div>
                    </div>
                    
                    <div>
                        <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ville *</label>
                        <select id="city_id" name="city_id" required
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4">
                            <option value="" disabled {{ old('city_id') ? '' : 'selected' }}>-- Sélectionnez votre ville --</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                                        
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse *</label>
                        <input type="text" id="address" name="address" required value="{{ old('address') }}"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                            placeholder="Votre adresse">
                    </div>

                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                                placeholder="Minimum 8 caractères">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            8 caractères minimum, incluant lettres, chiffres et caractères spéciaux
                        </p>
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmation *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4"
                                placeholder="Confirmez votre mot de passe">
                        </div>
                        <div id="password_confirmation-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button" id="next-to-step-2" class="flex items-center justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-forest hover:bg-opacity-90 dark:bg-meadow dark:hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:focus:ring-meadow transition duration-150">
                        Suivant
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </section>
            
            <!-- Step 2: Identity Verification -->
            <section id="step-2" class="step-section hidden">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-id-card mr-2 text-forest dark:text-meadow"></i>
                    Vérification d'identité
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CIN Recto *</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-forest dark:hover:border-meadow transition-colors duration-200">
                            <div class="text-center">
                                <i class="fas fa-id-card text-3xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                    <label
                                        class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-forest dark:text-meadow hover:text-opacity-80 dark:hover:text-opacity-80 focus-within:outline-none">
                                        <span>Télécharger un fichier</span>
                                        <input id="cin-front" name="cin_recto" type="file" accept="image/*"
                                            class="sr-only" required>
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, JPEG jusqu'à 5MB
                                </p>
                                <img id="cin-front-preview" class="mt-3 mx-auto max-h-32 hidden rounded">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CIN Verso *</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-forest dark:hover:border-meadow transition-colors duration-200">
                            <div class="text-center">
                                <i class="fas fa-id-card text-3xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                    <label
                                        class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-forest dark:text-meadow hover:text-opacity-80 dark:hover:text-opacity-80 focus-within:outline-none">
                                        <span>Télécharger un fichier</span>
                                        <input id="cin-back" name="cin_verso" type="file" accept="image/*"
                                            class="sr-only" required>
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, JPEG jusqu'à 5MB
                                </p>
                                <img id="cin-back-preview" class="mt-3 mx-auto max-h-32 hidden rounded">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-between">
                    <button type="button" id="back-to-step-1" class="flex items-center justify-center py-3 px-6 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:focus:ring-meadow transition duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Précédent
                    </button>
                    <button type="button" id="next-to-step-3" class="flex items-center justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-forest hover:bg-opacity-90 dark:bg-meadow dark:hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:focus:ring-meadow transition duration-150">
                        Suivant
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </section>
            
            <!-- Step 3: Agreements -->
            <section id="step-3" class="step-section hidden">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-file-contract mr-2 text-forest dark:text-meadow"></i>
                    Accords et contrats
                </h3>
                
                <div x-data="{ showTerms: false, showPrivacy: false, showContract: false }" class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" value="1" required
                                class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">
                                J'accepte les
                                <button type="button" @click="showTerms = !showTerms"
                                    class="text-forest dark:text-meadow underline hover:no-underline ml-1">
                                    CGU
                                </button>
                                et la
                                <button type="button" @click="showPrivacy = !showPrivacy"
                                    class="text-forest dark:text-meadow underline hover:no-underline ml-1">
                                    Politique de Confidentialité
                                </button> *
                            </label>
                        </div>
                    </div>

                    <div x-show="showTerms" x-transition
                        class="p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                        <h3 class="text-lg font-semibold mb-2">Conditions Générales d'Utilisation (CGU)</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>L'utilisateur s'engage à respecter les conditions de location et d'utilisation du
                                matériel.</li>
                            <li>CampShare peut suspendre un compte en cas d'abus.</li>
                            <li>Les données personnelles sont protégées selon la législation en vigueur.</li>
                        </ul>
                    </div>

                    <div x-show="showPrivacy" x-transition
                        class="p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                        <h3 class="text-lg font-semibold mb-2">Politique de Confidentialité</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Nous collectons uniquement les données nécessaires à la gestion de vos locations.
                            </li>
                            <li>Vos données ne sont jamais revendues à des tiers.</li>
                            <li>Vous pouvez demander la suppression de vos données à tout moment.</li>
                        </ul>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="contract" name="contract" type="checkbox" value="1" required
                                class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="contract" class="font-medium text-gray-700 dark:text-gray-300">
                                Je valide le
                                <button type="button" @click="showContract = !showContract"
                                    class="text-forest dark:text-meadow underline hover:no-underline ml-1">
                                    Contrat de Location
                                </button>
                            </label>
                        </div>
                    </div>

                    <div x-show="showContract" x-transition
                        class="p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                        <h3 class="text-lg font-semibold mb-2">Contrat de Service - CampShare</h3>
                        <p class="mb-2">En utilisant CampShare, vous acceptez les conditions suivantes :</p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Vous êtes responsable des équipements loués.</li>
                            <li>Les retards de retour peuvent entraîner des frais supplémentaires.</li>
                            <li>Les dommages ou pertes doivent être signalés immédiatement.</li>
                            <li>CampShare se réserve le droit de suspendre tout compte non conforme aux règles.</li>
                            <li>Le service est fourni "tel quel" sans garantie de disponibilité permanente.</li>
                        </ul>
                        <p class="mt-4 text-sm italic">Pour toute question, contactez notre support client.</p>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="become_partner" name="role" type="checkbox" value="partner"
                                class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="become_partner" class="font-medium text-gray-700 dark:text-gray-300">
                                Je souhaite devenir partenaire
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                En cochant cette case, vous pourrez proposer vos équipements à la location.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                    <div class="flex items-center h-5">
                        {{-- Ajout de {{ old('is_subscribed') ? 'checked' : '' }} pour conserver l'état après validation --}}
                        <input id="is_subscribed" name="is_subscribed" type="checkbox" value="1" {{ old('is_subscribed') ? 'checked' : '' }}
                            class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                    </div>
                    <div class="ml-3 text-sm">
                        {{-- Texte du label original conservé --}}
                        <label for="is_subscribed" class="font-medium text-gray-700 dark:text-gray-300">
                            Je souhaite recevoir les notifications (facultatif)
                        </label>
                    </div>
                </div>
            </div>

                <div class="mt-8 flex justify-between">
                    <button type="button" id="back-to-step-2" class="flex items-center justify-center py-3 px-6 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:focus:ring-meadow transition duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Précédent
                    </button>
                    <button type="submit" id="register-btn"
                        class="flex items-center justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-sunlight hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sunlight transition duration-150">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer mon compte
                    </button>
                </div>
            </section>
        </form>
        
        <div class="mt-10 flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('login') }}" class="footer-link text-forest dark:text-meadow hover:text-opacity-90 dark:hover:text-opacity-90">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Déjà un compte ? Connectez-vous
            </a>
            <a href="{{ url('/') }}" class="footer-link text-gray-600 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">
                <i class="fas fa-home mr-2"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = document.querySelectorAll('.step-section');
            const progressBar = document.getElementById('progress-bar');
            const progressPercentage = document.getElementById('progress-percentage');
            const currentStepTitle = document.getElementById('current-step-title');
            const stepIndicators = [
                document.getElementById('step-1-indicator'),
                document.getElementById('step-2-indicator'),
                document.getElementById('step-3-indicator')
            ];
            
            let currentStep = 1;
            const totalSteps = steps.length;
            
            const stepTitles = [
                'Étape 1 : Informations personnelles',
                'Étape 2 : Vérification d\'identité',
                'Étape 3 : Accords et contrats'
            ];
            
            // File upload preview
            function setupFilePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            setupFilePreview('cin-front', 'cin-front-preview');
            setupFilePreview('cin-back', 'cin-back-preview');

            // Update progress
            function updateProgress(step) {
                const percent = Math.round((step / totalSteps) * 100);
                progressBar.style.width = `${percent}%`;
                progressPercentage.textContent = percent;
                currentStepTitle.textContent = stepTitles[step - 1];
                
                for (let i = 0; i < stepIndicators.length; i++) {
                    if (i + 1 < step) {
                        stepIndicators[i].innerHTML = '<i class="fas fa-check"></i>';
                        stepIndicators[i].classList.remove('bg-gray-300', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-300');
                        stepIndicators[i].classList.add('bg-forest', 'dark:bg-meadow', 'text-white');
                    } else if (i + 1 === step) {
                        stepIndicators[i].textContent = i + 1;
                        stepIndicators[i].classList.remove('bg-gray-300', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-300');
                        stepIndicators[i].classList.add('bg-forest', 'dark:bg-meadow', 'text-white');
                    } else {
                        stepIndicators[i].textContent = i + 1;
                        stepIndicators[i].classList.remove('bg-forest', 'dark:bg-meadow', 'text-white');
                        stepIndicators[i].classList.add('bg-gray-300', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-300');
                    }
                }
            }
            
            // Navigate between steps
            function goToStep(step) {
                if (step < 1 || step > totalSteps) return;

                // Hide current step with animation
                steps[currentStep - 1].classList.add('fade-out');
                setTimeout(() => {
                    steps[currentStep - 1].classList.add('hidden');
                    steps[currentStep - 1].classList.remove('fade-out');

                    // Show new step with animation
                    steps[step - 1].classList.remove('hidden');
                    steps[step - 1].classList.add('fade-in');
                    setTimeout(() => {
                        steps[step - 1].classList.remove('fade-in');
                    }, 400);

                    currentStep = step;
                    updateProgress(currentStep);

                    // Scroll to top of form
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 300);
            }

            // Form validation
            function validateStep(step) {
                let valid = true;
                const errorMessages = [];

                // Helper function to show error
                function showError(fieldId, message) {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.classList.add('border-red-500');
                        field.classList.remove('border-gray-300', 'dark:border-gray-600');
                    }
                    errorMessages.push(message);
                    valid = false;
                }

                // Step 1 validation
                if (step === 1) {
                    // Required fields
                    const requiredFields = [
                        { id: 'username', name: 'Pseudonyme' },
                        { id: 'email', name: 'Email' },
                        { id: 'first_name', name: 'Prénom' },
                        { id: 'last_name', name: 'Nom' },
                        { id: 'address', name: 'Adresse' },
                        { id: 'phone_number', name: 'Téléphone' },
                        { id: 'password', name: 'Mot de passe' },
                        { id: 'password_confirmation', name: 'Confirmation mot de passe' }
                    ];

                    requiredFields.forEach(field => {
                        const value = document.getElementById(field.id)?.value.trim();
                        if (!value) showError(field.id, `${field.name} est requis`);
                    });

                    // Email format
                    const email = document.getElementById('email')?.value;
                    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        showError('email', 'Email invalide');
                    }

                    // Password match
                    const password = document.getElementById('password')?.value;
                    const confirmPassword = document.getElementById('password_confirmation')?.value;
                    if (password && confirmPassword && password !== confirmPassword) {
                        showError('password_confirmation', 'Les mots de passe ne correspondent pas');
                    }

                    // Password strength
                    if (password && password.length < 8) {
                        showError('password', 'Le mot de passe doit contenir au moins 8 caractères');
                    }
                }

                // Step 2 validation
                else if (step === 2) {
                    // CIN files
                    const cinFront = document.getElementById('cin-front');
                    const cinBack = document.getElementById('cin-back');

                    if (!cinFront.files || cinFront.files.length === 0) {
                        showError('cin-front', 'Photo CIN recto requise');
                    } else {
                        const file = cinFront.files[0];
                        const validTypes = ['image/jpeg', 'image/png'];
                        const maxSize = 5 * 1024 * 1024; // 5MB

                        if (!validTypes.includes(file.type)) {
                            showError('cin-front', 'Format fichier recto invalide (JPEG/PNG seulement)');
                        }
                        if (file.size > maxSize) {
                            showError('cin-front', 'Fichier recto trop volumineux (max 5MB)');
                        }
                    }

                    if (!cinBack.files || cinBack.files.length === 0) {
                        showError('cin-back', 'Photo CIN verso requise');
                    } else {
                        const file = cinBack.files[0];
                        const validTypes = ['image/jpeg', 'image/png'];
                        const maxSize = 5 * 1024 * 1024; // 5MB

                        if (!validTypes.includes(file.type)) {
                            showError('cin-back', 'Format fichier verso invalide (JPEG/PNG seulement)');
                        }
                        if (file.size > maxSize) {
                            showError('cin-back', 'Fichier verso trop volumineux (max 5MB)');
                        }
                    }
                }

                // Step 3 validation
                else if (step === 3) {
                    const terms = document.getElementById('terms');
                    const contract = document.getElementById('contract');

                    if (!terms.checked) {
                        terms.parentElement.parentElement.classList.add('text-red-500', 'dark:text-red-400');
                        errorMessages.push('Vous devez accepter les CGU');
                        valid = false;
                    } else {
                        terms.parentElement.parentElement.classList.remove('text-red-500', 'dark:text-red-400');
                    }

                    if (!contract.checked) {
                        contract.parentElement.parentElement.classList.add('text-red-500', 'dark:text-red-400');
                        errorMessages.push('Vous devez accepter le contrat');
                        valid = false;
                    } else {
                        contract.parentElement.parentElement.classList.remove('text-red-500', 'dark:text-red-400');
                    }
                }

                // Display errors if any
                if (!valid) {
                    const errorContainer = document.getElementById('client-side-errors');
                    const errorList = document.getElementById('client-error-list');

                    errorList.innerHTML = '';
                    errorMessages.forEach(msg => {
                        const li = document.createElement('li');
                        li.textContent = msg;
                        errorList.appendChild(li);
                    });

                    errorContainer.classList.remove('hidden');
                    errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    document.getElementById('client-side-errors').classList.add('hidden');
                }

                return valid;
            }

            // Navigation buttons
            document.getElementById('next-to-step-2').addEventListener('click', () => {
                if (validateStep(1)) goToStep(2);
            });

            document.getElementById('next-to-step-3').addEventListener('click', () => {
                if (validateStep(2)) goToStep(3);
            });

            document.getElementById('back-to-step-1').addEventListener('click', () => goToStep(1));
            document.getElementById('back-to-step-2').addEventListener('click', () => goToStep(2));

            // Form submission
            document.getElementById('registration-form').addEventListener('submit', function (e) {
                if (currentStep < totalSteps) {
                    e.preventDefault();
                    if (validateStep(currentStep)) goToStep(currentStep + 1);
                } else {
                    if (!validateStep(3)) {
                        e.preventDefault();
                        return;
                    }

                    // Show loading state
                    const button = document.getElementById('register-btn');
                    const originalText = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Création en cours...';

                    // In a real app, the form would submit here
                    // For demo purposes, we'll simulate a delay
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        alert('Fonctionnalité de démonstration. En production, le formulaire serait soumis.');
                    }, 2000);
                }
            });

            // Initialize
            updateProgress(currentStep);
        });
    </script>
</body>
</html>