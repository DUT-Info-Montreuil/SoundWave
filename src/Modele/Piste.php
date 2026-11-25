<?php

class Piste{
	private int $id_piste;
	private string $titre;
	private ?string $description;
	private string $fichier_audio;
	private int $nombre_ecoutes;
	private string $date_publication;
    private array $genres;
    private array $tags;

	public function __construct(int $id_piste, string $titre, ?string $description,
                                int $fichier_audio, int $nombre_ecoutes, string $date_publication,
                                array $genres, array $tags) {
		$this->id_piste = $id_piste;
		$this->titre = $titre;
		$this->description = $description;
		$this->fichier_audio = $fichier_audio;
		$this->nombre_ecoutes = $nombre_ecoutes;
		$this->date_publication = $date_publication;
        $this->genres = $genres;
        $this->tags = $tags;
	}

	public static function origin(array $pisteArray): self {
        return new self($pisteArray["id"], $pisteArray["titre"], $pisteArray["description"],
            $pisteArray["fichier_audio"], $pisteArray["nombre_ecoutes"], $pisteArray["date_publication"],
            $pisteArray["genres"], $pisteArray["tags"]);
    }

	public function getId_piste(): int {
		return $this->id_piste;
	}

	public function getTitre(): string {
		return $this->titre;
	}

	public function getDescription(): ?string {
		return $this->description;
	}

	public function getFichier_audio(): string {
		return $this->fichier_audio;
	}

	public function getNombre_ecoutes(): int {
		return $this->nombre_ecoutes;
	}

	public function getDate_publication(): string {
		return $this->date_publication;
	}

    public function getGenres(): array {
        return $this->genres;
    }

    public function getTags(): array {
        return $this->tags;
    }

}