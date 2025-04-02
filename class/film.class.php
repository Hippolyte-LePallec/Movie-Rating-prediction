<?php
class Film {
    private $db;
    private $data = [];


    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getData($key) {
        return $this->data[$key] ?? null;
    }

    public function fetchAll($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("
            SELECT m.*, 
                   string_agg(g.genre_name, ', ') AS genre_names
            FROM media m
            LEFT JOIN media_genre mg ON m.media_id = mg.media_id
            LEFT JOIN genre g ON mg.genre_id = g.genre_id
            GROUP BY m.media_id
            LIMIT :perPage OFFSET :offset
        ");
        
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    

    public function getTotalCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM media");
        return $stmt->fetchColumn();
    }
    
}
?>
