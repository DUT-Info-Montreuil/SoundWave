<?php

session_start();
ini_set('display_errors', '1');

require_once __DIR__ . '/../src/Vue/PisteListeVue.php';
require_once __DIR__ . '/../src/Vue/PisteDetailVue.php';
require_once __DIR__ . '/../src/Modele/PisteRepository.php';
require_once __DIR__ . '/../src/Controleur/PisteControleur.php';
require_once __DIR__ . '/../src/Vue/UtilisateurVue.php';
require_once __DIR__ . '/../src/Modele/UtilisateurRepository.php';
require_once __DIR__ . '/../src/Controleur/UtilisateurControleur.php';

$module = $_GET['module'] ?? 'piste';
$action = $_GET['action'] ?? ($_GET['route'] ?? 'liste');

if ($module === 'piste') {
    $repo = new PisteRepository();
    $vue = new PisteListeVue();
    $detailVue = new PisteDetailVue();
    $controleur = new PisteControleur($repo, $vue, $detailVue);

    if ($action === 'liste') {
        $controleur->liste();
    } elseif ($action === 'detail') {
        $controleur->detail();
    } elseif ($action === 'liker') {
        $controleur->liker();
    } else {
        http_response_code(404);
        echo 'Page introuvable';
    }
} elseif ($module === 'utilisateur' || $module === 'visiteur') {
    $userRepo = new UtilisateurRepository();
    $userView = new UtilisateurVue();
    $controleur = new UtilisateurControleur($userRepo, $userView);

    if ($action === 'formulaireInscription') {
        $controleur->formulaireInscription();
    } elseif ($action === 'inscrire') {
        $controleur->inscrire();
    } elseif ($action === 'formulaireConnexion') {
        $controleur->formulaireConnexion();
    } elseif ($action === 'connecter') {
        $controleur->connecter();
    } else {
        http_response_code(404);
        echo 'Page introuvable';
    }
} else {
    http_response_code(404);
    echo 'Page introuvable';
}