<?php
require_once __DIR__ . '/../Commun/Xss.php';
require_once __DIR__ . '/../Commun/Csrf.php';
require_once __DIR__ . '/../Commun/Vue.php';

class UtilisateurVue extends Vue{

	public function formulaireInscription(): void {
		$this->debutContenu();
		?>
        <section class="section-forms">
            <form method="post" enctype="multipart/form-data" action="index.php?module=visiteur&action=inscrire" class="form-inscription">
                <input type="hidden" name="csrf" value="<?= e(Csrf::jeton()) ?>">
                <div class="div-nom">
                    <label for="nom">Nom : </label>
                    <input type="text" name="nom" required>
                </div>
                <div class="div-email">
                    <label for="email">Email : </label>
                    <input type="email" name="email" required>
                </div>
                <div class="div-mdp">
                    <label for="mot_de_passe">Mot de passe : </label>
                    <input type="password" name="mot_de_passe" required>
                </div>
                <div class="div-submit">
                    <button type="submit" class="btn-purple">S'inscrire</button>
                </div>
            </form>
        </section>
		<?php
		$this->afficherPage('Inscription');
	}

	public function formulaireConnexion(): void {
		$this->debutContenu();
		?>
        <section class="section-forms">
            <form method="post" enctype="multipart/form-data" action="index.php?module=visiteur&action=connecter" class="form-connexion">
                <input type="hidden" name="csrf" value="<?= e(Csrf::jeton()) ?>">
                <div class="div-email">
                    <label for="email">Email : </label>
                    <input type="email" name="email" required>
                </div>
                <div class="div-mpd">
                    <label for="mot_de_passe">Mot de passe : </label>
                    <input type="password" name="mot_de_passe" required>
                </div>
                <div class="div-submit">
                    <button type="submit" class="btn-purple">Se connecter</button>
                </div>
            </form>
		</section>
		<?php
		$this->afficherPage('Connexion');
	}

    public function validationDeconnexion():void {
        $this->debutContenu();
        ?>
        <section class="section-forms">
            <form method="post" enctype="multipart/form-data" action="index.php?module=visiteur&action=deconnecter" class="form-deconnexion">
                <div class="div-submit">
                    <input type="hidden" name="csrf" value="<?= e(Csrf::jeton()) ?>">
                    <button type="submit" class="btn-deconnexion">Se Déconnecter</button>
                </div>
            </form>
            <a href="index.php?module=piste&action=liste" class="btn-ghost">Rester connecté</a>
        </section>
        <?php
        $this->afficherPage('Deconnexion');
    }
}

?>