<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - Dashboard Partenaire</title>

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

        // Detect dark mode preference
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

    <style>
        /* Navigation hover effects */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: currentColor;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Active link style */
        .active-nav-link {
            position: relative;
        }
        
        .active-nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #FFAA33;
        }
        
        /* Input styles */
        .custom-input {
            transition: all 0.3s ease;
            border-width: 2px;
        }
        
        .custom-input:focus {
            box-shadow: 0 0 0 3px rgba(45, 95, 43, 0.2);
        }
        
        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-switch .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        .toggle-switch input:checked + .slider {
            background-color: #2D5F2B;
        }
        
        .dark .toggle-switch input:checked + .slider {
            background-color: #4F7942;
        }
        
        .toggle-switch input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        /* Sidebar active */
        .sidebar-link.active {
            background-color: rgba(45, 95, 43, 0.1);
            color: #2D5F2B;
            border-left: 4px solid #2D5F2B;
        }
        
        .dark .sidebar-link.active {
            background-color: rgba(79, 121, 66, 0.2);
            color: #4F7942;
            border-left: 4px solid #4F7942;
        }
        
        /* Equipment card hover effect */
        .equipment-card {
            transition: all 0.3s ease;
        }
        
        .equipment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Chat styles */
        .chat-container {
            max-height: 400px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        
        .chat-message {
            margin-bottom: 15px;
            display: flex;
        }
        
        .chat-message.outgoing {
            justify-content: flex-end;
        }
        
        .chat-bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 80%;
        }
        
        .chat-message.incoming .chat-bubble {
            background-color: #f3f4f6;
            border-bottom-left-radius: 5px;
        }
        
        .dark .chat-message.incoming .chat-bubble {
            background-color: #374151;
        }
        
        .chat-message.outgoing .chat-bubble {
            background-color: #2D5F2B;
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .dark .chat-message.outgoing .chat-bubble {
            background-color: #4F7942;
        }

        /* Styles pour les boutons principaux - action buttons */
        button[type="submit"],
        a.inline-flex,
        button.px-4.py-2,
        button.px-6.py-2,
        .w-full.md\\:w-auto.px-4.py-2,
        button.inline-flex {
            background-color: #2D5F2B !important; /* forest color */
            color: white !important;
            transition: all 0.3s ease;
        }
        
        /* Exceptions pour les boutons retour/annuler */
        button[id^="back-to-step"],
        button[onclick="toggleEditMode(false)"] {
            background-color: white !important;
            color: #374151 !important;
            border: 1px solid #D1D5DB !important;
        }
        
        /* Hover state for action buttons */
        button[type="submit"]:hover,
        a.inline-flex:hover,
        button.px-4.py-2:hover,
        button.px-6.py-2:hover,
        .w-full.md\\:w-auto.px-4.py-2:hover,
        button.inline-flex:hover {
            background-color: #215A1A !important; /* darker forest */
        }


    </style>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
@include('Partenaire.side-bar');
<div class="flex flex-col md:flex-row pt-16">
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
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Locations réalisées</div>
                                    </div>

                                    <div class="flex flex-col items-center">
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
                                        <img id="avatarPreview" src="{{ $profile->avatar_url ?? 'https://via.placeholder.com/150' }}" 
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
            // Update all fields including avatar
            document.getElementById('viewUsername').textContent = data.user.username;
            document.getElementById('viewAddress').textContent = data.user.address;
            document.getElementById('viewEmail').textContent = data.user.email;
            document.getElementById('viewPhone').textContent = data.user.phone_number;
            
            // Update avatar in view mode
            const avatarView = document.querySelector('#profileView img');
            if (data.avatar_url) {
                avatarView.src = data.avatar_url;
            }
            
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
</body>
</html>