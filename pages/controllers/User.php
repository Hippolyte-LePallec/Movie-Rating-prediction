<?php
// Inclure le fichier de connexion à la base de données
include_once 'dbConnection.php';  // Assurez-vous d'avoir une connexion PDO dans ce fichier

require_once(dirname(__FILE__) . '/../../class/user.class.php');
require_once(dirname(__FILE__) . '/../../class/film.class.php');


$rowid = $_SESSION['user']['rowid'];

$user = new User( $db,$rowid);


$films = $user->getCreatedFilms();
$filmClass = new Film($db);

// Tableau pour stocker les informations des films créés
$filmDetails = [];

foreach ($films as $filmId) {
    // Récupérer les détails de chaque film en utilisant la méthode getFilmById
    $filmData = $filmClass->getFilmById($filmId['media_id']);


    if ($filmData) {
        // Ajouter les détails du film à notre tableau
        $filmDetails[] = $filmData;
    }   
}

?>
