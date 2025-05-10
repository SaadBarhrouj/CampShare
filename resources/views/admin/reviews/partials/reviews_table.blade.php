<table class="w-full admin-table">
    <thead>
        <tr class="text-left border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
            <th class="py-3 pl-6 font-medium text-gray-600 dark:text-gray-300">Évaluateur</th>
            <th class="py-3 font-medium text-gray-600 dark:text-gray-300">Évalué</th>
            <th class="py-3 font-medium text-gray-600 dark:text-gray-300">Type</th>
            <th class="py-3 font-medium text-gray-600 dark:text-gray-300">Équipement</th>
            <th class="py-3 font-medium text-gray-600 dark:text-gray-300">Note</th>
            <th class="py-3 font-medium text-gray-600 dark:text-gray-300">Commentaire</th>
            <th class="py-3 pr-6 font-medium text-gray-600 dark:text-gray-300">Date</th>
        </tr>
    </thead>
    <tbody id="reviewsTableBody">
        @foreach($reviews as $review)
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 review-row">
                <td class="py-5 pl-6">
                    <div class="flex items-center">
                        <img src="{{ $review->reviewer->avatar_url ?? asset('images/default-avatar.jpg') }}" 
                             alt="{{ $review->reviewer->first_name }}" 
                             class="w-10 h-10 rounded-full mr-3 object-cover border border-gray-200 dark:border-gray-600">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white reviewer-name">{{ $review->reviewer->first_name }} {{ $review->reviewer->last_name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 reviewer-email">{{ $review->reviewer->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="py-5">
                    @if($review->reviewee)
                        <div class="flex items-center">
                            <img src="{{ $review->reviewee->avatar_url ?? asset('images/default-avatar.jpg') }}" 
                                 alt="{{ $review->reviewee->first_name }}" 
                                 class="w-10 h-10 rounded-full mr-3 object-cover border border-gray-200 dark:border-gray-600">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white reviewee-name">{{ $review->reviewee->first_name }} {{ $review->reviewee->last_name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 reviewee-email">{{ $review->reviewee->email }}</p>
                            </div>
                        </div>
                    @else
                        <span class="text-gray-400 italic">Utilisateur supprimé</span>
                    @endif
                </td>
                <td class="py-5">
                    @switch($review->type)
                        @case('forObject')
                            <span class="inline-block px-3 py-1 text-xs font-semibold leading-tight text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-200">Équipement</span>
                            @break
                        @case('forPartner')
                            <span class="inline-block px-3 py-1 text-xs font-semibold leading-tight text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-200">Partenaire</span>
                            @break
                        @case('forClient')
                            <span class="inline-block px-3 py-1 text-xs font-semibold leading-tight text-indigo-800 bg-indigo-100 rounded-full dark:bg-indigo-900 dark:text-indigo-200">Client</span>
                            @break
                    @endswitch
                </td>
                <td class="py-5">
                    @if($review->item)
                        <p class="font-medium text-gray-900 dark:text-white">{{ $review->item->title }}</p>
                        @if($review->item->category)
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $review->item->category->name }}</p>
                        @endif
                    @else
                        <span class="text-gray-400 italic">Équipement supprimé</span>
                    @endif
                </td>
                <td class="py-5">
                    <div class="flex items-center">
                        <div class="flex items-center mr-2">
                            @php
                                $fullStars = floor($review->rating);
                                $hasHalfStar = fmod($review->rating, 1) !== 0.0;
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp
                            
                            @for($i = 0; $i < $fullStars; $i++)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            
                            @if($hasHalfStar)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <defs>
                                        <linearGradient id="half-star-{{ $review->id }}" x1="0" x2="100%" y1="0" y2="0">
                                            <stop offset="50%" stop-color="currentColor"/>
                                            <stop offset="50%" stop-color="#D1D5DB"/>
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half-star-{{ $review->id }} )" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                            
                            @for($i = 0; $i < $emptyStars; $i++)
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($review->rating, 1) }}</span>
                    </div>
                </td>
                <td class="py-5">
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $review->comment ?: 'Aucun commentaire' }}
                    </p>
                </td>
                <td class="py-5 pr-6">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->created_at->format('d/m/Y') }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->format('H:i') }}</span>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>