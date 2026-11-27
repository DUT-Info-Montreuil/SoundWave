<?php

session_start();
ini_set('display_errors', '1');

require_once __DIR__ . '/../src/Commun/Routeur.php';
$routeur = new Routeur();
$routeur->diriger($_GET);