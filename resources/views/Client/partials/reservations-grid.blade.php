<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Reservation 1 -->
    @foreach( $allReservations as $allRes)

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="relative h-40">
            <img src="{{ $allRes->image_url }}" alt="Image"
                 class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            @php
                $statusMap = [
                    'pending' => ['label' => 'En attente', 'color' => 'bg-yellow-400'],
                    'confirmed' => ['label' => 'Confirmée', 'color' => 'bg-blue-500'],
                    'ongoing' => ['label' => 'En cours', 'color' => 'bg-green-500'],
                    'canceled' => ['label' => 'Annulée', 'color' => 'bg-red-500'],
                    'completed' => ['label' => 'Terminée', 'color' => 'bg-purple-600'],
                ];

                $status = $allRes->status;
                $statusLabel = $statusMap[$status]['label'] ?? $status;
                $statusColor = $statusMap[$status]['color'] ?? 'bg-gray-400';
            @endphp

            <div class="absolute top-4 left-4">
                <span class="{{ $statusColor }} text-white text-xs px-2 py-1 rounded-full">
                    {{ $statusLabel }}
                </span>
            </div>
            <div class="absolute bottom-4 left-4 right-4">
                <h3 class="text-white font-bold text-lg truncate">{{$allRes->listing_title}}</h3>
                <p class="text-gray-200 text-sm">{{ \Illuminate\Support\Str::limit($allRes->description, 150) }}</p>
            </div>
        </div>
        
        <div class="p-4">
            <div class="flex items-start mb-4">
                <img src="{{ $allRes->partner_img}}" 
                     alt="image" 
                     class="w-8 h-8 rounded-full object-cover mr-3" />
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{$allRes->partner_username}}</p>
                    <div class="flex items-center text-sm">
                        @if($allRes->partner_avg_rating)
                            @php
                                $rating = $allRes->partner_avg_rating;
                                $fullStars = floor($rating);
                                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            @endphp
                            
                            <div class="flex text-amber-400">
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                
                                @if ($hasHalfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @endif
                                
                                {{-- Fill remaining empty stars --}}
                                @for ($i = 0; $i < (5 - $fullStars - ($hasHalfStar ? 1 : 0)); $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                            <span class="ml-1 text-gray-600 dark:text-gray-400 text-sm">
                                {{ number_format($rating, 1) }}
                            </span>
                        @else
                            <div class="text-sm text-gray-500">No ratings yet</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded p-3 mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Durée de résérvation</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{$allRes->start_date}} - {{$allRes->end_date}}</span>
                </div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Prix</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{$allRes->montant_paye}} MAD</span>
                </div>
              
            </div>
            
            <div class="flex items-center space-x-2">
                @if($allRes->status === 'pending')
                    <button onclick="cancelReservation({{ $allRes->id }})"
                            class="px-3 py-1.5 border border-red-300 dark:border-red-800 text-red-700 dark:text-red-400 text-sm rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex-1">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach

</div>
<script>
    function cancelReservation(reservationId) {
    if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
        fetch(`/client/reservations/cancel/${reservationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Recharger les réservations
                document.getElementById('statusFilter').dispatchEvent(new Event('change'));
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>