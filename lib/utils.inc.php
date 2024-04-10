<?php


function cloudflareHit($url=false) {
    if(!$url) {
        $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";    
    }
    file_get_contents('https://cloudflare.coworking-metz.fr/hit?url='.urlencode($url));
}
function noCacheHeaders() {
    header("Cache-Control: no-cache, must-revalidate, max-age=0");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Pragma: no-cache'); // HTTP 1.0.    
}
function erreur($code) {
    noCacheHeaders();
    http_response_code($code);
    die;
}