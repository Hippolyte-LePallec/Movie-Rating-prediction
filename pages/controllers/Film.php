<?php
require_once(dirname(__FILE__) . '/../../class/film.class.php');

// Liste des clés API
$apiKeys = ['6d08fedf', '51ca03d6', '12a20dd5'];

// Fonction pour récupérer les données d'un film depuis l'API avec gestion des clés
function getPosterAndPlot($id) {
    global $apiKeys;
    foreach ($apiKeys as $apiKey) {
        $url = "http://www.omdbapi.com/?i=" . urlencode($id) . "&apikey=" . $apiKey . "&r=json&plot=full";
        $response = file_get_contents($url);

        if ($response !== false) {
            $data = json_decode($response, true);
            
            // Vérifier si la réponse est correcte ou si la limite de requêtes est atteinte
            if (isset($data['Response']) && $data['Response'] === 'False' && strpos($data['Error'], 'limit') !== false) {
                continue; // Passer à la clé suivante
            }

            $posterUrl = isset($data['Poster']) && $data['Poster'] != 'N/A' ? $data['Poster'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg';
            $plot = isset($data['Plot']) && $data['Plot'] != 'N/A' ? $data['Plot'] : 'Plot not available';
            return ['posterUrl' => $posterUrl, 'plot' => $plot];
        }
    }
    // Si toutes les clés échouent
    return ['posterUrl' => 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg', 'plot' => 'Plot not available'];
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filmsPerPage = 15;

$film = new Film($db);
$films = $film->fetchAll($page, $filmsPerPage);
$totalFilms = $film->getTotalCount();
$totalPages = ceil($totalFilms / $filmsPerPage);

// Vérification et ajout du poster si nécessaire
foreach ($films as &$filmItem) {
    if ($filmItem['image_url'] == null || $filmItem['plot'] == null) {
        $filmData = getPosterAndPlot($filmItem['media_id']);
        $posterUrl = $filmData['posterUrl'];
        $plot = $filmData['plot'];

        if ($posterUrl != 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg') {
            $film->addPosterUrl($filmItem['media_id'], $posterUrl);
        }
        if ($plot != 'Plot not available') {
            $film->addPlot($filmItem['media_id'], $plot);
        }

        $filmItem['image_url'] = $posterUrl;
        $filmItem['plot'] = $plot;
    }
}

include 'views/films_list.php';
?>
