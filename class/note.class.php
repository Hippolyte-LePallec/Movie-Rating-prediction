<?php
class note {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Récupérer une note par son ID
    public function getRatingById($rating_id) {
        $stmt = $this->db->prepare("SELECT * FROM rating WHERE rating_id = :rating_id");
        $stmt->bindParam(':rating_id', $rating_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Récupérer les notes pour un film donné
    public function getRatingsByMediaId($media_id) {
        $stmt = $this->db->prepare("SELECT * FROM rating WHERE media_id = :media_id");
        $stmt->bindParam(':media_id', $media_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une nouvelle note
    public function addRating($media_id, $averageRating, $numVotes) {
        $stmt = $this->db->prepare("
            INSERT INTO rating (media_id, averageRating, numVotes)
            VALUES (:media_id, :averageRating, :numVotes)
        ");
        $stmt->bindParam(':media_id', $media_id, PDO::PARAM_STR);
        $stmt->bindParam(':averageRating', $averageRating, PDO::PARAM_STR);
        $stmt->bindParam(':numVotes', $numVotes, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Erreur lors de l'insertion de la note : " . $errorInfo[2]);
        }
    }

    // Mettre à jour une note existante
    public function updateRating($rating_id, $averageRating, $numVotes) {
        $stmt = $this->db->prepare("
            UPDATE rating
            SET averageRating = :averageRating, numVotes = :numVotes
            WHERE rating_id = :rating_id
        ");
        $stmt->bindParam(':rating_id', $rating_id, PDO::PARAM_INT);
        $stmt->bindParam(':averageRating', $averageRating, PDO::PARAM_STR);
        $stmt->bindParam(':numVotes', $numVotes, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Erreur lors de la mise à jour de la note : " . $errorInfo[2]);
        }
    }

    // Supprimer une note
    public function deleteRating($rating_id) {
        $stmt = $this->db->prepare("DELETE FROM rating WHERE rating_id = :rating_id");
        $stmt->bindParam(':rating_id', $rating_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Erreur lors de la suppression de la note : " . $errorInfo[2]);
        }
    }

    // Calculer la moyenne des notes pour un film donné
    public function calculateAverageRating($media_id) {
        $stmt = $this->db->prepare("
            SELECT AVG(averageRating) AS avgRating, SUM(numVotes) AS totalVotes
            FROM rating
            WHERE media_id = :media_id
        ");
        $stmt->bindParam(':media_id', $media_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>