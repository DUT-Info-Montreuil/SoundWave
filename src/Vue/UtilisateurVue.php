<?php
require_once __DIR__ . '/../Commun/Xss.php';
require_once __DIR__ . '/../Commun/Csrf.php';
require_once __DIR__ . '/../Commun/Vue.php';

class UtilisateurVue extends Vue{

	public function formulaireInscription(): void {
		$this->debutContenu();
		?>

		<form method="post" enctype="multipart/form-data" action="index.php?module=visiteur&action=inscrire">
			<input type="hidden" name="csrf" value="<?= e(Csrf::jeton()) ?>">
			<div>
				<label for="nom">Nom : </label>
				<input type="text" name="nom" required>
			</div>
			<div>
				<label for="email">Email : </label>
				<input type="email" name="email" required>
			</div>
			<div>
				<label for="mot_de_passe">Mot de passe : </label>
				<input type="password" name="mot_de_passe" required>
			</div>
			<button type="submit">S'inscrire</button>
		</form>
		<?php
		$this->afficherPage('Inscription');
	}

	public function formulaireConnexion(): void {
		$this->debutContenu();
		?>

		<form method="post" enctype="multipart/form-data" action="index.php?module=visiteur&action=connecter">
			<input type="hidden" name="csrf" value="<?= e(Csrf::jeton()) ?>">
			<div>
				<label for="email">Email : </label>
				<input type="email" name="email" required>
			</div>
			<div>
				<label for="mot_de_passe">Mot de passe : </label>
				<input type="password" name="mot_de_passe" required>
			</div>
			<button type="submit">Se connecter</button>
		</form>
		<?php
		$this->afficherPage('Connexion');
	}
}

?>