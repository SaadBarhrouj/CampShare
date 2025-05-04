<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h2 class="font-bold text-xl text-gray-900 dark:text-white">Liste des comentaires</h2>
            
            </div>

            <!-- Request items -->
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Request 1 -->
                @foreach ($reviews as $review)

                <div class="px-6 py-4">
                    <div class="flex flex-col lg:flex-row lg:items-start">
                       

                        <div class="flex-grow grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4 lg:mb-0">
                            <div class="flex-shrink-0 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">
                                <div class="flex items-center lg:w-16">
                                    <img src="{{ asset($review->reviewer_avatar) }}" 
                                        alt="image" 
                                        class="w-12 h-12 rounded-full object-cover" />
                                    <div class="ml-4">
                                        <h3 class="font-medium text-gray-900 dark:text-white">{{$review->reviewer_name}}</h3>
                            
                                    </div>
                                </div>

                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">rating</p>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-star text-amber-400 mr-1"></i>
                                    <span>{{ $review->rating }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">comment</p>
                                <p class="font-medium text-gray-900 dark:text-white"> {{ $review->comment }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Date</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $review->created_at}}</p>
                            </div>
                          
                      
                        </div>

                            
                    </div>
                </div>
                @endforeach
            </div>

        </div>
</div>
</main>