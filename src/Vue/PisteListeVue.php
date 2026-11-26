<?php

require_once __DIR__ . '/../Commun/Vue.php'; 

class PisteListeVue extends Vue
{
    public function afficher($pistes)
    {
        $this->debutContenu(); 
        ?>
        <h1>Découvrir de nouveaux sons</h1>
        <h2>Dernières pistes publiées</h2>
        <?php if (empty($pistes)): ?>
            <p>Aucune piste publiée pour le moment</p>
        <?php else: ?>
            <ul>
                <?php foreach ($pistes as $piste): ?>
                    <li>
                        <strong><?= e((string) $piste['titre']) ?></strong>
                        - Nombre d'écoutes : <?= e((string) $piste['nombre_ecoutes']) ?>
                        - Date : <?= e((string) $piste['date_publication']) ?>

                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php
        $this->afficherPage('SoundWave - Accueil');
    }
}


