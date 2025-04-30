<!-- Navigation -->
<nav
    class="bg-white bg-opacity-95 dark:bg-gray-800 dark:bg-opacity-95 shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <!-- Logo -->
                <a href="index.html" class="flex items-center">
                    <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span
                            class="text-sunlight">Share</span></span>
                    <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#comment-ca-marche"
                    class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Comment
                    ça marche ?</a>
                <a href="annonces.html"
                    class="nav-link active-nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">Explorer
                    le matériel</a>
                <a href="#" id="become-partner-link"
                    class="nav-link text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight font-medium transition duration-300">
                    Devenir Partenaire
                </a>

                @if (Auth::check())
                    <!-- Utilisateur connecté -->
                    <div class="flex items-center space-x-4">
                        <img src="{{ auth()->user()->avatar_url ? Storage::url(auth()->user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->username) }}"
                            alt="Avatar" class="h-10 w-10 rounded-full cursor-pointer avatar-clickable user-avatar"
                            data-username="{{ auth()->user()->username }}"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->username) }}'">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-500">Se déconnecter</button>
                        </form>
                    </div>
                @else
                    <!-- Liens de connexion / inscription -->
                    <div class="flex items-center space-x-4 ml-4">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 font-medium rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Connexion</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 font-medium rounded-md bg-sunlight hover:bg-amber-600 text-white shadow-md transition duration-300">Inscription</a>
                    </div>
                @endif
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button"
                    class="text-gray-600 dark:text-gray-300 hover:text-forest dark:hover:text-sunlight focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-800 pb-4 shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#comment-ca-marche"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Comment
                ça marche ?</a>
            <a href="annonces.html"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Explorer
                le matériel</a>
            <a href="#devenir-partenaire"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">Devenir
                Partenaire</a>

            @if (Auth::check())
                <!-- Menu mobile - utilisateur connecté -->
                <div class="mt-4 flex flex-col space-y-3 px-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 font-medium rounded-md text-center bg-red-500 hover:bg-red-600 text-white transition duration-300">Se
                            déconnecter</button>
                    </form>
                </div>
            @else
                <!-- Menu mobile - non connecté -->
                <div class="mt-4 flex flex-col space-y-3 px-3">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 font-medium rounded-md text-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-300">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 font-medium rounded-md text-center bg-sunlight hover:bg-amber-600 text-white transition duration-300">Inscription</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="partner-confirm-modal"
        class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Confirmer la conversion en Partenaire</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Êtes-vous sûr de vouloir devenir partenaire ? Cette action est irréversible et vous permettra de
                proposer du matériel à la location.
            </p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-partner-btn"
                    class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-300">
                    Annuler
                </button>
                <button id="confirm-partner-btn"
                    class="px-4 py-2 bg-sunlight hover:bg-amber-600 text-white rounded-md transition duration-300">
                    Confirmer
                </button>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('partner-confirm-modal');
    const becomePartnerLink = document.getElementById('become-partner-link');
    const cancelBtn = document.getElementById('cancel-partner-btn');
    const confirmBtn = document.getElementById('confirm-partner-btn');

    if (becomePartnerLink) {
        becomePartnerLink.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
    }

    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            // Envoyer la requête AJAX pour mettre à jour le rôle
            fetch('{{ route("user.become-partner") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Rafraîchir la page pour voir les changements
                    window.location.reload();
                } else {
                    alert('Une erreur est survenue: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            })
            .finally(() => {
                modal.classList.add('hidden');
            });
        });
    }
});
</script>




</nav>