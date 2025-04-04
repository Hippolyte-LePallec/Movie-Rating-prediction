<?php
require_once(dirname(__FILE__) . '/../../class/film.class.php');

// Paramètres de pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filmsPerPage = 100000;

// Paramètre de recherche
$searchTerm = isset($_POST['titre']) ? $_POST['titre'] : '';  // Récupération via POST

// Instancier la classe Film
$film = new Film($db);

// Récupérer les films filtrés par recherche
$films = $film->fetchFilmsBySearch($searchTerm, $page, $filmsPerPage);
$totalFilms = $film->getTotalCountBySearch($searchTerm);
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
}

// Inclure la vue d'affichage
include 'views/films_list.php';
?>
