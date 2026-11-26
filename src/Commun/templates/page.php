<?php
	require_once __DIR__ . '/../Template.php';
	require_once __DIR__ . '/../Xss.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titre) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="global-topbar">
    <div class="topbar-brand">
        <a href="index.php?module=piste&action=liste" class="logo">
            <span class="logo-badge">♫</span>
            <span>Sound<span>Wave</span></span>
        </a>
    </div>

    <div class="topbar-center">
        <a href="index.php?module=piste&action=liste" class="btn-home-round" title="Accueil">⌂</a>
        <form class="global-search-form" method="get" action="index.php">
            <input type="hidden" name="module" value="piste">
            <input type="hidden" name="action" value="liste">
            <span class="search-icon">🔍</span>
            <input
                    type="text"
                    name="s"
                    class="global-search-input"
                    placeholder="Que souhaitez-vous écouter ? Titre, artiste, groupe, tag, genre..."
                    value="<?= e((string) ($_GET['s'] ?? '')) ?>"
            >
        </form>
    </div>

    <?php if(isset($_SESSION['id_utilisateur'])): ?>
    <div class="topbar-auth">
        <a href="index.php?module=utilisateur&action=formulaireInscription" class="btn-ghost">Inscription</a>
        <a href="index.php?module=utilisateur&action=formulaireConnexion" class="btn-purple">Connexion</a>
    </div>
    <?php endif; ?>
</header>

<div class="app-shell">
    <?php require __DIR__ . '/entete.php'; ?>

    <main class="main-panel">
        <?= $contenu ?>
    </main>
</div>

<?php require __DIR__ . '/pied.php'; ?>
</body>
</html>