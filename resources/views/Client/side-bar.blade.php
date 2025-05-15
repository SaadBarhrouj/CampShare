<style>
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
        
        .active-nav-link {
            position: relative;
        }
        
        .active-nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #FFAA33;
        }
        
        .custom-input {
            transition: all 0.3s ease;
            border-width: 2px;
        }
        
        .custom-input:focus {
            box-shadow: 0 0 0 3px rgba(45, 95, 43, 0.2);
        }
        
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
        
        .equipment-card {
            transition: all 0.3s ease;
        }
        
        .equipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
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
        
        .chat-container {
            max-height: 400px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        
        .chat-message {
            margin-bottom: 15px;
            display: flex;
        }
        
        .chat-message.outgoing {
            justify-content: flex-end;
        }
        
        .chat-bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 80%;
        }
        
        .chat-message.incoming .chat-bubble {
            background-color: #f3f4f6;
            border-bottom-left-radius: 5px;
        }
        
        .dark .chat-message.incoming .chat-bubble {
            background-color: #374151;
        }
        
        .chat-message.outgoing .chat-bubble {
            background-color: #2D5F2B;
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .dark .chat-message.outgoing .chat-bubble {
            background-color: #4F7942;
        }

         .sidebar-link2.active {
            background-color: rgba(45, 95, 43, 0.1);
            color: #2D5F2B;
            border-left: 4px solid #2D5F2B;
        }
        
        .dark .sidebar-link2.active {
            background-color: rgba(79, 121, 66, 0.2);
            color: #4F7942;
            border-left: 4px solid #4F7942;
        }
    </style>
        <!-- Navigation -->
<nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <!-- Logo -->
                <a href="{{ route('index') }}" class="flex items-center">
                    <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                    <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
                </a>
            </div>
            
            <!-- Desktop Navigation -->

            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('client.listings.index') }}" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Explorer le matériel</a>
                
                @auth
                    @php
                        $user = $user ?? Auth::user();
                    @endphp
                    @if($user)
                        @if($user->role == 'client')
                            <button type="button" id="openPartnerModalBtn" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300 cursor-pointer">
                                Devenir Partenaire
                            </button>
                        @endif
                        <div class="relative ml-4">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <a id="notifications-client-icon-link" 
                                    href="{{ route('notifications.client.index') }}" 
                                    data-mark-read-url="{{ route('notifications.client.markAllAsRead') }}"
                                    class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                        <i class="fas fa-bell"></i>
                                        {{-- Utilisation de la variable globale $unreadClientNotificationsCountGlobal fournie par AppServiceProvider --}}
                                        @if(isset($unreadClientNotificationsCountGlobal) && $unreadClientNotificationsCountGlobal > 0)
                                            <span id="notification-badge-count" class="notification-badge">{{ $unreadClientNotificationsCountGlobal }}</span>
                                        @endif
                                    </a>
                                </div>
                                <div class="relative">
                                    <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                        <img src="{{ asset($user->avatar_url) ?? asset('images/default-avatar.png') }}"
                                           alt="Avatar de {{ $user->username }}"
                                           class="h-8 w-8 rounded-full object-cover" />
                                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $user->username }}</span>
                                        <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                    </button>
                                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-600">
                                        <div class="py-1">
                                            <a href="/Client/profile" data-target="profile" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                            </a>
                                            <a href="{{ route('HomeClient') }}" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Espace Client
                                            </a>
                                            @if($user->role == 'partner')
                                            <a href="{{ route('HomePartenaie') }}" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Espace Partenaire
                                            </a>
                                            @endif
                                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                            <a href="{{ route('logout') }}"
                                            class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                                @csrf
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($user->role == 'client')
                        <div id="partnerAcceptModal" class="fixed inset-0 z-[60] hidden overflow-y-auto bg-black bg-opacity-60 flex items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden max-w-2xl w-full p-6 m-4">
                                <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                        Devenir Partenaire Campshare
                                    </h3>
                                    <button id="closePartnerModalBtn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" aria-label="Fermer">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                                <div class="mt-4 mb-6 max-h-[60vh] overflow-y-auto px-1">
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        En devenant partenaire sur <strong>Campshare</strong>, notre plateforme de location d'équipements de camping, vous vous engagez à respecter les points suivants :
                                        <ul class="mt-3 ml-4 list-disc space-y-2 text-sm">
                                            <li><strong>Qualité et Sécurité :</strong> Fournir du matériel de camping conforme à sa description, propre, sécurisé et en parfait état de fonctionnement.</li>
                                            <li><strong>Annonces à Jour :</strong> Maintenir les informations de vos annonces (photos, descriptions, prix, caractéristiques) exactes et actuelles.</li>
                                            <li><strong>Disponibilité :</strong> Gérer avec précision et réactivité le calendrier de disponibilité de votre matériel pour éviter les doubles réservations.</li>
                                            <li><strong>Communication :</strong> Répondre rapidement (idéalement sous 24h) aux demandes de réservation et aux questions des locataires potentiels.</li>
                                            <li><strong>Gestion des Réservations :</strong> Honorer les réservations confirmées. Vous serez notifié par email et via votre espace partenaire lors de l'acceptation d'une réservation par un client.</li>
                                            <li><strong>Préparation et Restitution :</strong> Préparer le matériel loué pour le retrait par le locataire et vérifier son état lors de la restitution.</li>
                                            <li><strong>Respect des Règles :</strong> Vous conformer aux <a href="/conditions-generales-partenaires" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">Conditions Générales Partenaires de Campshare</a>.</li>
                                        </ul>
                                        <br>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                            En cliquant sur 'Accepter et Continuer', vous confirmez avoir lu, compris et accepté ces engagements pour rejoindre la communauté des partenaires Campshare.
                                        </p>
                                    </p>
                                </div>
                                <div class="flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <form method="POST" action="{{ route('devenir_partenaire') }}">
                                        @csrf
                                    <a id="cancelPartnerModalBtn"  class="cursor-pointer mr-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition duration-150 ease-in-out">
                                        Annuler
                                    </a>
                                    <button type="submit" id="confirmPartnerBtn" class="px-4 py-2 bg-forest text-white rounded-md hover:bg-opacity-90 dark:bg-sunlight dark:text-gray-900 dark:hover:bg-opacity-90 transition duration-150 ease-in-out shadow-sm">
                                        Accepter et Continuer
                                    </button>
                                </form>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                @else
                    <div class="flex items-center space-x-4 ml-4">
                        <a href="{{ route('login.form') }}" class="px-4 py-2 font-medium rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 font-medium rounded-md bg-sunlight hover:bg-amber-600 text-white shadow-md transition duration-300">Inscription</a>
                    </div>
                @endauth

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
    
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-800 pb-4 shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('client.listings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Explorer le matériel</a>
            @auth
                @php
                    $user = $user ?? Auth::user();
                @endphp
                @if($user)
                    @if($user->role == 'client')
                        <a href="#devenir" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Devenir Partenaire</a>

                    @endif

                        <!-- Mobile profile menu -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-3">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset($user->avatar_url) ?? asset('images/default-avatar.png') }}"
                                        alt="Avatar de {{ $user->username }}"
                                        class="h-8 w-8 rounded-full" />
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800 dark:text-white">{{ $user->first_name }} {{ $user->last_name }} - {{ $user->username }}</div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                </div>
                                <div class="ml-auto flex items-center space-x-4">
                                    <button class="flex-shrink-0 p-1 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <i class="fas fa-bell text-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="/Client/profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                </a>
                                <a href="{{ route('HomeClient') }}" class=" block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-user-circle mr-2 opacity-70"></i> Espace Client
                                </a>
                                @if($user->role == 'partner')
                                <a href="{{ route('HomePartenaie') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-user-circle mr-2 opacity-70"></i> Espace Partenaire
                                </a>
                                @endif
                                <a href="{{ route('logout') }}" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                    <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                </a>
                            </div>
                        </div>

                @endif
            @else
                <div class="mt-4 flex flex-col space-y-3 px-3">
                    <a href="{{ route('login.form') }}" class="px-4 py-2 font-medium rounded-md text-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 transition duration-300">Connexion</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 font-medium rounded-md text-center bg-sunlight hover:bg-amber-600 text-white transition duration-300">Inscription</a>
                </div>
            @endauth
        </div>
    </div>


</nav>
    <div class="flex flex-col md:flex-row pt-16">
        <aside class="hidden md:block w-64 bg-white dark:bg-gray-800 shadow-md h-screen fixed overflow-y-auto">
            <div class="p-5">
                <div class="mb-6 px-3 flex flex-col items-center">
                    <div class="relative">
                        <img src="{{ asset($user->avatar_url) ?? asset('images/default-avatar.jpg') }}" 
                        alt="Avatar de {{ $user->name }}" 
                             class="w-24 h-24 rounded-full border-4 border-forest dark:border-meadow object-cover" />
                        <div class="absolute bottom-1 right-1 bg-green-500 p-1 rounded-full border-2 border-white dark:border-gray-800">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-4">{{$user->username}}</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Membre depuis {{ \Carbon\Carbon::parse($user->created_at)->format('Y') }}</div>

                    <div class="flex items-center mt-2">
                        @if(isset($note_moyenne) && $note_moyenne != 0)
                            @php
                                $rating = $note_moyenne;
                                $fullStars = floor($rating); 
                                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp
                            
                            <div class="flex text-amber-400 mr-1">
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star text-base"></i>
                                @endfor
                                @if ($hasHalfStar)
                                    <i class="fas fa-star-half-alt text-base"></i>
                                @endif
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="far fa-star text-base"></i>
                                @endfor
                            </div>
                            
                            <span class="text-gray-600 dark:text-gray-300 text-sm ml-1">
                                {{ number_format($rating, 1) }}
                            </span>
                        @else
                            <span class="text-gray-400 text-sm">Not rated</span>
                        @endif
                    </div>
                </div>
                <nav class="mt-6 space-y-1">
                    <a href="/Client" data-target="dashboard" class="sidebar-link2 active flex items-center px-4 py-3 text-base font-medium rounded-md transition-colors">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Tableau de bord
                    </a>
                    <a href="/MesReservation" data-target="allRes" class="sidebar-link2 flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        Mes réservations
                    </a>
                    <a href="/EquipementRecommende" data-target="allSim" class="sidebar-link2 flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-heart w-5 mr-3"></i>
                        Équi. recommandés
                    </a>
                    <a href="/AvisRecus" data-target="mes-avis" class="sidebar-link2 flex items-center px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-star w-5 mr-3"></i>
                        Avis reçus
                    </a>
                    
                </nav>
                <div class="mt-28">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-300">
                            <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        <div id="mobile-sidebar-overlay" class="md:hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden"></div>
        <div class="md:hidden fixed bottom-4 right-4 z-50">
            <button id="mobile-sidebar-toggle" class="w-14 h-14 rounded-full bg-forest text-white shadow-lg flex items-center justify-center">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <div id="mobile-sidebar" class="md:hidden fixed inset-y-0 left-0 transform -translate-x-full w-64 bg-white dark:bg-gray-800 shadow-xl z-50 transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Mon compte</h2>
                    <button id="close-mobile-sidebar" class="text-gray-600 dark:text-gray-400 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="mb-6 px-3 flex flex-col items-center">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" 
                             alt="Fatima Benali" 
                             class="w-20 h-20 rounded-full border-4 border-forest dark:border-meadow object-cover" />
                        <div class="absolute bottom-1 right-1 bg-green-500 p-1 rounded-full border-2 border-white dark:border-gray-800">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mt-3">{{$user->username}}</h2>
                </div>
            </div>
        </div>
    </div>

    <script>
   
    function setActiveSidebarLink() {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('.sidebar-link2');
        
        sidebarLinks.forEach(link => {
            // Remove 'active' class from all links first
            link.classList.remove('active');
            
            // Check if the link's href matches the current path
            const linkPath = link.getAttribute('href');
            if (currentPath === linkPath || 
                (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                link.classList.add('active');
            }
        });
    }
    document.addEventListener('DOMContentLoaded', setActiveSidebarLink);

// Mobile menu toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});


// User dropdown toggle
const userMenuButton = document.getElementById('user-menu-button');
const userDropdown = document.getElementById('user-dropdown');

userMenuButton?.addEventListener('click', () => {
    userDropdown.classList.toggle('hidden');
});

// Notifications dropdown toggle
const notificationsButton = document.getElementById('notifications-button');
const notificationsDropdown = document.getElementById('notifications-dropdown');

notificationsButton?.addEventListener('click', () => {
    notificationsDropdown.classList.toggle('hidden');
});

// Messages dropdown toggle
const messagesButton = document.getElementById('messages-button');
const messagesDropdown = document.getElementById('messages-dropdown');

messagesButton?.addEventListener('click', () => {
    messagesDropdown.classList.toggle('hidden');
});

// Hide dropdowns when clicking outside
document.addEventListener('click', (e) => {
    // User dropdown
    if (userMenuButton && !userMenuButton.contains(e.target) && userDropdown && !userDropdown.contains(e.target)) {
        userDropdown.classList.add('hidden');
    }
    
    // Notifications dropdown
    if (notificationsButton && !notificationsButton.contains(e.target) && notificationsDropdown && !notificationsDropdown.contains(e.target)) {
        notificationsDropdown.classList.add('hidden');
    }
    
    // Messages dropdown
    if (messagesButton && !messagesButton.contains(e.target) && messagesDropdown && !messagesDropdown.contains(e.target)) {
        messagesDropdown.classList.add('hidden');
    }
});
         
document.addEventListener('DOMContentLoaded', function() {
    const openModalBtn = document.getElementById('openPartnerModalBtn');
    const partnerModal = document.getElementById('partnerAcceptModal');
    if (openModalBtn && partnerModal) {
        const closeModalBtn = document.getElementById('closePartnerModalBtn');
        const cancelModalBtn = document.getElementById('cancelPartnerModalBtn');
        const openModal = () => {
            partnerModal.classList.remove('hidden');
            partnerModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        };
        const closeModal = () => {
            partnerModal.classList.add('hidden');
            partnerModal.classList.remove('flex');
            document.body.style.overflow = '';
        };
        openModalBtn.addEventListener('click', (event) => {
            event.preventDefault();
            openModal();
        });
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }
        if (cancelModalBtn) {
            cancelModalBtn.addEventListener('click', closeModal);
        }
        partnerModal.addEventListener('click', (event) => {
            if (event.target === partnerModal) {
                closeModal();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !partnerModal.classList.contains('hidden')) {
                closeModal();
            }
        });
    }
});

    const notificationsClientIconLink = document.getElementById('notifications-client-icon-link');

    if (notificationsClientIconLink) {
        notificationsClientIconLink.addEventListener('click', function(event) {
            const badge = document.getElementById('notification-badge-count');
            const unreadCount = badge ? parseInt(badge.textContent) : 0;
            const markReadUrl = this.dataset.markReadUrl;

            if (unreadCount > 0 && markReadUrl) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF token not found! Assurez-vous que la balise meta csrf-token est présente dans votre <head>.');
                    return;
                }

                fetch(markReadUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        console.error('Erreur HTTP:', response.status, response.statusText);
                        return response.json().then(errData => {
                            throw new Error(errData.message || `Erreur ${response.status} lors du marquage.`);
                        }).catch(() => {
                            throw new Error(`Erreur ${response.status} lors du marquage.`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message && data.message.toLowerCase().includes('notifications client marquées comme lues')) {
                        console.log((data.updated_count || 0) + ' notifications client marquées comme lues.');
                        if (badge) {
                            badge.style.display = 'none';
                        }
                    } else {
                        console.warn('Problème marquage (réponse serveur):', data.message || data);
                    }
                })
                .catch(error => {
                    console.error('Erreur fetch/traitement:', error);
                });
            }
        });
    }
</script>
