<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
   
    
        
        <!-- Equipment recommendations -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Équipements recommandés</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Recommendation 1 -->
                @foreach($allSimilarListings as $item1)
                <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="relative h-48">
                        <img src="{{ $item1->image_url }}" alt="Image" 
                             class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4">
                            <button class="p-2 bg-white bg-opacity-80 dark:bg-gray-900 dark:bg-opacity-80 rounded-full text-amber-400 hover:text-amber-500 dark:hover:text-amber-300 transition-colors focus:outline-none">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-white font-bold text-lg truncate">{{$item1->listing_title}}</h3>
                            <p class="text-gray-200 text-sm">{{$item1->category_name}}</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <span class="font-bold text-lg text-gray-900 dark:text-white">{{$item1->price_per_day}} MAD</span>
                                <span class="text-gray-600 dark:text-gray-300 text-sm">/jour</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-star text-amber-400 mr-1"></i>
                                <span>4.8 <span class="text-gray-500 dark:text-gray-400">(18)</span></span>
                            </div>
                        </div>
                        
                        <div class="text-sm mb-3">
                            <span class="text-gray-600 dark:text-gray-300">Dispo. du 1 août au 1 oct.</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                <span class="font-medium text-purple-600 dark:text-purple-400">
                                    <i class="fas fa-map-marker-alt mr-1"></i> 
                                    {{$item1->city_name}}
                                </span>
                            </div>
                            <a href="#view-details" class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
</main>