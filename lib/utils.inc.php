<?php

function erreur($code) {
    http_response_code($code);
    die;
}