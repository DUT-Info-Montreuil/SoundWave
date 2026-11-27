<?php if (isset($contexte['fichier'])) : ?>
    <script src="js/lecteur.js"></script>
    <footer class="player-bar">
        <div class="player-now">
            <span class="player-thumb">♫</span>
            <div>
                <div class="player-track-name">SoundWave Player</div>
                <div>Sélectionnez une piste à écouter</div>
            </div>
        </div>

        <div class="player-controls">
            <div class="player-buttons">
                <span>⏮</span>
                <button class="player-play-btn" id="playbutton" onclick="playbutton()">▶</button>
                <span>⏭</span>
            </div>
            <div class="player-progress">
                <span>0:00</span>
                <div class="progress-track"><div class="progress-fill"></div></div>
                <span>3:00</span>
            </div>
            <audio id="player" controls src="../data/pistes/<?= e($contexte['fichier']) ?>" hidden="hidden"></audio>

        </div>
    </footer>
<?php endif; ?>
