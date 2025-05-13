<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $listing->item?->title ?? 'Détail Équipement' }} - CampShare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampShare - ParentCo</title>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/styles.css', 'resources/js/script.js'])

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

     <!-- Map dependencies -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        .flatpickr-calendar { background-color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 1px solid #e5e7eb; width: auto; max-width: 600px; }
        .dark .flatpickr-calendar { background-color: #1f2937; border-color: #374151; }
        .flatpickr-months { background: #2D5F2B; border-top-left-radius: 7px; border-top-right-radius: 7px; }
        .flatpickr-months .flatpickr-month { background: transparent; color: white; fill: white; height: 48px; display: flex; align-items: center; justify-content: space-between; padding: 0 10px; text-align: center; }
        .flatpickr-months .flatpickr-prev-month, .flatpickr-months .flatpickr-next-month { position: relative; top: auto; padding: 5px; margin: 0 5px; flex-shrink: 0; color: white !important; fill: white !important; opacity: 0.8; transition: opacity 0.15s; cursor: pointer; }
        .flatpickr-months .flatpickr-prev-month svg, .flatpickr-months .flatpickr-next-month svg { width: 14px; height: 14px; }
        .flatpickr-months .flatpickr-prev-month:hover, .flatpickr-months .flatpickr-next-month:hover { opacity: 1; background-color: rgba(255, 255, 255, 0.1); border-radius: 4px; }
        .flatpickr-current-month { font-size: 1rem; font-weight: 600; color: white; position: relative; display: flex; align-items: center; justify-content: center; flex-grow: 1; padding: 0 5px; }
        span.flatpickr-monthDropdown-months { font-weight: inherit; color: inherit; margin-right: 5px; display: inline-flex; align-items: center; cursor: pointer;}
        span.flatpickr-monthDropdown-months .arrowDown { margin-left: 4px; border-top-color: white !important; opacity: 0.8; }
        span.flatpickr-monthDropdown-months:hover .arrowDown { opacity: 1; }
        .flatpickr-current-month input.cur-year { font-weight: inherit; font-size: inherit; color: inherit; background: transparent; border: none; padding: 0; margin: 0; box-sizing: content-box; text-align: left; appearance: textfield; width: auto; max-width: 50px; display: inline-block; vertical-align: middle; cursor: text; }
        .flatpickr-current-month input.cur-year:hover { background: rgba(255, 255, 255, 0.1); border-radius: 3px; }
        .flatpickr-weekdays { background: #f9fafb; padding: 8px 0; }
        .dark .flatpickr-weekdays { background: #374151; }
        .flatpickr-weekday { color: #6b7280; font-weight: 500; font-size: 0.75rem; text-transform: capitalize; }
        .dark .flatpickr-weekday { color: #9ca3af; }
        .flatpickr-day { border: 1px solid transparent; height: 38px; line-height: 38px; font-size: 0.875rem; max-width: 38px; margin: 1px auto; border-radius: 50%; cursor: pointer; }
        .flatpickr-day:hover { background-color: #f3f4f6; }
        .dark .flatpickr-day:hover { background-color: #374151; }
        .flatpickr-day.today { border-color: #FDBA74; }
        .flatpickr-day.today:hover { border-color: #FDBA74; background-color: #FFF7ED; }
        .dark .flatpickr-day.today { border-color: #FDBA74; }
        .dark .flatpickr-day.today:hover { background-color: #4b5563; }
        .flatpickr-day.startRange, .flatpickr-day.selected.startRange { background: #FFAA33 !important; border-color: #FFAA33 !important; color: white !important; border-radius: 50% 0 0 50% !important; }
        .flatpickr-day.endRange, .flatpickr-day.selected.endRange { background: #3B82F6 !important; border-color: #3B82F6 !important; color: white !important; border-radius: 0 50% 50% 0 !important; }
        .flatpickr-day.startRange.endRange { border-radius: 50% !important; }
        .flatpickr-day.inRange { background: #FEF3C7 !important; border-color: transparent !important; box-shadow: none !important; border-radius: 0 !important; color: #1f2937 !important; }
        .dark .flatpickr-day.startRange, .dark .flatpickr-day.selected.startRange { background: #FFAA33 !important; border-color: #FFAA33 !important; color: #111827 !important; }
        .dark .flatpickr-day.endRange, .dark .flatpickr-day.selected.endRange { background: #60A5FA !important; border-color: #60A5FA !important; color: #111827 !important; }
        .dark .flatpickr-day.inRange { background: #374151 !important; color: #d1d5db !important; }
        .flatpickr-day.flatpickr-disabled, .flatpickr-day.prevMonthDay.flatpickr-disabled, .flatpickr-day.nextMonthDay.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover { background-color: #f9fafb !important; background-image: repeating-linear-gradient( 45deg, transparent, transparent 4px, rgba(209, 213, 219, 0.7) 4px, rgba(209, 213, 219, 0.7) 5px ) !important; border-color: transparent !important; color: #9ca3af !important; cursor: not-allowed !important; border-radius: 50% !important; }
        .dark .flatpickr-day.flatpickr-disabled, .dark .flatpickr-day.prevMonthDay.flatpickr-disabled, .dark .flatpickr-day.nextMonthDay.flatpickr-disabled, .dark .flatpickr-day.flatpickr-disabled:hover { background-color: #1f2937 !important; background-image: repeating-linear-gradient( 45deg, transparent, transparent 4px, rgba(55, 65, 81, 0.6) 4px, rgba(55, 65, 81, 0.6) 5px ) !important; border-color: transparent !important; color: #4b5563 !important; cursor: not-allowed !important; border-radius: 50% !important; }
        .flatpickr-day.selected:not(.startRange):not(.endRange) { background: #fbbf24; border-color: #fbbf24; color: #1f2937; border-radius: 50% !important; }
        .dark .flatpickr-day.selected:not(.startRange):not(.endRange) { background: #fbbf24; border-color: #fbbf24; color: #1f2937; }
        /* Styles Miniatures */
         .thumbnail { cursor: pointer; transition: all 0.2s ease; border: 2px solid transparent; }
         .thumbnail:hover { opacity: 0.8; }
         .thumbnail.active { border-color: #FFAA33; }
        /* Styles Onglets */
        .tab-button { transition: all 0.2s ease; }
        .tab-active { color: #2D5F2B; border-bottom-color: #FFAA33; font-weight: 500; }
        .dark .tab-active { color: #9ae6b4; border-bottom-color: #FFAA33; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

</head>


<body class="font-sans antialiased text-gray-800 bg-gray-50 dark:text-gray-200 dark:bg-gray-900">

    @include('partials.header')

    <main class="pt-16">
        <!-- SECTION: Breadcrumb -->
        <div class="bg-white dark:bg-gray-800 py-2 border-b border-gray-200 dark:border-gray-700 text-xs sm:text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                         <li class="inline-flex items-center">
                            <a href="{{ url('/') }}" class="inline-flex items-center font-medium text-gray-500 hover:text-forest dark:text-gray-400 dark:hover:text-meadow">
                                <i class="fas fa-home mr-1.5 text-xs"></i> Accueil
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right fa-xs text-gray-400"></i>
                                <a href="{{ route('client.listings.index') }}" class="ms-1 font-medium text-gray-500 hover:text-forest md:ms-2 dark:text-gray-400 dark:hover:text-meadow">Explorer</a>
                            </div>
                        </li>
                         @if($listing->item?->category)
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right fa-xs text-gray-400"></i>
                                <span class="ms-1 font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ $listing->item->category->name }}</span>
                            </div>
                         @endif
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right fa-xs text-gray-400"></i>
                                <span class="ms-1 font-medium text-gray-700 md:ms-2 dark:text-gray-300">{{ $listing->item?->title ?? 'Détail' }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- SECTION: Détail Équipement -->
        <section class="py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

                    <div class="w-full lg:w-7/12">
                        <div class="mb-6 sm:mb-8">
                             <div class="relative aspect-[4/3] mb-3 sm:mb-4 bg-gray-200 dark:bg-gray-800 rounded-lg overflow-hidden shadow-md">
                                <img id="mainImage"
                                     src="{{ $listing->item?->images?->first() ? asset($listing->item->images->first()->url) : asset('images/item-default.jpg') }}"
                                     alt="Image principale de {{ $listing->item?->title ?? 'équipement' }}"
                                     class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 ease-in-out p-1"/>
                            </div>
                            @if($listing->item?->images?->count() > 1)
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach($listing->item->images->take(5) as $image)
                                    <div class="thumbnail aspect-square {{ $loop->first ? 'active border-sunlight' : 'border-transparent' }} bg-gray-100 dark:bg-gray-700 rounded overflow-hidden cursor-pointer border-2 transition-all duration-200"
                                         onclick="changeImage(this, '{{ asset($image->url) ?? asset('images/item-default.jpg') }}')">
                                        <img src="{{ asset($image->url) ?? asset('images/item-default.jpg') }}" alt="Miniature {{ $loop->iteration }}" class="w-full h-full object-cover" loading="lazy"/>
                                    </div>
                                    @endforeach
                                    @for ($i = ($listing->item?->images?->count() ?? 0); $i < 5; $i++)
                                        <div class="aspect-square bg-gray-100 dark:bg-gray-800 rounded"></div>
                                    @endfor
                                </div>
                            @elseif(!$listing->item?->images || $listing->item?->images?->isEmpty())
                                <p class="text-center text-sm text-gray-500 dark:text-gray-400 italic">Aucune image disponible.</p>
                            @endif
                        </div>

                        <!-- SOUS-SECTION: Navigation par Onglets -->
                        <div class="border-b border-gray-200 dark:border-gray-700 sticky top-16 bg-gray-50 dark:bg-gray-900 z-30 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:relative lg:top-0 lg:bg-transparent dark:lg:bg-transparent mb-6">
                            <div class="flex overflow-x-auto scrollbar-hide space-x-6 sm:space-x-8">
                                <button class="tab-button py-3 font-medium text-sm sm:text-base whitespace-nowrap border-b-2" data-target="details-section">
                                    Description
                                </button>
                                <button class="tab-button py-3 font-medium text-sm sm:text-base text-gray-500 dark:text-gray-400 whitespace-nowrap border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600" data-target="reviews-section">
                                    Avis ({{ $reviewCount ?? 0 }})
                                </button>
                                <button class="tab-button py-3 font-medium text-sm sm:text-base text-gray-500 dark:text-gray-400 whitespace-nowrap border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600" data-target="location-section">
                                    Localisation
                                </button>
                            </div>
                        </div>
                        <!-- FIN SOUS-SECTION: Navigation par Onglets -->

                        <!-- SOUS-SECTION: Contenu des Onglets -->
                        <div class="space-y-8">
                            <!-- Onglet: Description -->
                            <section id="details-section" class="tab-content">
                                {{-- Description HTML (identique) --}}
                                 <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 sr-only">Description</h2>
                                <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 dark:text-gray-300 dark:prose-invert prose-headings:font-semibold prose-a:text-forest dark:prose-a:text-meadow">
                                    {!! nl2br(e($listing->item?->description ?? 'Aucune description fournie.')) !!}
                                </div>
                            </section>
                            <!-- Fin Onglet: Description -->

                             <!-- Onglet: Avis -->
                            <section id="reviews-section" class="tab-content hidden">
                                 {{-- Reviews HTML (identique) --}}
                                 <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 sr-only">Avis des utilisateurs</h2>
                                 @if(($reviewCount ?? 0) > 0 && isset($reviews) && $reviews instanceof \Illuminate\Support\Collection && $reviews->isNotEmpty())
                                     {{-- Résumé des Notes --}}
                                       <div class="bg-white dark:bg-gray-800/50 rounded-lg p-4 sm:p-6 mb-6 border border-gray-200 dark:border-gray-700">
                                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
                                            <div class="w-full sm:w-auto sm:flex-shrink-0 flex flex-col items-center text-center">
                                                <div class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white">{{ number_format($averageRating ?? 0, 1) }}</div>
                                                <div class="flex text-sunlight text-lg sm:text-xl mt-1" title="Note moyenne de {{ number_format($averageRating ?? 0, 1) }} sur 5">
                                                     @php $avg = round($averageRating ?? 0); $half = (($averageRating ?? 0) - $avg >= -0.5 && ($averageRating ?? 0) - $avg < 0); @endphp
                                                     @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $avg) <i class="fas fa-star"></i>
                                                        @elseif ($half && $i == $avg + 1) <i class="fas fa-star-half-alt"></i>
                                                        @else <i class="far fa-star text-gray-300 dark:text-gray-600"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Basé sur {{ $reviewCount }} avis</div>
                                            </div>
                                            <div class="flex-1 w-full">
                                                <div class="space-y-1.5">
                                                     @foreach(collect($ratingPercentages ?? [])->sortKeysDesc() as $stars => $percentage)
                                                    <div class="flex items-center" title="{{ round($percentage) }}% des avis ont donné {{ $stars }} étoile(s)">
                                                        <div class="w-16 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">{{ $stars }} étoile{{ $stars > 1 ? 's' : '' }}</div>
                                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mx-2">
                                                            <div class="h-full bg-sunlight rounded-full" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                        <div class="w-10 text-right text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ round($percentage) }}%</div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                
                                     <div class="space-y-6">
                                         @foreach ($reviews as $review)
                                         <div class="review-item border-b border-gray-200 dark:border-gray-700 pb-5 last:border-b-0 {{ $loop->index >= 3 ? 'hidden' : '' }}">
                                              <div class="flex items-start space-x-3">
                                                <a href="{{ route('client.profile.index', $review->reviewer?->id) }}">
                                                    <img src="{{ asset($review->reviewer?->avatar_url) ?? asset('images/default-avatar.jpg') }}"
                                                        alt="Avatar de {{ $review->reviewer?->username ?? 'Utilisateur' }}"
                                                        class="w-10 h-10 rounded-full object-cover flex-shrink-0 mt-1 border border-gray-200 dark:border-gray-600">
                                                </a>
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <a href="{{ route('client.profile.index', $review->reviewer?->id) }}">
                                                            <span class="font-semibold text-sm text-gray-800 dark:text-white">{{ $review->reviewer?->username ?? 'Utilisateur anonyme' }}</span>
                                                        </a>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400" title="{{ $review->created_at?->isoFormat('LLLL') }}">
                                                            {{ $review->created_at?->diffForHumans() ?? 'Date inconnue' }}
                                                        </span>
                                                    </div>
                                                    <div class="flex text-sunlight mb-1.5" title="{{ $review->rating }} sur 5 étoiles">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-xs"></i>
                                                        @endfor
                                                    </div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300 prose prose-sm max-w-none dark:prose-invert">
                                                        {{ $review->comment ?? 'Aucun commentaire.' }}
                                                    </p>
                                                </div>
                                            </div>
                                         </div>
                                         @endforeach

                                         {{-- Boutons Voir plus/moins --}}
                                         @if($reviewCount > 3)
                                         <div class="flex justify-center pt-4 space-x-3">
                                             <button id="loadMoreBtn" class="px-4 py-1.5 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                                 Voir plus d'avis
                                             </button>
                                             <button id="loadLessBtn" class="hidden px-4 py-1.5 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                                 Voir moins
                                             </button>
                                         </div>
                                         @endif
                                     </div>
                                 @else
                                     {{-- Message si aucun avis --}}
                                     <div class="text-center py-10 px-6 bg-white dark:bg-gray-800/50 rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                                         <i class="far fa-comment-dots fa-3x text-gray-400 dark:text-gray-500 mb-3"></i>
                                         <p class="text-gray-600 dark:text-gray-400 font-medium">Cet équipement n'a pas encore reçu d'avis.</p>
                                         <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Soyez le premier à partager votre expérience après l'avoir loué !</p>
                                     </div>
                                 @endif
                             </section>

                            <section id="location-section" class="">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 sr-only">Localisation de l'équipement</h2>
                                <div class="flex items-center text-gray-700 dark:text-gray-300 mb-4 text-base">
                                    <i class="fas fa-map-marker-alt fa-fw mr-2.5 text-gray-400 dark:text-gray-500"></i>
                                    Disponible dans la zone de <span class="font-semibold ml-1">{{ $listing->city?->name ?? 'Ville non spécifiée' }}</span>.
                                </div>
                                <div id="listing-map-container" class="z-0 mt-4 h-64 sm:h-80 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-600"></div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 italic">
                                    <i class="fas fa-info-circle mr-1"></i>L'adresse exacte ou le point de rencontre précis vous sera communiqué par le partenaire après la confirmation de votre réservation.
                                </p>
                            </section>

                            
         
                        </div>
                       
                    </div>
                    <!-- === FIN COLONNE GAUCHE === -->

                    <!-- === COLONNE DROITE : Réservation === -->
                    <div class="w-full lg:w-5/12">
                         <!-- SOUS-SECTION: Carte de Réservation -->
                         <div class="lg:sticky top-20 bg-white dark:bg-gray-800 p-5 sm:p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                             <!-- Bloc Titre, Prix, Note -->
                             <div class="pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                                 {{-- Titre, Prix, Note HTML (identique) --}}
                                 <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-1">{{ $listing->item?->title ?? 'Équipement à louer' }}</h2>
                                <div class="flex items-baseline mb-2">
                                    <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($listing->item?->price_per_day ?? 0, 2) }} MAD</span>
                                    <span class="text-gray-600 dark:text-gray-300 ml-1.5 text-sm">/ jour</span>
                                </div>
                                <div class="flex items-center text-xs sm:text-sm text-gray-600 dark:text-gray-400 flex-wrap gap-x-3 gap-y-1">
                                    @if($reviewCount > 0)
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-star text-sunlight mr-1"></i>
                                        <span class="font-medium mr-1">{{ number_format($averageRating, 1) }}</span>
                                        <span>({{ $reviewCount }} avis)</span>
                                    </span>
                                    <span class="hidden sm:inline">·</span>
                                    @endif
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-map-marker-alt fa-fw mr-1"></i>
                                        <span>{{ $listing->city?->name ?? 'Non spécifié' }}</span>
                                    </span>
                                </div>
                             </div>


                             <form id="reservation-form" method="POST" action="{{ route('reservations.store') }}">
                                @csrf
                                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                <input type="hidden" name="start_date" id="start_date">
                                <input type="hidden" name="end_date" id="end_date">

                                <!-- Sélecteur de dates -->
                                <div class="mb-4">
                                     <label for="date-range-picker" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Choisissez vos dates</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <i class="far fa-calendar-alt text-gray-400"></i>
                                        </div>
                                        <input type="text" id="date-range-picker" placeholder="Date de début - Date de fin" readonly="readonly"
                                               class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-1 focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-2 cursor-pointer appearance-none">
                                    </div>
                                    <div id="flatpickr-error" class="text-xs text-red-600 dark:text-red-400 mt-1"></div>
                                </div>

                                <!-- Option livraison -->
                                @if($listing->delivery_option)
                                <div class="mb-4">
                                    @php
                                        $fixedDeliveryCost = 50.00;
                                    @endphp
                                      <label for="delivery_option_checkbox" class="flex items-center cursor-pointer select-none p-2 border border-gray-200 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <input type="checkbox" id="delivery_option_checkbox" name="delivery_option" value="1" class="h-4 w-4 rounded border-gray-300 text-forest focus:ring-forest dark:bg-gray-600 dark:border-gray-500 dark:checked:bg-forest flex-shrink-0">
                                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Ajouter l'option de livraison
                                            {{-- Affiche le coût fixe défini en PHP --}}
                                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">(+{{ number_format($fixedDeliveryCost, 2) }} MAD)</span>
                                        </span>
                                    </label>
                                </div>
                                @endif

                                <!-- Section Calcul du Prix (sans frais de service) -->
                                <div id="price-calculation" class="hidden mt-4 mb-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-md border border-gray-200 dark:border-gray-700 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span id="price-breakdown" class="text-gray-600 dark:text-gray-400">Calcul du prix...</span>
                                        <span class="text-gray-700 dark:text-gray-200 font-medium" id="subtotal">0.00 MAD</span>
                                    </div>
                                    <div id="delivery-fee-row" class="hidden justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Frais de livraison</span>
                                        <span class="text-gray-700 dark:text-gray-200 font-medium" id="delivery-fee">0.00 MAD</span>
                                    </div>
                                    <div class="flex justify-between pt-2 border-t border-gray-300 dark:border-gray-600 text-base font-semibold">
                                        <span class="text-gray-900 dark:text-white">Total</span>
                                        <span class="text-gray-900 dark:text-white" id="total-price">0.00 MAD</span>
                                    </div>
                                </div>

                                <button type="submit" id="reservation-button" disabled
                                        class="w-full mt-2 py-3 px-4 bg-sunlight hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center text-base">
                                    <i class="far fa-calendar-check mr-2"></i>
                                    <span id="reservation-button-text">Sélectionner les dates</span>
                                </button>
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-2">Vous ne serez pas débité avant la confirmation du partenaire.</p>
                            </form>

                            @if($listing->item?->partner)
                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4 text-sm">
                                 {{-- Infos Partenaire HTML (identique) --}}
                                  <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Proposé par :</p>
                                 <div class="flex items-center">
                                    <a href="{{ route('partner.profile.index', $listing->item->partner->id) }}">
                                        <img src="{{ asset($listing->item->partner->avatar_url) ?? asset('images/avatar-default.jpg') }}"
                                            alt="Avatar de {{ $listing->item->partner->username ?? 'Partenaire' }}"
                                            class="w-9 h-9 rounded-full object-cover mr-2.5 border border-gray-200 dark:border-gray-600">
                                    </a>
                                    <div class="leading-tight">
                                        <a href="{{ route('partner.profile.index', $listing->item->partner->id) }}">
                                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $listing->item->partner->username ?? 'Partenaire CampShare' }}</span>
                                        </a>
                                         <p class="text-xs text-gray-500 dark:text-gray-400">
                                             Membre depuis {{ $listing->item->partner->created_at?->translatedFormat('F Y') ?? 'date inconnue' }}
                                         </p>
                                    </div>
                                 </div>
                            </div>
                            @endif
                         </div>
                         <!-- FIN SOUS-SECTION: Carte de Réservation -->
                    </div>
                    <!-- === FIN COLONNE DROITE === -->
                 </div>
            </div>
        </section>
        <!-- FIN SECTION: Détail Équipement -->
    </main>

    @include('partials.footer')

    

    <!-- Map Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $listing->latitude }};
            const lng = {{ $listing->longitude }};
    
            const title = @json($listing->item->title);
            const category = @json($listing->item->category->name);
            const partner = @json($listing->item->partner->username);

            // Small offset to hide the exact location (±0.01 degrees ≈ ±1km)
            const offsetLat = lat + (Math.random() - 0.5) * 0.02;
            const offsetLng = lng + (Math.random() - 0.5) * 0.02;
    
            const map = L.map('listing-map-container').setView([offsetLat, offsetLng], 13);
    
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
    
            const radiusMeters = 1500; 
    
            const circle = L.circle([offsetLat, offsetLng], {
                color: '#3b82f6',
                fillColor: '#93c5fd',
                fillOpacity: 0.3,
                radius: radiusMeters
            }).addTo(map);
    
            circle.bindPopup(`
                <div class="flex gap-2 items-center" style="min-width: 250px;">
                    <div>
                        <strong>${title}</strong><br>
                        <small>Catégorie: ${category}</small><br>
                        <small>Partenaire: ${partner}</small><br>
                        <em>Zone approximative</em>
                    </div>
                </div>
            `);

            circle.on('mouseover', function () {
                this.openPopup();
            });
            circle.on('mouseout', function () {
                this.closePopup();
            });

            bounds.push([loc.offsetLat, loc.offsetLng]);

        });
    </script>
    
    




    <!-- === SCRIPTS JAVASCRIPT === -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- Galerie d'images ---
            window.changeImage = function(thumbnailElement, newImageSrc) {
                 const mainImage = document.getElementById('mainImage');
                 if(!mainImage) return;
                 mainImage.style.opacity = 0.8;
                 mainImage.onload = () => { mainImage.style.opacity = 1; };
                 mainImage.onerror = () => { mainImage.style.opacity = 1; console.error('Error loading image:', newImageSrc);};
                 mainImage.src = newImageSrc;
                 document.querySelectorAll('.thumbnail').forEach(thumb => {
                     thumb.classList.remove('active', 'border-sunlight');
                     thumb.classList.add('border-transparent');
                 });
                 if(thumbnailElement) { // Check if element exists
                     thumbnailElement.classList.add('active', 'border-sunlight');
                     thumbnailElement.classList.remove('border-transparent');
                 }
             };

            // --- Gestion des onglets ---
            const tabButtons = document.querySelectorAll('.tab-button');
             const tabContents = document.querySelectorAll('.tab-content');
             const firstTabButton = document.querySelector('.tab-button');

             function activateTab(buttonToActivate) {
                if (!buttonToActivate) return;
                  tabButtons.forEach(btn => {
                     btn.classList.remove('tab-active');
                     btn.classList.add('text-gray-500', 'dark:text-gray-400', 'border-transparent');
                     btn.classList.remove('text-gray-900', 'dark:text-white', 'font-semibold');
                 });
                 buttonToActivate.classList.add('tab-active');
                 buttonToActivate.classList.remove('text-gray-500', 'dark:text-gray-400', 'border-transparent');
                 buttonToActivate.classList.add('text-gray-900', 'dark:text-white', 'font-semibold');

                 tabContents.forEach(content => content.classList.add('hidden'));
                 const targetId = buttonToActivate.getAttribute('data-target');
                 const targetElement = document.getElementById(targetId);
                 if (targetElement) {
                     targetElement.classList.remove('hidden');
                 }
            }
             tabButtons.forEach(button => {
                 button.addEventListener('click', () => activateTab(button));
             });
             if (firstTabButton) {
                 activateTab(firstTabButton);
             }

             const reviewsContainer = document.querySelector('#reviews-section .space-y-6');
             if (reviewsContainer) {
                 const reviewItems = reviewsContainer.querySelectorAll('.review-item');
                 const loadMoreBtn = document.getElementById('loadMoreBtn');
                 const loadLessBtn = document.getElementById('loadLessBtn');
                 const reviewsToShowInitially = 3;

                 function updateReviewVisibility(showAll) {
                     let visibleCount = 0;
                     reviewItems.forEach((review, index) => {
                         if (showAll || index < reviewsToShowInitially) {
                             review.classList.remove('hidden');
                             visibleCount++;
                         } else {
                             review.classList.add('hidden');
                         }
                     });
                     const canShowMore = reviewItems.length > reviewsToShowInitially;
                     if (loadMoreBtn) loadMoreBtn.classList.toggle('hidden', !canShowMore || showAll);
                     if (loadLessBtn) loadLessBtn.classList.toggle('hidden', !canShowMore || !showAll);
                 }

                 if (reviewItems.length > reviewsToShowInitially) {
                     updateReviewVisibility(false);
                     if(loadMoreBtn) {
                         loadMoreBtn.addEventListener('click', () => updateReviewVisibility(true));
                     }
                     if(loadLessBtn) {
                         loadLessBtn.addEventListener('click', () => {
                             updateReviewVisibility(false);
                             document.getElementById('reviews-section')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                         });
                     }
                 } else {
                     if(loadMoreBtn) loadMoreBtn.classList.add('hidden');
                     if(loadLessBtn) loadLessBtn.classList.add('hidden');
                 }
             }

            const dateRangePickerEl = document.getElementById('date-range-picker');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const priceCalculationDiv = document.getElementById('price-calculation');
            const priceBreakdownSpan = document.getElementById('price-breakdown');
            const subtotalSpan = document.getElementById('subtotal');
            const deliveryFeeRow = document.getElementById('delivery-fee-row');
            const deliveryFeeSpan = document.getElementById('delivery-fee');
            const totalPriceSpan = document.getElementById('total-price');
            const reservationButton = document.getElementById('reservation-button');
            const reservationButtonText = document.getElementById('reservation-button-text');
            const deliveryCheckbox = document.getElementById('delivery_option_checkbox');
            const flatpickrErrorDiv = document.getElementById('flatpickr-error');

            const listingId = {{ $listing->id ?? 0 }};
            const pricePerDay = {{ (float)($listing->item?->price_per_day ?? 0) }};
            const listingStartDateString = "{{ $listing->start_date?->format('Y-m-d') }}";
            const listingEndDateString = "{{ $listing->end_date?->format('Y-m-d') }}";
            const deliveryAvailable = {{ ($listing->delivery_option ?? false) ? 'true' : 'false' }};
            // *** MODIFICATION ICI: Utilisation d'un coût fixe pour la livraison ***
            const FIXED_DELIVERY_COST = 50.00; // Définir le coût fixe ici

             // Dates indisponibles 
             const unavailableDatesData = {!! json_encode($unavailableDates ?? []) !!};

            // Variables globales JS
            let flatpickrInstance = null;
            let selectedStartDate = null;
            let selectedEndDate = null;

            // Fonction formatage devise
            function formatCurrency(amount) {
                return amount.toLocaleString('fr-MA', { style: 'currency', currency: 'MAD', minimumFractionDigits: 2 });
            }

            function calculateAndUpdatePrice() {
                if (selectedStartDate && selectedEndDate && pricePerDay > 0) {
                    const start = new Date(selectedStartDate.getTime());
                    const end = new Date(selectedEndDate.getTime());
                    start.setUTCHours(0, 0, 0, 0);
                    end.setUTCHours(0, 0, 0, 0);

                    if (start > end) {
                        if(priceCalculationDiv) priceCalculationDiv.classList.add('hidden');
                        if(reservationButton) reservationButton.disabled = true;
                        if(reservationButtonText) reservationButtonText.textContent = 'Dates invalides';
                        return;
                    }

                    const diffTime = end.getTime() - start.getTime();
                    const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1;

                    if (diffDays > 0) {
                        const subtotal = diffDays * pricePerDay;
                        let currentDeliveryCost = 0;

                        // *** MODIFICATION ICI: Vérifie si dispo et cochée, utilise le coût fixe ***
                        if (deliveryAvailable && deliveryCheckbox && deliveryCheckbox.checked) {
                            currentDeliveryCost = FIXED_DELIVERY_COST; // Utilise le coût fixe
                            if(deliveryFeeRow) deliveryFeeRow.classList.remove('hidden');
                            if(deliveryFeeSpan) deliveryFeeSpan.textContent = formatCurrency(currentDeliveryCost);
                        } else {
                            currentDeliveryCost = 0; 
                            if(deliveryFeeRow) deliveryFeeRow.classList.add('hidden');
                        }

                        const total = subtotal + currentDeliveryCost; // Calcul sans frais de service

                        // Mettre à jour affichage
                        if(priceBreakdownSpan) priceBreakdownSpan.textContent = `${formatCurrency(pricePerDay)} × ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
                        if(subtotalSpan) subtotalSpan.textContent = formatCurrency(subtotal);
                        if(totalPriceSpan) totalPriceSpan.textContent = formatCurrency(total);

                        // Afficher le bloc et activer bouton
                        if(priceCalculationDiv) priceCalculationDiv.classList.remove('hidden');
                        if(reservationButton) reservationButton.disabled = false;
                        if(reservationButtonText) reservationButtonText.textContent = 'Demander à réserver';
                        return;
                    }
                }
                // Cacher/Réinitialiser
                if(priceCalculationDiv) priceCalculationDiv.classList.add('hidden');
                if(reservationButton) reservationButton.disabled = true;
                if(reservationButtonText) reservationButtonText.textContent = 'Sélectionner les dates';
            }

            // Écouteur checkbox livraison
            if (deliveryCheckbox) {
                 deliveryCheckbox.addEventListener('change', calculateAndUpdatePrice);
            }

            // Fonction initializeFlatpickr
            function initializeFlatpickr(disabledDates = []) {
                const today = new Date();
                today.setUTCHours(0, 0, 0, 0);
                let minDateForPicker = today;

                if (listingStartDateString) {
                     const listingStart = new Date(listingStartDateString + 'T00:00:00Z');
                     if (listingStart > today) {
                         minDateForPicker = listingStart;
                     }
                 }

                const flatpickrOptions = {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    locale: "fr",
                    inline: false,
                    numberOfMonths: window.innerWidth < 768 ? 1 : 2,
                    minDate: minDateForPicker,
                    disable: disabledDates, 
                    altInput: true,
                    altFormat: "j F Y",
                    onOpen: function(selectedDates, dateStr, instance) {
                        instance.set('numberOfMonths', window.innerWidth < 768 ? 1 : 2);
                    },
                    onClose: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length === 2) {
                            selectedStartDate = selectedDates[0];
                            selectedEndDate = selectedDates[1];
                            if(startDateInput) startDateInput.value = instance.formatDate(selectedStartDate, "Y-m-d");
                            if(endDateInput) endDateInput.value = instance.formatDate(selectedEndDate, "Y-m-d");
                            if(flatpickrErrorDiv) flatpickrErrorDiv.textContent = '';
                        } else {
                            selectedStartDate = null;
                            selectedEndDate = null;
                             if(startDateInput) startDateInput.value = '';
                             if(endDateInput) endDateInput.value = '';
                            if (dateStr !== '') {
                                if(flatpickrErrorDiv) flatpickrErrorDiv.textContent = 'Veuillez sélectionner une date de début ET une date de fin.';
                            } else {
                                if(flatpickrErrorDiv) flatpickrErrorDiv.textContent = '';
                            }
                        }
                         calculateAndUpdatePrice(); // Mettre à jour le prix
                    }
                };

                 if (listingEndDateString) {
                      const listingEnd = new Date(listingEndDateString + 'T00:00:00Z');
                      if (listingEnd >= minDateForPicker) {
                         flatpickrOptions.maxDate = listingEnd;
                      }
                 }

                if(dateRangePickerEl) {
                    flatpickrInstance = flatpickr(dateRangePickerEl, flatpickrOptions);
                } else {
                    console.error("L'élément Flatpickr (#date-range-picker) n'a pas été trouvé.");
                }
            }

            // --- Initialisation de Flatpickr avec les données du contrôleur ---
            console.log("Initialisation Flatpickr avec dates indisponibles:", unavailableDatesData);
            initializeFlatpickr(unavailableDatesData); // Utilise la variable passée par Blade
            // --- Fin Initialisation ---

            // Écouteur redimensionnement
            window.addEventListener('resize', () => {
                if (flatpickrInstance && flatpickrInstance.isOpen) {
                    flatpickrInstance.set('numberOfMonths', window.innerWidth < 768 ? 1 : 2);
                }
            });

        }); // Fin DOMContentLoaded
    </script>

</body>
</html>