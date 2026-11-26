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
        $pistes = $this->repo->dernieresPistes();
        $this->vue->afficher($pistes);
    }
}


?>