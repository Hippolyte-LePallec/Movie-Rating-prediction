<?php
require_once(dirname(__FILE__) . '/../class/film.class.php');

// Liste des films en vedette
$featuredFilmIds = ['tt0358082', 'tt1014672', 'tt0312004', 'tt0121766', 'tt15846788'];

$film = new Film($db);

// Fonction pour récupérer les films en vedette
function getFeaturedFilms($filmIds)
{
    global $film;
    $featuredFilms = [];

    foreach ($filmIds as $id) {
        // Récupérer les détails du film depuis la base de données
        $filmDetails = $film->getFilmById($id);

        // Si le film a déjà un poster, on l'ajoute directement
        if ($filmDetails['image_url'] != null) {
            $featuredFilms[] = $filmDetails;
        } else {
            // Sinon, récupérer les données via l'API
            $filmData = $film->getPosterAndPlot($id);

            // Ajouter le poster et le plot dans la base de données
            if ($filmData['posterUrl'] != 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg') {
                $film->addPosterUrl($id, $filmData['posterUrl']);
            }
            if ($filmData['plot'] != 'Plot not available') {
                $film->addPlot($id, $filmData['plot']);
            }

            // Ajouter les données récupérées
            $featuredFilms[] = [
                'media_id' => $id,
                'image_url' => $filmData['posterUrl'],
                'plot' => $filmData['plot']
            ];
        }
    }
    return $featuredFilms;
}

// Récupérer les films en vedette
$featuredFilms = getFeaturedFilms($featuredFilmIds);

// Récupérer les films les mieux notés
$topRatedFilms = $film->getTopRatedFilms();
foreach ($topRatedFilms as $topfilm) {

    $topfilm = $film->getFilmById($topfilm['media_id']);
    
    // Vérifie si l'image du film est déjà disponible dans la base de données
    if ($topfilm['image_url'] != null) {
        // Ajouter les films les mieux notés dans une liste séparée
        $topRatedFilmsList[] = $topfilm;
    } else {
        // Sinon, récupérer les données via l'API
        $filmData = $film->getPosterAndPlot($topfilm['media_id']);

        // Ajouter le poster et le plot dans la base de données
        if ($filmData['posterUrl'] != 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg') {
            $film->addPosterUrl($topfilm['media_id'], $filmData['posterUrl']);
        }
        if ($filmData['plot'] != 'Plot not available') {
            $film->addPlot($topfilm['media_id'], $filmData['plot']);
        }

        // Ajouter les données récupérées dans la liste des films les mieux notés
        $topRatedFilmsList[] = [
            'media_id' => $topfilm['media_id'],
            'image_url' => $filmData['posterUrl'],
            'plot' => $filmData['plot']
        ];
    }
}


$worstRatedFilms = $film->getWorstRatedFilms();
foreach ($worstRatedFilms as $filmItem) {
    $filmDetails = $film->getFilmById($filmItem['media_id']);

    if ($filmDetails['image_url'] != null) {
        $worstRatedFilmsList[] = $filmDetails;
    } else {
        $filmData = $film->getPosterAndPlot($filmItem['media_id']);

        if ($filmData['posterUrl'] != 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg') {
            $film->addPosterUrl($filmItem['media_id'], $filmData['posterUrl']);
        }
        if ($filmData['plot'] != 'Plot not available') {
            $film->addPlot($filmItem['media_id'], $filmData['plot']);
        }

        $worstRatedFilmsList[] = [
            'media_id' => $filmItem['media_id'],
            'image_url' => $filmData['posterUrl'],
            'plot' => $filmData['plot']
        ];
    }
}

?>
