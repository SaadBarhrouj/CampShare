<main class="flex-1 md:ml-64 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 md:px-8">
        <!-- Dashboard header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Mes reservations</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Bienvenue, {{$user->username}} ! Voici un résumé de vos réservations.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <!-- Status Filter Dropdown -->
                <select id="statusFilter" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md px-3 py-1.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="confirmed">Confirmé</option>
                    <option value="completed">Terminé</option>
                    <option value="canceled">Annulé</option>
                </select>
            </div>
        </div>
        
        <!-- Reservations Grid (Will be updated via AJAX) -->
        <div id="reservations-container">
            @include('Client.partials.reservations-grid', ['allReservations' => $allReservations])
        </div>
    </div>
</main>

<!-- AJAX Script -->
<script>
document.getElementById('statusFilter').addEventListener('change', function() {
    const status = this.value;
    
    fetch(`/client/reservations/filter?status=${status}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html',
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('reservations-container').innerHTML = html;
    })
    .catch(error => console.error('Error:', error));
});
</script>