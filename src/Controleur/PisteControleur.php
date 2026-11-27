<?php

require_once __DIR__ . '/../Modele/PisteRepository.php'; 
require_once __DIR__ . '/../Vue/PisteListeVue.php';

class PisteControleur
{
    private PisteRepository $repo;
    private PisteListeVue $vue; 
    private PisteDetailVue $detailVue;

    public function __construct(PisteRepository $repo, PisteListeVue $vue, ?PisteDetailVue $detailVue)
    {
        $this->repo = $repo; 
        $this->vue = $vue;
        $this->detailVue = $detailVue ?? new PisteDetailVue();
    }

    public function liste(): void
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

    public function detail(): void
    {
       $id = isset($_GET['id']) ? (int) $_GET['id']: 0;
       if($id <= 0){
           http_response_code(404);
           echo'Piste introuvable';
           return;
       }

       $piste = $this->repo->findById($id);
       if($piste === null){
           http_response_code(404);
           echo 'Piste introuvable';
           return;
       }

       if(!isset($_GET['like'])) {
           $this->repo->incrementerEcoutes($id);
           $piste = $this->repo->findById($id) ?? $piste;
       }

       $auteurs = $this->repo->auteursDe($piste);
       $nbLikes = $this->repo->nombreLikes($id);
       $idUtilisateur = isset($_SESSION['id_utilisateur']) ? (int) $_SESSION['id_utilisateur'] : null;
       $estLikee = $idUtilisateur !== null ? $this->repo->estLikeePar($id, $idUtilisateur) : false;
       $this -> detailVue->afficher(
           $piste,
           $auteurs,
           $nbLikes,
           $estLikee,
           $idUtilisateur
       );
    }

    public function liker(): void
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            die('Methode HTTP non autorisé');
        }

        if(!csrf::verifierValeur($_POST['csrf'] ?? null)){
            http_response_code(403);
            die('Jeton CSRF invalide');
        }

        if(!isset($_SESSION['id_utilisateur'])){
            header('Location: index.php?module=utilisateur&action=formulaireConnexion');
            exit();
        }

        $idPiste = isset($_POST['id_piste']) ? (int) $_POST['id_piste']: 0;
        if($idPiste <= 0){
            http_response_code(400);
            die('Piste invalide');
        }

        $this ->repo->basculerLike($idPiste, (int) $_SESSION['id_utilisateur']);
        header('Location: index.php?module=piste&action=detail&id=' . $idPiste . '&like=1');
        exit();
    }
}