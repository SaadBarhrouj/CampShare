@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="py-8 px-4 md:px-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $listing->item->title }}</h1>
            <p class="text-gray-600 dark:text-gray-400">Détails de l'annonce #{{ $listing->id }}</p>
        </div>
        <a href="{{ route('admin.partners') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main content -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Informations de base</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Catégorie</p>
                        <p class="font-medium">{{ $listing->item->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Prix par jour</p>
                        <p class="font-medium">{{ $listing->item->price_per_day }} MAD</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Ville</p>
                        <p class="font-medium">{{ $listing->city->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Statut</p>
                        <p class="font-medium">
                            <span class="badge {{ $listing->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $listing->status === 'active' ? 'Actif' : 'Inactif' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-gray-600 dark:text-gray-400">Description</p>
                    <p class="mt-2 text-gray-800 dark:text-gray-200">{{ $listing->item->description }}</p>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Images</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($listing->item->media as $media)
                        <img src="{{ asset($media->path) }}" alt="Image de l'équipement" class="rounded-lg w-full h-40 object-cover">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Partner info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Partenaire</h2>
                <div class="flex items-center mb-4">
                    <img src="{{ $listing->item->user->avatar_url ? asset($listing->item->user->avatar_url) : asset('images/default-avatar.jpg') }}" 
                         alt="Avatar" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <p class="font-medium">{{ $listing->item->user->username }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $listing->item->user->email }}</p>
                    </div>
                </div>
                
            </div>

            <!-- Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Statistiques</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Réservations</p>
                        <p class="font-medium text-2xl">{{ $reservationsCount }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Note moyenne</p>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($averageRating))
                                    <i class="fas fa-star text-yellow-400"></i>
                                @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                    <i class="fas fa-star-half-alt text-yellow-400"></i>
                                @else
                                    <i class="far fa-star text-yellow-400"></i>
                                @endif
                            @endfor
                            <span class="ml-2">{{ number_format($averageRating, 1) }}/5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection