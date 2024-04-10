<?php


/**
 * Envoie une image au client avec les en-têtes appropriés pour le cache.
 * 
 * @param string $imageUrl URL de l'image à afficher.
 */
function outputImage($imageUrl) {
    // Déterminer le type de contenu en fonction de l'extension de l'image
    $imageType = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));
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
    
 

    // Lire et envoyer le contenu de l'image
    $c = file_get_contents($imageUrl);

    if(!$c) return;
    cloudflareHit();

    // Configurer les en-têtes pour le cache
    header('Content-Type: ' . $contentType);
    header('Cache-Control: public, max-age=31536000, s-max-age=31536000, immutable'); // Cache pour un an
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    echo $c;
}
