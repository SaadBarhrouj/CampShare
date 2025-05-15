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
    

    @include('partials.header', ['user' => Auth::user()])
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
                                    <a href="{{ route('HomeClient') }}" class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">
                                        <i class="fas fa-tachometer-alt mr-2"></i>
                                        Tableau de Bord Client
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
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Mes Notifications</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Consultez vos notifications liées à vos réservations et aux annonces.</p>
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
                                <option value="review_object">Avis Objet</option>
                                <option value="review_partner">Avis Partenaire</option>
                                <option value="accepted_reservation">Résa. Acceptée</option>
                                <option value="rejected_reservation">Résa. Refusée</option>
                                <option value="added_listing">Annonce Ajoutée</option>
                                <option value="updated_listing">Annonce MàJ</option>
                            </select>

                            <label for="sort-select" class="text-sm font-medium text-gray-700 dark:text-gray-300 ml-4 mr-2">Trier par</label>
                            <select id="sort-select" class="py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow focus:border-forest dark:focus:border-meadow">
                                <option value="newest">Plus récentes</option>
                                <option value="oldest">Plus anciennes</option>
                                <option value="important">Non lues d'abord</option> 
                            </select>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[600px] overflow-y-auto" id="notifications-list">
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
                                                  <a href="{{ route('client.listings.show', ['listing' => $notification->listing_id]) }}" class="text-sm text-forest dark:text-meadow hover:underline">
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('Token CSRF introuvable. Assurez-vous que la balise meta csrf-token est présente.');
        }

        const notificationsListContainer = document.getElementById('notifications-list');
        const selectAllCheckbox = document.getElementById('select-all');
        const markAllReadButton = document.getElementById('mark-all-read');
        const deleteSelectedButton = document.getElementById('delete-selected');
        const filterSelect = document.getElementById('filter-select');
        const sortSelect = document.getElementById('sort-select');
        const notificationCounterElement = document.getElementById('notification-counter');
        // **IMPORTANT**: Assurez-vous que ce sélecteur est correct pour VOTRE header client
        const headerBadge = document.querySelector('#notifications-client-icon-link .notification-badge'); 

        // --- Fonction pour mettre à jour les compteurs ET l'état des boutons ---
        function updateUIStates() { // Renommée pour plus de clarté
            if (!notificationsListContainer) return;

            const allItems = notificationsListContainer.querySelectorAll('.notification-item');
            const unreadItems = notificationsListContainer.querySelectorAll('.notification-item:not([data-read="true"])');
            const unreadCount = unreadItems.length;
            // Compte les éléments visibles après filtrage
            const totalVisibleCount = Array.from(allItems).filter(item => item.style.display !== 'none').length;


            if (notificationCounterElement) {
                // Texte plus informatif pour le compteur local
                notificationCounterElement.textContent = `${unreadCount} non lue${unreadCount !== 1 ? 's' : ''} sur ${totalVisibleCount} affichée${totalVisibleCount !== 1 ? 's' : ''}`;
            }
            if (headerBadge) {
                // Le badge global doit refléter le nombre total de non-lues pour l'utilisateur,
                // pas seulement celles sur la page actuelle. Pour une mise à jour précise ici,
                // il faudrait un appel AJAX séparé ou une info du serveur.
                // Pour l'instant, on met à jour avec le compte de la page, ce qui est une approximation.
                // Si vous avez des pages de notifications, ce badge ne sera précis que pour la page 1.
                headerBadge.textContent = unreadCount; // Simplicité pour l'instant
                headerBadge.style.display = unreadCount > 0 ? 'flex' : 'none';
            }

            // Mettre à jour l'état des boutons
            if (markAllReadButton) {
                markAllReadButton.disabled = (unreadCount === 0);
            }
            if (deleteSelectedButton) {
                const anyChecked = Array.from(notificationsListContainer.querySelectorAll('.notification-checkbox:checked')).length > 0;
                deleteSelectedButton.disabled = !anyChecked;
            }

            // Mettre à jour l'état de la checkbox "Tout sélectionner"
            if (selectAllCheckbox && allItems.length > 0) {
                const allVisibleCheckboxes = Array.from(notificationsListContainer.querySelectorAll('.notification-checkbox'))
                                                .filter(cb => cb.closest('.notification-item').style.display !== 'none');
                const allVisibleChecked = allVisibleCheckboxes.every(cb => cb.checked);
                selectAllCheckbox.checked = allVisibleCheckboxes.length > 0 && allVisibleChecked;
            } else if (selectAllCheckbox) {
                selectAllCheckbox.checked = false; // Si pas d'items, décocher
            }
            
            // Afficher message si la liste est vide
            if (allItems.length === 0 && notificationsListContainer.firstChild?.nodeName !== 'DIV') {
                notificationsListContainer.innerHTML = '<div class="p-6 text-center text-gray-500 dark:text-gray-400">Vous n\'avez plus de notifications.</div>';
            }
        }

        // --- Fonction générique pour les requêtes AJAX (votre version existante) ---
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

        // --- Gestion des actions sur les notifications individuelles (votre version existante, avec spinner et restauration du texte) ---
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
                    const data = await sendRequest(`/notifications/${notificationId}/mark-read/${userId}`, 'POST');
                    console.log(data.message);
                    if (data.message.toLowerCase().includes('marquée comme lue') || data.message.toLowerCase().includes('déjà marquée')) {
                        notificationItem.setAttribute('data-read', 'true');
                        notificationItem.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                        notificationItem.querySelector('.unread-indicator')?.remove();
                        button.remove(); // Enlève le bouton "Marquer comme lu"
                        updateUIStates(); // Mise à jour des compteurs et états
                    } else {
                        throw new Error(data.message || "Réponse inattendue du serveur.");
                    }
                } catch (error) {
                    alert(`Erreur lors du marquage: ${error.message}`);
                    button.innerHTML = originalButtonContent;
                    button.disabled = false;
                }
            } else if (action === 'delete') {
                if (!confirm('Voulez-vous vraiment supprimer cette notification ?')) {
                    button.innerHTML = originalButtonContent;
                    button.disabled = false;
                    return;
                }
                try {
                    const data = await sendRequest(`/notifications/${notificationId}/delete/${userId}`, 'DELETE');
                    console.log(data.message || 'Notification supprimée.');
                    // Animation de suppression (votre classe 'removing' + setTimeout)
                    notificationItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease, max-height 0.3s ease, padding 0.3s ease, margin 0.3s ease, border 0.3s ease';
                    notificationItem.style.opacity = '0';
                    notificationItem.style.transform = 'scale(0.95)';
                    notificationItem.style.maxHeight = '0px';
                    notificationItem.style.paddingTop = '0px';
                    notificationItem.style.paddingBottom = '0px';
                    notificationItem.style.marginTop = '0px';
                    notificationItem.style.marginBottom = '0px';
                    notificationItem.style.borderWidth = '0px';
                    setTimeout(() => {
                        notificationItem.remove();
                        updateUIStates();
                    }, 300);
                } catch (error) {
                    alert(`Erreur lors de la suppression: ${error.message}`);
                    button.innerHTML = originalButtonContent;
                    button.disabled = false;
                }
            } else {
                button.innerHTML = originalButtonContent;
                button.disabled = false;
            }
        });

        // --- Gestion de "Tout sélectionner" (votre version, avec mise à jour de l'état du bouton delete) ---
        selectAllCheckbox?.addEventListener('change', (event) => {
            if (!notificationsListContainer) return;
            // Coche/décoche seulement les checkboxes des notifications actuellement visibles
            notificationsListContainer.querySelectorAll('.notification-item').forEach(item => {
                if (item.style.display !== 'none') { // 'flex' si vous utilisez flex, ou vérifiez la classe 'hidden'
                    const cb = item.querySelector('.notification-checkbox');
                    if (cb) cb.checked = event.target.checked;
                }
            });
            updateUIStates(); // Met à jour l'état du bouton "Supprimer sélection" et le reste
        });
        // Écouteur pour les changements sur les checkboxes individuelles
        notificationsListContainer?.addEventListener('change', (event) => {
            if (event.target.classList.contains('notification-checkbox')) {
                updateUIStates(); // Met à jour "Tout sélectionner" et le bouton "Supprimer"
            }
        });


        // --- REMPLACEMENT DU BLOC "Marquer tout comme lu" ---
        markAllReadButton?.addEventListener('click', async function() {
            if (!notificationsListContainer) return;
            // Cible les notifications non lues *actuellement visibles* sur la page
            const unreadVisibleItems = Array.from(notificationsListContainer.querySelectorAll('.notification-item:not([data-read="true"])'))
                                          .filter(item => item.style.display !== 'none');

            if (unreadVisibleItems.length === 0) {
                alert('Toutes les notifications visibles sont déjà lues.');
                return;
            }

            const originalButtonText = this.innerHTML;
            this.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Traitement...`;
            this.disabled = true;

            try {
                // URL pour marquer toutes les notifications CLIENT comme lues
                const data = await sendRequest('{{ route("notifications.client.markAllVisibleAsRead") }}', 'POST');
                console.log(data.message, `Mis à jour par le serveur: ${data.updated_count}`);

                // Mettre à jour l'UI pour les éléments qui étaient non lus sur la page
                unreadVisibleItems.forEach(item => {
                    item.setAttribute('data-read', 'true');
                    item.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                    item.querySelector('.unread-indicator')?.remove();
                    item.querySelector('button[data-action="mark-read"]')?.remove();
                });
                updateUIStates(); // Crucial pour mettre à jour les compteurs et états
                alert(data.message || `${data.updated_count || 0} notification(s) marquée(s) comme lue(s).`);

            } catch (error) {
                alert(`Erreur: ${error.message}`);
            } finally {
                this.innerHTML = originalButtonText;
                // L'état 'disabled' sera géré par updateUIStates()
                updateUIStates();
            }
        });

        // --- REMPLACEMENT DU BLOC "Supprimer la sélection" ---
        deleteSelectedButton?.addEventListener('click', async function() {
            if (!notificationsListContainer) return;
            const selectedCheckboxes = notificationsListContainer.querySelectorAll('.notification-checkbox:checked');
            const selectedIds = Array.from(selectedCheckboxes)
                                   .map(cb => cb.value)
                                   .filter(id => id); // Filtre les valeurs vides si besoin

            if (selectedIds.length === 0) {
                alert('Veuillez sélectionner au moins une notification à supprimer.');
                return;
            }
            if (!confirm(`Voulez-vous vraiment supprimer les ${selectedIds.length} notification(s) sélectionnée(s) ?`)) {
                return;
            }

            const originalButtonText = this.innerHTML;
            this.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Suppression...`;
            this.disabled = true;

            try {
                // URL pour supprimer les notifications CLIENT sélectionnées
                const data = await sendRequest('{{ route("notifications.client.deleteSelected") }}', 'POST', { ids: selectedIds });
                console.log(data.message, `Supprimées par le serveur: ${data.deleted_count}`);

                selectedCheckboxes.forEach(cb => {
                    const item = cb.closest('.notification-item');
                    if (item) {
                        // Appliquer l'animation de suppression
                        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease, max-height 0.3s ease, padding 0.3s ease, margin 0.3s ease, border 0.3s ease';
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.95)';
                        item.style.maxHeight = '0px';
                        item.style.paddingTop = '0px';
                        item.style.paddingBottom = '0px';
                        item.style.marginTop = '0px';
                        item.style.marginBottom = '0px';
                        item.style.borderWidth = '0px';
                        setTimeout(() => item.remove(), 300);
                    }
                });

                // Attendre la fin des animations avant de mettre à jour l'UI
                setTimeout(() => {
                    updateUIStates(); // Mettre à jour compteurs et états
                    alert(data.message || `${data.deleted_count || 0} notification(s) supprimée(s).`);
                }, 350); // Légèrement plus long que l'animation

            } catch (error) {
                alert(`Erreur: ${error.message}`);
            } finally {
                this.innerHTML = originalButtonText;
                // L'état 'disabled' sera géré par updateUIStates() car les cases seront décochées
                if (selectAllCheckbox) selectAllCheckbox.checked = false;
                updateUIStates();
            }
        });

        // --- Filtrage et Tri (votre version existante) ---
        filterSelect?.addEventListener('change', applyFiltersAndSort);
        sortSelect?.addEventListener('change', applyFiltersAndSort);

        function applyFiltersAndSort() {
            if (!notificationsListContainer) return;
            const filterValue = filterSelect?.value || 'all';
            const sortValue = sortSelect?.value || 'newest';
            const allItems = Array.from(notificationsListContainer.querySelectorAll('.notification-item'));

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
            updateUIStates(); // Mettre à jour après filtrage/tri
        }

        // Initialiser au chargement
        updateUIStates(); // Appel initial pour définir les états
        if (filterSelect || sortSelect) {
            applyFiltersAndSort(); // Applique les filtres/tris par défaut
        }
         if (deleteSelectedButton) { // S'assurer qu'il est désactivé au début
            deleteSelectedButton.disabled = true;
        }

    }); // Fin de DOMContentLoaded
</script>

</body>
</html>