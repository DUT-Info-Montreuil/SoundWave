<?php

class Utilisateur{
	private int $id;
	private string $nom;
	private string $email;
	private string $mdp;
	private string $role;

	public function __construct(int $id, string $nom, string $email, string $mdp, string $role)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->role = $role;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getMdp(): string{
        return $this->mdp;
    }

    public function getRole(): string{
        return $this->role;
    }

    public static function origin(array $utilisateurArray): self{
        return new self(
            (int) $utilisateurArray['id'],
            $utilisateurArray['nom'],
            $utilisateurArray['email'],
            $utilisateurArray['mot_de_passe_hash'],
            $utilisateurArray['role']
        );
    }
}