<?php
require_once(dirname(__FILE__) . '/../../class/film.class.php');
require_once(dirname(__FILE__) . '/../../class/note.class.php');

// Paramètres de pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filmsPerPage = 15;

$note = new note($db);
$notes = $note->getRatingById();
$film = new Film($db);
$films = $film->fetchAll($page, $filmsPerPage);
$totalFilms = $film->getTotalCount();
$totalPages = ceil($totalFilms / $filmsPerPage);

// Vérification et ajout du poster si nécessaire
foreach ($films as &$filmItem) {
    // Vérifier si le film n'a pas de poster ou de plot
    if ($filmItem['image_url'] == null || $filmItem['plot'] == null) {
        // Appeler la méthode de la classe Film pour récupérer les données via l'API
        $filmData = $film->getPosterAndPlot($filmItem['media_id']);
        $posterUrl = $filmData['posterUrl'];
        $plot = $filmData['plot'];

        // Ajouter le poster et le plot dans la base de données
        if ($posterUrl != 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg') {
            $film->addPosterUrl($filmItem['media_id'], $posterUrl);
        }
        if ($plot != 'Plot not available') {
            $film->addPlot($filmItem['media_id'], $plot);
        }

        // Mettre à jour les données du film
        $filmItem['image_url'] = $posterUrl;
        $filmItem['plot'] = $plot;
    }

    // Récupérer le averageRating pour le film
    $ratingData = $note->calculateAverageRating($filmItem['media_id']);
    $filmItem['averageRating'] = $ratingData['avgRating'] ?? 'N/A';
}

// Inclure la vue d'affichage
include 'views/films_list.php';
?>
