<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - Dashboard Client</title>

    <!-- Styles / Scripts -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    

    <link rel="icon" href="{{ asset('images/favicon_io/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/favicon_io/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="CampShare - Louez facilement le matériel de camping dont vous avez besoin
    directement entre particuliers.">
    <meta name="keywords" content="camping, location, matériel, aventure, plein air, partage, communauté">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'forest': '#2D5F2B',
                        'meadow': '#4F7942',
                        'earth': '#8B7355',
                        'wood': '#D2B48C',
                        'sky': '#5D9ECE',
                        'water': '#1E7FCB',
                        'sunlight': '#FFAA33',
                    }
                }
            },
            darkMode: 'class',
        }

        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (event.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
    

</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
@include('Client.side-bar')
<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
        <div class="mb-8">
            <section class="bg-gray-50 dark:bg-gray-800 py-10 border-b border-gray-200 dark:border-gray-700">
                <div id="profileView">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row items-start md:items-center">
                            <div class="relative mb-6 md:mb-0 md:mr-8">
                                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-white dark:border-gray-700 shadow-md">
                                    <img src="{{ asset($profile->avatar_url) ?? 'https://via.placeholder.com/150' }}" 
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
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                            <div class="flex items-center mt-2">
                                                @if(isset($note_moyenne) && is_numeric($note_moyenne))
                                                    @php
                                                        $rating = min(max($note_moyenne, 0), 5); // Ensure rating is between 0-5
                                                        $fullStars = floor($rating); 
                                                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                                    @endphp
                                                    
                                                    <div class="flex text-amber-400 mr-1">
                                                        {{-- Full stars --}}
                                                        @for ($i = 0; $i < $fullStars; $i++)
                                                            <i class="fas fa-star text-base"></i>
                                                        @endfor
                                                        
                                                        {{-- Half star --}}
                                                        @if ($hasHalfStar)
                                                            <i class="fas fa-star-half-alt text-base"></i>
                                                        @endif
                                                        
                                                        {{-- Empty stars --}}
                                                        @for ($i = 0; $i < $emptyStars; $i++)
                                                            <i class="far fa-star text-base"></i>
                                                        @endfor
                                                    </div>
                                                    
                                                    <span class="text-gray-600 dark:text-gray-300 text-sm ml-1">
                                                        {{ number_format($rating, 1) }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 text-sm">Not rated</span>
                                                @endif
                                            </div>
                                        </div>
                                       
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
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Email</h2>
                        <p class="text-gray-600 dark:text-gray-300 max-w-3xl" id="viewEmail">
                             {{$profile->email}}
                        </p>
                        <br>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Nº téléphone</h2>
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
                                        <img id="avatarPreview" src="{{ asset($profile->avatar_url) ?? 'https://via.placeholder.com/150' }}" 
                                             alt="{{ $profile->username }}" 
                                             class="w-full h-full object-cover" />
                                    </div>
                                    <label for="avatarUpload" class="absolute -bottom-2 -right-2 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center border-2 border-white dark:border-gray-700 cursor-pointer hover:bg-blue-600 transition-colors">
                                        <i class="fas fa-camera"></i>
                                        <input type="file" id="avatarUpload" name="avatar" accept="image/*" class="hidden">
                                    </label>
                                </div>
                                
                                <script>
                                document.getElementById('avatarUpload').addEventListener('change', function(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        
                                        reader.onload = function(e) {
                                            // Update the preview image
                                            document.getElementById('avatarPreview').src = e.target.result;
                                                                                        
                                        };
                                        
                                        reader.readAsDataURL(file);
                                    }
                                });
                                </script>

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
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe</label>
                                        <input type="password" id="password" name="password" 
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="verify_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Verifie mote de passe</label>
                                        <input type="password" id="confirm_password" name="confirm_password" 
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                    
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ville</label>
                                        <select id="city" name="city_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                            <option value="">Sélectionnez votre ville</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ $profile->city_name == $city->name ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex flex-col items-start space-y-2">
                                        <span class=" text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Recevoir notifications</span>
                                        
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="user-active-toggle"
                                                class="sr-only peer"
                                                {{ $profile->is_subscriber == 1 ? 'checked' : '' }}
                                                onchange="document.getElementById('is_subscriber_field').value = this.checked ? '1' : '0'">
                                            
                                            <div class="w-11 h-6 bg-gray-300 peer-checked:bg-green-500 rounded-full peer -ransition-all duration-300 ease-in-out">
                                            </div>
                                            
                                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform duration-300 ease-in-out peer-checked:translate-x-full"></div>
                                        </label>
                                        
                                        <input type="hidden" id="is_subscriber_field" name="is_subscriber" value="{{ $profile->is_subscriber }}">
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

    document.getElementById('avatarUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('avatarPreview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Form submission
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
    .then(response => response.json())
    .then(data => {
    if (data.success) {
        window.location.href = "{{ route('HomeClient.profile') }}";
    } else {
        alert('Error: ' + (data.message || 'Une erreur est survenue'));
    }
})

});
</script>
<script>
      
      document.addEventListener('DOMContentLoaded', function() {
          const openModalBtn = document.getElementById('openPartnerModalBtn');
          const partnerModal = document.getElementById('partnerAcceptModal');
          if (openModalBtn && partnerModal) {
              const closeModalBtn = document.getElementById('closePartnerModalBtn');
              const cancelModalBtn = document.getElementById('cancelPartnerModalBtn');
              const openModal = () => {
                  partnerModal.classList.remove('hidden');
                  partnerModal.classList.add('flex');
                  document.body.style.overflow = 'hidden';
              };
              const closeModal = () => {
                  partnerModal.classList.add('hidden');
                  partnerModal.classList.remove('flex');
                  document.body.style.overflow = '';
              };
              openModalBtn.addEventListener('click', (event) => {
                  event.preventDefault();
                  openModal();
              });
              if (closeModalBtn) {
                  closeModalBtn.addEventListener('click', closeModal);
              }
              if (cancelModalBtn) {
                  cancelModalBtn.addEventListener('click', closeModal);
              }
              partnerModal.addEventListener('click', (event) => {
                  if (event.target === partnerModal) {
                      closeModal();
                  }
              });
              document.addEventListener('keydown', (event) => {
                  if (event.key === 'Escape' && !partnerModal.classList.contains('hidden')) {
                      closeModal();
                  }
              });
          }
      });
  </script>
</body>
</html>