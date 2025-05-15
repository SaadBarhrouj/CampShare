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
        <!-- Dashboard header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Mes reservations</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Voici un résumé de vos réservations, leurs status, dates...</p>
            </div>
            
        </div>

        <div class="mt-4 mb-8  md:mt-0 flex space-x-3 justify-end items-center">
            <!-- Status Filter Dropdown -->
            <label class="block text-gray-700 dark:text-gray-300">Statut de résérvation</label>
            <select id="statusFilter" class="flex items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all w-46">
                <option value="all">Tous les statuts</option>
                <option value="pending">En attente</option>
                <option value="confirmed">Confirmé</option>
                <option value="ongoing">En cours</option>
                <option value="completed">Terminé</option>
                <option value="canceled">Annulé</option>
            </select>
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