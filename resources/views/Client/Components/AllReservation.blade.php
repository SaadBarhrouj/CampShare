<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
        <!-- Dashboard header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Mes reservations</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Bienvenue, {{$user->username}} ! Voici un résumé de vos réservations.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
               
            </div>
        </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Reservation 1 -->
                @foreach( $allReservations as $allRes)

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="relative h-40">
                        <img src="{{ $allRes->image_url }}" alt="Image"
                             class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">{{$allRes->status}}</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-bold text-lg truncate">{{$allRes->listing_title}}</h3>
                            <p class="text-gray-200 text-sm">{{$allRes->description}}</p>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-start mb-4">
                            <img src="{{ $allRes->partener_img}}" 
                                 alt="image" 
                                 class="w-8 h-8 rounded-full object-cover mr-3" />
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{$allRes->partener_username}}</p>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-star text-amber-400 mr-1"></i>
                                    <span>{{$allRes->partener_avg_rating}} </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded p-3 mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Dates:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{$allRes->start_date}} - {{$allRes->end_date}}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Prix:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{$allRes->montant_paye}}</span>
                            </div>
                          
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <button class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex-1">
                                <i class="fas fa-calendar-alt mr-2"></i> Modifier
                            </button>
                            <button class="px-3 py-1.5 border border-red-300 dark:border-red-800 text-red-700 dark:text-red-400 text-sm rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex-1">
                                <i class="fas fa-times mr-2"></i> Annuler
                            </button>
                            <button class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                <i class="fas fa-comment-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
</main>