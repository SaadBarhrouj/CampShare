
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - CampShare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Assure-toi d'inclure tes styles/scripts --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
     <style>
        /* Style simple pour les étoiles */
        .rating { display: inline-block; }
        .rating input { display: none; }
        .rating label {
            float: right; 
            padding: 0 2px;
            font-size: 1.5rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label { 
            color: #FFAA33; 
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">



    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ $pageTitle }}</h1>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

             {{-- Afficher les erreurs de validation --}}
             @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oups !</strong>
                    <span class="block sm:inline">Il y avait quelques problèmes avec votre saisie.</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Afficher les messages de succès/erreur de redirection --}}
            @if(session('success')) <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ session('error') }}</div> @endif
            @if(session('warning')) <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">{{ session('warning') }}</div> @endif


            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf

                {{-- Champs cachés importants --}}
                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                <input type="hidden" name="review_type" value="{{ $reviewType }}">

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Pour la réservation #{{ $reservation->id }} de "{{ $itemName }}"
                    @if($reviewType == 'review_partner')
                        avec {{ $revieweeName }}
                    @elseif($reviewType == 'review_client')
                         par {{ $revieweeName }}
                    @endif
                     (Terminée le {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}).
                </p>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Votre note :</label>
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" {{ old('rating') == 5 ? 'checked' : '' }} required><label for="star5" title="5 étoiles"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }}><label for="star4" title="4 étoiles"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }}><label for="star3" title="3 étoiles"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }}><label for="star2" title="2 étoiles"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }}><label for="star1" title="1 étoile"><i class="fas fa-star"></i></label>
                    </div>
                     @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label for="comment" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Votre commentaire :</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full px-3 py-2 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-forest dark:focus:ring-meadow focus:border-transparent" placeholder="Partagez votre expérience..." required>{{ old('comment') }}</textarea>
                     @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-forest hover:bg-green-700 text-white font-medium rounded-md shadow-md transition duration-300">
                        Envoyer l'évaluation
                    </button>
                </div>
            </form>
        </div>
    </div>


</body>
</html>

