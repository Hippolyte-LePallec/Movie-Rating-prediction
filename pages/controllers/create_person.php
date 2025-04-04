<?php
require_once(dirname(__FILE__) . '/../../lib/mypdo.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $primaryName = $_POST['primaryName'];
    $birthYear = !empty($_POST['birthYear']) ? $_POST['birthYear'] : null;
    $deathYear = !empty($_POST['deathYear']) ? $_POST['deathYear'] : null;

    try {
        $stmt = $db->prepare("
            INSERT INTO personne (primaryName, birthYear, deathYear)
            VALUES (:primaryName, :birthYear, :deathYear)
        ");
        $stmt->bindParam(':primaryName', $primaryName);
        $stmt->bindParam(':birthYear', $birthYear);
        $stmt->bindParam(':deathYear', $deathYear);
        $stmt->execute();

        $message = "Personne créée avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Inclure la vue
include(dirname(__FILE__) . '/../views/create_person.php');
?>