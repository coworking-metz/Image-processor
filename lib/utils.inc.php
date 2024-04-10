<?php


function cloudflareHit(array $urls) {
    if(!$urls) {
        $urls = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";    
    }

    
    if(!is_array($urls)) {
        $urls = [$urls];
    }

    $data = ['urls' => $urls];
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context = stream_context_create($options);
    file_get_contents('https://cloudflare.coworking-metz.fr/hit', false, $context);
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