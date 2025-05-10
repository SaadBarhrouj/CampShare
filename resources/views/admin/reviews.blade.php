@extends('admin.dashboard')

@section('content')
<div class="py-8 px-4 md:px-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Gestion des Avis</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Liste des avis laissés par les utilisateurs</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="font-bold text-lg text-gray-900 dark:text-white">Tous les avis</h2>
            <form method="GET" action="{{ route('admin.reviews') }}" class="flex items-center">
                <div class="relative mr-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher des avis..."
                        class="pl-8 pr-4 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-admin-primary dark:focus:ring-admin-secondary text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500 text-xs"></i>
                    </div>
                </div>
                <button type="submit" class="px-3 py-1.5 bg-admin-primary dark:bg-admin-secondary text-white rounded-md text-sm">
                    Rechercher
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead>
                    <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                        <th class="pb-3 pl-6">Auteur</th>
                        <th class="pb-3">Destinataire</th>
                        <th class="pb-3">Équipement</th>
                        <th class="pb-3">Note</th>
                        <th class="pb-3">Commentaire</th>
                        <th class="pb-3 pr-6">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="py-4 pl-6">
                                <div class="flex items-center">
                                    <img src="{{ $review->reviewer->avatar_url ?? asset('images/default-avatar.jpg') }}" 
                                         alt="{{ $review->reviewer->username }}" 
                                         class="w-8 h-8 rounded-full object-cover mr-2">
                                    {{ $review->reviewer->username }}
                                </div>
                            </td>
                            <td class="py-4">
                                {{ $review->reviewee->username }}
                            </td>
                            <td class="py-4">
                                {{ $review->item->title ?? 'Équipement supprimé' }}
                            </td>
                            <td class="py-4">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-yellow-400"></i>
                                        @else
                                            <i class="far fa-star text-gray-300"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td class="py-4">
                                {{ Str::limit($review->comment, 50) }}
                            </td>
                            <td class="py-4 pr-6">
                                {{ $review->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Aucun avis trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection