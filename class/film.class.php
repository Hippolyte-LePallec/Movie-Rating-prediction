<?php
class Film {
    private $db;
    private $data = [];

    // Constructeur
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Get des données du film (non statique)
    public function getData($key) {
        return $this->data[$key] ?? null;
    }

    // Récupère tous les films (non statique)
    public function fetchAll($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
    
        // Ajouter une condition LIMIT avec l'offset pour la pagination
        $stmt = $this->db->prepare("SELECT * FROM media LIMIT :perPage OFFSET :offset");
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>
