<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CampShare</title>
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-in-out forwards',
                        'fade-out': 'fadeOut 0.3s ease-in-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            'from': { opacity: '0', transform: 'translateY(10px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeOut: {
                            'from': { opacity: '1', transform: 'translateY(0)' },
                            'to': { opacity: '0', transform: 'translateY(-10px)' }
                        }
                    }
                }
            },
            darkMode: 'class',
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body
    class="font-sans antialiased text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div
        class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300">
        <!-- Header with progress -->
        <div class="bg-forest dark:bg-meadow text-white p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center">
                    <span class="text-2xl font-bold">Camp<span class="text-sunlight">Share</span></span>
                    <span class="text-xs ml-2 opacity-80">by ParentCo</span>
                </div>
                <span class="text-sm font-medium"><span id="progress-percentage">33</span>% complété</span>
            </div>

            <div class="w-full bg-white/20 rounded-full h-2 mb-2">
                <div id="progress-bar" class="bg-sunlight h-2 rounded-full transition-all duration-500 ease-in-out"
                    style="width: 33%"></div>
            </div>

            <div class="flex justify-between text-xs">
                <span class="text-white">Informations</span>
                <span class="text-white/70">Identité</span>
                <span class="text-white/70">Accords</span>
            </div>
        </div>

        <!-- Form container -->
        <div class="p-6 sm:p-8">
            <!-- Error messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0 text-red-500 dark:text-red-400">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Erreurs détectées :</h3>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-700 dark:text-red-300">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div id="client-side-errors" class="hidden mb-6 p-4 bg-red-50 dark:bg-red-900/30 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0 text-red-500 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Veuillez corriger :</h3>
                        <ul id="client-error-list"
                            class="mt-2 list-disc list-inside text-sm text-red-700 dark:text-red-300"></ul>
                    </div>
                </div>
            </div>

            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0 text-blue-500 dark:text-blue-400">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="ml-3 text-sm text-blue-700 dark:text-blue-300">
                        Pour garantir la sécurité de notre communauté, nous demandons une vérification d'identité. Ces
                        informations sont sécurisées et ne seront utilisées que pour valider votre identité.
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Créer votre compte</h2>

            <form id="registration-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Personal Info -->
                <section id="step-1" class="step-section space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pseudonyme
                                *</label>
                            <input type="text" id="username" name="username" required value="{{ old('username') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition">
                        </div>

                        <div>
                            <label for="first_name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prénom *</label>
                            <input type="text" id="first_name" name="first_name" required
                                value="{{ old('first_name') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition">
                        </div>

                        <div>
                            <label for="image"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Photo de
                                profil</label>
                            <input type="file" id="image" name="image" accept="image/*"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition">
                        </div>

                        <div>
                            <label for="last_name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom *</label>
                            <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition">
                        </div>

                        <div>
                            <label for="address"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adresse
                                *</label>
                            <input type="text" id="address" name="address" required value="{{ old('address') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition">
                        </div>

                        <div>
                            <label for="phone_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Téléphone
                                *</label>
                            <input type="text" id="phone_number" name="phone_number" required value="{{ old('phone_number') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email
                            *</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                class="w-full pl-10 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition"
                                placeholder="votre@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="city_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ville *</label>
                        <div class="relative">
                            <select id="city_id" name="city_id" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition">
                                <option value="" disabled {{ old('city_id') ? '' : 'selected' }}>-- Sélectionnez votre
                                    ville --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mot de passe
                                *</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="w-full pl-10 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition"
                                    placeholder="Minimum 8 caractères">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Inclure lettres, chiffres et caractères spéciaux
                            </p>
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirmation
                                *</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full pl-10 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-forest focus:ring-2 focus:ring-forest/50 dark:bg-gray-700 dark:text-white transition"
                                    placeholder="Retapez votre mot de passe">
                            </div>
                            <div id="password_confirmation-error" class="text-red-500 text-sm mt-1"></div>
                        </div>
                    </div>

            

                    <div class="pt-4 flex justify-end">
                        <button type="button" id="next-to-step-2"
                            class="flex items-center justify-center px-6 py-3 bg-forest hover:bg-forest/90 dark:bg-meadow dark:hover:bg-meadow/90 text-white rounded-lg font-medium transition">
                            Suivant <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </section>

                <!-- Step 2: Identity Verification -->
                <section id="step-2" class="step-section hidden space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CIN Recto
                                *</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-forest dark:hover:border-meadow transition-colors">
                                <div class="text-center">
                                    <i class="fas fa-id-card text-3xl text-gray-400 mb-3"></i>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                        <label
                                            class="relative cursor-pointer font-medium text-forest dark:text-meadow hover:text-opacity-80">
                                            <span>Télécharger</span>
                                            <input id="cin-front" name="cin_recto" type="file" accept="image/*"
                                                class="sr-only" required>
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        PNG, JPG (max 5MB)
                                    </p>
                                    <img id="cin-front-preview" class="mt-3 mx-auto max-h-32 hidden rounded">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CIN Verso
                                *</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-forest dark:hover:border-meadow transition-colors">
                                <div class="text-center">
                                    <i class="fas fa-id-card text-3xl text-gray-400 mb-3"></i>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                        <label
                                            class="relative cursor-pointer font-medium text-forest dark:text-meadow hover:text-opacity-80">
                                            <span>Télécharger</span>
                                            <input id="cin-back" name="cin_verso" type="file" accept="image/*"
                                                class="sr-only" required>
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        PNG, JPG (max 5MB)
                                    </p>
                                    <img id="cin-back-preview" class="mt-3 mx-auto max-h-32 hidden rounded">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <button type="button" id="back-to-step-1"
                            class="flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg font-medium transition">
                            <i class="fas fa-arrow-left mr-2"></i> Précédent
                        </button>
                        <button type="button" id="next-to-step-3"
                            class="flex items-center justify-center px-6 py-3 bg-forest hover:bg-forest/90 dark:bg-meadow dark:hover:bg-meadow/90 text-white rounded-lg font-medium transition">
                            Suivant <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </section>

                <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                <section id="step-3" class="step-section hidden space-y-6">
                    <div x-data="{ showTerms: false, showPrivacy: false, showContract: false }" class="space-y-4">

                        <div class="flex items-start">
                            <div class="flex items-center h-5 mt-0.5">
                                <input id="terms" name="terms" type="checkbox" value="1" required
                                    class="h-4 w-4 text-forest focus:ring-2 focus:ring-forest/50 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">
                                    J'accepte les
                                    <button type="button" @click="showTerms = !showTerms"
                                        class="text-forest dark:text-meadow underline hover:no-underline ml-1">
                                        CGU
                                    </button>
                                    et la
                                    <button type="button" @click="showPrivacy = !showPrivacy"
                                        class="text-forest dark:text-meadow underline hover:no-underline ml-1">
                                        Politique de Confidentialité
                                    </button> *
                                </label>
                            </div>
                        </div>

                        <div x-show="showTerms" x-transition
                            class="p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                            <h3 class="text-lg font-semibold mb-2">Conditions Générales d'Utilisation (CGU)</h3>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>L'utilisateur s'engage à respecter les conditions de location et d'utilisation du
                                    matériel.</li>
                                <li>CampShare peut suspendre un compte en cas d'abus.</li>
                                <li>Les données personnelles sont protégées selon la législation en vigueur.</li>
                            </ul>
                        </div>

                        <div x-show="showPrivacy" x-transition
                            class="p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                            <h3 class="text-lg font-semibold mb-2">Politique de Confidentialité</h3>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Nous collectons uniquement les données nécessaires à la gestion de vos locations.
                                </li>
                                <li>Vos données ne sont jamais revendues à des tiers.</li>
                                <li>Vous pouvez demander la suppression de vos données à tout moment.</li>
                            </ul>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5 mt-0.5">
                                <input id="contract" name="contract" type="checkbox" value="1" required
                                    class="h-4 w-4 text-forest focus:ring-2 focus:ring-forest/50 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="contract" class="font-medium text-gray-700 dark:text-gray-300">
                                    Je valide le
                                    <button type="button" @click="window.location.href='{{ route('agreement.pdf') }}'"
                                        class="text-forest dark:text-meadow underline hover:no-underline ml-1">
                                        Contrat de Location
                                    </button>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-start mt-4">
                        <div class="flex items-center h-5">
                            <input id="become_partner" name="role" type="checkbox" value="partner"
                                class="h-4 w-4 text-forest focus:ring-2 focus:ring-forest/50 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="become_partner" class="font-medium text-gray-700 dark:text-gray-300">
                                Je souhaite devenir partenaire
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                En cochant cette case, vous pourrez proposer vos équipements à la location.
                            </p>
                        </div>
                    </div>

                        <div x-show="showContract" x-transition
                            class="p-4 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                            <h3 class="text-lg font-semibold mb-2">Contrat de Service - CampShare</h3>
                            <p class="mb-2">En utilisant CampShare, vous acceptez les conditions suivantes :</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Vous êtes responsable des équipements loués.</li>
                                <li>Les retards de retour peuvent entraîner des frais supplémentaires.</li>
                                <li>Les dommages ou pertes doivent être signalés immédiatement.</li>
                                <li>CampShare se réserve le droit de suspendre tout compte non conforme aux règles.</li>
                                <li>Le service est fourni "tel quel" sans garantie de disponibilité permanente.</li>
                            </ul>
                            <p class="mt-4 text-sm italic">Pour toute question, contactez notre support client.</p>
                        </div>

                        <!-- Checkbox pour les notifications -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5 mt-0.5">
                                <input id="is_subscribed" name="is_subscribed" type="checkbox" value="1"
                                    class="h-4 w-4 text-forest focus:ring-2 focus:ring-forest/50 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_subscribed" class="font-medium text-gray-700 dark:text-gray-300">
                                    Je souhaite recevoir les notifications (facultatif)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <button type="button" id="back-to-step-2"
                            class="flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg font-medium transition">
                            <i class="fas fa-arrow-left mr-2"></i> Précédent
                        </button>
                        <button type="submit" id="register-btn"
                            class="flex items-center justify-center px-6 py-3 bg-sunlight hover:bg-sunlight/90 text-white rounded-lg font-medium transition">
                            <i class="fas fa-user-plus mr-2"></i> Créer mon compte
                        </button>
                    </div>
                </section>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Déjà un compte ? <a href="{{ route('login') }}"
                        class="text-forest dark:text-meadow font-medium hover:underline">Connectez-vous</a>
                    <span class="mx-2">•</span>
                    <a href="{{ url('/') }}"
                        class="text-gray-600 dark:text-gray-400 hover:text-forest dark:hover:text-meadow hover:underline">Retour
                        à l'accueil</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = document.querySelectorAll('.step-section');
            const progressBar = document.getElementById('progress-bar');
            const progressPercentage = document.getElementById('progress-percentage');
            let currentStep = 1;
            const totalSteps = steps.length;

            // File upload preview
            function setupFilePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            setupFilePreview('cin-front', 'cin-front-preview');
            setupFilePreview('cin-back', 'cin-back-preview');

            // Update progress
            function updateProgress(step) {
                const percent = Math.round((step / totalSteps) * 100);
                progressBar.style.width = `${percent}%`;
                progressPercentage.textContent = percent;
            }

            // Navigate between steps
            function goToStep(step) {
                if (step < 1 || step > totalSteps) return;

                // Hide current step with animation
                steps[currentStep - 1].classList.add('animate-fade-out');
                setTimeout(() => {
                    steps[currentStep - 1].classList.add('hidden');
                    steps[currentStep - 1].classList.remove('animate-fade-out');

                    // Show new step with animation
                    steps[step - 1].classList.remove('hidden');
                    steps[step - 1].classList.add('animate-fade-in');
                    setTimeout(() => {
                        steps[step - 1].classList.remove('animate-fade-in');
                    }, 400);

                    currentStep = step;
                    updateProgress(currentStep);

                    // Scroll to top of form
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 300);
            }

            // Form validation
            function validateStep(step) {
                let valid = true;
                const errorMessages = [];

                // Helper function to show error
                function showError(fieldId, message) {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.classList.add('border-red-500');
                        field.classList.remove('border-gray-300', 'dark:border-gray-600');
                    }
                    errorMessages.push(message);
                    valid = false;
                }

                // Step 1 validation
                if (step === 1) {
                    // Required fields
                    const requiredFields = [
                        { id: 'username', name: 'Pseudonyme' },
                        { id: 'email', name: 'Email' },
                        { id: 'first_name', name: 'Prénom' },
                        { id: 'last_name', name: 'Nom' },
                        { id: 'address', name: 'Adresse' },
                        { id: 'phone_number', name: 'Téléphone' },
                        { id: 'password', name: 'Mot de passe' },
                        { id: 'password_confirmation', name: 'Confirmation mot de passe' }
                    ];

                    requiredFields.forEach(field => {
                        const value = document.getElementById(field.id)?.value.trim();
                        if (!value) showError(field.id, `${field.name} est requis`);
                    });

                    // Email format
                    const email = document.getElementById('email')?.value;
                    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        showError('email', 'Email invalide');
                    }

                    // Password match
                    const password = document.getElementById('password')?.value;
                    const confirmPassword = document.getElementById('password_confirmation')?.value;
                    if (password && confirmPassword && password !== confirmPassword) {
                        showError('password_confirmation', 'Les mots de passe ne correspondent pas');
                    }

                    // Password strength
                    if (password && password.length < 8) {
                        showError('password', 'Le mot de passe doit contenir au moins 8 caractères');
                    }
                }

                // Step 2 validation
                else if (step === 2) {
                    // CIN files
                    const cinFront = document.getElementById('cin-front');
                    const cinBack = document.getElementById('cin-back');

                    if (!cinFront.files || cinFront.files.length === 0) {
                        showError('cin-front', 'Photo CIN recto requise');
                    } else {
                        const file = cinFront.files[0];
                        const validTypes = ['image/jpeg', 'image/png'];
                        const maxSize = 5 * 1024 * 1024; // 5MB

                        if (!validTypes.includes(file.type)) {
                            showError('cin-front', 'Format fichier recto invalide (JPEG/PNG seulement)');
                        }
                        if (file.size > maxSize) {
                            showError('cin-front', 'Fichier recto trop volumineux (max 5MB)');
                        }
                    }

                    if (!cinBack.files || cinBack.files.length === 0) {
                        showError('cin-back', 'Photo CIN verso requise');
                    } else {
                        const file = cinBack.files[0];
                        const validTypes = ['image/jpeg', 'image/png'];
                        const maxSize = 5 * 1024 * 1024; // 5MB

                        if (!validTypes.includes(file.type)) {
                            showError('cin-back', 'Format fichier verso invalide (JPEG/PNG seulement)');
                        }
                        if (file.size > maxSize) {
                            showError('cin-back', 'Fichier verso trop volumineux (max 5MB)');
                        }
                    }
                }

                // Step 3 validation
                else if (step === 3) {
                    const terms = document.getElementById('terms');
                    const contract = document.getElementById('contract');

                    if (!terms.checked) {
                        terms.parentElement.parentElement.classList.add('text-red-500', 'dark:text-red-400');
                        errorMessages.push('Vous devez accepter les CGU');
                        valid = false;
                    } else {
                        terms.parentElement.parentElement.classList.remove('text-red-500', 'dark:text-red-400');
                    }

                    if (!contract.checked) {
                        contract.parentElement.parentElement.classList.add('text-red-500', 'dark:text-red-400');
                        errorMessages.push('Vous devez accepter le contrat');
                        valid = false;
                    } else {
                        contract.parentElement.parentElement.classList.remove('text-red-500', 'dark:text-red-400');
                    }
                }

                // Display errors if any
                if (!valid) {
                    const errorContainer = document.getElementById('client-side-errors');
                    const errorList = document.getElementById('client-error-list');

                    errorList.innerHTML = '';
                    errorMessages.forEach(msg => {
                        const li = document.createElement('li');
                        li.textContent = msg;
                        errorList.appendChild(li);
                    });

                    errorContainer.classList.remove('hidden');
                    errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    document.getElementById('client-side-errors').classList.add('hidden');
                }

                return valid;
            }

            // Navigation buttons
            document.getElementById('next-to-step-2').addEventListener('click', () => {
                if (validateStep(1)) goToStep(2);
            });

            document.getElementById('next-to-step-3').addEventListener('click', () => {
                if (validateStep(2)) goToStep(3);
            });

            document.getElementById('back-to-step-1').addEventListener('click', () => goToStep(1));
            document.getElementById('back-to-step-2').addEventListener('click', () => goToStep(2));

            // Form submission
            document.getElementById('registration-form').addEventListener('submit', function (e) {
                if (currentStep < totalSteps) {
                    e.preventDefault();
                    if (validateStep(currentStep)) goToStep(currentStep + 1);
                } else {
                    if (!validateStep(3)) {
                        e.preventDefault();
                        return;
                    }

                    // Show loading state
                    const button = document.getElementById('register-btn');
                    const originalText = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Création en cours...';

                    // In a real app, the form would submit here
                    // For demo purposes, we'll simulate a delay
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        alert('Fonctionnalité de démonstration. En production, le formulaire serait soumis.');
                    }, 2000);
                }
            });

            // Initialize
            updateProgress(currentStep);
        });
    </script>
</body>
</html>