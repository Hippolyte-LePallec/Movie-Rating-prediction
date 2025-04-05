<?php
class User {
    private $pdo;
    private $rowid;

    // Constructeur pour initialiser la connexion à la base de données et l'identifiant utilisateur
    public function __construct($pdo, $rowid=1) {
        $this->pdo = $pdo;
        $this->rowid = $rowid;
    }

    public function createUser($username, $password, $firstname, $lastname, $admin = 0) {
        try {
            // Vérifier si le nom d'utilisateur existe déjà
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM mp_users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            if ($stmt->fetchColumn() > 0) {
                return "Le nom d'utilisateur existe déjà.";
            }

            // Hacher le mot de passe avec bcrypt
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insérer l'utilisateur dans la base de données
            $stmt = $this->pdo->prepare(
                "INSERT INTO mp_users (username, password, firstname, lastname, admin) 
                 VALUES (:username, :password, :firstname, :lastname, :admin)"
            );
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':admin' => $admin,
            ]);

            return "Utilisateur créé avec succès.";
        } catch (PDOException $e) {
            return "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
        }
    }

    public function getUser($username) {
        try {
            // Préparation de la requête pour récupérer l'utilisateur
            $stmt = $this->pdo->prepare(
                "SELECT * 
                 FROM mp_users 
                 WHERE username = :username"
            );
            $stmt->execute([':username' => $username]);
    
            // Récupérer l'utilisateur en tant que tableau associatif
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Vérifier si l'utilisateur existe
            if ($user) {
                return $user;
            } else {
                return "Utilisateur non trouvé.";
            }
        } catch (PDOException $e) {
            return "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
        }
    }

    

    // Fonction pour récupérer les films créés par l'utilisateur
    public function getCreatedFilms() {
        // Requête pour récupérer les films associés à l'utilisateur via la table media_user
        $stmt = $this->pdo->prepare(
            "SELECT mu.media_id 
            FROM media_user mu
            WHERE mu.rowid = :rowid"
        );
        $stmt->execute([':rowid' => $this->rowid]);

        // Retourner tous les films trouvés sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFilm($primaryTitle, $isAdult, $startYear, $runtimeMinutes, $imageUrl, $plot, $genres, $id_directeurs, $id_writers, $id_actors) {
        // Démarrer une transaction
        $this->pdo->beginTransaction();
    
        try {
            // Ajouter le film et la relation dans media_genre
            $query = "SELECT ajout_media(
                :primaryTitle, 
                :isAdult, 
                :startYear, 
                :runtimeMinutes, 
                :imageUrl, 
                :plot, 
                :genres
            ) AS media_id";
    
            $stmt = $this->pdo->prepare($query);
    
            $stmt->bindParam(':primaryTitle', $primaryTitle, PDO::PARAM_STR);
            $stmt->bindParam(':isAdult', $isAdult, PDO::PARAM_INT);
            $stmt->bindParam(':startYear', $startYear, PDO::PARAM_INT);
            $stmt->bindParam(':runtimeMinutes', $runtimeMinutes, PDO::PARAM_STR);
            $stmt->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
            $stmt->bindParam(':plot', $plot, PDO::PARAM_STR);

            var_dump($genres);
    
            $stmt->bindParam(':genres', $genres);
    
            if (!$stmt->execute()) {
                throw new Exception('Erreur lors de l\'ajout du film.');
            }
    
            // Récupérer l'ID du média inséré
            $media_id = $stmt->fetchColumn();
    
            // Insérer le crew (directeurs et scénaristes)
            $stmt = $this->pdo->prepare("
                INSERT INTO crew (media_id, directors, writers)
                VALUES (:media_id, :directors, :writers)
            ");
    
            $stmt->bindParam(':media_id', $media_id);
            $stmt->bindParam(':directors', $id_directeurs);
            $stmt->bindParam(':writers', $id_writers);
    
            if (!$stmt->execute()) {
                throw new Exception('Erreur lors de l\'ajout du crew.');
            }
    
            // Insérer les acteurs dans principal
            $query = "INSERT INTO principal (media_id, ordering, perso_id, cat_id, job, characters) 
                    VALUES (:media_id, :ordering, :perso_id, :cat_id, :job, :characters)";
            
            $stmt = $this->pdo->prepare($query);
    
            // Itération sur chaque acteur
            $i = 0;
            foreach ($id_actors as $id_actor) {
                $stmt->bindParam(':media_id', $media_id, PDO::PARAM_STR);
                $stmt->bindParam(':ordering', $i, PDO::PARAM_INT);
                $stmt->bindParam(':perso_id', $id_actor, PDO::PARAM_STR);

                $cat_id = 1;
                $job = "N/A";
                $characters = "N/A";

                $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
                $stmt->bindParam(':job', $job, PDO::PARAM_STR);
                $stmt->bindParam(':characters', $characters, PDO::PARAM_STR);

                
                if (!$stmt->execute()) {
                    throw new Exception('Erreur lors de l\'ajout des acteurs.');
                }
                $i++;
            }
    
            // Appeler la méthode pour ajouter le film à l'utilisateur
            if (!$this->addFilmToUser($media_id)) {
                throw new Exception('Erreur lors de l\'ajout du film à l\'utilisateur.');
            }
    
            // Si toutes les étapes ont réussi, on valide la transaction
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            // En cas d'erreur, annuler la transaction
            $this->pdo->rollBack();
            return $e;
        }
    }
    

    public function addFilmToUser($media_id) {
        // Vérifiez que $this->rowid est défini avant de l'utiliser
        if (isset($this->rowid) && !empty($this->rowid)) {
            try {
                $stmt = $this->pdo->prepare("
                    INSERT INTO media_user (media_id, rowid) VALUES (:media_id, :rowid)
                ");
    
                $stmt->bindParam(":media_id", $media_id, PDO::PARAM_STR);
                $stmt->bindParam(":rowid", $this->rowid, PDO::PARAM_INT);
    
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>
