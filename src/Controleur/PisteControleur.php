<?php

require_once __DIR__ . '/../Modele/PisteRepository.php'; 
require_once __DIR__ . '/../Vue/PisteListeVue.php';

class PisteControleur
{
    private PisteRepository $repo;
    private PisteListeVue $vue; 

    public function __construct(PisteRepository $repo, PisteListeVue $vue)
    {
        $this->repo = $repo; 
        $this->vue = $vue;
    }

    public function liste()
    {
        $genre = isset($_GET['genre']) ? trim((string) $_GET['genre']) : '';
        $genres = $this->repo->tousLesGenres();

        if ($genre !== '') {
            $pistes = $this->repo->pistesParGenre($genre);
        } else {
            $pistes = $this->repo->dernieresPistes();
        }

        $this->vue->afficher($pistes, $genres, $genre);
    }
}


?>