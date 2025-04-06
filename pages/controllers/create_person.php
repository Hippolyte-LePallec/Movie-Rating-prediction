<?php
require_once(dirname(__FILE__) . '/../../lib/mypdo.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $primaryName = $_POST['primaryName'];
    $birthYear = !empty($_POST['birthYear']) ? $_POST['birthYear'] : null;
    $deathYear = !empty($_POST['deathYear']) ? $_POST['deathYear'] : null;
    $primaryProfession = !empty($_POST['primaryProfession']) ? $_POST['primaryProfession'] : null;

    try {
        // Requête SQL pour insérer une nouvelle personne
        $stmt = $db->prepare('
            INSERT INTO personne ("primaryName", "birthYear", "deathYear")
            VALUES (:primaryName, :birthYear, :deathYear)
        ');
        $stmt->bindParam(':primaryName', $primaryName);
        $stmt->bindParam(':birthYear', $birthYear);
        $stmt->bindParam(':deathYear', $deathYear);
        $stmt->execute();

        $message = "Personne créée avec succès.";
        header("Location: http://localhost/Movie-Rating-prediction/index.php?element=pages&action=Film");
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
?>