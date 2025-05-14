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

        /* Améliorations stylistiques supplémentaires */
        /* Animations douces */
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        
        /* Effets visuels pour carte de réservation */
        .card-highlight {
            background: linear-gradient(to bottom, #ffffff, #f9fafb);
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .dark .card-highlight {
            background: linear-gradient(to bottom, #1f2937, #111827);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5), 0 8px 10px -6px rgba(0,0,0,0.4);
        }
        
        /* Améliorations des images produit */
        .product-img-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .product-img-container:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        
        /* Amélioration des boutons */
        .btn-enhanced {
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-enhanced::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120%;
            height: 0;
            padding-bottom: 120%;
            border-radius: 50%;
            transform: translate3d(-50%, -50%, 0) scale(0);
            opacity: 0;
            background-color: rgba(255,255,255,0.1);
            transition: transform 0.4s ease-out, opacity 0.2s ease-out;
        }
        
        .btn-enhanced:active::after {
            transform: translate3d(-50%, -50%, 0) scale(1);
            opacity: 1;
            transition: transform 0s;
        }
        
        /* Améliorations des onglets */
        .tab-button {
            position: relative;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .tab-button::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 3px;
            background-color: #FFAA33;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .tab-button:hover::after {
            width: 40%;
        }
        
        .tab-active::after {
            width: 100%;
        }
        
        /* Amélioration des cartes d'avis */
        .review-card {
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        
        .review-card:hover {
            background-color: rgba(249, 250, 251, 0.8);
            border-color: #e5e7eb;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .dark .review-card:hover {
            background-color: rgba(31, 41, 55, 0.8);
            border-color: #374151;
        }
        
        /* Améliorations des badges et labels */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1;
        }
        
        .badge-subtle {
            background-color: rgba(45, 95, 43, 0.1);
            color: #2D5F2B;
        }
        
        .dark .badge-subtle {
            background-color: rgba(154, 230, 180, 0.1);
            color: #9ae6b4;
        }
    </style>

</head>


<body class="font-sans antialiased text-gray-800 bg-gray-100 dark:text-gray-200 dark:bg-gray-900">

    @include('partials.header')

    <main class="pt-16">
        <!-- SECTION: Breadcrumb -->
        <div class="bg-white dark:bg-gray-800 py-3 border-b border-gray-200 dark:border-gray-700 text-xs sm:text-sm shadow-sm">
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
        <section class="py-10 md:py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

                    <div class="w-full lg:w-7/12">
                        <div class="mb-8 sm:mb-10">
                             <div class="relative aspect-[4/3] mb-4 sm:mb-6 bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden shadow-md product-img-container">
                                <img id="mainImage"
                                     src="{{ $listing->item?->images?->first() ? asset($listing->item->images->first()->url) : asset('images/item-default.jpg') }}"
                                     alt="Image principale de {{ $listing->item?->title ?? 'équipement' }}"
                                     class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 ease-in-out p-1"/>
                            </div>
                            @if($listing->item?->images?->count() > 1)
                                <div class="grid grid-cols-5 gap-2 sm:gap-3">
                                    @foreach($listing->item->images->take(5) as $image)
                                    <div class="thumbnail aspect-square {{ $loop->first ? 'active border-sunlight' : 'border-transparent' }} bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden cursor-pointer border-2 transition-all duration-200 hover:opacity-90"
                                         onclick="changeImage(this, '{{ asset($image->url) ?? asset('images/item-default.jpg') }}')">
                                        <img src="{{ asset($image->url) ?? asset('images/item-default.jpg') }}" alt="Miniature {{ $loop->iteration }}" class="w-full h-full object-cover" loading="lazy"/>
                                    </div>
                                    @endforeach
                                    @for ($i = ($listing->item?->images?->count() ?? 0); $i < 5; $i++)
                                        <div class="aspect-square bg-gray-100 dark:bg-gray-800 rounded-lg"></div>
                                    @endfor
                                </div>
                            @elseif(!$listing->item?->images || $listing->item?->images?->isEmpty())
                                <p class="text-center text-sm text-gray-500 dark:text-gray-400 italic">Aucune image disponible.</p>
                            @endif
                        </div>

                        <!-- SOUS-SECTION: Navigation par Onglets -->
                        <div class="border-b border-gray-200 dark:border-gray-700 sticky top-16 bg-gray-50 dark:bg-gray-900 z-30 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:relative lg:top-0 lg:bg-transparent dark:lg:bg-transparent mb-8">
                            <div class="flex overflow-x-auto scrollbar-hide space-x-8 sm:space-x-10">
                                <button class="tab-button py-4 font-medium text-sm sm:text-base whitespace-nowrap border-b-2" data-target="details-section">
                                    Description
                                </button>
                                <button class="tab-button py-4 font-medium text-sm sm:text-base text-gray-500 dark:text-gray-400 whitespace-nowrap border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600" data-target="reviews-section">
                                    Avis ({{ $reviewCount ?? 0 }})
                                </button>
                                <button class="tab-button py-4 font-medium text-sm sm:text-base text-gray-500 dark:text-gray-400 whitespace-nowrap border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600" data-target="location-section">
                                    Localisation
                                </button>
                            </div>
                        </div>
                        <!-- FIN SOUS-SECTION: Navigation par Onglets -->

                        <!-- SOUS-SECTION: Contenu des Onglets -->
                        <div class="space-y-10">
                            <!-- Onglet: Description -->
                            <section id="details-section" class="tab-content">
                                 <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 sr-only">Description</h2>
                                <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 dark:text-gray-300 dark:prose-invert prose-headings:font-semibold prose-a:text-forest dark:prose-a:text-meadow bg-white dark:bg-gray-800/50 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
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
                                       <div class="bg-white dark:bg-gray-800/50 rounded-xl p-5 sm:p-7 mb-6 border border-gray-200 dark:border-gray-700 shadow-sm">
                                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-8">
                                            <div class="w-full sm:w-auto sm:flex-shrink-0 flex flex-col items-center text-center bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                                                <div class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white">{{ number_format($averageRating ?? 0, 1) }}</div>
                                                <div class="flex text-sunlight text-lg sm:text-xl mt-2" title="Note moyenne de {{ number_format($averageRating ?? 0, 1) }} sur 5">
                                                     @php $avg = round($averageRating ?? 0); $half = (($averageRating ?? 0) - $avg >= -0.5 && ($averageRating ?? 0) - $avg < 0); @endphp
                                                     @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $avg) <i class="fas fa-star"></i>
                                                        @elseif ($half && $i == $avg + 1) <i class="fas fa-star-half-alt"></i>
                                                        @else <i class="far fa-star text-gray-300 dark:text-gray-600"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2"><span class="badge badge-subtle">{{ $reviewCount }} avis</span></div>
                                            </div>
                                            <div class="flex-1 w-full">
                                                <div class="space-y-2.5">
                                                     @foreach(collect($ratingPercentages ?? [])->sortKeysDesc() as $stars => $percentage)
                                                    <div class="flex items-center" title="{{ round($percentage) }}% des avis ont donné {{ $stars }} étoile(s)">
                                                        <div class="w-16 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">{{ $stars }} étoile{{ $stars > 1 ? 's' : '' }}</div>
                                                        <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mx-2">
                                                            <div class="h-full bg-sunlight rounded-full" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                        <div class="w-10 text-right text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ round($percentage) }}%</div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                
                                     <div class="space-y-4">
                                         @foreach ($reviews as $review)
                                         <div class="review-item review-card bg-white dark:bg-gray-800/50 p-4 border-b dark:border-gray-700 last:border-b-0 {{ $loop->index >= 3 ? 'hidden' : '' }}">
                                              <div class="flex items-start space-x-4">
                                                <a href="{{ route('client.profile.index', $review->reviewer?->id) }}" class="flex-shrink-0">
                                                    <img src="{{ asset($review->reviewer?->avatar_url) ?? asset('images/default-avatar.jpg') }}"
                                                        alt="Avatar de {{ $review->reviewer?->username ?? 'Utilisateur' }}"
                                                        class="w-12 h-12 rounded-full object-cover flex-shrink-0 mt-1 border-2 border-white dark:border-gray-600 shadow-sm">
                                                </a>
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <a href="{{ route('client.profile.index', $review->reviewer?->id) }}" class="hover:underline">
                                                            <span class="font-semibold text-gray-800 dark:text-white">{{ $review->reviewer?->username ?? 'Utilisateur anonyme' }}</span>
                                                        </a>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 py-1 px-2 rounded-full" title="{{ $review->created_at?->isoFormat('LLLL') }}">
                                                            {{ $review->created_at?->diffForHumans() ?? 'Date inconnue' }}
                                                        </span>
                                                    </div>
                                                    <div class="flex text-sunlight mb-2" title="{{ $review->rating }} sur 5 étoiles">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-sm"></i>
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
                                         <div class="flex justify-center pt-6 space-x-4">
                                             <button id="loadMoreBtn" class="px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors btn-enhanced">
                                                 <i class="fas fa-chevron-down mr-2"></i> Voir plus d'avis
                                             </button>
                                             <button id="loadLessBtn" class="hidden px-4 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors btn-enhanced">
                                                 <i class="fas fa-chevron-up mr-2"></i> Voir moins
                                             </button>
                                         </div>
                                         @endif
                                     </div>
                                 @else
                                     {{-- Message si aucun avis --}}
                                     <div class="text-center py-12 px-6 bg-white dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-700 shadow-sm">
                                         <i class="far fa-comment-dots fa-4x text-gray-400 dark:text-gray-500 mb-4"></i>
                                         <p class="text-lg text-gray-600 dark:text-gray-400 font-medium">Cet équipement n'a pas encore reçu d'avis.</p>
                                         <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">Soyez le premier à partager votre expérience après l'avoir loué !</p>
                                     </div>
                                 @endif
                             </section>

                            <section id="location-section" class="tab-content">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 sr-only">Localisation de l'équipement</h2>
                                <div class="flex items-center text-gray-700 dark:text-gray-300 mb-5 text-base bg-white dark:bg-gray-800/50 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                                    <i class="fas fa-map-marker-alt fa-fw mr-3 text-forest dark:text-meadow"></i>
                                    Disponible dans la zone de <span class="font-semibold ml-1">{{ $listing->city?->name ?? 'Ville non spécifiée' }}</span>.
                                </div>
                                <div id="listing-map-container" class="z-0 mt-4 h-64 sm:h-80 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-600"></div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-4 italic bg-gray-50 dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <i class="fas fa-info-circle mr-2 text-amber-500"></i>L'adresse exacte ou le point de rencontre précis vous sera communiqué par le partenaire après la confirmation de votre réservation.
                                </p>
                            </section>
                        </div>
                       
                    </div>
                    <!-- === FIN COLONNE GAUCHE === -->

                    <!-- === COLONNE DROITE : Réservation === -->
                    <div class="w-full lg:w-5/12">
                         <!-- SOUS-SECTION: Carte de Réservation -->
                         <div class="lg:sticky top-20 bg-white dark:bg-gray-800 p-6 sm:p-7 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 card-highlight">
                             <!-- Bloc Titre, Prix, Note -->
                             <div class="pb-5 mb-5 border-b border-gray-200 dark:border-gray-700">
                                 {{-- Titre, Prix, Note HTML (identique) --}}
                                 <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $listing->item?->title ?? 'Équipement à louer' }}</h2>
                                <div class="flex items-baseline mb-3">
                                    <span class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($listing->item?->price_per_day ?? 0, 2) }} <span class="text-forest dark:text-meadow">MAD</span></span>
                                    <span class="text-gray-600 dark:text-gray-300 ml-2 text-sm">/ jour</span>
                                </div>
                                <div class="flex flex-wrap gap-3 mt-3">
                                    @if($reviewCount > 0)
                                    <span class="inline-flex items-center badge bg-amber-50 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 py-1.5 px-2.5">
                                        <i class="fas fa-star text-sunlight mr-1.5"></i>
                                        <span class="font-medium mr-1">{{ number_format($averageRating, 1) }}</span>
                                        <span>({{ $reviewCount }} avis)</span>
                                    </span>
                                    @endif
                                    <span class="inline-flex items-center badge bg-forest/10 text-forest dark:bg-meadow/10 dark:text-meadow py-1.5 px-2.5">
                                        <i class="fas fa-map-marker-alt fa-fw mr-1.5"></i>
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
                                <div class="mb-5">
                                     <label for="date-range-picker" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Choisissez vos dates</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <i class="far fa-calendar-alt text-forest dark:text-meadow"></i>
                                        </div>
                                        <input type="text" id="date-range-picker" placeholder="Date de début - Date de fin" readonly="readonly"
                                               class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-1 focus:ring-forest dark:bg-gray-700 dark:text-white text-base py-3 cursor-pointer appearance-none">
                                    </div>
                                    <div id="flatpickr-error" class="text-xs text-red-600 dark:text-red-400 mt-2"></div>
                                </div>

                                <!-- Option livraison -->
                                @if($listing->delivery_option)
                                <div class="mb-5">
                                    @php
                                        $fixedDeliveryCost = 50.00;
                                    @endphp
                                      <label for="delivery_option_checkbox" class="flex items-center cursor-pointer select-none p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <input type="checkbox" id="delivery_option_checkbox" name="delivery_option" value="1" class="h-5 w-5 rounded-md border-gray-300 text-forest focus:ring-forest dark:bg-gray-600 dark:border-gray-500 dark:checked:bg-forest flex-shrink-0">
                                        <div class="ml-3 flex flex-col">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Ajouter l'option de livraison</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">(+{{ number_format($fixedDeliveryCost, 2) }} MAD)</span>
                                        </div>
                                    </label>
                                </div>
                                @endif

                                <!-- Section Calcul du Prix (sans frais de service) -->
                                <div id="price-calculation" class="hidden mt-5 mb-5 p-5 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-700 space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span id="price-breakdown" class="text-gray-600 dark:text-gray-400">Calcul du prix...</span>
                                        <span class="text-gray-700 dark:text-gray-200 font-medium" id="subtotal">0.00 MAD</span>
                                    </div>
                                    <div id="delivery-fee-row" class="hidden justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Frais de livraison</span>
                                        <span class="text-gray-700 dark:text-gray-200 font-medium" id="delivery-fee">0.00 MAD</span>
                                    </div>
                                    <div class="flex justify-between pt-3 border-t border-gray-300 dark:border-gray-600 text-base font-semibold">
                                        <span class="text-gray-900 dark:text-white">Total</span>
                                        <span class="text-gray-900 dark:text-white" id="total-price">0.00 MAD</span>
                                    </div>
                                </div>

                                <button type="submit" id="reservation-button" disabled
                                        class="w-full mt-3 py-4 px-6 bg-sunlight hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center text-base btn-enhanced">
                                    <i class="far fa-calendar-check mr-3 text-lg"></i>
                                    <span id="reservation-button-text">Sélectionner les dates</span>
                                </button>
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-3 bg-gray-50 dark:bg-gray-800/50 p-2 rounded-md">Vous ne serez pas débité avant la confirmation du partenaire.</p>
                            </form>

                            @if($listing->item?->partner)
                            <div class="mt-7 border-t border-gray-200 dark:border-gray-700 pt-5">
                                 {{-- Infos Partenaire HTML (identique) --}}
                                  <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Proposé par :</p>
                                 <div class="flex items-center bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg hover-lift">
                                    <a href="{{ route('partner.profile.index', $listing->item->partner->id) }}" class="flex-shrink-0">
                                        <img src="{{ asset($listing->item->partner->avatar_url) ?? asset('images/avatar-default.jpg') }}"
                                            alt="Avatar de {{ $listing->item->partner->username ?? 'Partenaire' }}"
                                            class="w-12 h-12 rounded-full object-cover mr-3 border-2 border-white dark:border-gray-600 shadow-sm">
                                    </a>
                                    <div class="leading-tight">
                                        <a href="{{ route('partner.profile.index', $listing->item->partner->id) }}" class="hover:underline">
                                            <span class="font-medium text-gray-800 dark:text-gray-100 text-base">{{ $listing->item->partner->username ?? 'Partenaire CampShare' }}</span>
                                        </a>
                                         <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                            <i class="fas fa-user-clock mr-1.5 text-forest/70 dark:text-meadow/70"></i>
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

        </main>

    <!-- Début: Modal de Paiement -->
    <div id="payment-simulation-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-[1000] hidden transition-opacity duration-300 ease-in-out" aria-labelledby="modal-title-text" role="dialog" aria-modal="true">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300 ease-in-out scale-95 opacity-0" id="payment-modal-content">
            <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center" id="modal-title-text">
                    <i class="fas fa-credit-card text-forest dark:text-meadow mr-2"></i>
                    Paiement sécurisé
                </h3>
                <button type="button" id="close-payment-modal-btn" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times fa-lg"></i>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>

            <div class="mt-4">
                <div class="space-y-4">
                    <div class="relative">
                        <label for="card-number-fake" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro de carte</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="far fa-credit-card text-gray-400"></i>
                            </div>
                            <input type="text" id="card-number-fake" name="card_number_fake" placeholder="XXXX XXXX XXXX XXXX" 
                                class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white sm:text-sm p-2.5">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <div class="flex gap-1">
                                    <i class="fab fa-cc-visa text-blue-600 dark:text-blue-400"></i>
                                    <i class="fab fa-cc-mastercard text-red-600 dark:text-red-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="relative">
                            <label for="expiry-month-fake" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mois Exp.</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="text" id="expiry-month-fake" name="expiry_month_fake" placeholder="MM" 
                                    class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white sm:text-sm p-2.5">
                            </div>
                        </div>
                        <div class="relative">
                            <label for="expiry-year-fake" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Année Exp.</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-calendar-check text-gray-400"></i>
                                </div>
                                <input type="text" id="expiry-year-fake" name="expiry_year_fake" placeholder="AA" 
                                    class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white sm:text-sm p-2.5">
                            </div>
                        </div>
                        <div class="relative">
                            <label for="cvv-fake" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CVV</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="text" id="cvv-fake" name="cvv_fake" placeholder="XXX" 
                                    class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white sm:text-sm p-2.5">
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <label for="card-name-fake" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom sur la carte</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="far fa-user text-gray-400"></i>
                            </div>
                            <input type="text" id="card-name-fake" name="card_name_fake" placeholder="Prénom NOM" 
                                class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-forest focus:ring-forest dark:bg-gray-700 dark:text-white sm:text-sm p-2.5">
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-shield-alt text-forest dark:text-meadow"></i>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Paiement sécurisé</span>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Montant total :</span>
                        <strong id="modal-payment-amount" class="text-xl font-bold text-gray-900 dark:text-white">0.00 MAD</strong>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row-reverse gap-3">
                <button type="button" id="confirm-simulated-payment-btn" class="w-full sm:w-auto inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-forest text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest sm:text-sm">
                    <i class="fas fa-check-circle mr-1.5"></i>
                    Confirmer et payer
                </button>
                <button type="button" id="cancel-simulated-payment-btn" class="w-full sm:w-auto mt-3 sm:mt-0 inline-flex justify-center items-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                    <i class="fas fa-times-circle mr-1.5"></i>
                    Annuler
                </button>
            </div>
            <div id="payment-success-message" class="hidden mt-4 p-3 bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 rounded-md flex items-start">
                <i class="fas fa-check-circle text-green-600 dark:text-green-300 mr-2 mt-0.5"></i>
                <span class="text-sm text-green-700 dark:text-green-200">
                    Paiement effectué avec succès ! Redirection vers la confirmation de réservation...
                </span>
            </div>
        </div>
    </div>
    <!-- Fin: Modal de Paiement -->


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
        const reservationForm = document.getElementById('reservation-form'); // AJOUTER CECI

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

               const paymentModal = document.getElementById('payment-simulation-modal');
        const paymentModalContent = document.getElementById('payment-modal-content');
        const closeModalButton = document.getElementById('close-payment-modal-btn');
        const confirmSimulatedPaymentButton = document.getElementById('confirm-simulated-payment-btn');
        const cancelSimulatedPaymentButton = document.getElementById('cancel-simulated-payment-btn');
        const modalPaymentAmountSpan = document.getElementById('modal-payment-amount');
        const paymentSuccessMessageDiv = document.getElementById('payment-success-message');
        // reservationButton est déjà défini plus haut dans votre code existant
        // totalPriceSpan est déjà défini plus haut dans votre code existant (c'est l'ID du span qui affiche le total dans la carte de réservation)

        function openPaymentModal() {
            if (!paymentModal || !totalPriceSpan || !modalPaymentAmountSpan) {
                console.error("Éléments du modal ou totalPriceSpan introuvables.");
                return;
            }

            const totalAmountText = totalPriceSpan.textContent; // Récupère le total calculé
            modalPaymentAmountSpan.textContent = totalAmountText; // Affiche dans le modal

            paymentModal.classList.remove('hidden');
            setTimeout(() => { // Pour l'animation d'apparition
                paymentModal.classList.remove('opacity-0');
                if(paymentModalContent) {
                    paymentModalContent.classList.remove('scale-95', 'opacity-0');
                    paymentModalContent.classList.add('scale-100', 'opacity-100');
                }
            }, 10);

            // Vider les champs de la carte pour une nouvelle simulation (optionnel)
            const cardNumberFakeEl = document.getElementById('card-number-fake');
            const expiryMonthFakeEl = document.getElementById('expiry-month-fake');
            // ... récupérer les autres champs ...
            if(cardNumberFakeEl) cardNumberFakeEl.value = '';
            if(expiryMonthFakeEl) expiryMonthFakeEl.value = '';
            // ... vider les autres champs ...
            if(paymentSuccessMessageDiv) paymentSuccessMessageDiv.classList.add('hidden');
        }

        function closePaymentModal() {
            if (!paymentModal || !paymentModalContent) return;
            paymentModalContent.classList.remove('scale-100', 'opacity-100');
            paymentModalContent.classList.add('scale-95', 'opacity-0');
            paymentModal.classList.add('opacity-0');
            setTimeout(() => {
                paymentModal.classList.add('hidden');
            }, 300); // Attend la fin de la transition
        }

        if (reservationButton && reservationForm) { // reservationButton est votre bouton "Demander à réserver"
            reservationButton.addEventListener('click', function(event) {
                event.preventDefault(); // Très important: Empêche la soumission du formulaire

                if (this.disabled) { // Si le bouton est désactivé (ex: dates non sélectionnées)
                    // Optionnel: informer l'utilisateur qu'il doit sélectionner les dates
                    if (flatpickrErrorDiv && !flatpickrErrorDiv.textContent.trim() && (!startDateInput.value || !endDateInput.value) ) {
                       if(flatpickrErrorDiv) flatpickrErrorDiv.textContent = 'Veuillez sélectionner une date de début ET une date de fin.';
                       if(flatpickrInstance && dateRangePickerEl) flatpickrInstance.open(); // Ouvre le calendrier
                    }
                    return;
                }
                 // S'assurer que les dates sont bien là avant d'ouvrir le modal
                if (!startDateInput.value || !endDateInput.value) {
                    if(flatpickrErrorDiv) flatpickrErrorDiv.textContent = 'Veuillez sélectionner une date de début ET une date de fin.';
                    if(flatpickrInstance && dateRangePickerEl) flatpickrInstance.open(); // Ouvre le calendrier
                    return;
                }
                if(flatpickrErrorDiv) flatpickrErrorDiv.textContent = ''; // Nettoyer message d'erreur s'il y en avait un

                openPaymentModal(); // Ouvrir le modal de paiement
            });
        }

        if (closeModalButton) {
            closeModalButton.addEventListener('click', closePaymentModal);
        }
        if (cancelSimulatedPaymentButton) {
            cancelSimulatedPaymentButton.addEventListener('click', closePaymentModal);
        }

        if (confirmSimulatedPaymentButton && reservationForm) {
            confirmSimulatedPaymentButton.addEventListener('click', function() {
                this.textContent = 'Traitement en cours...';
                this.disabled = true;
                if(cancelSimulatedPaymentButton) cancelSimulatedPaymentButton.disabled = true;

                // Simuler un délai de traitement du paiement
                setTimeout(() => {
                    if(paymentSuccessMessageDiv) paymentSuccessMessageDiv.classList.remove('hidden');
                    this.innerHTML = '<i class="fas fa-check-circle mr-1.5"></i>Confirmer et payer'; // Réinitialiser le texte avec l'icône
                    this.disabled = false;
                    if(cancelSimulatedPaymentButton) cancelSimulatedPaymentButton.disabled = false;

                    // Après un court délai pour lire le message, soumettre le formulaire original
                    setTimeout(() => {
                        closePaymentModal();
                        reservationForm.submit(); // Soumission réelle du formulaire de réservation
                    }, 2500); // Laisse 2.5s pour lire le message de succès
                }, 1500); // Simule 1.5s de traitement
            });
        }

        // Fermer le modal si on clique en dehors de son contenu
        if (paymentModal) {
            paymentModal.addEventListener('click', function(event) {
                if (event.target === paymentModal) {
                    closePaymentModal();
                }
            });
        }
     }); // Fin DOMContentLoaded
    </script>

</body>
</html>