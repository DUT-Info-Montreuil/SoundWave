<?php

require_once __DIR__ . '/../Commun/Vue.php';
require_once __DIR__ . '/../Commun/Csrf.php';
require_once __DIR__ . '/../Commun/Xss.php';
require_once __DIR__ . '/../Commun/Utilitaires.php';

class PisteDetailVue extends Vue
{
    public function afficher(
        Piste $piste,
        array $auteurs,
        int $nbLikes,
        bool $estLikee,
        ?int $idUtilisateur
    ): void {
        $this->debutContenu();
        $idPiste = $piste->getIdPiste();
        $nomsAuteurs = array_map(static fn(array $a): string => (string) $a['nom'], $auteurs);
        $texteAuteurs = !empty($nomsAuteurs) ? implode(', ', $nomsAuteurs) : 'Artiste inconnu';
        ?>
        <div>
            <a href="index.php?module=piste&action=liste" class="btn-voir">← Retour aux pistes</a>
        </div>

        <section class="hero-banner detail-header">
            <div class="detail-header-main">
                <div class="detail-cover"><?= e(Utilitaires::initiale($piste->getTitre())) ?></div>
                <div>
                    <span class="hero-tag">Piste audio • Publiée le <?= e($piste->getDate_publication()) ?></span>
                    <h1><?= e($piste->getTitre()) ?></h1>
                    <p class="detail-auteurs">Par <strong><?= e($texteAuteurs) ?></strong></p>

                    <div class="detail-badges">
                        <?php foreach ($piste->getGenres() as $genre): ?>
                            <span class="badge-genre"><?= e((string) $genre['nom']) ?></span>
                        <?php endforeach; ?>
                        <?php foreach ($piste->getTags() as $tag): ?>
                            <span class="badge-tag">#<?= e((string) $tag['nom']) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="detail-card">

            <div class="detail-stats-actions">
                <div class="detail-stats">
                    <span>🎧 <strong><?= $piste->getNombre_ecoutes() ?></strong> écoutes</span>
                    <span>•</span>
                    <span>♥ <strong><?= $nbLikes ?></strong> J'aime</span>
                </div>

                <?php if ($idUtilisateur !== null): ?>
                    <div class="detail-actions-group">
                        <form method="post" action="index.php?module=piste&action=liker">
                            <input type="hidden" name="csrf" value="<?= e(Csrf::jeton()) ?>">
                            <input type="hidden" name="id_piste" value="<?= $idPiste ?>">
                            <button type="submit" class="<?= $estLikee ? 'btn-purple' : 'btn-voir' ?>">
                                <?= $estLikee ? '♥ Retirer J\'aime' : ' J\'aime' ?> (<?= $nbLikes ?>)
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <p class="detail-login-hint">
                        <a href="index.php?module=utilisateur&action=formulaireConnexion" class="piste-titre">Connectez-vous</a>
                        pour aimer cette piste.
                    </p>
                <?php endif; ?>
            </div>

            <div class="detail-description">
                <h3>Description de la piste</h3>
                <p>
                    <?= $piste->getDescription() !== null && trim($piste->getDescription()) !== ''
                        ? nl2br(e($piste->getDescription()))
                        : 'Aucune description fournie pour cette piste.' ?>
                </p>
            </div>
        </section>
        <?php
        $this->afficherPage('SoundWave - ' . $piste->getTitre(), ['piste' => $piste]);
    }
}
