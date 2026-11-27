<?php

require_once __DIR__ . '/../Vue/PisteListeVue.php';
require_once __DIR__ . '/../Vue/PisteDetailVue.php';
require_once __DIR__ . '/../Modele/PisteRepository.php';
require_once __DIR__ . '/../Controleur/PisteControleur.php';
require_once __DIR__ . '/../Vue/UtilisateurVue.php';
require_once __DIR__ . '/../Modele/UtilisateurRepository.php';
require_once __DIR__ . '/../Controleur/UtilisateurControleur.php';

class routeur{

    public function diriger(array $query): void
    {
        $module = isset($query['module']) ? (string) $query['module'] : 'piste';
        $action = isset($query['action'])
            ? (string) $query['action']
            : (isset($query['route']) ? (string) $query['route'] : 'liste');

        if ($module === 'piste') {
            $repo = new PisteRepository();
            $vue = new PisteListeVue();
            $detailVue = new PisteDetailVue();
            $controleur = new PisteControleur($repo, $vue, $detailVue);

            match ($action) {
                'liste' => $controleur->liste(),
                'detail' => $controleur->detail(),
                'liker' => $controleur->liker(),
                default => $this->introuvable(),
            };
            return;
        }

        if ($module === 'utilisateur' || $module === 'visiteur') {
            $userRepo = new UtilisateurRepository();
            $userView = new UtilisateurVue();
            $controleur = new UtilisateurControleur($userRepo, $userView);

            match ($action) {
                'formulaireInscription' => $controleur->formulaireInscription(),
                'inscrire' => $controleur->inscrire(),
                'formulaireConnexion' => $controleur->formulaireConnexion(),
                'connecter' => $controleur->connecter(),
                default => $this->introuvable(),
            };
            return;
        }
        $this->introuvable();
    }

    private function introuvable(): void
    {
        http_response_code(404);
        echo 'Page introuvable';
    }
}