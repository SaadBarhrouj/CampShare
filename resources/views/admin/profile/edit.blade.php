<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil | Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Utilisé si Vite est configuré --}}
</head>

<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900">

<nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo stylisé -->
            <div class="flex-shrink-0 flex items-center">
                <a href="#" class="flex items-center">
                   <span class="text-3xl font-extrabold leading-none">
                       <span class="text-[#173BCA]">Camp</span><span class="text-[#FDAA2A]">Share</span>
                   </span>
                    <span class="text-xs ml-2 text-[#6B7280] bg-[#F1F2F6] px-2 py-1 rounded-full font-medium">
                        ADMIN
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative">
                    <button id="notifications-button" class="relative p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">5</span>
                    </button>
                </div>

                <!-- User menu -->
                @auth
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-3 focus:outline-none group">
                        <div class="flex flex-col items-start">
                            <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">
                                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                            </span>
                            <span class="text-xs text-admin-primary dark:text-admin-secondary font-medium">
                                {{ ucfirst(auth()->user()->role) ?? 'Utilisateur' }}
                            </span>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-500 group-hover:text-admin-primary transition-colors"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg z-50 overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div class="py-2">
                            <a href="{{ route('admin.profile.edit') }}"
                                class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-user-circle mr-2 opacity-70"></i> Mon profil
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2 opacity-70"></i> Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<aside class="hidden md:block w-64 bg-white dark:bg-gray-800 shadow-md h-screen fixed left-0 top-16 overflow-y-auto">
    <div class="p-5">
        <div class="mb-6 px-3">
            <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                Menu Principal</h5>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors">
                    <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Tableau de bord
                </a>
            </nav>
        </div>

        <div class="mb-6 px-3">
            <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                Utilisateurs</h5>
            <nav class="space-y-1">
                <a href="{{ route('admin.partners') }}"
                    class="sidebar-link active flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-handshake w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Partenaires
                </a>
                <a href="{{ route('admin.clients') }}"
                    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-users w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Clients
                </a>
            </nav>
        </div>

        <div class="mb-6 px-3">
            <h5 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                Equi. Réserv. & Avis</h5>
            <nav class="space-y-1">
                <a href="{{ route('equipements.index') }}"
                    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-campground w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Équipements
                </a>
                <a href="{{ route('admin.reservations.index') }}" 
                    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-calendar-alt w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Réservations
                </a>
                <a href="{{ route('admin.reviews') }}"
                    class="sidebar-link flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-star w-5 mr-3 text-gray-500 dark:text-gray-400"></i>
                    Avis
                </a>
            </nav>
        </div>
    </div>
</aside>

<!-- Main Content - Correctly positioned to account for sidebar -->
<main class="md:ml-64 bg-white dark:bg-gray-900 min-h-screen">
    <div class="pt-16 px-4 sm:px-6 lg:px-8">
        <section class="py-8">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Modifier mon profil administrateur
                    </h2>
                    <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Retour
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900 text-green-600 dark:text-green-400 p-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900 text-red-600 dark:text-red-400 p-4 rounded-lg">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 sm:p-8">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Photo de profil -->
                        <div class="flex flex-col items-center space-y-4">
                            <div class="relative">
                                @if($admin->avatar_url)
                                    <img src="{{ asset($admin->avatar_url) }}" alt="Photo de profil" 
                                         class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-md">
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-4 border-white shadow-md">
                                        <i class="fas fa-user text-gray-400 dark:text-gray-500 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-2">
                                <label for="avatar" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer transition-colors">
                                    <i class="fas fa-camera mr-2"></i> Changer la photo
                                </label>
                                <input id="avatar" name="avatar" type="file" accept="image/*" class="sr-only">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    JPG, PNG ou GIF. Max 2MB.
                                </p>
                            </div>
                        </div>

                        <!-- Informations de base -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informations de base</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Nom d'utilisateur <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="username" id="username" value="{{ old('username', $admin->username) }}" required
                                        class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required
                                        class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Numéro de téléphone
                                    </label>
                                    <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $admin->phone_number) }}"
                                        class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Changer le mot de passe</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Nouveau mot de passe
                                    </label>
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Laissez vide pour conserver le mot de passe actuel
                                    </p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Confirmer le mot de passe
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end pt-4">
                            <a href="{{ route('admin.profile.edit') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors mr-4">
                                Annuler
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- JavaScript pour le menu déroulant et autres fonctionnalités -->
<script>
    // Toggle user dropdown
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    }

    // Preview uploaded image
    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.querySelector('.relative img');
                    if (imgElement) {
                        imgElement.src = e.target.result;
                    } else {
                        const iconContainer = document.querySelector('.relative div');
                        if (iconContainer) {
                            iconContainer.innerHTML = '';
                            iconContainer.classList.remove('flex', 'items-center', 'justify-center');
                            
                            const newImg = document.createElement('img');
                            newImg.src = e.target.result;
                            newImg.alt = 'Photo de profil';
                            newImg.className = 'w-32 h-32 object-cover rounded-full border-4 border-white shadow-md';
                            
                            iconContainer.parentNode.replaceChild(newImg, iconContainer);
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>

</body>
</html> 