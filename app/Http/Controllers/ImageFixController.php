<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use App\Models\Image;

class ImageFixController extends Controller
{
    public function fixImages()
    {
        // 1. Vérifier si le lien symbolique existe
        $linkExists = file_exists(public_path('storage'));
        
        // Si le lien n'existe pas, le créer
        if (!$linkExists) {
            try {
                Artisan::call('storage:link');
                $linkCreated = true;
            } catch (\Exception $e) {
                $linkCreated = false;
                Log::error('Erreur lors de la création du lien symbolique: ' . $e->getMessage());
            }
        }
        
        // 2. Vérifier si le dossier equipment_images existe
        $equipmentDirExists = Storage::disk('public')->exists('equipment_images');
        
        // Si le dossier n'existe pas, le créer
        if (!$equipmentDirExists) {
            try {
                Storage::disk('public')->makeDirectory('equipment_images');
                $dirCreated = true;
            } catch (\Exception $e) {
                $dirCreated = false;
                Log::error('Erreur lors de la création du dossier equipment_images: ' . $e->getMessage());
            }
        }
        
        // 3. Corriger les chemins d'images dans la base de données
        $updated = 0;
        $images = Image::all();
        
        foreach ($images as $image) {
            $url = $image->url;
            
            // Vérifier si l'URL commence par /storage
            if (strpos($url, '/storage/') === 0) {
                // Supprimer le slash au début
                $newUrl = substr($url, 1);
                $image->url = $newUrl;
                $image->save();
                $updated++;
                Log::info('URL d\'image corrigée: ' . $url . ' -> ' . $newUrl);
            }
        }
        
        // 4. Créer une image de test pour vérifier
        try {
            $testImagePath = storage_path('app/public/equipment_images/test-image.jpg');
            $testImageExists = file_exists($testImagePath);
            
            if (!$testImageExists) {
                // Créer une image simple si GD est disponible
                if (extension_loaded('gd')) {
                    $image = imagecreatetruecolor(300, 200);
                    $bgColor = imagecolorallocate($image, 255, 255, 255);
                    $textColor = imagecolorallocate($image, 0, 0, 0);
                    imagefill($image, 0, 0, $bgColor);
                    imagestring($image, 5, 100, 80, 'Test Image', $textColor);
                    imagejpeg($image, $testImagePath);
                    imagedestroy($image);
                    $testImageCreated = true;
                } else {
                    // Si GD n'est pas disponible, créer un fichier texte
                    file_put_contents($testImagePath, 'Test image placeholder');
                    $testImageCreated = true;
                }
            } else {
                $testImageCreated = false;
            }
        } catch (\Exception $e) {
            $testImageCreated = false;
            Log::error('Erreur lors de la création de l\'image de test: ' . $e->getMessage());
        }
        
        return view('image-fix-results', [
            'linkExists' => $linkExists,
            'linkCreated' => $linkCreated ?? false,
            'equipmentDirExists' => $equipmentDirExists,
            'dirCreated' => $dirCreated ?? false,
            'imagesUpdated' => $updated,
            'totalImages' => count($images),
            'testImageCreated' => $testImageCreated ?? false
        ]);
    }
    
    public function showFixResults()
    {
        return view('image-fix-results');
    }
}
