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
                    p.id_piste,
                    p.titre,
                    p.nombre_ecoutes,
                    STRFTIME('%d/%m/%Y', p.date_publication) AS date_publication
                FROM piste p
                ORDER BY 
                    p.date_publication DESC, 
                    p.id_piste DESC
                LIMIT 10"
        );
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function findById(int $id): ?Piste
    {
        $requetePiste = self::$pdo->prepare(
            "SELECT
                p.id_piste,
                p.titre,
                p.description,
                p.fichier_audio,
                p.nombre_ecoutes,
                p.date_publication
             FROM piste p
             WHERE p.id_piste = :id"
        );
        $requetePiste->execute(['id' => $id]);
        $pistesTrouvees = $requetePiste->fetch(PDO::FETCH_ASSOC);
        if ($pistesTrouvees === false) {
            return null;
        }

        $requeteGenres = self::$pdo->prepare(
            "SELECT genre.nom
             FROM piste
             JOIN possede_genre USING (id_piste)
             JOIN genre USING (id_genre)
             WHERE piste.id_piste = :id"
        );
        $requeteGenres->execute(['id' => $id]);
        $pistesTrouvees['genres'] = $requeteGenres->fetchAll(PDO::FETCH_ASSOC);

        $requeteTags = self::$pdo->prepare(
            "SELECT tag.nom
             FROM piste
             JOIN possede_tag USING (id_piste)
             JOIN tag USING (id_tag)
             WHERE piste.id_piste = :id"
        );
        $requeteTags->execute(['id' => $id]);
        $pistesTrouvees['tags'] = $requeteTags->fetchAll(PDO::FETCH_ASSOC);

        return Piste::origin($pistesTrouvees);
    }

    public function auteursDe(Piste $piste) : array {
        $requete = self::$pdo->prepare(
            "SELECT
            groupe.nom
            FROM piste
            JOIN auteur USING (id_piste)
            JOIN groupe USING (id_groupe)
            WHERE piste.id_piste = :id"
        );
        $requete->execute(['id' => $piste->getIdPiste()]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tousLesGenres(): array
    {
        $requete = self::$pdo->query("SELECT nom FROM genre ORDER BY nom ASC");
        return $requete->fetchAll(PDO::FETCH_COLUMN);
    }
    public function pistesParGenre(string $genre): array
    {
        $requete = self::$pdo->prepare(
                "SELECT
                    p.id_piste,
                    p.titre,
                    p.nombre_ecoutes,
                    STRFTIME('%d/%m/%Y', p.date_publication) AS date_publication
                FROM piste p
                JOIN possede_genre USING (id_piste)
                JOIN genre USING (id_genre)
                WHERE genre.nom = :genre
                ORDER BY 
                    p.date_publication DESC, 
                    p.id_piste DESC
                LIMIT 10"
        );
        $requete->execute(['genre' => $genre]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function incrementerEcoutes(int $idPiste) : void
    {
         $requete = self::$pdo->prepare(
             "UPDATE piste SET nombre_ecoutes = nombre_ecoutes + 1 WHERE id_piste = :id"
         );
         $requete->execute(['id' => $idPiste]);
    }

    public function nombreLikes(int $idPiste): int
    {
        $requete = self::$pdo->prepare(
            "SELECT COUNT(*) FROM like_piste WHERE id_piste = :id"
        );
        $requete->execute(['id' => $idPiste]);
        return (int) $requete -> fetchColumn();
    }

    public function estLikeePar(int $idPiste, int $idMembre): bool
    {
        $requete = self::$pdo->prepare(
            "SELECT 1 FROM like_piste WHERE id_piste = :id_piste AND id_membre = :id_membre"
        );
        $requete->execute([
            'id_piste' => $idPiste,
            'id_membre' => $idMembre,
        ]);
        return $requete->fetchColumn() !== false;
    }

    public function basculerLike(int $idPiste, int $idMembre): void
    {
        if ($this->estLikeePar($idPiste, $idMembre)) {
            $requete = self::$pdo->prepare(
                "DELETE FROM like_piste WHERE id_piste = :id_piste AND id_membre = :id_membre"
            );
        } else {
            $requete = self::$pdo->prepare(
                "INSERT INTO like_piste (id_membre, id_piste) VALUES (:id_membre, :id_piste)"
            );
        }
        $requete->execute([
            'id_membre' => $idMembre,
            'id_piste' => $idPiste,
        ]);
    }
}


?>