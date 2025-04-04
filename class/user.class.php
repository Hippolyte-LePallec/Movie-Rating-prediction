<?php
class User {
    private $pdo;
    private $rowid;

    // Constructeur pour initialiser la connexion à la base de données et l'identifiant utilisateur
    public function __construct($pdo, $rowid) {
        $this->pdo = $pdo;
        $this->rowid = $rowid;
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
