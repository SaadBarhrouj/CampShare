<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CampShare</title>
    <script src="https://cdn.tailwindcss.com"></script>

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

        // Detect dark mode preference
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.4s ease-in-out forwards;
        }
        .fade-out {
            animation: fadeOut 0.3s ease-in-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        
        button:focus {
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(45, 95, 43, 0.5);
        }
        
        input::placeholder {
            padding-left: 0;
        }
        
        .footer-link {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .footer-link:hover {
            background-color: rgba(45, 95, 43, 0.1);
        }
        
        .dark .footer-link:hover {
            background-color: rgba(79, 121, 66, 0.2);
        }
        
        button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-900 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 transition-all duration-300">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="flex items-center">
                <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
                <span class="text-xs ml-2 text-gray-500 dark:text-gray-400">by ParentCo</span>
            </div>
        </div>
        
        <h2 class="text-center text-2xl font-bold mb-4 text-gray-800 dark:text-white">Devenir Parenaire dans CampShare</h2>
        
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 dark:text-blue-400"></i>
                </div>
                <div class="ml-3">
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    Rejoignez la communauté CampShare en tant que partenaire ! Une fois ce formulaire complété, vous pourrez proposer votre matériel de camping à la vente sur notre plateforme. Cette étape nous permet de mieux vous connaître et d'assurer une expérience fiable et sécurisée à tous nos utilisateurs.
                </p>
                </div>
            </div>
        </div>


       

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

        <form id="registration-form" method="POST" action="{{ route('devenir_partenaire') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <section id="step-3" class="step-section">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-file-contract mr-2 text-forest dark:text-meadow"></i>
                    Accords et contrats
                </h3>
                
                <div x-data="{ showTerms: false, showPrivacy: false, showContract: false }" class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" value="1" required
                                class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
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
                        <div class="flex items-center h-5">
                            <input id="contract" name="contract" type="checkbox" value="1" required
                                class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="contract" class="font-medium text-gray-700 dark:text-gray-300">
                                Je valide le
                                <button type="button" @click="showContract = !showContract"
                                    class="text-forest dark:text-meadow underline hover:no-underline ml-1">
                                    Contrat de Location
                                </button>
                            </label>
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

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="become_partner" name="role" type="checkbox" value="partner"
                                class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
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

                    <div class="flex items-start">
                    <div class="flex items-center h-5">
                        {{-- Ajout de {{ old('is_subscribed') ? 'checked' : '' }} pour conserver l'état après validation --}}
                        <input id="is_subscribed" name="is_subscribed" type="checkbox" value="1" {{ old('is_subscribed') ? 'checked' : '' }}
                            class="h-4 w-4 text-forest focus:ring-forest border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                    </div>
                    <div class="ml-3 text-sm">
                        {{-- Texte du label original conservé --}}
                        <label for="is_subscribed" class="font-medium text-gray-700 dark:text-gray-300">
                            Je souhaite recevoir les notifications (facultatif)
                        </label>
                    </div>
                </div>
            </div>

                <div class="mt-8 flex justify-between">

                    <button type="submit" id="register-btn"
                        class="flex items-center justify-center py-3 px-6 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-sunlight hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sunlight transition duration-150">
                        <i class="fas fa-user-plus mr-2"></i>
                        Devnir Partenaire
                    </button>
                </div>
            </section>
        </form>
        
        <div class="mt-10 flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4">
            <a href="/Client" class="footer-link text-gray-600 dark:text-gray-400 hover:text-forest dark:hover:text-meadow">
                <i class="fas fa-home mr-2"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = document.querySelectorAll('.step-section');
            const progressBar = document.getElementById('progress-bar');
            const progressPercentage = document.getElementById('progress-percentage');
            const currentStepTitle = document.getElementById('current-step-title');
            const stepIndicators = [
                document.getElementById('step-1-indicator'),
                document.getElementById('step-3-indicator')
            ];
            
            let currentStep = 1;
            const totalSteps = steps.length;
            
            const stepTitles = [
                'Étape 1 : Informations personnelles',
                'Étape 2 : Vérification d\'identité',
                'Étape 3 : Accords et contrats'
            ];
            
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

            
            // Navigate between steps
            function goToStep(step) {
                if (step < 1 || step > totalSteps) return;

                // Hide current step with animation
                steps[currentStep - 1].classList.add('fade-out');
                setTimeout(() => {
                    steps[currentStep - 1].classList.add('hidden');
                    steps[currentStep - 1].classList.remove('fade-out');

                    // Show new step with animation
                    steps[step - 1].classList.remove('hidden');
                    steps[step - 1].classList.add('fade-in');
                    setTimeout(() => {
                        steps[step - 1].classList.remove('fade-in');
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

                if (step === 3) {
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