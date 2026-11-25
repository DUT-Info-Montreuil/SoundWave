<?php

require_once __DIR__ . "/../Modele/UtilisateurRepository.php";
require_once __DIR__ . "/../Vue/UtilisateurVue.php";

class UtilisateurControleur {

	private UtilisateurRepository $userRepo;
	private UtilisateurView $userView;

	public function __construct(UtilisateurRepository $userRepo, UtilisateurView $userView) {
		$this->userRepo=$userRepo;
		$this->userView=$userView;
	}

	public function formulaireInscription(): void {
		$this->userView->formulaireInscription();
	}

	public function inscrire(): void {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Mauvaise méthode HTTP");
        }

        if (!Csrf::verifierValeur($_POST['csrf'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }

        $nom = $_POST['nom'] ?? null;
        $email = $_POST['email'] ?? null;
        $mdp = $_POST['mdp'] ?? null;
        if (!is_string($nom) || $nom === ''
            || !is_string($email) || $email === ''
            || !is_string($mdp) || $mdp === '') {
            die("Paramètre manquant");
        }

        $utilisateurNouv = new Utilisateur(0, $nom, $email, $mdp, 'lecteur');
        $this->userRepo->inscrire($utilisateurNouv);
        ?><a href="index.php?module=utilisateur&route=formulaire_connexion">Se connecter</a><?php
		
	}

	public function formulaireConnexion(): void {
        $this->userView->formulaireConnexion();
	}

	public function connecter() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Mauvaise méthode HTTP");
        }

        if (!Csrf::verifierValeur($_POST['csrf'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }

        $email = $_POST['email'] ?? null;
        $mdp = $_POST['mdp'] ?? null;
        if (!is_string($email) || $email === '' || !is_string($mdp) || $mdp === '') {
            die("Paramètre manquant");
        }

		$user = $this->userRepo->findByEmail($email);

		if ($user !== null && password_verify($mdp, $user->getMdp())) {
			session_regenerate_id(true);
			$_SESSION['id_utilisateur'] = $user->getId();
			
		} else {
			die("Erreur lors de la connexion, email ou mot de passe incorrect");
		}
	}