<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
        <div class="mb-8">
            <section class="bg-gray-50 dark:bg-gray-800 py-10 border-b border-gray-200 dark:border-gray-700">
                <div id="profileView">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row items-start md:items-center">
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

                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                                    <div>
                                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                                            <span id="viewUsername">{{ $profile->username }}</span>
                                            <span class="ml-3 text-sm font-medium px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md">
                                                Membre depuis {{ \Carbon\Carbon::parse($profile->created_at)->format('Y') }}
                                            </span>
                                        </h1>
                                        <div class="mt-2 flex items-center text-gray-600 dark:text-gray-300">
                                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                            <span id="viewAddress">{{ $profile->address }}</span>
                                        </div>
                                    </div>
                                </div>

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
                        <p class="text-gray-600 dark:text-gray-300 max-w-3xl" id="viewEmail">
                             {{$profile->email}}
                        </p>
                        <br>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Numero de telephone de {{ $profile->username }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 max-w-3xl" id="viewPhone">
                            {{$profile->phone_number}}
                        </p>
                    </div>

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 text-right">
                        <button onclick="toggleEditMode(true)" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Modifier le profil
                        </button>
                    </div>
                </div>

                <div id="profileEdit" class="hidden">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <form id="profileForm">
                            @csrf
                            @method('POST')                              
                            <div class="flex flex-col md:flex-row items-start md:items-center mb-8">
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

                                <div class="flex-1 space-y-4">
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom d'utilisateur</label>
                                        <input type="text" id="username" name="username" value="{{ $profile->username }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                        <input type="email" id="email" name="email" value="{{ $profile->email }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                                    <input type="text" id="phone_number" name="phone_number" value="{{ $profile->phone_number }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse</label>
                                    <input type="text" id="address" name="address" value="{{ $profile->address }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <button type="button" onclick="toggleEditMode(false)" 
                                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    Annuler
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<script>
    function toggleEditMode(showEdit) {
        const viewMode = document.getElementById('profileView');
        const editMode = document.getElementById('profileEdit');
        
        if (showEdit) {
            viewMode.classList.add('hidden');
            editMode.classList.remove('hidden');
        } else {
            viewMode.classList.remove('hidden');
            editMode.classList.add('hidden');
        }
    }

    document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch("{{ route('profile.update') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            document.getElementById('viewUsername').textContent = data.user.username;
            document.getElementById('viewAddress').textContent = data.user.address;
            document.getElementById('viewEmail').textContent = data.user.email;
            document.getElementById('viewPhone').textContent = data.user.phone_number;
            
            toggleEditMode(false);
            
        } else {
            alert('Error: ' + (data.message || 'Une erreur est survenue'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue: ' + error.message);
    });
});
</script>