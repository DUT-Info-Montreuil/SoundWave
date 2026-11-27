<?php

require_once __DIR__ . "/../Modele/UtilisateurRepository.php";
require_once __DIR__ . "/../Vue/UtilisateurVue.php";

class UtilisateurControleur {

	private UtilisateurRepository $userRepo;
	private UtilisateurVue $userView;

	public function __construct(UtilisateurRepository $userRepo, UtilisateurVue $userView) {
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
        $mot_de_passe = $_POST['mot_de_passe'] ?? null;
        if (!is_string($nom) || $nom === ''
            || !is_string($email) || $email === ''
            || !is_string($mot_de_passe) || $mot_de_passe === '') {
            die("Paramètre manquant");
        }

        $utilisateurNouv = new Utilisateur(0, $nom, $email, $mot_de_passe, 'membre');
        $this->userRepo->inscrire($utilisateurNouv);
        header('Location: index.php?module=visiteur&action=formulaireConnexion');
        exit();
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
        $mot_de_passe = $_POST['mot_de_passe'] ?? null;
        if (!is_string($email) || $email === '' || !is_string($mot_de_passe) || $mot_de_passe === '') {
            die("Paramètre manquant");
        }

		$user = $this->userRepo->findByEmail($email);

		if ($user !== null && password_verify($mot_de_passe, $user->getMot_de_passe())) {
			session_regenerate_id(true);
			$_SESSION['id_utilisateur'] = $user->getId_membre();
            header('Location: index.php?module=piste&action=liste');
            exit();
		} else {
			die("Erreur lors de la connexion, email ou mot de passe incorrect");
		}
	}

    public function validationDeconnexion(): void {
        $this->userView->validationDeconnexion();
    }

    public function deconnecter() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Mauvaise méthode HTTP");
        }

        if (!Csrf::verifierValeur($_POST['csrf'] ?? null)) {
            http_response_code(403);
            die('Jeton CSRF invalide');
        }

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 60,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
        header('Location: index.php?module=piste&action=liste');
        exit();
    }
}

?>