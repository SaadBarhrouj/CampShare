<style>
    .filter-chip {
    @apply px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer transition-colors mr-2 mb-2;
    @apply bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300;
}

.filter-chip.active {
    @apply bg-forest dark:bg-meadow text-white;
}

.filter-chip:hover {
    @apply bg-gray-200 dark:bg-gray-600;
}

.filter-chip.active:hover {
    @apply bg-green-700 dark:bg-green-600;
}

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <div class="flex flex-col md:flex-row pt-16">
        <main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="py-8 px-4 md:px-8">
                <!-- Page header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Les Avis Reçus</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Gérez toutes vos demandes de location entrantes.</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <a href="index.html" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-md shadow-sm transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour au tableau de bord
                        </a>
                    </div>
                </div>

                <!-- Filters and search -->
                <form  id="filters-form1" >
                @csrf

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2 md:mb-0">Filtrer les demandes</h2>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Rechercher..." 
                                    class="px-4 py-2 pr-10 w-full md:w-64 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-base custom-input"
                                >
                                <input type="hidden" id="partner-email" name="email" value="{{ $user->email }}">

                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            @php
                                $statuses = ['all' => 'all', 'ForPartenaire' => 'For Partenaire', 'ForItem' => 'For Item'];
                            @endphp

                            @foreach($statuses as $key => $label)
                                <button 
                                    type="button"
                                    name="status"
                                    value="{{ $key }}"
                                    class="filter-chip {{ request('status', 'all') === $key ? 'active' : '' }}"
                                >
                                    <span>{{ $label }}</span>
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="status" id="selected-status" value="{{ request('status', 'all') }}">

                        <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="flex items-center">
                                <label for="date-filter" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Date:</label>
                                <select 
                                    id="date-filter" 
                                    name="date" 
                                    class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-sm custom-input"
                                >
                                    <option value="all" {{ request('date') == 'all' ? 'selected' : '' }}>Toutes les Avis</option>
                                    <option value="this-month" {{ request('date') == 'this-month' ? 'selected' : '' }}>Ce mois-ci</option>
                                    <option value="last-month" {{ request('date') == 'last-month' ? 'selected' : '' }}>Mois dernier</option>
                                    <option value="last-3-months" {{ request('date') == 'last-3-months' ? 'selected' : '' }}>3 derniers mois</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <label for="sort-by" class="text-sm text-gray-700 dark:text-gray-300 mr-2">Trier par:</label>
                                <select 
                                    id="sort-by" 
                                    name="sort" 
                                    class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-sm custom-input"
                                >
                                    <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Date (plus récent)</option>
                                    <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Date (plus ancien)</option>
                                
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h2 class="font-bold text-xl text-gray-900 dark:text-white">Liste des Avis Reçus</h2>
                        <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-3 py-1 text-xs font-medium rounded-full">
                           {{$NumberLocationsEncours}} Avis Reçus
                        </span>
                    </div>

                    <!-- Request items -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div id="reservations">
                            @foreach($LesAvis as $Avis)
                                <div class="px-6 py-4">
                                    <div class="flex flex-col lg:flex-row lg:items-start">
                                       

                                        <div class="flex-grow grid grid-cols-1 lg:grid-cols-4 gap-3 mb-4 lg:mb-0">
                                            <div>
                                                <div class="flex-shrink-0 items-center content-center mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto">
                                                    <div class="flex items-center content-center w-12">
                                                        <img src="{{$Avis->avatar_url}}"
                                                            alt="Mehdi Idrissi" 
                                                            class="w-12 h-12 rounded-full object-cover" />

                                                    </div>
                                                    <div class="lg:block mt-2">
                                                        <h3 class="font-medium text-gray-900 dark:text-white ">{{$Avis->username}}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Rating</p>
                                                    @php
                                                        $rating = $Avis->rating;  
                                                        $fullStars = floor($rating); 
                                                        $halfStar = $rating - $fullStars !=0
                                                    @endphp

                                                        <div class="flex text-amber-400">
                                                        @for ($i = 0; $i < $fullStars; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                    
                                                        @if ($halfStar)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @endif
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Commentaire</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{$Avis->comment}}</p>
                                            </div>
                                            @if($Avis->object_title)
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pour Equipement</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{$Avis->object_title}}</p>
                                            </div>
                                            @else
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pour partenaire</p>
                                                <p class="font-medium text-gray-900 dark:text-white"></p>
                                            </div>
                                            @endif
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Date</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{$Avis->created_at}}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>



                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-between">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Affichage de 
                            <span class="font-medium text-gray-900 dark:text-white">
                                
                            </span> 
                            à 
                            <span class="font-medium text-gray-900 dark:text-white">
                                
                            </span> 
                            sur 
                            <span class="font-medium text-gray-900 dark:text-white">                  
                            </span> demandes
                        </div>
                        <div>
                            
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </main>
    </div>






