// Script pour intégrer les données dynamiques dans le tableau de bord partenaire
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les éléments du DOM pour les statistiques
    const statsElements = {
        totalListings: document.querySelector('[data-stat="total-listings"]'),
        totalReservations: document.querySelector('[data-stat="total-reservations"]'),
        averageRating: document.querySelector('[data-stat="average-rating"]'),
        totalRevenue: document.querySelector('[data-stat="total-revenue"]')
    };

    // Récupérer les éléments du DOM pour les conteneurs de données
    const containers = {
        recentActivity: document.querySelector('#recent-activity-container'),
        pendingReservations: document.querySelector('#pending-reservations-container'),
        equipmentList: document.querySelector('#equipment-list-container')
    };

    // Fonction pour formater les dates
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR');
    }

    // Fonction pour calculer le temps écoulé
    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        
        let interval = Math.floor(seconds / 31536000);
        if (interval >= 1) {
            return interval + ' an' + (interval > 1 ? 's' : '');
        }
        
        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) {
            return interval + ' mois';
        }
        
        interval = Math.floor(seconds / 86400);
        if (interval >= 1) {
            return interval + ' jour' + (interval > 1 ? 's' : '');
        }
        
        interval = Math.floor(seconds / 3600);
        if (interval >= 1) {
            return interval + ' heure' + (interval > 1 ? 's' : '');
        }
        
        interval = Math.floor(seconds / 60);
        if (interval >= 1) {
            return interval + ' minute' + (interval > 1 ? 's' : '');
        }
        
        return Math.floor(seconds) + ' seconde' + (Math.floor(seconds) > 1 ? 's' : '');
    }

    // Fonction pour créer un élément d'activité récente
    function createActivityItem(activity) {
        const activityType = activity.type;
        const data = activity.data;
        const createdAt = activity.created_at;
        
        let iconClass = '';
        let title = '';
        let description = '';
        
        if (activityType === 'reservation') {
            iconClass = 'fas fa-calendar-check text-blue-600 dark:text-blue-400';
            title = `Nouvelle réservation de ${data.client?.username || 'Client'}`;
            description = `${data.listing?.title || 'Équipement'} - ${formatDate(data.start_date)} au ${formatDate(data.end_date)}`;
        } else if (activityType === 'review') {
            iconClass = 'fas fa-star text-yellow-600 dark:text-yellow-400';
            title = `Nouvel avis de ${data.reservation?.client?.username || 'Client'}`;
            description = `${data.reservation?.listing?.title || 'Équipement'} - Note: ${data.rating}/5`;
        }
        
        return `
            <div class="px-6 py-4">
                <div class="flex">
                    <div class="flex-shrink-0 mr-4">
                        <div class="h-10 w-10 rounded-full bg-${activityType === 'reservation' ? 'blue' : 'yellow'}-100 dark:bg-${activityType === 'reservation' ? 'blue' : 'yellow'}-900 flex items-center justify-center">
                            <i class="${iconClass}"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${title}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">${description}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Il y a ${timeAgo(createdAt)}</p>
                    </div>
                </div>
            </div>
        `;
    }

    // Fonction pour créer un élément de demande de location
    function createReservationRequestItem(reservation) {
        return `
            <div class="px-6 py-4">
                <div class="flex items-start">
                    <img src="${reservation.client?.avatar_url || 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80'}" 
                         alt="${reservation.client?.username || 'Client'}" 
                         class="w-10 h-10 rounded-full object-cover mr-4" />
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">${reservation.client?.username || 'Client'}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">${reservation.listing?.title || 'Équipement'}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">${formatDate(reservation.start_date)} - ${formatDate(reservation.end_date)}</p>
                            </div>
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">En attente</span>
                        </div>
                        <div class="mt-3 flex space-x-2">
                            <button class="px-3 py-1 bg-forest text-white text-xs font-medium rounded hover:bg-forest/90 dark:bg-meadow dark:hover:bg-meadow/90 transition-colors">Accepter</button>
                            <button class="px-3 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors">Refuser</button>
                            <button class="px-3 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors">Message</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Fonction pour créer un élément d'équipement
    function createEquipmentItem(listing) {
        const statusClass = listing.status === 'active' ? 'green' : (listing.status === 'archived' ? 'amber' : 'gray');
        const statusText = listing.status === 'active' ? 'Actif' : (listing.status === 'archived' ? 'Archivé' : 'Inactif');
        
        return `
            <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img src="${listing.images && listing.images.length > 0 ? listing.images[0].url : 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80'}" 
                         alt="${listing.title}" 
                         class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-${statusClass}-500 text-white text-xs px-2 py-1 rounded-full">${statusText}</span>
                    </div>
                    ${listing.is_premium ? `
                    <div class="absolute top-4 right-4">
                        <span class="bg-sunlight text-white text-xs px-2 py-1 rounded-full">Premium</span>
                    </div>
                    ` : ''}
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">${listing.title}</h3>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-forest dark:text-meadow font-bold">${listing.price_per_day} DH<span class="text-gray-500 dark:text-gray-400 font-normal">/jour</span></p>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-1 text-sm"></i>
                            <span class="text-sm text-gray-500 dark:text-gray-400">${listing.city?.name || 'Ville'}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs font-medium">
                            <i class="fas fa-tag mr-1"></i>
                            ${listing.category?.name || 'Catégorie'}
                        </span>
                        <div class="flex space-x-2">
                            <a href="#edit" class="text-gray-500 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#stats" class="text-gray-500 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">
                                <i class="fas fa-chart-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Fonction pour mettre à jour les statistiques
    function updateStats(data) {
        if (statsElements.totalListings) {
            statsElements.totalListings.textContent = data.totalListings || '0';
        }
        
        if (statsElements.totalReservations) {
            statsElements.totalReservations.textContent = data.totalReservations || '0';
        }
        
        if (statsElements.averageRating) {
            statsElements.averageRating.textContent = (data.averageRating ? data.averageRating.toFixed(1) : '0.0') + '/5';
        }
        
        if (statsElements.totalRevenue) {
            statsElements.totalRevenue.textContent = (data.totalRevenue ? data.totalRevenue.toLocaleString('fr-FR') : '0') + ' DH';
        }
    }

    // Fonction pour mettre à jour l'activité récente
    function updateRecentActivity(activities) {
        if (!containers.recentActivity) return;
        
        if (activities && activities.length > 0) {
            const activityHtml = activities.map(activity => createActivityItem(activity)).join('');
            containers.recentActivity.innerHTML = activityHtml;
        } else {
            containers.recentActivity.innerHTML = `
                <div class="px-6 py-4 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Aucune activité récente</p>
                </div>
            `;
        }
    }

    // Fonction pour mettre à jour les demandes de location
    function updatePendingReservations(reservations) {
        if (!containers.pendingReservations) return;
        
        if (reservations && reservations.length > 0) {
            const reservationsHtml = reservations.map(reservation => createReservationRequestItem(reservation)).join('');
            containers.pendingReservations.innerHTML = reservationsHtml;
        } else {
            containers.pendingReservations.innerHTML = `
                <div class="px-6 py-4 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Aucune demande de location en attente</p>
                </div>
            `;
        }
    }

    // Fonction pour mettre à jour la liste des équipements
    function updateEquipmentList(listings) {
        if (!containers.equipmentList) return;
        
        if (listings && listings.length > 0) {
            const listingsHtml = listings.map(listing => createEquipmentItem(listing)).join('');
            containers.equipmentList.innerHTML = listingsHtml;
        } else {
            containers.equipmentList.innerHTML = `
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Vous n'avez pas encore d'équipements</p>
                    <a href="/annonce/create" class="inline-flex items-center px-4 py-2 bg-forest dark:bg-meadow text-white font-medium rounded-md shadow-sm hover:bg-forest/90 dark:hover:bg-meadow/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:focus:ring-meadow transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter un équipement
                    </a>
                </div>
            `;
        }
    }

    // Fonction pour récupérer les données du tableau de bord
    function fetchDashboardData() {
        fetch('/api/partner-dashboard')
            .then(response => response.json())
            .then(data => {
                // Mettre à jour les statistiques
                updateStats(data);
                
                // Mettre à jour l'activité récente
                updateRecentActivity(data.recentActivity);
                
                // Mettre à jour les demandes de location
                updatePendingReservations(data.pendingReservations);
                
                // Mettre à jour la liste des équipements
                updateEquipmentList(data.listings);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données du tableau de bord:', error);
            });
    }

    // Initialiser le tableau de bord avec les données de la page
    function initDashboard() {
        // Récupérer les données du tableau de bord depuis la variable window.dashboardData
        // Cette variable sera définie dans le template Blade
        if (window.dashboardData) {
            // Mettre à jour les statistiques
            updateStats(window.dashboardData);
            
            // Mettre à jour l'activité récente
            updateRecentActivity(window.dashboardData.recentActivity);
            
            // Mettre à jour les demandes de location
            updatePendingReservations(window.dashboardData.pendingReservations);
            
            // Mettre à jour la liste des équipements
            updateEquipmentList(window.dashboardData.listings);
        } else {
            // Si les données ne sont pas disponibles, les récupérer via l'API
            fetchDashboardData();
        }
    }

    // Initialiser le tableau de bord
    initDashboard();
});
