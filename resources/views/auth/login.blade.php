<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CampShare</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
                    },
                    animation: {
                        fade: 'fadeIn 0.4s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0, transform: 'translateY(10px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' },
                        },
                    }
                }
            }
        };

        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans px-4">

    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 space-y-6 animate-fade">
        
        <!-- Logo -->
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-forest dark:text-meadow">Camp<span class="text-sunlight">Share</span></h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">by ParentCo</p>
        </div>

        <!-- Messages -->
        @if (Session::has('success'))
        <div class="p-3 bg-green-100 border border-green-400 text-green-700 rounded-md flex items-center justify-between">
            <div><i class="fas fa-check-circle mr-2"></i>{{ Session::get('success') }}</div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800"><i class="fas fa-times"></i></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded-md flex items-center justify-between">
            <div><i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}</div>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800"><i class="fas fa-times"></i></button>
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold mb-1">Adresse email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="pl-10 w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-base py-3 px-4 focus:ring-2 focus:ring-forest focus:outline-none @error('email') border-red-500 @enderror"
                        placeholder="votre@email.com">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold mb-1">Mot de passe</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password" id="password" required
                        class="pl-10 pr-10 w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-base py-3 px-4 focus:ring-2 focus:ring-forest focus:outline-none @error('password') border-red-500 @enderror"
                        placeholder="Votre mot de passe">
                    <button type="button" id="toggle-password" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mt-1 text-right">
                    <a href="#" class="text-sm text-forest dark:text-meadow hover:underline">Mot de passe oublié ?</a>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full flex justify-center items-center py-3 px-4 rounded-md bg-sunlight hover:bg-amber-500 text-white font-semibold shadow hover:shadow-md transition duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
            </button>
        </form>

        <!-- Footer Links -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-3 text-sm pt-2">
            <a href="{{ route('register') }}" class="text-forest dark:text-meadow hover:underline"><i class="fas fa-user-plus mr-1"></i>Créer un compte</a>
            <a href="{{ url('/') }}" class="flex items-center justify-center py-2 px-4 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md transition-all duration-200">
                <i class="fas fa-home mr-2"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isHidden);
            icon.classList.toggle('fa-eye-slash', isHidden);
        });
    </script>

</body>
</html>