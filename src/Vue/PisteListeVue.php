<?php

require_once __DIR__ . '/../Commun/Vue.php';

class PisteListeVue extends Vue
{
    public function afficher($pistes, $genres, $genreSelectionne, $tags, $tagSelectionne)
    {
        $this->debutContenu();
        ?>
        <section class="hero-banner">
            <div>
                <span class="hero-tag">À la une sur SoundWave</span>
                <h1>Découvrir de nouveaux sons</h1>
                <p>Explorez les dernières pistes publiées sur SoundWave.</p>
            </div>
            <a href="#dernieres-pistes" class="hero-cta">Écouter maintenant</a>
        </section>

        <form class="search-filters-bar" method="get" action="index.php">
            <input type="hidden" name="module" value="piste">
            <input type="hidden" name="action" value="liste">

            <input
                    type="text"
                    name="s"
                    class="filter-input"
                    placeholder="Rechercher : titre, artiste, groupe, tag, genre"
                    value="<?= e((string) ($_GET['s'] ?? '')) ?>"
            >

            <select name="genre" id="genre" class="filter-select" aria-label="Genre">
                <option value="">Tous les genres</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= e((string) $genre) ?>" <?= $genreSelectionne === $genre ? 'selected' : '' ?>>
                        <?= e((string) $genre) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="tag" class="filter-select" aria-label="Tag">
                <option value ="">Tous les tags</option>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= e((string) $tag) ?>" <?= $tagSelectionne === $tag ? 'selected' : '' ?>>
                        <?= e((string) $tag) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-filter-submit">Filtrer</button>
        </form>

        <section id="dernieres-pistes">
            <div class="section-header">
                <h2 class="section-titre">Dernières pistes publiées</h2>
            </div>

            <?php if (empty($pistes)): ?>
                <p class="message-vide">Aucune piste publiée pour le moment</p>
            <?php else: ?>
                <ul class="pistes-liste">
                    <?php foreach ($pistes as $piste): ?>
                        <?php
                        $initiale = mb_strtoupper(mb_substr((string) $piste['titre'], 0, 1, 'UTF-8'), 'UTF-8');
                        ?>
                        <li class="piste-row">
                            <div class="piste-cover">
                                <?= e($initiale !== '' ? $initiale : '♪') ?>
                            </div>

                            <div class="piste-infos">
                                <a class="piste-titre" href="index.php?module=piste&action=detail&id=<?= (int) $piste['id_piste'] ?>">
                                    <?= e((string) $piste['titre']) ?>
                                </a>
                                <div class="piste-sous-titre">
                                    <span><?= e((string) $piste['nombre_ecoutes']) ?> écoutes</span>
                                    <span>•</span>
                                    <span class="badge-genre"><?= e((string) $piste['date_publication']) ?></span>
                                </div>
                            </div>

                            <div class="piste-actions">
                                <a class="btn-ecouter" href="index.php?module=piste&action=detail&id=<?= (int) $piste['id_piste'] ?>">
                                    ▶ Écouter
                                </a>
                                <a class="btn-voir" href="index.php?module=piste&action=detail&id=<?= (int) $piste['id_piste'] ?>">
                                    Voir
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
        <?php
        $this->afficherPage('SoundWave - Accueil');
    }
}
