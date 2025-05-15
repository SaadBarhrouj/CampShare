<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
        <!-- Dashboard header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Tableau de bord</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Bienvenue, {{$user->username}} ! Voici un résumé de vos réservations.</p>
            </div>
         
        </div>
        
        <!-- Stats cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Stats card 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                        <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Total réservations</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalReservations }}</h3>
                        
                    </div>
                </div>
            </div>
            
            <!-- Stats card 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                        <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Montant total dépensé</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$totalDepenseByEmail}}</h3>
                      
                    </div>
                </div>
            </div>
            
            <!-- Stats card 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 mr-4">
                        <i class="fas fa-star text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Note moyenne</p>
                        @if(isset($note_moyenne) && $note_moyenne != 0)
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{$note_moyenne}}</h3>
                        @else
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Non noté</h3>
                        @endif
                      
                    </div>
                </div>
            </div>
        </div>
        

        <!-- My reservations section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Mes réservations</h2>
                <a href="{{ route('HomeClient.reservations') }}" data-target = "allRes" class=" sidebar-link text-forest dark:text-meadow hover:underline text-sm font-medium">
                    Voir toutes mes réservations
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Reservation 1 -->
                @forelse($reservations as $res)

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="relative h-40">
                        <img src="{{ $res->image_url }}" alt="Image"
                             class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        @php
                            $statusMap = [
                                'pending' => ['label' => 'En attente', 'color' => 'bg-yellow-400'],
                                'confirmed' => ['label' => 'Confirmée', 'color' => 'bg-blue-500'],
                                'ongoing' => ['label' => 'En cours', 'color' => 'bg-green-500'],
                                'canceled' => ['label' => 'Annulée', 'color' => 'bg-red-500'],
                                'completed' => ['label' => 'Terminée', 'color' => 'bg-purple-600'],
                            ];

                            $status = $res->status;
                            $statusLabel = $statusMap[$status]['label'] ?? $status;
                            $statusColor = $statusMap[$status]['color'] ?? 'bg-gray-400';
                        @endphp

                        <div class="absolute top-4 left-4">
                            <span class="{{ $statusColor }} text-white text-xs px-2 py-1 rounded-full">
                                {{ $statusLabel }}
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-bold text-lg truncate">{{$res->listing_title}}</h3>
                            <p class="text-gray-200 text-sm">{{ \Illuminate\Support\Str::limit($res->description, 150) }}</p>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-start mb-4">
                            <a href="{{ route('partner.profile.index', $res->partner_id) }}">
                                <img src="{{ $res->partner_img}}" 
                                    alt="image" 
                                    class="w-8 h-8 rounded-full object-cover mr-3" />
                            </a>
                            <div>
                                <a href="{{ route('partner.profile.index', $res->partner_id) }}">
                                    <p class="font-medium text-gray-900 dark:text-white">{{$res->partner_username}}</p>
                                </a>
                                <div class="flex items-center text-sm">
                                    @if($res->partner_avg_rating)
                                        @php
                                            $rating = $res->partner_avg_rating;
                                            $fullStars = floor($rating);
                                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                        @endphp
                                        
                                        <div class="flex text-amber-400 mr-1">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            
                                            @if ($hasHalfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            
                                            @for ($i = 0; $i < (5 - $fullStars - ($hasHalfStar ? 1 : 0)); $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ number_format($rating, 1) }}
                                        </span>
                                    @else
                                        <div class="text-sm text-gray-500">No ratings yet</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded p-3 mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Date</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{$res->start_date}} - {{$res->end_date}}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Prix</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{$res->montant_paye}} MAD</span>
                            </div>
                          
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @if($res->status === 'pending')
                                <button onclick="cancelReservation({{ $res->id }})"
                                        class="px-3 py-1.5 border border-red-300 dark:border-red-800 text-red-700 dark:text-red-400 text-sm rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex-1">
                                    <i class="fas fa-times mr-2"></i> Annuler
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="rounded-lg shadow-sm overflow-hidden">
                    <p class="mx-8 text-sm text-gray-600 dark:text-gray-400">Vous n'avez aucune réservation.</p>
                </div>
                @endforelse

            </div>
        </div>
        


       
        
        <!-- Equipment recommendations -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Équipements recommandés</h2>
                <a href="{{ route('HomeClient.equips') }}" data-target = "allSim" class=" sidebar-link text-forest dark:text-meadow hover:underline text-sm font-medium">
                    Voir plus de recommandations
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Recommendation 1 -->
                @forelse($similarListings as $item)
                <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    
                    <a href="{{ route('client.listings.show', $item->lis_id) }}">
                    <div class="relative h-48">
                        <img src="{{ $item->image_url }}" alt="Image" 
                             class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-bold text-lg truncate">{{$item->listing_title}}</h3>
                            <p class="text-gray-200 text-sm">{{$item->category_name}}</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <span class="font-bold text-lg text-gray-900 dark:text-white">{{$item->price_per_day}} MAD</span>
                                <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                            </div>
                            <div class="flex items-center text-sm">
                                @if($item->review_count)
                                    @php
                                        $rating = $item->avg_rating;
                                        $fullStars = floor($rating);
                                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                    @endphp
                                    
                                    <div class="flex items-center">
                                        <div class="flex text-amber-400 mr-1">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            
                                            @if ($hasHalfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            
                                            @for ($i = 0; $i < (5 - $fullStars - ($hasHalfStar ? 1 : 0)); $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ number_format($rating, 1) }}
                                            <span class="text-xs text-gray-400 ml-1">({{ $item->review_count }})</span>
                                        </span>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">No ratings yet</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-sm mb-3">
                            <span class="text-gray-600 dark:text-gray-300">
                                Dispo. du {{ \Carbon\Carbon::parse($item->start_date)->format('d M') }} 
                                au {{ \Carbon\Carbon::parse($item->end_date)->format('d M') }}
                            </span>                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                <span class="font-medium text-green-800 dark:text-green-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i> 
                                    {{$item->city_name}}
                                </span>
                            </div>
                            <a href="{{ route('client.listings.show', $item->lis_id) }}" class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                    </a>
                </div>
                @empty
                @foreach($liss as $lis)
                <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    
                    <a href="{{ route('client.listings.show', $lis->id) }}">
                    <div class="relative h-48">
                        <img src="{{ $lis->item?->images?->first() ? asset($lis->item->images->first()->url) : asset('images/item-default.jpg') }}" alt="Image" 
                             class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-bold text-lg truncate">{{$lis->item->title}}</h3>
                            <p class="text-gray-200 text-sm">{{$lis->item->category->name}}</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <span class="font-bold text-lg text-gray-900 dark:text-white">{{$lis->item->price_per_day}} MAD</span>
                                <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                            </div>
                            <div class="flex items-center text-sm">
                                @if($lis->item->averageRating() !=0)
                                    @php
                                        $rating = $lis->item->averageRating();
                                        $fullStars = floor($rating);
                                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                    @endphp
                                    
                                    <div class="flex items-center">
                                        <div class="flex text-amber-400 mr-1">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            
                                            @if ($hasHalfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            
                                            @for ($i = 0; $i < (5 - $fullStars - ($hasHalfStar ? 1 : 0)); $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">No ratings yet</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-sm mb-3">
                            <span class="text-gray-600 dark:text-gray-300">
                                Dispo. du {{ \Carbon\Carbon::parse($lis->start_date)->format('d M') }} 
                                au {{ \Carbon\Carbon::parse($lis->end_date)->format('d M') }}
                            </span>                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                <span class="font-medium text-green-800 dark:text-green-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i> 
                                    {{$lis->city->name}}
                                </span>
                            </div>
                            <a href="{{ route('client.listings.show', $lis->id) }}" class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
                @endforelse
                
            </div>
        </div>
    </div>
</main>
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
    
    // Sidebar link active state
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Remove active class from all links
            sidebarLinks.forEach(el => el.classList.remove('active'));
            
            // Add active class to clicked link
            link.classList.add('active');
        });
    });
    
    // Message modal
    const messageButtons = document.querySelectorAll('button .fas.fa-comment-alt, .fas.fa-envelope');
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
    
    // Add to favorites functionality
    const heartButtons = document.querySelectorAll('.far.fa-heart');
    
    heartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            if (button.classList.contains('far')) {
                button.classList.remove('far');
                button.classList.add('fas');
            } else {
                button.classList.remove('fas');
                button.classList.add('far');
            }
        });
    });
</script>
<script>
    function cancelReservation(reservationId) {
    if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
        fetch(`/client/reservations/cancel/${reservationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                //alert(data.message);
                // Recharger les réservations
                document.getElementById('statusFilter').dispatchEvent(new Event('change'));
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>