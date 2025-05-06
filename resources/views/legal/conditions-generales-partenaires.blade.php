<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Conditions Générales Partenaires - CampShare | Louez du matériel de camping entre particuliers</title>
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
        /* Legal document styling */
        .legal-section {
            margin-bottom: 2rem;
        }
        
        .legal-section h2 {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .legal-section h3 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .legal-section p {
            margin-bottom: 1rem;
            line-height: 1.7;
        }
        
        .legal-section ul, .legal-section ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .legal-section li {
            margin-bottom: 0.5rem;
        }
        
        .legal-section strong {
            font-weight: 600;
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none;
            }
            
            body {
                font-size: 12pt;
            }
            
            .legal-section {
                page-break-inside: avoid;
            }
            
            a {
                text-decoration: none;
                color: #000;
            }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-200 dark:bg-gray-900">
    <!-- Main Content Only -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 sm:p-10">
            <!-- Logo -->
            <div class="text-center mb-6">
                <span class="text-forest dark:text-meadow text-3xl font-extrabold">Camp<span class="text-sunlight">Share</span></span>
            </div>
            
            <header class="mb-10 pb-5 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Conditions Générales Partenaires</h1>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Dernière mise à jour : {{ date('d/m/Y') }}</p>
            </header>

            <div class="prose prose-lg max-w-none dark:prose-invert text-gray-700 dark:text-gray-300">
                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="preambule">1. Préambule</h2>
                    <p>Les présentes Conditions Générales Partenaires (ci-après les "CGP") constituent un contrat entre :</p>
                    <ul class="list-disc ml-6">
                        <li>La société <strong>CampShare</strong>, opérant la plateforme de mise en relation entre propriétaires de matériel de camping (ci-après les "Partenaires") et utilisateurs souhaitant louer ce matériel (ci-après les "Clients"), accessible via le site web et l'application mobile CampShare (ci-après la "Plateforme").</li>
                        <li>Et toute personne physique ou morale souhaitant proposer du matériel de camping à la location via la Plateforme (ci-après le "Partenaire").</li>
                    </ul>
                    <p>Ces CGP définissent les conditions dans lesquelles les Partenaires peuvent utiliser la Plateforme pour proposer leur matériel à la location.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="definitions">2. Définitions</h2>
                    <p>Dans les présentes CGP, les termes suivants, lorsqu'ils sont écrits avec une première lettre majuscule, auront la signification suivante :</p>
                    <ul class="list-disc ml-6">
                        <li><strong>"Annonce"</strong> : offre de location de Matériel publiée par un Partenaire sur la Plateforme.</li>
                        <li><strong>"Client"</strong> : tout utilisateur inscrit sur la Plateforme souhaitant louer du Matériel proposé par un Partenaire.</li>
                        <li><strong>"Commission"</strong> : rémunération perçue par CampShare sur chaque transaction réalisée via la Plateforme.</li>
                        <li><strong>"Contenu"</strong> : tout élément (texte, image, vidéo, etc.) publié par un Partenaire sur la Plateforme.</li>
                        <li><strong>"Matériel"</strong> : équipement de camping proposé à la location par un Partenaire sur la Plateforme.</li>
                        <li><strong>"Réservation"</strong> : action par laquelle un Client réserve du Matériel auprès d'un Partenaire via la Plateforme.</li>
                    </ul>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="inscription">3. Inscription en tant que Partenaire</h2>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">3.1 Conditions d'éligibilité</h3>
                    <p>Pour s'inscrire en tant que Partenaire sur la Plateforme, l'utilisateur doit :</p>
                    <ul class="list-disc ml-6">
                        <li>Être âgé d'au moins 18 ans et disposer de la pleine capacité juridique ;</li>
                        <li>Être propriétaire du Matériel proposé à la location ou disposer de toutes les autorisations nécessaires pour le proposer ;</li>
                        <li>Disposer d'un compte bancaire permettant de recevoir des paiements ;</li>
                        <li>Fournir des informations exactes et complètes lors de son inscription.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">3.2 Procédure d'inscription</h3>
                    <p>L'inscription en tant que Partenaire se déroule comme suit :</p>
                    <ol class="list-decimal ml-6">
                        <li>Création d'un compte utilisateur sur la Plateforme ;</li>
                        <li>Acceptation des présentes CGP ;</li>
                        <li>Fourniture des informations requises (identité, coordonnées, etc.) ;</li>
                        <li>Vérification de l'identité et validation du compte par CampShare ;</li>
                        <li>Configuration des modalités de paiement.</li>
                    </ol>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">3.3 Vérification des Partenaires</h3>
                    <p>CampShare se réserve le droit de procéder à des vérifications concernant l'identité et les informations fournies par le Partenaire. Cette vérification peut inclure la demande de documents justificatifs supplémentaires.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="annonces">4. Publication d'Annonces</h2>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">4.1 Création d'Annonces</h3>
                    <p>Le Partenaire peut créer des Annonces pour chaque Matériel qu'il souhaite proposer à la location. Chaque Annonce doit contenir :</p>
                    <ul class="list-disc ml-6">
                        <li>Une description précise et fidèle du Matériel ;</li>
                        <li>Des photographies de qualité représentant fidèlement le Matériel ;</li>
                        <li>Les conditions de location (prix, durée minimale/maximale, etc.) ;</li>
                        <li>Les conditions de mise à disposition et de restitution ;</li>
                        <li>Tout autre élément pertinent permettant au Client de prendre sa décision.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">4.2 Prix et Conditions</h3>
                    <p>Le Partenaire fixe librement les prix de location de son Matériel, sous réserve de respecter les éventuelles recommandations de CampShare. Les prix doivent être indiqués toutes taxes comprises.</p>
                    
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">4.3 Disponibilité du Matériel</h3>
                    <p>Le Partenaire s'engage à maintenir à jour le calendrier de disponibilité de son Matériel et à honorer toutes les Réservations acceptées via la Plateforme. En cas d'indisponibilité exceptionnelle, il doit en informer CampShare dans les plus brefs délais.</p>
                    
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">4.4 Modération des Annonces</h3>
                    <p>CampShare se réserve le droit de modérer les Annonces avant ou après leur publication, et peut refuser ou retirer toute Annonce ne respectant pas les présentes CGP ou les standards de qualité de la Plateforme.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="reservations">5. Gestion des Réservations</h2>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">5.1 Processus de Réservation</h3>
                    <p>Lorsqu'un Client effectue une demande de Réservation :</p>
                    <ol class="list-decimal ml-6">
                        <li>Le Partenaire reçoit une notification et dispose de 24 heures pour accepter ou refuser la demande ;</li>
                        <li>En cas d'acceptation, la Réservation est confirmée et le paiement est sécurisé ;</li>
                        <li>Les coordonnées du Client sont alors transmises au Partenaire pour organiser la mise à disposition du Matériel.</li>
                    </ol>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">5.2 Obligations du Partenaire</h3>
                    <p>Le Partenaire s'engage à :</p>
                    <ul class="list-disc ml-6">
                        <li>Répondre rapidement aux demandes de Réservation (dans un délai maximal de 24 heures) ;</li>
                        <li>Mettre à disposition le Matériel réservé dans l'état décrit dans l'Annonce et aux dates convenues ;</li>
                        <li>Vérifier l'identité du Client lors de la mise à disposition du Matériel ;</li>
                        <li>Fournir au Client toutes les instructions nécessaires à l'utilisation du Matériel ;</li>
                        <li>Être joignable pendant toute la durée de la location.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">5.3 Annulations et Modifications</h3>
                    <p>En cas d'annulation d'une Réservation :</p>
                    <ul class="list-disc ml-6">
                        <li>Par le Client : les conditions de remboursement définies dans les Conditions Générales d'Utilisation s'appliquent ;</li>
                        <li>Par le Partenaire : celui-ci peut être soumis à des pénalités, sauf cas de force majeure dûment justifié.</li>
                    </ul>
                    <p>Toute modification d'une Réservation doit être effectuée via la Plateforme et acceptée par les deux parties.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="paiements">6. Paiements et Commission</h2>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">6.1 Système de Paiement</h3>
                    <p>Tous les paiements sont traités par CampShare via son prestataire de services de paiement sécurisé. Le Partenaire ne doit en aucun cas demander ou accepter de paiement direct de la part des Clients.</p>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">6.2 Commission de CampShare</h3>
                    <p>Pour chaque Réservation réalisée via la Plateforme, CampShare perçoit une Commission calculée sur le montant total de la transaction. Le montant de cette Commission est précisé dans l'espace Partenaire. CampShare se réserve le droit de modifier le taux de Commission moyennant un préavis de 30 jours.</p>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">6.3 Versement des Revenus</h3>
                    <p>Les sommes dues au Partenaire (montant de la location moins la Commission) sont versées sur son compte bancaire dans un délai maximum de 7 jours après la fin de la location, sous réserve qu'aucun litige ne soit en cours.</p>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">6.4 Fiscalité</h3>
                    <p>Le Partenaire est seul responsable de ses obligations fiscales liées aux revenus générés via la Plateforme. CampShare pourra fournir, sur demande des autorités compétentes, toute information relative aux transactions effectuées.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="responsabilites">7. Responsabilités</h2>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">7.1 Responsabilité du Partenaire</h3>
                    <p>Le Partenaire est seul responsable :</p>
                    <ul class="list-disc ml-6">
                        <li>De l'exactitude des informations fournies dans son profil et ses Annonces ;</li>
                        <li>De la qualité, de la conformité et de la sécurité du Matériel proposé à la location ;</li>
                        <li>Du respect de ses obligations légales et fiscales ;</li>
                        <li>Des dommages causés par le Matériel résultant d'un défaut d'entretien ou d'une non-conformité.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">7.2 Assurance</h3>
                    <p>Il est fortement recommandé au Partenaire de souscrire une assurance couvrant les risques liés à la location de son Matériel (dommages, vol, responsabilité civile, etc.). CampShare pourra proposer des solutions d'assurance spécifiques via des partenaires.</p>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">7.3 Limitation de Responsabilité de CampShare</h3>
                    <p>CampShare agit uniquement en qualité d'intermédiaire entre les Partenaires et les Clients. Sa responsabilité se limite à la fourniture des services de la Plateforme et ne saurait être engagée :</p>
                    <ul class="list-disc ml-6">
                        <li>En cas de litige entre un Partenaire et un Client ;</li>
                        <li>En cas de dommages causés au Matériel ou par le Matériel ;</li>
                        <li>En cas d'informations erronées fournies par un Partenaire.</li>
                    </ul>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="gestion-litiges">8. Gestion des Litiges</h2>
                    <p>En cas de litige entre un Partenaire et un Client :</p>
                    <ol class="list-decimal ml-6">
                        <li>Les parties sont encouragées à résoudre le différend à l'amiable via les outils de communication fournis par la Plateforme ;</li>
                        <li>Si aucun accord n'est trouvé, CampShare peut intervenir comme médiateur ;</li>
                        <li>CampShare peut, à sa discrétion, décider de compenser certains préjudices, sans que cela ne constitue une reconnaissance de responsabilité.</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="evaluation">9. Système d'Évaluation</h2>
                    <p>Après chaque location, les Clients peuvent évaluer le Partenaire et le Matériel loué. De même, le Partenaire peut évaluer les Clients. Ces évaluations sont publiques et contribuent à la confiance au sein de la communauté CampShare.</p>
                    <p>CampShare se réserve le droit de modérer les évaluations ne respectant pas sa charte d'utilisation (contenu offensant, diffamatoire, etc.).</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="sanctions">10. Sanctions et Résiliation</h2>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">10.1 Sanctions</h3>
                    <p>En cas de non-respect des présentes CGP, CampShare se réserve le droit d'appliquer, selon la gravité des faits, les sanctions suivantes :</p>
                    <ul class="list-disc ml-6">
                        <li>Avertissement ;</li>
                        <li>Suspension temporaire du compte Partenaire ;</li>
                        <li>Suppression d'une ou plusieurs Annonces ;</li>
                        <li>Résiliation définitive du compte Partenaire ;</li>
                        <li>Exclusion définitive de la Plateforme.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">10.2 Résiliation par le Partenaire</h3>
                    <p>Le Partenaire peut, à tout moment, résilier son compte en respectant un préavis de 30 jours et en veillant à honorer les Réservations en cours. La résiliation entraîne la suppression de toutes les Annonces du Partenaire.</p>

                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">10.3 Conséquences de la Résiliation</h3>
                    <p>La résiliation, qu'elle émane du Partenaire ou de CampShare, ne donne droit à aucune indemnité ou compensation, sauf disposition légale contraire.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="modification-cgp">11. Modification des CGP</h2>
                    <p>CampShare se réserve le droit de modifier les présentes CGP à tout moment. Les Partenaires seront informés de toute modification par email et/ou notification sur la Plateforme au moins 30 jours avant l'entrée en vigueur des nouvelles dispositions.</p>
                    <p>Si le Partenaire n'accepte pas les nouvelles CGP, il devra résilier son compte avant leur entrée en vigueur. À défaut, la poursuite de l'utilisation de la Plateforme vaudra acceptation des CGP modifiées.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="loi-juridiction">12. Loi Applicable et Juridiction</h2>
                    <p>Les présentes CGP sont régies par le droit français. Tout litige relatif à leur interprétation ou leur exécution relève, sauf disposition légale contraire, de la compétence des tribunaux du ressort de Tetouan, Maroc.</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-2xl font-bold text-forest dark:text-meadow" id="contact">13. Contact</h2>
                    <p>Pour toute question relative aux présentes CGP ou au fonctionnement de la Plateforme, le Partenaire peut contacter CampShare :</p>
                    <ul class="list-disc ml-6">
                        <li>Par email : partenaires@campshare.fr</li>
                        <li>Par courrier : CampShare - Service Partenaires, 123 Avenue du Camping, Tétouan, Maroc</li>
                        <li>Via le formulaire de contact disponible sur la Plateforme</li>
                    </ul>
                </section>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 no-print">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    En acceptant ces conditions, vous vous engagez à respecter l'ensemble des règles décrites ci-dessus en tant que partenaire CampShare.
                </p>
                
                <div class="flex justify-center">
                    <a href="{{ route('HomeClient') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-forest hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest dark:bg-meadow dark:hover:bg-green-700 mr-4">
                        <i class="fas fa-arrow-left mr-2"></i> Retourner à mon espace
                    </a>
                    
                    <a href="{{ url('/devenir_partenaire') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-sunlight hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sunlight">
                        <i class="fas fa-check mr-2"></i> J'accepte et je continue
                    </a>
                </div>
                
                <div class="mt-4 text-center">
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-print mr-2"></i> Imprimer ces conditions
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling to anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>
