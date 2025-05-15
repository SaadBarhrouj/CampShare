<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="z-0 bg-gray-50 dark:bg-gray-700 sticky top-0">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Évaluateur</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Évalué</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Élément</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Note</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Commentaire</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($reviews as $review)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-review-id="{{ $review->id }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full border border-gray-200 dark:border-gray-600" 
                                     src="{{ asset($review->reviewer->avatar_url) ?? asset('images/default-avatar.jpg') }}" 
                                     alt="{{ $review->reviewer->first_name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->reviewer->first_name }} {{ $review->reviewer->last_name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $review->reviewer->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($review->reviewee)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full border border-gray-200 dark:border-gray-600" 
                                         src="{{ asset($review->reviewee->avatar_url) ?? asset('images/default-avatar.jpg') }}" 
                                         alt="{{ $review->reviewee->first_name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->reviewee->first_name }} {{ $review->reviewee->last_name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $review->reviewee->email }}</div>
                                </div>
                            </div>
                        @else
                            <span class="text-gray-400 italic text-sm">Utilisateur supprimé</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($review->type)
                            @case('forObject')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Équipement</span>
                                @break
                            @case('forPartner')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Partenaire</span>
                                @break
                            @case('forClient')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">Client</span>
                                @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($review->item)
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->item->title }}</div>
                            @if($review->item->category)
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $review->item->category->name }}</div>
                            @endif
                        @else
                            <span class="text-gray-400 italic text-sm">Élément supprimé</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex items-center mr-2">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->rating }}/5</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($review->comment)
                            <p class="text-sm text-gray-700 dark:text-gray-300 review-comment max-w-xs truncate">{{ $review->comment }}</p>
                        @else
                            <p class="text-sm text-gray-400 italic review-comment">Aucun commentaire</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">{{ $review->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex space-x-2">
                            <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 delete-review" 
                                    data-review-id="{{ $review->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelectorAll('.delete-review').forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.getAttribute('data-review-id');
            const reviewRow = document.querySelector(`tr[data-review-id="${reviewId}"]`);
            
            if (confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ? Cette action est irréversible.')) {
                fetch(`/admin/reviews/${reviewId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        reviewRow.remove();
                        alert('Évaluation supprimée avec succès');
                        
                        if (document.querySelectorAll('tbody tr').length === 0) {
                            setTimeout(() => window.location.reload(), 1500);
                        }
                    } else {
                        throw new Error(data.message || 'Erreur lors de la suppression');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Une erreur est survenue lors de la suppression');
                });
            }
        });
    });
});
</script>