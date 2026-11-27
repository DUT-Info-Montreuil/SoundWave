<?php if (isset($contexte['fichier'])) : ?>
    <footer class="player-bar">
        <div class="player-now">
            <!--<span class="player-thumb">♫</span>
            <div>
                <div class="player-track-name">SoundWave Player</div>
                <div>Sélectionnez une piste à écouter</div>
            </div>-->
        </div>

        <div class="player-controls">
            <div class="player-buttons">
                <span>⏮</span>
                <button class="player-play-btn" id="playbutton" onclick="playbutton()">▶</button>
                <span>⏭</span>
            </div>
            <div class="player-progress">
                <span id="progression">0:00</span>
                <div class="progress-track"><div class="progress-fill"></div></div>
                <span id="max-duration">0:00</span>
            </div>
            <audio id="player" src="../data/pistes/<?= e($contexte['fichier']) ?>"></audio>
        </div>
    </footer>
    <script src="js/lecteur.js"></script>
<?php endif; ?>
