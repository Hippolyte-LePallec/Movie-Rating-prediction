<?php
class Personne {
    private PDO $db;
    private string $perso_id;
    private ?string $primaryName;
    private ?string $birthYear;
    private ?string $deathYear;
    private ?string $primaryProfession;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Création d'une personne
    public function create(string $perso_id, string $primaryName, ?string $birthYear, ?string $deathYear, ?string $primaryProfession): bool {
        $sql = "INSERT INTO personne (perso_id, primaryName, birthYear, deathYear, primaryProfession) 
                VALUES (:perso_id, :primaryName, :birthYear, :deathYear, :primaryProfession)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':perso_id' => $perso_id,
            ':primaryName' => $primaryName,
            ':birthYear' => $birthYear,
            ':deathYear' => $deathYear,
            ':primaryProfession' => $primaryProfession
        ]);
    }

    // Lire une personne par son ID
    public function fetch(string $perso_id): ?array {
        $sql = "SELECT * FROM personne WHERE perso_id = :perso_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':perso_id' => $perso_id]);
        $personne = $stmt->fetch(PDO::FETCH_ASSOC);
        return $personne ?: null;
    }

    // Mettre à jour une personne
    public function update(string $perso_id, ?string $primaryName, ?string $birthYear, ?string $deathYear, ?string $primaryProfession): bool {
        $sql = "UPDATE personne SET 
                    primaryName = :primaryName, 
                    birthYear = :birthYear, 
                    deathYear = :deathYear, 
                    primaryProfession = :primaryProfession
                WHERE perso_id = :perso_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':perso_id' => $perso_id,
            ':primaryName' => $primaryName,
            ':birthYear' => $birthYear,
            ':deathYear' => $deathYear,
            ':primaryProfession' => $primaryProfession
        ]);
    }

    // Supprimer une personne
    public function delete(string $perso_id): bool {
        $sql = "DELETE FROM personne WHERE perso_id = :perso_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':perso_id' => $perso_id]);
    }

    // Récupérer toutes les personnes
    public function fetchAll(): array {
        $sql = "SELECT * FROM personne";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recherche des acteurs
    public function searchPersons($term) {
        $stmt = $this->db->prepare("SELECT perso_id, \"primaryName\" FROM personne WHERE \"primaryName\" LIKE :term LIMIT 10");
        $stmt->execute(['term' => '%' . $term . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}