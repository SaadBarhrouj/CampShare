<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonce publiée - CampShare | Louez du matériel de camping entre particuliers</title>
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
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-forest dark:text-meadow">CampShare</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex flex-col pt-16 min-h-screen">
        <!-- Main content -->
        <main class="flex-1 bg-gray-50 dark:bg-gray-900 py-8 px-4 md:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-10 p-8 text-center">
                    <div class="mb-6">
                        <div class="mx-auto w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-3xl text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                    
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Annonce publiée avec succès!</h1>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-lg mx-auto">
                        Votre annonce a été soumise et sera examinée par notre équipe dans les 24 heures. Vous recevrez une notification dès qu'elle sera approuvée.
                    </p>
                    
                    <div class="space-y-4">
                        <a href="{{ route('listing.create') }}" class="inline-block px-6 py-3 bg-forest hover:bg-green-700 dark:bg-meadow dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un autre équipement
                        </a>
                        
                        <div>
                            <a href="{{ route('dashboard') }}" class="inline-block text-forest dark:text-meadow hover:underline mt-4">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Retour au tableau de bord
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 py-8 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                    &copy; 2025 CampShare. Tous droits réservés.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
