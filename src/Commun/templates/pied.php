<?php
require_once __DIR__ . '/../Utilitaires.php';
$piste = $contexte['piste'] ?? null
?>
<footer class="player-bar">
    <div class="player-now">
        <span class="player-thumb">
            <?php if (isset($piste)) : ?>
                <?= e(Utilitaires::initiale($piste->getTitre())) ?>
            <?php else : ?>
                <?= '♪' ?>
            <?php endif ?>
        </span>
            <?php if (!isset($piste)): ?>
                <div>
                    <div class="player-track-name">SoundWave Player</div>
                    <div>Sélectionnez une piste à écouter</div>
                </div>
            <?php endif ?>
    </div>

    <?php if (isset($piste)) : ?>
        <div class="player-controls">
            <div class="player-buttons">
                <span>⏮</span>
                <button class="player-play-btn" id="playbutton" onclick="playbutton()">▶</button>
                <span>⏭</span>
            </div>
            <div class="player-progress">
                <span id="progression">0:00</span>
                <div class="progress-track"><div class="progress-fill" id="progress-fill"></div></div>
                <span id="max-duration">0:00</span>
            </div>
            <audio id="player" src="../data/pistes/<?= e($piste->getFichier_audio()) ?>"></audio>
        </div>
    <?php endif; ?>
</footer>
<script src="js/lecteur.js"></script>
