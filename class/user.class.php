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
                "SELECT * admin 
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
}
?>
