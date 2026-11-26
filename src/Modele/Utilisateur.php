<?php

class Utilisateur{
	private int $id_membre;
	private string $nom;
	private string $email;
	private string $mot_de_passe;
	private string $role;

	public function __construct(int $id_membre, string $nom, string $email, string $mot_de_passe, string $role)
    {
        $this->id_membre = $id_membre;
        $this->nom = $nom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->role = $role;
    }

    public function getId_membre(): int{
        return $this->id_membre;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getMot_de_passe(): string{
        return $this->mot_de_passe;
    }

    public function getRole(): string{
        return $this->role;
    }

    public static function origin(array $utilisateurArray): self{
        return new self(
            (int) $utilisateurArray['id_membre'],
            $utilisateurArray['nom'],
            $utilisateurArray['email'],
            $utilisateurArray['mot_de_passe'],
            $utilisateurArray['role']
        );
    }
}

?>