<?php
class Maker {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Récupère tous les genres depuis la base de données
     */
    public function getGenres() {
        // Correction: utilisation des noms de colonnes qui existent réellement dans la table
        $query = "SELECT genre_id as id, genre_name as name FROM genre ORDER BY genre_name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupère tous les directeurs depuis la base de données
     */
    public function getDirectors() {
        $query = "SELECT p.perso_id as id, p.\"primaryName\" as name
                 FROM Personne p
                 INNER JOIN crew_directeurs cd ON p.perso_id = cd.directeur_id
                 ORDER BY p.\"primaryName\" ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupère tous les scénaristes depuis la base de données
     */
    public function getWriters() {
        $query = "SELECT p.perso_id as id, p.\"primaryName\" as name
                 FROM Personne p
                 INNER JOIN crew_scenaristes cs ON p.perso_id = cs.scenariste_id
                 ORDER BY p.\"primaryName\" ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupère tous les acteurs depuis la base de données
     */
    public function getActors() {
        $query = "SELECT DISTINCT p.perso_id as id, p.\"primaryName\" as name
                 FROM Personne p
                 INNER JOIN principal pr ON p.perso_id = pr.perso_id
                 INNER JOIN categorie c ON pr.id_categorie = c.categorie_id
                 WHERE c.nom_categorie IN ('actor', 'actress')
                 ORDER BY p.\"primaryName\" ASC";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Pour le développement, on peut logger l'erreur
            error_log("Erreur dans getActors: " . $e->getMessage());
            // En production, retourner un tableau vide est plus sûr
            return [];
        }
    }
    
    /**
     * Récupère une personne par son ID
     */
    public function getPersonById($id) {
        $query = "SELECT perso_id as id, \"primaryName\" as name FROM Personne WHERE perso_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Ajoute une nouvelle personne dans la base de données
     */
    public function addPerson($name) {
        $id = uniqid('nm'); // Génère un ID unique au format 'nmXXXXXXXXXXXXX'
        $query = "INSERT INTO Personne (perso_id, \"primaryName\") VALUES (:id, :name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $id;
    }
    
    /**
     * Ajoute un nouveau média dans la base de données
     */
    public function addMedia($data) {
        try {
            $this->db->beginTransaction();
            
            // Insertion dans la table média
            $mediaId = uniqid('tt'); // Génère un ID unique au format 'ttXXXXXXXXXXXXX'
            
            $query = "INSERT INTO media (media_id, \"primaryTitle\", \"startYear\", \"runtimeMinutes\", \"isAdult\", \"post\", \"media_URL\") 
                     VALUES (:id, :title, :year, :runtime, :adult, :post, :url)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $mediaId, PDO::PARAM_STR);
            $stmt->bindParam(':title', $data['primaryTitle'], PDO::PARAM_STR);
            $stmt->bindParam(':year', $data['startYear'], PDO::PARAM_INT);
            $stmt->bindParam(':runtime', $data['runtimeMinutes'], PDO::PARAM_INT);
            $stmt->bindParam(':adult', $data['isAdult'], PDO::PARAM_BOOL);
            $stmt->bindParam(':post', $data['post'], PDO::PARAM_STR);
            $stmt->bindParam(':url', $data['media_URL'], PDO::PARAM_STR);
            $stmt->execute();
            
            // Insertion des genres
            if (!empty($data['genre'])) {
                $query = "INSERT INTO media_genre (media_id, genre_id) VALUES (:media_id, :genre_id)";
                $stmt = $this->db->prepare($query);
                
                foreach ($data['genre'] as $genreId) {
                    $stmt->bindParam(':media_id', $mediaId, PDO::PARAM_STR);
                    $stmt->bindParam(':genre_id', $genreId, PDO::PARAM_STR);
                    $stmt->execute();
                }
            }
            
            // Traitement des réalisateurs
            $this->processDirectors($mediaId, $data);
            
            // Traitement des scénaristes
            $this->processWriters($mediaId, $data);
            
            // Traitement des acteurs
            $this->processActors($mediaId, $data);
            
            $this->db->commit();
            return $mediaId;
            
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Erreur dans addMedia: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Traite les réalisateurs pour un média
     */
    private function processDirectors($mediaId, $data) {
        if (empty($data['directeur_existant'])) return;
        
        $query = "INSERT INTO crew_directeurs (media_id, directeur_id) VALUES (:media_id, :directeur_id)";
        $stmt = $this->db->prepare($query);
        
        for ($i = 0; $i < count($data['directeur_existant']); $i++) {
            $directorId = $data['directeur_existant'][$i];
            
            // Si c'est un nouveau réalisateur
            if ($directorId === 'new' && !empty($data['directeur_nom'][$i])) {
                $directorId = $this->addPerson($data['directeur_nom'][$i]);
            }
            
            if (!empty($directorId) && $directorId !== 'new') {
                $stmt->bindParam(':media_id', $mediaId, PDO::PARAM_STR);
                $stmt->bindParam(':directeur_id', $directorId, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }
    
    /**
     * Traite les scénaristes pour un média
     */
    private function processWriters($mediaId, $data) {
        if (empty($data['scenariste_existant'])) return;
        
        $query = "INSERT INTO crew_scenaristes (media_id, scenariste_id) VALUES (:media_id, :scenariste_id)";
        $stmt = $this->db->prepare($query);
        
        for ($i = 0; $i < count($data['scenariste_existant']); $i++) {
            $writerId = $data['scenariste_existant'][$i];
            
            // Si c'est un nouveau scénariste
            if ($writerId === 'new' && !empty($data['scenariste_nom'][$i])) {
                $writerId = $this->addPerson($data['scenariste_nom'][$i]);
            }
            
            if (!empty($writerId) && $writerId !== 'new') {
                $stmt->bindParam(':media_id', $mediaId, PDO::PARAM_STR);
                $stmt->bindParam(':scenariste_id', $writerId, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }
    
    /**
     * Traite les acteurs pour un média
     */
    private function processActors($mediaId, $data) {
        if (empty($data['acteur_existant'])) return;
        
        // Obtenir l'ID de la catégorie
        $categoryQuery = "SELECT categorie_id FROM categorie WHERE nom_categorie = :nom";
        $categoryStmt = $this->db->prepare($categoryQuery);
        
        $principalQuery = "INSERT INTO principal (media_id, perso_id, id_categorie, ordering, \"characters\", \"job\") 
                          VALUES (:media_id, :perso_id, :categorie_id, :ordering, :characters, :job)";
        $principalStmt = $this->db->prepare($principalQuery);
        
        for ($i = 0; $i < count($data['acteur_existant']); $i++) {
            $actorId = $data['acteur_existant'][$i];
            
            // Si c'est un nouvel acteur
            if ($actorId === 'new' && !empty($data['acteur_nom'][$i])) {
                $actorId = $this->addPerson($data['acteur_nom'][$i]);
            }
            
            if (!empty($actorId) && $actorId !== 'new') {
                // Obtenir l'ID de la catégorie
                $categoryStmt->bindParam(':nom', $data['acteur_categorie'][$i], PDO::PARAM_STR);
                $categoryStmt->execute();
                $categoryId = $categoryStmt->fetchColumn();
                
                // Préparer les données pour characters (format JSON)
                $characters = !empty($data['acteur_personnage'][$i]) ? json_encode([$data['acteur_personnage'][$i]]) : null;
                
                $principalStmt->bindParam(':media_id', $mediaId, PDO::PARAM_STR);
                $principalStmt->bindParam(':perso_id', $actorId, PDO::PARAM_STR);
                $principalStmt->bindParam(':categorie_id', $categoryId, PDO::PARAM_STR);
                $principalStmt->bindParam(':ordering', $data['acteur_ordre'][$i], PDO::PARAM_INT);
                $principalStmt->bindParam(':characters', $characters, PDO::PARAM_STR);
                $principalStmt->bindParam(':job', $data['acteur_job'][$i], PDO::PARAM_STR);
                $principalStmt->execute();
            }
        }
    }

    /**
     * Recherche des directeurs par terme
     */
    public function searchDirectors($term) {
        $sql = "SELECT id, name FROM directors 
                WHERE LOWER(name) LIKE LOWER(:term) 
                ORDER BY name ASC LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['term' => "%$term%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche des scénaristes par terme
     */
    public function searchWriters($term) {
        $sql = "SELECT id, name FROM writers 
                WHERE LOWER(name) LIKE LOWER(:term) 
                ORDER BY name ASC LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['term' => "%$term%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche des acteurs par terme
     */
    public function searchActors($term) {
        $sql = "SELECT id, name FROM actors 
                WHERE LOWER(name) LIKE LOWER(:term) 
                ORDER BY name ASC LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['term' => "%$term%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}