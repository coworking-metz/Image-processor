<?php
if(isset($_GET['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}
include 'images.inc.php';
include 'utils.inc.php';