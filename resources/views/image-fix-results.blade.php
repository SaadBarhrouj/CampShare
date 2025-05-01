<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la correction des images</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Diagnostic et correction des images</h1>
            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">1. Vérification du lien symbolique</h2>
                @if(isset($linkExists) && $linkExists)
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2">
                        <p>✅ Le lien symbolique <code>public/storage</code> existe.</p>
                    </div>
                @elseif(isset($linkCreated) && $linkCreated)
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2">
                        <p>✅ Le lien symbolique <code>public/storage</code> a été créé avec succès.</p>
                    </div>
                @else
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-2">
                        <p>❌ Le lien symbolique <code>public/storage</code> n'existe pas ou n'a pas pu être créé.</p>
                        <p>Exécutez la commande suivante manuellement :</p>
                        <pre class="bg-gray-800 text-white p-2 rounded mt-2">php artisan storage:link</pre>
                    </div>
                @endif
            </div>
            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">2. Vérification du dossier equipment_images</h2>
                @if(isset($equipmentDirExists) && $equipmentDirExists)
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2">
                        <p>✅ Le dossier <code>storage/app/public/equipment_images</code> existe.</p>
                    </div>
                @elseif(isset($dirCreated) && $dirCreated)
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2">
                        <p>✅ Le dossier <code>storage/app/public/equipment_images</code> a été créé avec succès.</p>
                    </div>
                @else
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-2">
                        <p>❌ Le dossier <code>storage/app/public/equipment_images</code> n'existe pas ou n'a pas pu être créé.</p>
                    </div>
                @endif
            </div>
            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">3. Correction des chemins d'images</h2>
                @if(isset($imagesUpdated))
                    @if($imagesUpdated > 0)
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2">
                            <p>✅ {{ $imagesUpdated }} chemins d'images ont été corrigés dans la base de données.</p>
                        </div>
                    @else
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-2">
                            <p>ℹ️ Aucun chemin d'image n'avait besoin d'être corrigé (sur {{ $totalImages ?? 0 }} images).</p>
                        </div>
                    @endif
                @endif
            </div>
            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">4. Image de test</h2>
                @if(isset($testImageCreated) && $testImageCreated)
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-2">
                        <p>✅ Une image de test a été créée avec succès.</p>
                    </div>
                    <div class="mt-4">
                        <p class="mb-2">Aperçu de l'image de test :</p>
                        <img src="{{ asset('storage/equipment_images/test-image.jpg') }}" alt="Image de test" class="border border-gray-300 max-w-md">
                    </div>
                @else
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-2">
                        <p>⚠️ L'image de test existe déjà ou n'a pas pu être créée.</p>
                    </div>
                @endif
            </div>
            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Que faire maintenant ?</h2>
                <ol class="list-decimal pl-5 space-y-2">
                    <li>Essayez d'ajouter un nouvel équipement avec une image.</li>
                    <li>Si les images ne s'affichent toujours pas, vérifiez les permissions des dossiers.</li>
                    <li>Assurez-vous que le serveur web a les droits d'accès au dossier <code>storage</code>.</li>
                    <li>Redémarrez le serveur web si nécessaire.</li>
                </ol>
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('HomePartenaie') }}" class="inline-block bg-forest hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded">
                    Retour à la page des équipements
                </a>
            </div>
        </div>
    </div>
</body>
</html>
