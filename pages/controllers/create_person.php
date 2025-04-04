<?php
require_once(dirname(__FILE__) . '/../../lib/mypdo.php');

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

        // Redirection après succès
        header('Location: ../../index.php?element=pages&action=PersonList&success=1');
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>