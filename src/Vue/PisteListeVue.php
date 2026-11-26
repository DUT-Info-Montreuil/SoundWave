<?php

require_once __DIR__ . '/../Commun/Vue.php';

class PisteListeVue extends Vue
{
    public function afficher($pistes)
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
                    name="q"
                    class="filter-input"
                    placeholder="Rechercher : titre, artiste, groupe, tag, genre"
                    value="<?= e((string) ($_GET['q'] ?? '')) ?>"
            >

            <select name="genre" class="filter-select" aria-label="Genre">
                <option value disabled selected hidden>Genre ▾</option>
                <option value="Rap" <?= (($_GET['genre'] ?? '') === 'Rap') ? 'selected' : '' ?>>Rap</option>
                <option value="Electro" <?= (($_GET['genre'] ?? '') === 'Electro') ? 'selected' : '' ?>>Electro</option>
                <option value="Pop" <?= (($_GET['genre'] ?? '') === 'Pop') ? 'selected' : '' ?>>Pop</option>
                <option value="Rock" <?= (($_GET['genre'] ?? '') === 'Rock') ? 'selected' : '' ?>>Rock</option>
            </select>

            <select name="tag" class="filter-select" aria-label="Tag">
                <option value disabled selected hidden>Tag ▾</option>
                <option value="chill" <?= (($_GET['tag'] ?? '') === 'chill') ? 'selected' : '' ?>>#chill</option>
                <option value="remix" <?= (($_GET['tag'] ?? '') === 'remix') ? 'selected' : '' ?>>#remix</option>
                <option value="instru" <?= (($_GET['tag'] ?? '') === 'instru') ? 'selected' : '' ?>>#instru</option>
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
                                    <span>- Nombre d'écoutes : <?= e((string) $piste['nombre_ecoutes']) ?></span>
                                    <span>•</span>
                                    <span class="badge-genre">- Date : <?= e((string) $piste['date_publication']) ?></span>
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
