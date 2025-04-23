<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
        <div class="mb-8">

            <section class="bg-gray-50 dark:bg-gray-800 py-10 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row items-start md:items-center">
                        <!-- Profile Image -->
                        <div class="relative mb-6 md:mb-0 md:mr-8">
                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-md">
                                <img src="{{ $profile->avatar_url ?? 'https://via.placeholder.com/150' }}" 
                                     alt="{{ $profile->username }}" 
                                     class="w-full h-full object-cover" />
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center border-2 border-white dark:border-gray-700">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                                        {{ $profile->username }}
                                        <span class="ml-3 text-sm font-medium px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md">
                                            Membre depuis {{ \Carbon\Carbon::parse($profile->created_at)->format('Y') }}
                                        </span>
                                    </h1>
                                    <div class="mt-2 flex items-center text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                        <span>{{ $profile->address }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="flex flex-wrap gap-6 mt-6">
                                <div class="flex flex-col items-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $profile->avg_rating }}</div>
                                    <div class="flex text-amber-400 mt-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">({{ $profile->review_count }} avis)</div>
                                </div>

                                <div class="flex flex-col items-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalReservations }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Locations réalisées</div>
                                </div>

                                <div class="flex flex-col items-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{$totalDepenseByEmail}}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Montant total dépensé</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Email de {{ $profile->username }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 max-w-3xl">
                         {{$profile->email}}
                    </p>
                    <br>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Numero de telephone  de {{ $profile->username }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 max-w-3xl">
                        {{$profile->phone_number}}
                    </p>

                  
                </div>
            </section>

        </div>
    </div>
</main>
