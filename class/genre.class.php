<?php
class Genre {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Ajouter un genre
    public function create(string $genre_name): bool {
        $sql = "INSERT INTO genre (genre_name) VALUES (:genre_name) RETURNING genre_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':genre_name' => $genre_name]);
    }

    // Récupérer un genre par son ID
    public function fetch(int $genre_id): ?array {
        $sql = "SELECT * FROM genre WHERE genre_id = :genre_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':genre_id' => $genre_id]);
        $genre = $stmt->fetch(PDO::FETCH_ASSOC);
        return $genre ?: null;
    }

    // Mettre à jour un genre
    public function update(int $genre_id, string $genre_name): bool {
        $sql = "UPDATE genre SET genre_name = :genre_name WHERE genre_id = :genre_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':genre_id' => $genre_id,
            ':genre_name' => $genre_name
        ]);
    }

    // Supprimer un genre
    public function delete(int $genre_id): bool {
        $sql = "DELETE FROM genre WHERE genre_id = :genre_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':genre_id' => $genre_id]);
    }

    // Récupérer tous les genres
    public function fetchAll(): array {
        $sql = "SELECT * FROM genre";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}