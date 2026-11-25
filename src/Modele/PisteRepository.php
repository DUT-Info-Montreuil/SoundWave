<?php

require_once __DIR__ . '/../Commun/BDD.php'; 
require_once __DIR__ . '/Piste.php'; 

class PisteRepository extends BDD{

    function __construct()
    {
        parent::__construct();
    }

    public function dernieresPistes() : array
    {
        $requete = self::$pdo->prepare("SELECT
                    p.id_piste,
                    p.titre,
                    p.description,
                    p.fichier_audio,
                    p.nombre_ecoutes,
                    p.nom_genre,
                    p.date_publication,
                    m.nom AS nom_artiste,
                    g.nom AS nom_groupe
                FROM Piste p
                LEFT JOIN Membre m ON p.id_membre = m.id_membre
                LEFT JOIN Groupe g ON p.id_groupe = g.id_groupe
                ORDER BY p.date_publication DESC, p.id_piste DESC LIMIT 10");
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC); 
    }


    public function findById(int $id) : ?Piste
    {
        $requete = self::$pdo->prepare("SELECT
                    p.id_piste,
                    p.titre,
                    p.description,
                    p.fichier_audio,
                    p.nombre_ecoutes,
                    p.nom_genre,
                    p.date_publication,
                    m.nom AS nom_artiste,
                    g.nom AS nom_groupe
                FROM Piste p
                LEFT JOIN Membre m ON p.id_membre = m.id_membre
                LEFT JOIN Groupe g ON p.id_groupe = g.id_groupe
                WHERE p.id_piste = :id"); 
        $requete->execute(['id' => $id]);
        $pistesTrouvees = $requete->fetch(PDO::FETCH_ASSOC);
        return $pistesTrouves === false ? null : Piste::origin($pistesTrouvees);
    }

    public function tousLesGenres(): array
    {
        $requete = self::$pdo->query("SELECT nom_genre FROM Genre ORDER BY nom_genre ASC");
        return $requete->fetchAll(PDO::FETCH_COLUMN);
    }
    public function pistesParGenre(string $genre): array
    {
        $requete = self::$pdo->prepare("SELECT
                    p.id_piste,
                    p.titre,
                    p.description,
                    p.nombre_ecoutes,
                    p.nom_genre,
                    p.date_publication,
                    m.nom AS nom_artiste,
                    g.nom AS nom_groupe
                FROM Piste p
                LEFT JOIN Membre m ON p.id_membre = m.id_membre
                LEFT JOIN Groupe g ON p.id_groupe = g.id_groupe
                WHERE p.nom_genre = :genre
                ORDER BY p.date_publication DESC, p.id_piste DESC");
        $requete->execute(['genre' => $genre]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>