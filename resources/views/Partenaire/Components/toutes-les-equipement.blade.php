
    <div class="flex flex-col md:flex-row pt-16">
        <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Page header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Vos Équipement</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez toutes vos Équipement.</p>
                    </div>
                    
                </div>

                <!-- Filters and search -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2 md:mb-0">Filtrer les demandes</h2>
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="px-4 py-2 pr-10 w-full md:w-64 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-base custom-input">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap">
                        <div class="filter-chip active">
                            <span>Toutes</span>
                            <span class="ml-2 bg-white dark:bg-gray-700 text-forest dark:text-meadow rounded-full px-2 py-0.5 text-xs">12</span>
                        </div>
                        <div class="filter-chip">
                            <span>En attente</span>
                            <span class="ml-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full px-2 py-0.5 text-xs">3</span>
                        </div>
                        <div class="filter-chip">
                            <span>Acceptées</span>
                            <span class="ml-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full px-2 py-0.5 text-xs">4</span>
                        </div>
                        <div class="filter-chip">
                            <span>Refusées</span>
                            <span class="ml-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full px-2 py-0.5 text-xs">2</span>
                        </div>
                        <div class="filter-chip">
                            <span>Annulées</span>
                            <span class="ml-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full px-2 py-0.5 text-xs">1</span>
                        </div>
                        <div class="filter-chip">
                            <span>Terminées</span>
                            <span class="ml-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full px-2 py-0.5 text-xs">2</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center">
                            <label for="date-filter" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Date:</label>
                            <select id="date-filter" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-sm custom-input">
                                <option value="all">Toutes les dates</option>
                                <option value="this-month">Ce mois-ci</option>
                                <option value="last-month">Mois dernier</option>
                                <option value="last-3-months">3 derniers mois</option>
                                <option value="custom">Personnalisé</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <label for="equipment-filter" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Équipement:</label>
                            <select id="equipment-filter" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-sm custom-input">
                                <option value="all">Tous les équipements</option>
                                <option value="pack-camping">Pack Camping Complet 2p</option>
                                <option value="tente-legere">Tente Légère 2 Personnes</option>
                                <option value="sacs-couchage">Sacs de Couchage Ultra Confort</option>
                                <option value="matelas">Matelas Gonflable Double</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <label for="sort-by" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Trier par:</label>
                            <select id="sort-by" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-sm custom-input">
                                <option value="date-desc">Date (plus récent)</option>
                                <option value="date-asc">Date (plus ancien)</option>
                                <option value="price-desc">Prix (décroissant)</option>
                                <option value="price-asc">Prix (croissant)</option>
                                <option value="duration-desc">Durée (la plus longue)</option>
                                <option value="duration-asc">Durée (la plus courte)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Rental requests list -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h2 class="font-bold text-xl text-gray-900 dark:text-white">Liste des Equipment</h2>
                        <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-3 py-1 text-xs font-medium rounded-full">
                            {{$NumberOfPartenaireEquipement}} Équipement au total
                        </span>
                    </div>

                    <!-- Request items -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($AllEquipement as $Equipement)
                            <div class="px-6 py-4">
                            <div class="flex flex-col lg:flex-row lg:items-start">
                               

                                <div class="flex-grow grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4 lg:mb-0">
                                    <div>
                                        <div class="flex-shrink-0 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">
                                            <div class="flex items-center lg:w-16">
                                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                                                    alt="Mehdi Idrissi" 
                                                    class="w-12 h-12 rounded-full object-cover" />
                                                <div class="lg:hidden ml-3">
                                                    <h3 class="font-medium text-gray-900 dark:text-white">{{$Equipement->title}}</h3>
                                                    <div class="flex  text-sm">
                                                        <i class="fas fa-star text-amber-400 mr-1"></i>
                                                        <span>4.8 <span class="text-gray-500 dark:text-gray-400">(14)</span></span>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="hidden lg:block mt-2">
                                            <h3 class="font-medium text-gray-900 dark:text-white ">{{$Equipement->title}}</h3>
                                            <div class="flex items-center  text-xs mt-1">
                                                <i class="fas fa-star text-amber-400 mr-1"></i>
                                                <span>4.8</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>   
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">category</p>
                                        <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                            <span class="truncate">{{$Equipement->name}}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Dates</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{$Equipement->description}}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Prix </p>
                                        <p class="font-medium text-gray-900 dark:text-white">({{$Equipement->price_per_day}} MAD/jour)</p>
                                    </div>
                                </div>

                                
                            </div>
                            </div>
                        @endforeach

                        

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-between">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Affichage de 
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $AllReservationForPartner->firstItem() }}
                            </span> 
                            à 
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $AllReservationForPartner->lastItem() }}
                            </span> 
                            sur 
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $AllReservationForPartner->total() }}
                            </span> demandes
                        </div>
                        <div>
                            {{ $AllReservationForPartner->links() }}
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Message Modal (hidden by default) -->
    

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton?.addEventListener('click', () => {
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
        });
        
        // Mobile sidebar toggle
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const closeMobileSidebar = document.getElementById('close-mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        
        mobileSidebarToggle?.addEventListener('click', () => {
            mobileSidebar.classList.toggle('-translate-x-full');
            mobileSidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        });
        
        closeMobileSidebar?.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        mobileSidebarOverlay?.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Filter chips
        const filterChips = document.querySelectorAll('.filter-chip');
        
        filterChips.forEach(chip => {
            chip.addEventListener('click', () => {
                // If already active, stay active
                if (chip.classList.contains('active')) {
                    return;
                }
                
                // Remove active class from all chips
                filterChips.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked chip
                chip.classList.add('active');
            });
        });
        
        // Message modal
        const messageButtons = document.querySelectorAll('button .fas.fa-comment-alt');
        const messageModal = document.getElementById('message-modal');
        const closeMessageModal = document.getElementById('close-message-modal');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        
        messageButtons.forEach(button => {
            button.parentElement.addEventListener('click', (e) => {
                e.preventDefault();
                messageModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                // Scroll to bottom of chat
                const chatContainer = document.querySelector('.chat-container');
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
                // Focus input
                messageInput?.focus();
            });
        });
        
        closeMessageModal?.addEventListener('click', () => {
            messageModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Close modal when clicking outside
        messageModal?.addEventListener('click', (e) => {
            if (e.target === messageModal) {
                messageModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Handle message form submission
        messageForm?.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (message) {
                // Create and append new message
                const chatContainer = document.querySelector('.chat-container');
                const newMessage = document.createElement('div');
                newMessage.className = 'chat-message outgoing';
                
                const now = new Date();
                const hours = now.getHours();
                const minutes = now.getMinutes();
                const timeString = `${hours}:${minutes < 10 ? '0' + minutes : minutes}`;
                
                newMessage.innerHTML = `
                    <div class="chat-bubble">
                        <p class="text-white">${message}</p>
                        <p class="text-xs text-gray-300 mt-1">${timeString}</p>
                    </div>
                `;
                
                chatContainer.appendChild(newMessage);
                messageInput.value = '';
                
                // Scroll to bottom of chat
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });
    </script>
