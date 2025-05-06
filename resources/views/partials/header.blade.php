<!-- Navigation -->
<nav class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <!-- Logo -->
                <a href="{{ route('index') }}" class="flex items-center">
                    <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                    <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('index') }}#comment-ca-marche" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Comment ça marche ?</a>
                <a href="{{ route('client.listings.index') }}" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Explorer le matériel</a>
                <a href="#devenir-partenaire" class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Devenir Partenaire</a>
                
                <div class="flex items-center space-x-4 ml-4">
                    <a href="{{ route('login.form') }}" class="px-4 py-2 font-medium rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Connexion</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 font-medium rounded-md bg-sunlight hover:bg-amber-600 text-white shadow-md transition duration-300">Inscription</a>
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-800 pb-4 shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#comment-ca-marche" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Comment ça marche ?</a>
            <a href="{{ route('client.listings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Explorer le matériel</a>
            <a href="#devenir-partenaire" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Devenir Partenaire</a>
            <div class="mt-4 flex flex-col space-y-3 px-3">
                <a href="{{ route('login.form') }}" class="px-4 py-2 font-medium rounded-md text-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 transition duration-300">Connexion</a>
                <a href="{{ route('register') }}" class="px-4 py-2 font-medium rounded-md text-center bg-sunlight hover:bg-amber-600 text-white transition duration-300">Inscription</a>
            </div>
        </div>
    </div>
</nav>