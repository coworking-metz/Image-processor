<?php

/**
 * Envoie une image au client avec les en-têtes appropriés pour le cache, en stockant localement les images pour éviter les téléchargements multiples.
 * Gère également le redimensionnement de l'image en fonction d'une largeur donnée tout en préservant le rapport d'aspect.
 * 
 * @param string $imageUrl URL de l'image à afficher.
 * @param array $options Options de redimensionnement (p. ex. 'width').
 */
function outputImage($imageUrl, $options = [])
{
    $width = $options['width'] ?? false;
    $imageType = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));
    $localPath = __DIR__ . '/../tmp/' . md5($imageUrl . json_encode($options)) . '.' . $imageType;

    // Déterminer le type de contenu en fonction de l'extension de l'image
    switch ($imageType) {
        case 'jpg':
        case 'jpeg':
            $contentType = 'image/jpeg';
            break;
        case 'png':
            $contentType = 'image/png';
            break;
        case 'gif':
            $contentType = 'image/gif';
            break;
        case 'webp':
            $contentType = 'image/webp';
            break;
        default:
            return;
    }

    // Vérifier si l'image est déjà en cache
    if (file_exists($localPath)) {
        $c = file_get_contents($localPath);
    } else {
        $c = file_get_contents($imageUrl);

        if ($width) {
            // Redimensionnement de l'image si une largeur est spécifiée
            $imageResource = imagecreatefromstring($c);
            $originalWidth = imagesx($imageResource);
            $originalHeight = imagesy($imageResource);
            $height = ($originalHeight / $originalWidth) * $width;

            $resizedImage = imagecreatetruecolor($width, $height);
            imagecopyresampled($resizedImage, $imageResource, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

            ob_start();
            switch ($contentType) {
                case 'image/jpeg':
                    imagejpeg($resizedImage);
                    break;
                case 'image/png':
                    imagepng($resizedImage);
                    break;
                case 'image/gif':
                    imagegif($resizedImage);
                    break;
                case 'image/webp':
                    imagewebp($resizedImage);
                    break;
            }
            $c = ob_get_clean();
        }
        if (!$c) {
            return; // En cas d'erreur de téléchargement, quitter la fonction
        }
        file_put_contents($localPath, $c);
    }


    // Appliquer les en-têtes de cache et envoyer l'image
    header('Content-Type: ' . $contentType);
    echo $c;
}
