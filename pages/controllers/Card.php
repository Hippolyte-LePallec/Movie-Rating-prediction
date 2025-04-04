<?php
require_once(dirname(__FILE__) . '/../../class/film.class.php');

// Vérifie si l'ID du film est passé en paramètre
if (!isset($_GET['id'])) {
    die("Aucun film spécifié.");
}

$media_id = $_GET['id'];

// Instancier la classe Film
$film = new Film($db);

// Récupérer les informations du film via l'ID
$filmDetails = $film->getFilmById($media_id);

// Vérifie si le film existe
if (!$filmDetails) {
    die("Film introuvable.");
}

// Inclure la vue pour afficher les détails du film
include 'views/card.php';
?>
