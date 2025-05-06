<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - ParentCo</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/styles.css', 'resources/js/script.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="CampShare - Louez facilement le matériel de camping dont vous avez besoin
    directement entre particuliers.">
    <meta name="keywords" content="camping, location, matériel, aventure, plein air, partage, communauté">

</head>


<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900">
    
    @include('partials.header')

    <!-- Hero Section -->
    <header class="relative pt-16 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Paysage de camping" class="h-full w-full object-cover brightness-75 dark:brightness-50 transition-all duration-300" />
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 dark:opacity-70"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 lg:py-40">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                    Votre aventure commence ici.
                </h1>
                <p class="text-xl md:text-2xl text-white opacity-90 mb-8">
                    Louez facilement le matériel de camping dont vous avez besoin, directement entre particuliers.
                </p>
                
                <!-- Search Box -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-4 md:p-6 mb-8 transition-all duration-300">
                    <form action="{{ route('client.listings.index') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="search" name="search" placeholder="Rechercher des tentes, lampes, boussoles ..." class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3">
                            </div>
                        </div>
                    
                        <div class="flex items-end">
                            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-sunlight hover:bg-amber-600 text-white font-medium rounded-md shadow-md transition duration-300 flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i>
                                Rechercher
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- How It Works Section -->
        <section id="comment-ca-marche" class="py-16 md:py-24 bg-gray-50 dark:bg-gray-800 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Comment ça marche ?</h2>
                    <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">
                        Profitez de vos aventures en plein air sans vous ruiner grâce à notre plateforme simple et sécurisée.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 text-center transform transition duration-300 hover:scale-105">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-meadow bg-opacity-10 text-white mb-4">
                            <i class="fas fa-search text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">1. Recherchez</h3>
                        <p class="text-gray-600 dark:text-gray-300">Trouvez le matériel de camping dont vous avez besoin selon votre emplacement et vos dates.</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 text-center transform transition duration-300 hover:scale-105">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-forest bg-opacity-10 text-white mb-4">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">2. Réservez</h3>
                        <p class="text-gray-600 dark:text-gray-300">Réservez en quelques clics et communiquez directement avec le propriétaire du matériel.</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 text-center transform transition duration-300 hover:scale-105">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-water bg-opacity-10 text-white mb-4">
                            <i class="fas fa-mountain text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">3. Profitez</h3>
                        <p class="text-gray-600 dark:text-gray-300">Récupérez le matériel et profitez pleinement de votre aventure en plein air.</p>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 text-center transform transition duration-300 hover:scale-105">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-sunlight bg-opacity-10 text-white mb-4">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">4. Évaluez</h3>
                        <p class="text-gray-600 dark:text-gray-300">Partagez votre expérience en laissant une évaluation après avoir rendu le matériel.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Popular Categories Section -->
        <section id="explorer" class="py-16 md:py-24 bg-white dark:bg-gray-900 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Catégories Populaires</h2>
                    <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">
                        Découvrez notre sélection de matériel de camping de qualité pour toutes vos aventures.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                    <!-- Category 1 -->
                    <a href="#" class="group">
                        <div class="relative rounded-lg overflow-hidden shadow-lg aspect-w-3 aspect-h-2 mb-4">
                            <img src="https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Tentes" class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-300" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-xl font-bold text-white">Tentes</h3>
                                <p class="text-sm text-gray-200">68 articles disponibles</p>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Category 2 -->
                    <a href="#" class="group">
                        <div class="relative rounded-lg overflow-hidden shadow-lg aspect-w-3 aspect-h-2 mb-4">
                            <img src="https://images.unsplash.com/photo-1526491109672-74740652b963?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Couchage" class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-300" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-xl font-bold text-white">Couchage</h3>
                                <p class="text-sm text-gray-200">42 articles disponibles</p>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Category 3 - Cuisine image updated -->
                    <a href="#" class="group">
                        <div class="relative rounded-lg overflow-hidden shadow-lg aspect-w-3 aspect-h-2 mb-4">
                            <img src="https://images.unsplash.com/photo-1517411032315-54ef2cb783bb?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Cuisine" class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-300" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-xl font-bold text-white">Cuisine</h3>
                                <p class="text-sm text-gray-200">56 articles disponibles</p>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Category 4 -->
                    <a href="#" class="group">
                        <div class="relative rounded-lg overflow-hidden shadow-lg aspect-w-3 aspect-h-2 mb-4">
                            <img src="https://images.unsplash.com/photo-1510672981848-a1c4f1cb5ccf?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Mobilier" class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-300" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-xl font-bold text-white">Mobilier</h3>
                                <p class="text-sm text-gray-200">37 articles disponibles</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('client.listings.index') }}" class="inline-block px-6 py-3 bg-forest hover:bg-green-700 text-white font-medium rounded-md shadow-md transition duration-300">
                        Voir toutes les catégories
                    </a>
                </div>
            </div>
        </section>
        
        <!-- Value Proposition Section -->
        <section class="py-16 md:py-24 bg-gray-50 dark:bg-gray-800 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Pourquoi choisir CampShare ?</h2>
                    <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">
                        Nous rendons le camping plus accessible, économique et durable pour tous.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Benefit 1 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 transform transition duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-meadow text-white mb-4">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Économisez</h3>
                        <p class="text-gray-600 dark:text-gray-300">Louez uniquement ce dont vous avez besoin sans investir dans du matériel coûteux que vous n'utiliserez que rarement.</p>
                    </div>
                    
                    <!-- Benefit 2 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 transform transition duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-forest text-white mb-4">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Éco-responsable</h3>
                        <p class="text-gray-600 dark:text-gray-300">Contribuez à réduire la surconsommation en partageant des ressources plutôt qu'en achetant du matériel neuf.</p>
                    </div>
                    
                    <!-- Benefit 3 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 transform transition duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-water text-white mb-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Sécurisé</h3>
                        <p class="text-gray-600 dark:text-gray-300">Profitez de notre système de vérification, d'évaluations et d'assurance pour des transactions en toute confiance.</p>
                    </div>
                    
                    <!-- Benefit 4 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 transform transition duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-earth text-white mb-4">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Local</h3>
                        <p class="text-gray-600 dark:text-gray-300">Trouvez du matériel près de votre destination ou de chez vous, pour un voyage plus pratique.</p>
                    </div>
                    
                    <!-- Benefit 5 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 transform transition duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-sunlight text-white mb-4">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Rentabilisez</h3>
                        <p class="text-gray-600 dark:text-gray-300">Rentabilisez votre propre matériel de camping en le louant lorsque vous ne l'utilisez pas.</p>
                    </div>
                    
                    <!-- Benefit 6 -->
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 transform transition duration-300 hover:shadow-lg">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-cyan-600 text-white mb-4">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Communauté</h3>
                        <p class="text-gray-600 dark:text-gray-300">Rejoignez une communauté de passionnés de plein air et partagez conseils et expériences.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Become a Partner CTA -->
        <section id="devenir-partenaire" class="relative py-16 md:py-24 overflow-hidden transition-all duration-300">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1563299796-17596ed6b017?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Paysage de montagne" class="h-full w-full object-cover brightness-75 dark:brightness-50" />
                <div class="absolute inset-0 bg-gradient-to-r from-forest/80 to-transparent dark:from-forest/90"></div>
            </div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="md:w-1/2 text-white">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Gagnez de l'argent avec votre matériel inutilisé !</h2>
                        <p class="text-xl mb-6 text-white opacity-90">
                            Devenez Partenaire CampShare et transformez votre matériel de camping en source de revenus lorsque vous ne l'utilisez pas.
                        </p>
                        <ul class="mb-8 space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-sunlight mt-1 mr-2"></i>
                                <span>Gagnez jusqu'à 10 000 MAD par saison selon votre matériel</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-sunlight mt-1 mr-2"></i>
                                <span>Protection assurance partenaire incluse</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-sunlight mt-1 mr-2"></i>
                                <span>Vous gardez le contrôle : prix, disponibilités, validation</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-sunlight mt-1 mr-2"></i>
                                <span>Inscription et publication d'annonces gratuites</span>
                            </li>
                        </ul>
                        <a href="#" class="inline-block px-6 py-3 bg-sunlight hover:bg-amber-600 text-white font-medium rounded-md shadow-md transition duration-300">
                            Devenir Partenaire maintenant
                        </a>
                    </div>
                    
                    <div class="mt-10 md:mt-0 md:w-2/5">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-6 md:p-8 transition-all duration-300">
                            <div class="text-center mb-6">
                                <span class="inline-block p-3 rounded-full bg-sunlight bg-opacity-10 text-white">
                                    <i class="fas fa-calculator text-2xl"></i>
                                </span>
                                <h3 class="text-xl font-bold mt-4 text-gray-900 dark:text-white">Simulez vos revenus</h3>
                            </div>
                            
                            <form class="space-y-4">
                                <div>
                                    <label for="equipment-type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type de matériel</label>
                                    <select id="equipment-type" name="equipment-type" class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4">
                                        <option>Tente</option>
                                        <option>Sac de couchage</option>
                                        <option>Matelas gonflable</option>
                                        <option>Réchaud</option>
                                        <option>Autre</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valeur d'achat estimée (MAD)</label>
                                    <div class="relative">
                                        <input type="number" id="value" name="value" placeholder="1000" class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 px-4 custom-input">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400">MAD</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Disponibilité (semaines par an)</label>
                                    <input type="range" id="duration" name="duration" min="1" max="20" value="10" class="block w-full">
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <span>1 semaine</span>
                                        <span>10</span>
                                        <span>20 semaines</span>
                                    </div>
                                </div>
                                
                                <div class="pt-4">
                                    <button id="calculate-button" type="button" class="w-full px-6 py-3 bg-forest hover:bg-green-700 text-white font-medium rounded-md shadow-md transition duration-300">
                                        Calculer mes revenus potentiels
                                    </button>
                                </div>
                                
                                <div id="result-container" class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 hidden">
                                    <div class="text-center">
                                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Revenus estimés</h4>
                                        <p class="text-3xl font-bold text-sunlight"><span id="estimated-revenue">0</span> MAD</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">par an, selon nos estimations</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Testimonials  -->
        <section class="py-16 md:py-24 bg-white dark:bg-gray-900 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Ce que disent nos utilisateurs</h2>
                    <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">
                        Découvrez les expériences vécues par notre communauté de campeurs et partenaires.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="text-amber-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-2 text-gray-600 dark:text-gray-300">5.0</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            "J'ai loué une tente 4 places pour un weekend entre amis. Matériel impeccable, échanges faciles avec le propriétaire, et prix bien plus abordable qu'en boutique. Je recommande !"
                        </p>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 font-medium">IK</span>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900 dark:text-white">Iabakriman Kaoutar</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Cliente depuis 2022</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="text-amber-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-2 text-gray-600 dark:text-gray-300">5.0</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            "En tant que partenaire, j'ai déjà rentabilisé mon matériel de randonnée en seulement une saison ! Plateforme intuitive et équipe réactive. Très satisfait de mon expérience."
                        </p>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 font-medium">BS</span>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900 dark:text-white">Barhrouj Saad</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Partenaire depuis 2021</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 3 -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="text-amber-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="ml-2 text-gray-600 dark:text-gray-300">4.5</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            "Premier camping en famille réussi grâce à CampShare ! J'ai pu louer tout le nécessaire sans investir des centaines d'euros, et les conseils du propriétaire étaient précieux."
                        </p>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 font-medium">DF</span>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-medium text-gray-900 dark:text-white">Deraoui Fatima</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Cliente depuis 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 text-white py-12 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
                <!-- Column 1: Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-6">
                        <span class="text-white text-2xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                        <span class="text-xs ml-2 text-gray-400">by ParentCo</span>
                    </div>
                    <p class="text-gray-300 mb-4 max-w-md">
                        CampShare est un service de ParentCo qui permet aux particuliers de louer du matériel de camping entre eux, pour des aventures plus accessibles et éco-responsables.
                    </p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-300 hover:text-white transition duration-150">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-150">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-150">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-150">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Column 2: Links 1 -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">CampShare</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Comment ça marche</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Explorer le matériel</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Devenir Partenaire</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Guide du camping</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Destinations populaires</a></li>
                    </ul>
                </div>
                
                <!-- Column 3: Links 2 -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Assistance</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Contactez-nous</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Signaler un problème</a></li>
                        <li><a href="#reclamation" class="text-white font-medium hover:text-sunlight transition duration-150">
                            <i class="fas fa-exclamation-circle mr-1"></i> Réclamations
                        </a></li>
                    </ul>
                </div>
                
                <!-- Column 4: Links 3 -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informations légales</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">À propos de ParentCo</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Conditions Générales Client</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Conditions Générales Partenaire</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Politique de Confidentialité</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Mentions légales</a></li>
                    </ul>
                </div>
            </div>
            
            <div id="reclamation" class="my-8 p-5 bg-gray-700 dark:bg-gray-800 rounded-lg border-l-4 border-sunlight">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0 md:mr-6">
                        <h3 class="font-bold text-xl mb-2 flex items-center">
                            <i class="fas fa-headset text-sunlight mr-2"></i>
                            Service Réclamations
                        </h3>
                        <p class="text-gray-300">Un problème avec votre location ou votre compte ? Notre équipe est à votre disposition pour traiter votre réclamation dans les meilleurs délais.</p>
                    </div>
                    <a href="/reclamations" class="pulse-button inline-flex items-center justify-center px-6 py-3 bg-sunlight hover:bg-amber-600 text-white font-medium rounded-md shadow-md transition duration-300 whitespace-nowrap">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Déposer une réclamation
                    </a>
                </div>
            </div>
            
            <div class="border-t border-gray-600 pt-8 mt-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-400">
                            © 2023 ParentCo. Tous droits réservés. CampShare est un service de ParentCo.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <img src="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.11.0/flags/4x3/ma.svg" alt="Drapeau marocain" class="h-5 w-auto" />
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Français</a>
                        <span class="text-gray-600">|</span>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">العربية</a>
                        <span class="text-gray-600">|</span>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">English</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Sticky navbar effect on scroll
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
        
        // Revenue calculator functionality
        document.addEventListener('DOMContentLoaded', function() {
            const calculateButton = document.getElementById('calculate-button');
            const resultContainer = document.getElementById('result-container');
            const estimatedRevenue = document.getElementById('estimated-revenue');
            const equipmentType = document.getElementById('equipment-type');
            const value = document.getElementById('value');
            const duration = document.getElementById('duration');
            
            if (calculateButton) {
                calculateButton.addEventListener('click', function() {
                    const equipmentValue = parseFloat(value.value) || 0;
                    const durationValue = parseInt(duration.value) || 10;
                    const equipmentTypeValue = equipmentType.value;
                    
                    let rentalRate = 0;
                    switch(equipmentTypeValue) {
                        case 'Tente':
                            rentalRate = 0.12; // 12% of value per week
                            break;
                        case 'Sac de couchage':
                            rentalRate = 0.08; // 8% of value per week
                            break;
                        case 'Matelas gonflable':
                            rentalRate = 0.10; // 10% of value per week
                            break;
                        case 'Réchaud':
                            rentalRate = 0.09; // 9% of value per week
                            break;
                        default:
                            rentalRate = 0.07; // 7% for other equipment
                    }
                    
                    const weeklyRate = Math.round(equipmentValue * rentalRate);
                    const annualRevenue = weeklyRate * durationValue;
                    
                    estimatedRevenue.textContent = annualRevenue.toLocaleString('fr-MA');
                    resultContainer.classList.remove('hidden');
                });
            }
            
            duration.addEventListener('input', function() {
                document.querySelector('span:nth-child(2)').textContent = this.value;
            });
        });
    </script>
</body>
</html>