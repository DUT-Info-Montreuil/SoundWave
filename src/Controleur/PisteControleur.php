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

    public function liste(): void
    {
        $genre = isset($_GET['genre']) ? trim((string) $_GET['genre']) : '';
        $tag = isset($_GET['tag']) ? trim((string) $_GET['tag']) : '';

        $genres = $this->repo->tousLesGenres();
        $tags = $this->repo->tousLesTags();

        if ($genre !== '' and $tag !== '') {
            $pistes = $this->repo->pistesParGenreEtTag($genre, $tag);
        } elseif ($genre !== '') {
            $pistes = $this->repo->pistesParGenre($genre);
        }elseif ($tag !== '') {
            $pistes = $this->repo->pistesParTag($tag);
        }else{
            $pistes = $this->repo->dernieresPistes();
        }

        $this->vue->afficher($pistes, $genres, $genre, $tags, $tag);
    }
}