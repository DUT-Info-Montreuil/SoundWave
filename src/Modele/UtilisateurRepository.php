<?php
require_once __DIR__ . '/../Commun/BDD.php';
require_once __DIR__ . '/Utilisateur.php';

class UtilisateurRepository extends BDD {

    public function __construct() {
        parent::__construct();
    }

    public function findById(int $id):?Utilisateur {
        
		$requete = self::$pdo->prepare("SELECT * FROM membre WHERE id=?");
		$requete->execute([$id]);
		$users = $requete->fetch(PDO::FETCH_ASSOC);

		return $users === false ? null : Utilisateur::origin($users);
    }
    
    public function findByEmail(string $email):?Utilisateur {

        $requete = self::$pdo->prepare("SELECT * FROM membre WHERE email=?");
        $requete->execute([$email]);
        $user = $requete->fetch(PDO::FETCH_ASSOC);

        return $user === false ? null : Utilisateur::origin($userTrouves);
    }

    public function inscrire(Utilisateur $utilisateur):int {
        if ($this->findByEmail($utilisateur->getEmail()) !== null) {
            die("L'utilisateur existe déjà");
        }

        if (strlen($utilisateur->getMdp()) < 4) {
            die("Le mot de passe doit contenir au moins 4 caractères");
        }

        $requete = self::$pdo->prepare(
            "INSERT INTO membre (nom, email, mot_de_passe_hash, role) VALUES (?, ?, ?, ?)"
        );
        $requete->execute([
            $utilisateur->getNom(),
            $utilisateur->getEmail(),
            password_hash($utilisateur->getMdp(), PASSWORD_DEFAULT),
            'membre'
        ]);

        return (int) self::$pdo->lastInsertId();
    }

    public function changerRole(int $id, string $role): bool {
        $requete = self::$pdo->prepare("UPDATE membre SET role = :role WHERE id = :id");
        return $requete->execute([
            ':role' => $role,
            ':id' => $id,
        ]) && $requete->rowCount() === 1;
    }
}

?>