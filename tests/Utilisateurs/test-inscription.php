<?php

require_once __DIR__ . '/../../src/Commun/BDD.php';
require_once __DIR__ . "/../../src/Modele/Utilisateur.php";
require_once __DIR__ . "/../../src/Modele/UtilisateurRepository.php";

$repo = new UtilisateurRepository();
/*$user = new Utilisateur(0, "nom", "email", "mot_de_passe", "Membre");
$id_user_inscrit = $repo->inscrire($user);
$userInscrit = $repo->findById($id_user_inscrit);
echo "<br>";
var_dump($userInscrit);*/

/*$user = new Utilisateur(0, "nomAdmin", "emailAdmin", "mot_de_passeAdmin", "Administrateur");
$repo->inscrire($user);
$userInscrit = $repo->findByEmail("emailAdmin");
echo "<br>";
var_dump($userInscrit);*/

//utilisateur avec email déjà utilisé
/*$user = new Utilisateur(0, "utilisateurMailUsed", "email", "mot_de_passe", "Membre");
$id_user_inscrit = $repo->inscrire($user);
$userInscrit = $repo->findById($id_user_inscrit);
echo "<br>";
var_dump($userInscrit);*/
//Pas ajouter car email déjà utilisé

//utilisateur mot_de_passe moins de 8 lettres
/*$user = new Utilisateur(0, "utilisateurMDPTropCourt", "email3", "mot_de", "Membre");
$id_user_inscrit = $repo->inscrire($user);
$userInscrit = $repo->findById($id_user_inscrit);
echo "<br>";*/
//Pas ajouter car mdp moins de 8 lettres

//utilisateur mot_de_passe plus de 20 lettres
/*$user = new Utilisateur(0, "utilisateurMDPTropCourt", "email3", "mot_de_passeaaaaaaaaa", "Membre");
$id_user_inscrit = $repo->inscrire($user);
$userInscrit = $repo->findById($id_user_inscrit);
echo "<br>";*/
//Pas ajouter car mdp plus de 20 lettres

?>