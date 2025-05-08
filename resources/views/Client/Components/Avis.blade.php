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
        <!-- Dashboard header -->
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Avis reçus</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Voici un résumé des avis des utilisateurs sur vous.</p>
            </div>
        
    </div>
    <div class="py-8 px-4 md:px-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h2 class="font-bold text-xl text-gray-900 dark:text-white">Liste des avis</h2>
            
            </div>

            <!-- Request items -->
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Request 1 -->
                @foreach ($reviews as $review)

                <div class="px-6 py-4">
                    <div class="flex flex-col lg:flex-row lg:items-start">
                       

                        <div class="flex-grow grid grid-cols-1 lg:grid-cols-7 gap-4 mb-4 lg:mb-0">
                            <div class="flex-shrink-0 mb-4 lg:mb-0 lg:mr-6 w-full lg:w-auto col-span-2">
                                <div class="flex items-center lg:w-16">
                                    <img src="{{ asset($review->reviewer_avatar) }}" 
                                        alt="image" 
                                        class="w-12 h-12 rounded-full object-cover" />
                                    <div class="ml-4">
                                        <a href="{{ route('partner.profile.index', $review->reviewer_id) }}">
                                            <h3 class="font-medium text-gray-900 dark:text-white">{{$review->reviewer_name}}</h3>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Note reçu</p>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-star text-amber-400 mr-1"></i>
                                    <span>{{ $review->rating }}</span>
                                </div>
                            </div>
                            <div class="col-span-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Commentaire</p>
                                <p class="font-medium text-gray-900 dark:text-white"> {{ $review->comment }}</p>
                            </div>
                            <div class="col-span-1">
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