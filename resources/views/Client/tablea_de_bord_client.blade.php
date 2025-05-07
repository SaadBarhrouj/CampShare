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
    <div id="dashboard" class="component">
        @include ('Client.Components.Dashboard');
    </div>
    <div id="mes-avis" class="component hidden">
        @include ('Client.Components.Avis');
    </div>
    <div id="allRes" class="component hidden">
        @include ('Client.Components.AllReservation');
    </div>
    <div id="allSim" class="component hidden">
        @include ('Client.Components.Equipements_recommande');
    </div>
    <div id="profile" class="component hidden">
        @include ('Client.Components.Profile');
    </div>
    <div id="message-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" 
                         alt="Omar Tazi" 
                         class="w-10 h-10 rounded-full object-cover mr-3" />
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Omar Tazi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Grande Tente 6 Personnes</p>
                    </div>
                </div>
                <button id="close-message-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <form id="message-form" class="flex items-end">
                    <div class="flex-grow">
                        <textarea id="message-input" placeholder="Tapez votre message..." class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow text-base resize-none custom-input" rows="3"></textarea>
                    </div>
                    <div class="ml-3 flex flex-col space-y-2">
                        <button type="button" class="p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <button type="submit" class="p-2 bg-forest hover:bg-green-700 text-white rounded-md shadow-sm transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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