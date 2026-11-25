<?php

require_once __DIR__ . '/../Commun/BDD.php'; 
require_once __DIR__ . '/Piste.php'; 

class PisteRepository extends BDD{

    function __construct() {
        parent::__construct();
    }

    public function dernieresPistes() : array {
        $requete = self::$pdo->prepare(
            "SELECT
                    p.titre,
                    p.nombre_ecoutes,
                    p.date_publication
                FROM piste p
                ORDER BY 
                    p.date_publication DESC, 
                    p.id_piste DESC
                LIMIT 10"
        );
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function findById(int $id) : ?Piste {
        $requetePiste = self::$pdo->prepare(
            "SELECT
                    p.id_piste,
                    p.titre,
                    p.description,
                    p.fichier_audio,
                    p.nombre_ecoutes,
                    p.date_publication
                FROM piste p
                WHERE p.id_piste = :id");
        $requetePiste->execute(['id' => $id]);
        $pistesTrouvees = $requetePiste->fetch(PDO::FETCH_ASSOC);
        if ($pistesTrouvees === false){
            return null;
        }

        $requeteGenres = self::$pdo->prepare(
            "SELECT
                    genre.nom
                FROM piste
                JOIN possede_genre USING (id_piste)
                JOIN genre USING (id_genre)
                WHERE piste.id_piste = :id");
        $requeteGenres->execute(['id' => $id]);
        $pistesTrouvees["genre"] = $requeteGenres->fetchAll(PDO::FETCH_ASSOC);

        $requeteTags = self::$pdo->prepare(
            "SELECT
                    tag.nom
                FROM piste
                JOIN possede_tag USING (id_piste)
                JOIN tag USING (id_tag)
                WHERE piste.id_piste = :id");
        $requeteTags->execute(['id' => $id]);
        $pistesTrouvees["tags"] = $requeteTags->fetchAll(PDO::FETCH_ASSOC);

        return Piste::origin($pistesTrouvees);
    }
}


?>