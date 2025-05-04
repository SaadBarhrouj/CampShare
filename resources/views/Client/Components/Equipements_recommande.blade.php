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
                    @if($item1->is_premium)
                        <div class="absolute top-2 left-2 z-10 bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            Premium
                        </div>
                     @endif
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
                                @if($item1->review_count)
                                    @php
                                        $rating = $item1->avg_rating;
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
                                            @if($item1->review_count)
                                                <span class="text-xs text-gray-400 ml-1">({{ $item1->review_count }})</span>
                                            @endif
                                        </span>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">No ratings yet</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-sm mb-3">
                            <span class="text-gray-600 dark:text-gray-300">
                                Dispo. du {{ \Carbon\Carbon::parse($item1->start_date)->format('d M') }} 
                                au {{ \Carbon\Carbon::parse($item1->end_date)->format('d M') }}
                            </span>                        
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