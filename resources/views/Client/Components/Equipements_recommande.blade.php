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
   
    
        
        <!-- Equipment recommendations -->
        <div class="mb-8">

            <div class="mb-16">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Équipements recommandés</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Voici quelques équipements que vous pouvez utiliser dans votre prochain camping!</p>
            </div>
                
            <div class="flex justify-end">
                <a href="{{ route('client.listings.index') }}"
                    class="inline-block mb-8 px-4 py-2 bg-forest text-white text-sm font-medium rounded hover:bg-green-700 transition">
                    Voir tous les équipements
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Recommendation 1 -->
                @foreach($allSimilarListings as $item1)
                <div class="equipment-card bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden relative">
                    @if($item1->is_premium)
                        <div class="absolute top-2 left-2 z-10 bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            Premium
                        </div>
                    @endif
                    <a href="{{ route('client.listings.show', $item1->lis_id) }}">
                    <div class="relative h-48">
                        <img src="{{ $item1->image_url }}" alt="Image" 
                             class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
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
                                @if($item1->review_count !=0)
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
                                <span class="font-medium text-green-700 dark:text-green-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i> 
                                    {{$item1->city_name}}
                                </span>
                            </div>
                            <a href="{{ route('client.listings.show', $item1->lis_id) }}" class="px-3 py-1.5 bg-forest hover:bg-green-700 text-white text-sm rounded-md transition-colors">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                    </a>
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