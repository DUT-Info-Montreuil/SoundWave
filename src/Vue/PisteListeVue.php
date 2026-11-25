<?php

require_once __DIR__ . '/../Commun/Vue.php'; 

class PisteListeVue extends Vue
{
    public function afficher($pistes)
    {
        $this->debutContenu(); 
        ?>
        <h1>Découvrir de nouveaux sons</h1>
        <form method="get" action="index.php">
            <input type="hidden" name="module" value="piste">
            <input type="hidden" name="action" value="liste">
            <label for="genre">Filtrer par genre :</label>
            <select name="genre" id="genre">
                <option value="">Tous les genres</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= e((string) $genre) ?>" <?= $genreSelectionne === $genre ? 'selected' : '' ?>>
                        <?= e((string) $genre) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrer</button>
        </form>
        <h2>Dernières pistes publiées</h2>
        <?php if (empty($pistes)): ?>
            <p>Aucune piste publiée pour le moment</p>
        <?php else: ?>
            <ul>
                <?php foreach ($pistes as $piste): ?>
                    <?php
                    $auteur = isset($piste['nom_artiste']) && $piste['nom_artiste'] !== null
                        ? $piste['nom_artiste']
                        : (isset($piste['nom_groupe']) && $piste['nom_groupe'] !== null
                            ? $piste['nom_groupe']
                            : 'Artiste inconnu');
                    ?>
                    <li>
                        <strong><?= e((string) $piste['titre']) ?></strong>
                        - Artiste : <?= e((string) $auteur) ?>
                        - Genre : <?= e((string) $piste['nom_genre']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php
        $this->afficherPage('SoundWave - Accueil');
    }
}


