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
            SELECT
                m.*,
                string_agg(g.genre_name, ', ') AS genre_names,
                r.\"averageRating\",
                r.\"numVotes\"
            FROM media m
            LEFT JOIN media_genre mg ON m.media_id = mg.media_id
            LEFT JOIN genre g ON mg.genre_id = g.genre_id
            LEFT JOIN rating r ON m.media_id = r.media_id
            GROUP BY m.media_id, r.\"averageRating\", r.\"numVotes\"
            ORDER BY m.\"primaryTitle\" ASC
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


    public function addPosterUrl($media_id, $url_image) {

        $stmt = $this->db->prepare("SELECT ajouter_url_media(:media_id, :url_image)");

        $stmt->bindParam(':media_id', $media_id,PDO::PARAM_STR);   
        $stmt->bindParam(':url_image', $url_image,PDO::PARAM_STR); 

        if (!$stmt->execute()) {

            $errorInfo = $stmt->errorInfo();
            throw new Exception("Erreur lors de l'exécution de la procédure : " . $errorInfo[2]);
        }
    }

    public function addPlot($media_id,$plot){
        $stmt = $this->db->prepare("SELECT ajouter_plot_media(:media_id, :plot)");
  
        $stmt->bindParam(':media_id', $media_id,PDO::PARAM_STR);   
        $stmt->bindParam(':plot', $plot,PDO::PARAM_STR); 

        if (!$stmt->execute()) {

            $errorInfo = $stmt->errorInfo();
            throw new Exception("Erreur lors de l'exécution de la procédure : " . $errorInfo[2]);
        }
    }

    public function getFilmById($media_id) {
        $stmt = $this->db->prepare("SELECT m.*, string_agg(g.genre_name, ', ') AS genre_names 
                                    FROM media AS m 
                                    LEFT JOIN media_genre AS mg ON m.media_id = mg.media_id 
                                    LEFT JOIN genre AS g ON mg.genre_id = g.genre_id 
                                    LEFT JOIN rating r ON m.media_id = r.media_id
                                    WHERE m.media_id = :media_id 
                                    GROUP BY m.media_id");
    
        $stmt->bindParam(':media_id', $media_id, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getPosterAndPlot($id) {
        
        $apiKeys = ['6d08fedf', '51ca03d6', '12a20dd5'];
        foreach ($apiKeys as $apiKey) {
            $url = "http://www.omdbapi.com/?i=" . urlencode($id) . "&apikey=" . $apiKey . "&r=json&plot=full";
            $response = file_get_contents($url);
    
            if ($response !== false) {
                $data = json_decode($response, true);
                
                // Vérifier si la réponse est correcte ou si la limite de requêtes est atteinte
                if (isset($data['Response']) && $data['Response'] === 'False' && strpos($data['Error'], 'limit') !== false) {
                    continue; // Passer à la clé suivante
                }
    
                $posterUrl = isset($data['Poster']) && $data['Poster'] != 'N/A' ? $data['Poster'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg';
                $plot = isset($data['Plot']) && $data['Plot'] != 'N/A' ? $data['Plot'] : 'Plot not available';
                
                return ['posterUrl' => $posterUrl, 'plot' => $plot];
            }
        }
        // Si toutes les clés échouent
        return ['posterUrl' => 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg', 'plot' => 'Plot not available'];
    }

    public function getTopRatedFilms() {
        // Appel à la procédure stockée pour récupérer les films les mieux notés
        $stmt = $this->db->prepare("SELECT * FROM get_top_10_movies_by_vote_ratio()");
        $stmt->execute();
        $topRatedFilms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les films récupérés
        return $topRatedFilms;
    }

    public function getWorstRatedFilms() {
        $stmt = $this->db->prepare("
            SELECT m.\"media_id\", r.\"averageRating\", r.\"numVotes\"
            FROM rating r
            JOIN media m ON r.media_id = m.media_id
            WHERE r.\"averageRating\" <= 4
            AND r.\"numVotes\" > 50000
            ORDER BY r.\"averageRating\" ASC, r.\"numVotes\" DESC
            LIMIT 10;
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
