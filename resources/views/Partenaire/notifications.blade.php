<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notifications - CampShare | Louez du matériel de camping entre particuliers</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Navigation hover effects */
        .nav-link { position: relative; transition: all 0.3s ease; }
        .nav-link::after { content: ''; position: absolute; width: 0; height: 2px; bottom: -4px; left: 0; background-color: currentColor; transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
        /* Active link style */
        .active-nav-link { position: relative; }
        .active-nav-link::after { content: ''; position: absolute; width: 100%; height: 2px; bottom: -4px; left: 0; background-color: #FFAA33; }
        /* Custom checkbox */
        .custom-checkbox { position: relative; padding-left: 30px; cursor: pointer; display: inline-block; line-height: 20px; }
        .custom-checkbox input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
        .checkmark { position: absolute; top: 0; left: 0; height: 20px; width: 20px; background-color: #eee; border-radius: 4px; transition: all 0.3s ease; }
        .dark .checkmark { background-color: #374151; }
        .custom-checkbox:hover input ~ .checkmark { background-color: #ccc; }
        .dark .custom-checkbox:hover input ~ .checkmark { background-color: #4B5563; }
        .custom-checkbox input:checked ~ .checkmark { background-color: #2D5F2B; } /* forest */
        .dark .custom-checkbox input:checked ~ .checkmark { background-color: #4F7942; } /* meadow */
        .checkmark:after { content: ""; position: absolute; display: none; }
        .custom-checkbox input:checked ~ .checkmark:after { display: block; }
        .custom-checkbox .checkmark:after { left: 8px; top: 4px; width: 5px; height: 10px; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg); }
        /* Notification badge */
        .notification-badge { position: absolute; top: -5px; right: -5px; background-color: #ef4444; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; display: flex; align-items: center; justify-content: center; }
        /* Notification items hover */
        .notification-item { transition: all 0.3s ease-out; } /* Légèrement plus long pour la suppression */
        .notification-item:hover { background-color: rgba(249, 250, 251, 0.8); }
        .dark .notification-item:hover { background-color: rgba(55, 65, 81, 0.3); }
        /* Notification item animation */
        .notification-item.removing { opacity: 0; transform: translateX(-20px); } /* Pour l'animation de suppression */
        /* Indicateur non lu */
         .unread-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #3b82f6; /* Blue-500 */
            margin-left: 8px;
            animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    

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
                        $user = Auth::user();
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
                                    <a id="notifications-partner-icon-link"
                                       href="{{ route('notifications.partner.index') }}"
                                       class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                                        <i class="fas fa-bell"></i>
                                        @if(isset($unreadPartnerNotificationsCountGlobal) && $unreadPartnerNotificationsCountGlobal > 0)
                                            <span id="notification-badge-count" class="absolute -top-1 -right-1 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full">
                                                {{ $unreadPartnerNotificationsCountGlobal }}
                                            </span>
                                        @endif
                                    </a>
                                </div>
                                <div class="relative">
                                    <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                        <img src="{{ asset($user->avatar_url ?? 'images/default-avatar.png') }}"
                                           alt="Avatar de {{ $user->username }}"
                                           class="h-8 w-8 rounded-full object-cover" />
                                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $user->username }}</span>
                                        <i class="fas fa-chevron-down text-sm text-gray-500"></i>
                                    </button>
                                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-[51] border border-gray-200 dark:border-gray-600">
                                        <div class="py-1">
                                            <a href="/profile_partenaire" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                                            </a>
                                            <a href="{{ route('HomeClient') }}" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Espace Client
                                            </a>
                                            <a href="{{ route('HomePartenaie') }}" class="sidebar-link block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-tachometer-alt mr-2 opacity-70"></i> Espace Partenaire
                                            </a>
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
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-3">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img src="{{ asset($user->avatar_url ?? 'images/default-avatar.png') }}"
                                    alt="Avatar de {{ $user->username }}"
                                    class="h-8 w-8 rounded-full object-cover" />
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800 dark:text-white">{{ $user->username }}</div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1 px-2">
                            <a href="/profile_partenaire" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                            </a>
                            <a href="{{ route('HomePartenaie') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                <i class="fas fa-tachometer-alt mr-2 opacity-70"></i> Espace Partenaire
                            </a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                               class="block px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                                <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                            </a>
                            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
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

    <!-- Main content -->
    <main class="flex-1 pt-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header with breadcrumbs -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <nav class="flex mb-3" aria-label="Breadcrumb">
                                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                        <li class="inline-flex items-center">
                                            <a href="{{ route('HomePartenaie') }}" class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">
                                                <i class="fas fa-tachometer-alt mr-2"></i>
                                                Espace Partenaire
                                            </a>
                                        </li>
                                        <li aria-current="page">
                                            <div class="flex items-center">
                                                <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                                                <span class="text-sm font-medium text-gray-500 dark:text-gray-300">Notifications</span>
                                            </div>
                                        </li>
                                    </ol>
                                </nav>
                                {{-- Titre de la page --}}
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Notifications Partenaire</h1>
                                {{-- Description --}}
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Consultez les notifications liées à vos annonces et réservations.</p>
                            </div>

                    <div class="mt-4 md:mt-0 flex space-x-2">
                        <button id="mark-all-read" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-check-double mr-2"></i>
                            Tout marquer comme lu
                        </button>
                        <button id="delete-selected" class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Supprimer sélection
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notifications container -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
                <!-- Filters -->
                <div class="border-b border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center space-x-2">
                            <label class="custom-checkbox text-sm font-medium text-gray-700 dark:text-gray-300">
                                <input type="checkbox" id="select-all">
                                <span class="checkmark"></span>
                                Tout sélectionner
                            </label>

                            <span class="text-gray-400 dark:text-gray-500 mx-1">|</span>

                            <div id="notification-counter" class="text-sm text-gray-600 dark:text-gray-400">
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <label for="filter-select" class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Filtrer par</label>
                            <select id="filter-select" class="py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow">
                                <option value="all">Toutes</option>
                                <option value="unread">Non lues</option>

                                <option value="review_client">Avis Client</option>
                        
                            </select>

                            <label for="sort-select" class="text-sm font-medium text-gray-700 dark:text-gray-300 ml-4 mr-2">Trier par</label>
                            <select id="sort-select" class="py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow">
                                <option value="newest">Plus récentes</option>
                                <option value="oldest">Plus anciennes</option>
                                <option value="important">Non lues d'abord</option> {{-- Renommé pour clarté --}}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[600px] overflow-y-auto" id="notifications-list">
                     {{-- Boucle sur les notifications passées par le contrôleur --}}
                    @forelse ($notifications as $notification)
                        @php
                            $isReviewNotification = in_array($notification->type, ['review_object', 'review_partner', 'review_client']);
                            $reviewUrl = null;
                            if ($isReviewNotification && $notification->reservation_id) {
                                // Génère l'URL vers le formulaire d'évaluation
                                $reviewUrl = route('reviews.create', ['reservation' => $notification->reservation_id, 'type' => $notification->type]);
                            }

                            // Définir les classes/textes par défaut
                             $iconClass = 'fa-info-circle'; $bgColorClass = 'bg-gray-100 dark:bg-gray-700'; $textColorClass = 'text-gray-500 dark:text-gray-400';
                            $tagText = 'Système'; $tagBgClass = 'bg-gray-100 dark:bg-gray-700'; $tagTextColorClass = 'text-gray-800 dark:text-gray-300';
                            $titleText = ucfirst(str_replace('_', ' ', $notification->type)); // Titre par défaut

                             // Personnalisation basée sur le type de notification
                            switch ($notification->type) {
                                case 'accepted_reservation':
                                    $iconClass = 'fa-calendar-check'; $bgColorClass = 'bg-green-100 dark:bg-green-800'; $textColorClass = 'text-green-500 dark:text-green-300';
                                    $tagText = 'Réservation'; $tagBgClass = 'bg-green-100 dark:bg-green-800'; $tagTextColorClass = 'text-green-800 dark:text-green-300';
                                    $titleText = 'Réservation Acceptée';
                                    break;
                                case 'rejected_reservation':
                                    $iconClass = 'fa-calendar-times'; $bgColorClass = 'bg-red-100 dark:bg-red-800'; $textColorClass = 'text-red-500 dark:text-red-300';
                                    $tagText = 'Réservation'; $tagBgClass = 'bg-red-100 dark:bg-red-800'; $tagTextColorClass = 'text-red-800 dark:text-red-300';
                                     $titleText = 'Réservation Refusée';
                                    break;
                                case 'added_listing':
                                case 'updated_listing':
                                    $iconClass = 'fa-bullhorn'; $bgColorClass = 'bg-indigo-100 dark:bg-indigo-800'; $textColorClass = 'text-indigo-500 dark:text-indigo-300';
                                    $tagText = 'Annonce'; $tagBgClass = 'bg-indigo-100 dark:bg-indigo-800'; $tagTextColorClass = 'text-indigo-800 dark:text-indigo-300';
                                    $titleText = ($notification->type === 'added_listing') ? 'Nouvelle Annonce' : 'Annonce Mise à Jour';
                                    break;
                                case 'review_object':
                                case 'review_partner':
                                case 'review_client':
                                    $iconClass = 'fa-star'; $bgColorClass = 'bg-yellow-100 dark:bg-yellow-800'; $textColorClass = 'text-yellow-500 dark:text-yellow-300';
                                    $tagText = 'Évaluation'; $tagBgClass = 'bg-yellow-100 dark:bg-yellow-800'; $tagTextColorClass = 'text-yellow-800 dark:text-yellow-300';
                                    $titleText = 'Demande d\'évaluation';
                                     break;
                            }
                        @endphp

                        <div class="notification-item flex p-5 {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}"
                             data-type="{{ $notification->type }}"
                             data-read="{{ $notification->is_read ? 'true' : 'false' }}"
                             data-date="{{ $notification->created_at->toIso8601String() }}"
                             data-id="{{ $notification->id }}"> {{-- ID de la notif pour JS --}}

                            <div class="flex-shrink-0 self-start pt-1">
                                <label class="custom-checkbox">
                                    {{-- Valeur de la checkbox est l'ID de la notif --}}
                                    <input type="checkbox" class="notification-checkbox" value="{{ $notification->id }}">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="flex flex-1 ml-3">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 rounded-full {{ $bgColorClass }} flex items-center justify-center {{ $textColorClass }}">
                                        <i class="fas {{ $iconClass }}"></i>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-1">
                                        <h3 class="font-medium text-gray-900 dark:text-white flex items-center">
                                            {{ $titleText }}
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $tagBgClass }} {{ $tagTextColorClass }}">
                                                {{ $tagText }}
                                            </span>
                                             {{-- Indicateur visuel si non lue --}}
                                            @if(!$notification->is_read)
                                                <span class="unread-indicator" title="Non lue"></span>
                                            @endif
                                        </h3>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>

                                    <p class="text-gray-600 dark:text-gray-300">
                                        {{ $notification->message }}
                                    </p>

                                    <div class="mt-3 flex items-center flex-wrap gap-x-4 gap-y-1">
                                         {{-- Afficher le bouton d'évaluation SEULEMENT si c'est le bon type, non lu, et qu'on a l'URL --}}
                                        @if ($isReviewNotification && !$notification->is_read && $reviewUrl)
                                            <a href="{{ $reviewUrl }}" class="text-sm text-forest dark:text-meadow hover:underline font-semibold">
                                                <i class="fas fa-pen-alt mr-1"></i> Laisser une évaluation
                                            </a>
                                        {{-- Sinon, afficher un lien vers l'annonce si disponible et si ce n'est pas une notif d'évaluation --}}
                                        @elseif (!$isReviewNotification && $notification->listing_id)
                                             <a href="{{-- route('client.listings.show', ['listing' => $notification->listing_id]) --}}#" class="text-sm text-forest dark:text-meadow hover:underline">
                                                <i class="fas fa-eye mr-1"></i> Voir l'annonce
                                            </a>
                                        @endif

                                        {{-- Actions communes : Marquer comme lu (si non lue) et Supprimer --}}
                                        @if (!$notification->is_read)
                                            <button data-action="mark-read" data-id="{{ $notification->id }}" data-user-id="{{ Auth::id() }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                                <i class="fas fa-check mr-1"></i> Marquer comme lu
                                            </button>
                                        @endif
                                        <button data-action="delete" data-id="{{ $notification->id }}" data-user-id="{{ Auth::id() }}" class="text-sm text-red-600 dark:text-red-400 hover:underline ml-auto">
                                            <i class="fas fa-trash mr-1"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                            Vous n'avez aucune notification pour le moment.
                        </div>
                    @endforelse
                </div>

                 @if ($notifications instanceof \Illuminate\Pagination\LengthAwarePaginator && $notifications->hasPages())
                    <div class="px-5 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                         {{ $notifications->links() }} 
                    </div>
                 @endif
            </div>
        </div>
    </main>

    {{-- Inclusion de ton footer --}}
    {{-- @include('partials.footer') --}}

   {{-- ... Tout votre HTML pour la page Partenaire/notifications.blade.php ... --}}
{{-- Assurez-vous d'avoir la meta CSRF dans votre <head> ou dans votre layout principal --}}
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('Token CSRF introuvable. Assurez-vous que la balise meta csrf-token est présente.');
    }

    const notificationsListContainer = document.getElementById('notifications-list');
    const selectAllCheckbox = document.getElementById('select-all');
    const markAllReadButton = document.getElementById('mark-all-read'); // ID de votre bouton
    const deleteSelectedButton = document.getElementById('delete-selected'); // ID de votre bouton
    const filterSelect = document.getElementById('filter-select');
    const sortSelect = document.getElementById('sort-select');
    const notificationCounterElement = document.getElementById('notification-counter');
    // **MODIFICATION POTENTIELLE ICI** : Vérifiez ce sélecteur pour le header PARTENAIRE
    // Si l'ID de l'élément qui contient la cloche est '#notifications-partner-icon-link' (par exemple) :
    // const headerBadge = document.querySelector('#notifications-partner-icon-link .notification-badge');
    // Si la structure est la même que pour le client (ID "notifications-button" sur le bouton/lien parent de la cloche) :
    const headerBadge = document.querySelector('#notifications-button .notification-badge');


    // --- Fonction pour mettre à jour les compteurs ET l'état des boutons ---
    function updateUIStates() {
        if (!notificationsListContainer) return;
        const allItems = Array.from(notificationsListContainer.querySelectorAll('.notification-item'));
        const unreadItems = allItems.filter(item => item.getAttribute('data-read') === 'false');
        const unreadCount = unreadItems.length;
        const totalVisibleCount = allItems.filter(item => item.style.display !== 'none').length;

        if (notificationCounterElement) {
            notificationCounterElement.textContent = `${unreadCount} non lue${unreadCount !== 1 ? 's' : ''} sur ${totalVisibleCount} affichée${totalVisibleCount !== 1 ? 's' : ''}`;
        }
        if (headerBadge) {
            headerBadge.textContent = unreadCount;
            headerBadge.style.display = unreadCount > 0 ? 'flex' : 'none';
        }
        if (markAllReadButton) {
            markAllReadButton.disabled = (unreadCount === 0);
        }
        if (deleteSelectedButton) {
            const anyChecked = Array.from(notificationsListContainer.querySelectorAll('.notification-checkbox:checked')).length > 0;
            deleteSelectedButton.disabled = !anyChecked;
        }
        if (selectAllCheckbox && allItems.length > 0) {
            const allVisibleCheckboxes = allItems.filter(item => item.style.display !== 'none')
                                             .map(item => item.querySelector('.notification-checkbox'))
                                             .filter(cb => cb);
            const allVisibleChecked = allVisibleCheckboxes.length > 0 && allVisibleCheckboxes.every(cb => cb.checked);
            selectAllCheckbox.checked = allVisibleChecked;
        } else if (selectAllCheckbox) {
            selectAllCheckbox.checked = false;
        }
        if (allItems.filter(item => item.style.display !== 'none').length === 0 && totalVisibleCount === 0 && notificationsListContainer.children.length > 0 && notificationsListContainer.firstChild?.nodeName !== 'DIV') {
            notificationsListContainer.innerHTML = '<div class="p-6 text-center text-gray-500 dark:text-gray-400">Aucune notification ne correspond à vos filtres.</div>';
        } else if (allItems.length === 0 && notificationsListContainer.firstChild?.nodeName !== 'DIV') {
            notificationsListContainer.innerHTML = '<div class="p-6 text-center text-gray-500 dark:text-gray-400">Vous n\'avez plus de notifications.</div>';
        }
    }

    // --- Fonction générique pour les requêtes AJAX (identique à celle du client) ---
    async function sendRequest(url, method, data = null) {
        const options = {
            method: method.toUpperCase(),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        };
        if (data && (method.toUpperCase() === 'POST' || method.toUpperCase() === 'PUT' || method.toUpperCase() === 'PATCH')) {
            options.body = JSON.stringify(data);
        }
        try {
            const response = await fetch(url, options);
            if (!response.ok && response.status !== 204) {
                const errorData = await response.json().catch(() => ({ message: `Erreur HTTP ${response.status}` }));
                console.error(`Failed request to ${url}:`, response.status, errorData.message);
                throw new Error(errorData.message || `Erreur HTTP ${response.status}`);
            }
            if (response.status !== 204) {
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return await response.json();
                }
            }
            return { message: 'Opération réussie.' };
        } catch (error) {
            console.error(`Error during request to ${url}:`, error);
            throw error;
        }
    }

    // --- Gestion des actions sur les notifications individuelles (identique, les data-url sur les boutons HTML doivent être corrects) ---
    notificationsListContainer?.addEventListener('click', async (event) => {
        const button = event.target.closest('button[data-action]');
        if (!button) return;
        const action = button.getAttribute('data-action');
        const notificationId = button.getAttribute('data-id');
        const userId = button.getAttribute('data-user-id');
        const notificationItem = button.closest('.notification-item');

        if (!notificationId || !userId) {
            console.error("ID de notification ou d'utilisateur manquant sur le bouton.");
            alert("Une erreur s'est produite (ID manquant).");
            return;
        }
        const originalButtonContent = button.innerHTML;
        button.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
        button.disabled = true;

        if (action === 'mark-read') {
            try {
                // Les routes /notifications/{id}/mark-read/{user} sont génériques
                const data = await sendRequest(`/notifications/${notificationId}/mark-read/${userId}`, 'POST');
                console.log(data.message);
                if (data.message.toLowerCase().includes('marquée comme lue') || data.message.toLowerCase().includes('déjà marquée')) {
                    notificationItem.setAttribute('data-read', 'true');
                    notificationItem.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                    notificationItem.querySelector('.unread-indicator')?.remove();
                    button.remove();
                    updateUIStates();
                } else { throw new Error(data.message || "Réponse inattendue."); }
            } catch (error) {
                alert(`Erreur marquage: ${error.message}`);
                button.innerHTML = originalButtonContent; button.disabled = false;
            }
        } else if (action === 'delete') {
            if (!confirm('Supprimer cette notification ?')) {
                button.innerHTML = originalButtonContent; button.disabled = false; return;
            }
            try {
                const data = await sendRequest(`/notifications/${notificationId}/delete/${userId}`, 'DELETE');
                console.log(data.message || 'Notification supprimée.');
                notificationItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease, max-height 0.3s ease, padding 0.3s ease, margin 0.3s ease, border 0.3s ease';
                notificationItem.style.opacity = '0';
                notificationItem.style.transform = 'scale(0.95)';
                notificationItem.style.maxHeight = '0px';
                notificationItem.style.paddingTop = '0px';
                notificationItem.style.paddingBottom = '0px';
                notificationItem.style.marginTop = '0px';
                notificationItem.style.marginBottom = '0px';
                notificationItem.style.borderWidth = '0px';
                setTimeout(() => { notificationItem.remove(); updateUIStates(); }, 300);
            } catch (error) {
                alert(`Erreur suppression: ${error.message}`);
                button.innerHTML = originalButtonContent; button.disabled = false;
            }
        } else {
            button.innerHTML = originalButtonContent; button.disabled = false;
        }
    });

    // --- Gestion de "Tout sélectionner" (identique) ---
    selectAllCheckbox?.addEventListener('change', (event) => {
        if (!notificationsListContainer) return;
        notificationsListContainer.querySelectorAll('.notification-item').forEach(item => {
            if (item.style.display !== 'none') {
                const cb = item.querySelector('.notification-checkbox');
                if (cb) cb.checked = event.target.checked;
            }
        });
        updateUIStates();
    });
    notificationsListContainer?.addEventListener('change', (event) => {
        if (event.target.classList.contains('notification-checkbox')) {
            updateUIStates();
        }
    });

    // --- "Marquer tout comme lu" (PARTENAIRE) ---
    markAllReadButton?.addEventListener('click', async function() {
        if (!notificationsListContainer) return;
        const unreadVisibleItems = Array.from(notificationsListContainer.querySelectorAll('.notification-item:not([data-read="true"])'))
                                      .filter(item => item.style.display !== 'none');
        if (unreadVisibleItems.length === 0) {
            alert('Toutes les notifications visibles sont déjà lues.'); return;
        }
        const originalButtonText = this.innerHTML;
        this.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Traitement...`;
        this.disabled = true;
        try {
            // **MODIFICATION ICI**: Utilisation de la route PARTENAIRE
            const data = await sendRequest('{{ route("notifications.partner.markAllVisibleAsRead") }}', 'POST');
            console.log(data.message, `Serveur maj: ${data.updated_count}`);
            if (data.message.toLowerCase().includes('marquées comme lues')) { // Ou vérifier data.updated_count
                notificationsListContainer.querySelectorAll('.notification-item:not([data-read="true"])').forEach(item => {
                    item.setAttribute('data-read', 'true');
                    item.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                    item.querySelector('.unread-indicator')?.remove();
                    item.querySelector('button[data-action="mark-read"]')?.remove();
                });
                updateUIStates();
                alert(data.message || `${data.updated_count || 0} notification(s) marquée(s) comme lue(s).`);
            } else { throw new Error(data.message || "Réponse inattendue."); }
        } catch (error) {
            alert(`Erreur: ${error.message}`);
        } finally {
            this.innerHTML = originalButtonText;
            updateUIStates();
        }
    });

    // --- "Supprimer la sélection" (PARTENAIRE) ---
    deleteSelectedButton?.addEventListener('click', async function() {
        if (!notificationsListContainer) return;
        const selectedCheckboxes = notificationsListContainer.querySelectorAll('.notification-checkbox:checked');
        const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value).filter(id => id);
        if (selectedIds.length === 0) {
            alert('Sélectionnez des notifications à supprimer.'); return;
        }
        if (!confirm(`Supprimer les ${selectedIds.length} notification(s) sélectionnée(s) ?`)) return;
        const originalButtonText = this.innerHTML;
        this.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Suppression...`;
        this.disabled = true;
        try {
            // **MODIFICATION ICI**: Utilisation de la route PARTENAIRE
            const data = await sendRequest('{{ route("notifications.partner.deleteSelected") }}', 'POST', { ids: selectedIds });
            console.log(data.message, `Serveur suppr: ${data.deleted_count}`);
             if (data.message.toLowerCase().includes('supprimées')) { // Ou vérifier data.deleted_count
                selectedCheckboxes.forEach(cb => {
                    const item = cb.closest('.notification-item');
                    if (item) {
                        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease, max-height 0.3s ease, padding 0.3s ease, margin 0.3s ease, border 0.3s ease';
                        item.style.opacity = '0'; item.style.transform = 'scale(0.95)'; item.style.maxHeight = '0px';
                        item.style.paddingTop = '0px'; item.style.paddingBottom = '0px'; item.style.marginTop = '0px';
                        item.style.marginBottom = '0px'; item.style.borderWidth = '0px';
                        setTimeout(() => item.remove(), 300);
                    }
                });
                setTimeout(() => {
                    updateUIStates();
                    alert(data.message || `${data.deleted_count || 0} notification(s) supprimée(s).`);
                }, 350);
            } else { throw new Error(data.message || "Réponse inattendue."); }
        } catch (error) {
            alert(`Erreur: ${error.message}`);
        } finally {
            this.innerHTML = originalButtonText;
            if (selectAllCheckbox) selectAllCheckbox.checked = false;
            updateUIStates();
        }
    });

    // --- Filtrage et Tri (identique) ---
    filterSelect?.addEventListener('change', applyFiltersAndSort);
    sortSelect?.addEventListener('change', applyFiltersAndSort);

    function applyFiltersAndSort() {
        if (!notificationsListContainer) return;
        const filterValue = filterSelect?.value || 'all';
        const sortValue = sortSelect?.value || 'newest';
        const allItems = Array.from(notificationsListContainer.querySelectorAll('.notification-item'));
        const noNotifMessage = notificationsListContainer.querySelector('div.text-center');
        if (noNotifMessage && noNotifMessage.textContent.includes("Aucune notification")) noNotifMessage.style.display = 'none';

        allItems.forEach(item => {
            const type = item.getAttribute('data-type');
            const isRead = item.getAttribute('data-read') === 'true';
            let show = false;
            if (filterValue === 'all') show = true;
            else if (filterValue === 'unread') show = !isRead;
            else show = (type === filterValue);
            item.style.display = show ? 'flex' : 'none';
        });
        const visibleItems = allItems.filter(item => item.style.display !== 'none');
        visibleItems.sort((a, b) => {
            const dateA = new Date(a.getAttribute('data-date'));
            const dateB = new Date(b.getAttribute('data-date'));
            const readA = a.getAttribute('data-read') === 'true';
            const readB = b.getAttribute('data-read') === 'true';
            if (sortValue === 'oldest') return dateA - dateB;
            if (sortValue === 'important') {
                if (readA !== readB) return readA ? 1 : -1;
                return dateB - dateA;
            }
            return dateB - dateA;
        });
        visibleItems.forEach(item => notificationsListContainer.appendChild(item));
        updateUIStates();
    }

    // Initialisation
    if (notificationsListContainer?.children.length > 0 && notificationsListContainer.firstChild?.nodeName !== 'DIV') {
        applyFiltersAndSort();
    }
    updateUIStates();
    if (deleteSelectedButton) { deleteSelectedButton.disabled = true; }

    // User dropdown toggle
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');

    userMenuButton?.addEventListener('click', () => {
        userDropdown.classList.toggle('hidden');
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (userMenuButton && !userMenuButton.contains(e.target) && userDropdown && !userDropdown.contains(e.target)) {
            userDropdown.classList.add('hidden');
        }
    });
});
</script>

</body>
</html>