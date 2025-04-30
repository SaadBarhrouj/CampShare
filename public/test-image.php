<?php
// Script de test pour vérifier les problèmes d'images

// Charger l'environnement Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier si le lien symbolique existe
echo "<h2>Vérification du lien symbolique</h2>";
if (file_exists(__DIR__.'/storage')) {
    echo "<p style='color:green'>✓ Le lien symbolique /public/storage existe.</p>";
} else {
    echo "<p style='color:red'>✗ Le lien symbolique /public/storage n'existe pas.</p>";
    echo "<p>Exécutez la commande : <code>php artisan storage:link</code></p>";
}

// Vérifier si le dossier equipment_images existe
echo "<h2>Vérification du dossier equipment_images</h2>";
if (is_dir(__DIR__.'/../storage/app/public/equipment_images')) {
    echo "<p style='color:green'>✓ Le dossier storage/app/public/equipment_images existe.</p>";
} else {
    echo "<p style='color:red'>✗ Le dossier storage/app/public/equipment_images n'existe pas.</p>";
    echo "<p>Création du dossier...</p>";
    mkdir(__DIR__.'/../storage/app/public/equipment_images', 0755, true);
    echo "<p style='color:green'>✓ Dossier créé avec succès.</p>";
}

// Vérifier les permissions
echo "<h2>Vérification des permissions</h2>";
$storageDir = __DIR__.'/../storage';
$publicStorageDir = __DIR__.'/storage';
$equipmentImagesDir = __DIR__.'/../storage/app/public/equipment_images';

echo "<p>Permissions du dossier storage: " . substr(sprintf('%o', fileperms($storageDir)), -4) . "</p>";
echo "<p>Permissions du lien symbolique public/storage: " . (file_exists($publicStorageDir) ? substr(sprintf('%o', fileperms($publicStorageDir)), -4) : 'N/A') . "</p>";
echo "<p>Permissions du dossier equipment_images: " . substr(sprintf('%o', fileperms($equipmentImagesDir)), -4) . "</p>";

// Vérifier les images dans la base de données
echo "<h2>Images dans la base de données</h2>";
try {
    $images = DB::table('images')->get();
    
    if (count($images) === 0) {
        echo "<p>Aucune image trouvée dans la base de données.</p>";
    } else {
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Item ID</th><th>URL</th><th>Existe</th><th>Aperçu</th></tr>";
        
        foreach ($images as $image) {
            $url = $image->url;
            $fullPath = __DIR__ . '/' . $url;
            $exists = file_exists($fullPath);
            
            echo "<tr>";
            echo "<td>" . $image->id . "</td>";
            echo "<td>" . $image->item_id . "</td>";
            echo "<td>" . $url . "</td>";
            echo "<td>" . ($exists ? "<span style='color:green'>Oui</span>" : "<span style='color:red'>Non</span>") . "</td>";
            echo "<td>";
            if ($exists) {
                echo "<img src='/" . $url . "' style='max-width: 100px; max-height: 100px;'>";
            } else {
                echo "<span style='color:red'>Image introuvable</span>";
            }
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Erreur lors de la récupération des images : " . $e->getMessage() . "</p>";
}

// Créer une image de test
echo "<h2>Création d'une image de test</h2>";
try {
    // Créer une image de test
    $testImagePath = __DIR__.'/../storage/app/public/equipment_images/test-image.jpg';
    $testImageUrl = 'storage/equipment_images/test-image.jpg';
    
    // Vérifier si l'image existe déjà
    if (file_exists($testImagePath)) {
        echo "<p>L'image de test existe déjà.</p>";
    } else {
        // Créer une image simple
        $image = imagecreatetruecolor(300, 200);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $bgColor);
        imagestring($image, 5, 100, 80, 'Test Image', $textColor);
        imagejpeg($image, $testImagePath);
        imagedestroy($image);
        
        echo "<p style='color:green'>✓ Image de test créée avec succès.</p>";
    }
    
    // Afficher l'image de test
    echo "<p>Aperçu de l'image de test :</p>";
    echo "<img src='/" . $testImageUrl . "' style='max-width: 300px; border: 1px solid #ccc;'>";
    
    // Vérifier si l'image est accessible via l'URL
    $testImageFullUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $testImageUrl;
    $headers = @get_headers($testImageFullUrl);
    $accessible = $headers && strpos($headers[0], '200') !== false;
    
    echo "<p>URL de l'image : <a href='/" . $testImageUrl . "' target='_blank'>" . $testImageUrl . "</a></p>";
    echo "<p>Accessible via URL : " . ($accessible ? "<span style='color:green'>Oui</span>" : "<span style='color:red'>Non</span>") . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Erreur lors de la création de l'image de test : " . $e->getMessage() . "</p>";
}

// Corriger les chemins d'images dans la base de données
echo "<h2>Correction des chemins d'images</h2>";
try {
    $updated = 0;
    
    foreach ($images as $image) {
        $url = $image->url;
        
        // Vérifier si l'URL commence par /storage
        if (strpos($url, '/storage/') === 0) {
            // Supprimer le slash au début
            $newUrl = substr($url, 1);
            DB::table('images')->where('id', $image->id)->update(['url' => $newUrl]);
            $updated++;
        }
    }
    
    if ($updated > 0) {
        echo "<p style='color:green'>✓ " . $updated . " chemins d'images corrigés dans la base de données.</p>";
    } else {
        echo "<p>Aucun chemin d'image n'a eu besoin d'être corrigé.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Erreur lors de la correction des chemins d'images : " . $e->getMessage() . "</p>";
}

echo "<h2>Que faire maintenant ?</h2>";
echo "<ol>";
echo "<li>Si le lien symbolique n'existe pas, exécutez <code>php artisan storage:link</code></li>";
echo "<li>Si les images ne s'affichent pas, vérifiez que les chemins dans la base de données sont corrects (sans slash au début)</li>";
echo "<li>Assurez-vous que les permissions des dossiers sont correctes (755 ou 775)</li>";
echo "<li>Essayez d'ajouter un nouvel équipement avec une image après avoir exécuté ce script</li>";
echo "</ol>";

echo "<p><a href='/'>Retour à l'accueil</a></p>";
