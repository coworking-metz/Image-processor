<?php
include 'lib/main.inc.php';

$uri = explode('?',$_SERVER['REQUEST_URI'])[0]??false;

if(!$uri) erreur(404);

$w = $_GET['w']??false;
$cache = empty($_GET['nocache']);

$uri = str_replace('/supabase/','/', $uri);


$url = 'https://lvsbvjweppdlhmjuqqvt.supabase.co/storage/v1/object/public'.$uri;

if(!outputImage($url, ['width'=>$w, 'cache'=>$cache])) {
    erreur(500);
}