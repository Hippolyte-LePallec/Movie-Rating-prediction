<?php
require_once(dirname(__FILE__) . '/../../class/film.class.php');

$apiKey = '12a20dd5'; // Votre clé API OMDb

// Fonction pour récupérer l'URL du poster d'un film par son titre
// Fonction pour récupérer l'URL du poster et le plot d'un film par son ID
function getPosterAndPlot($id, $apiKey) {
    $url = "http://www.omdbapi.com/?i=" . urlencode($id) . "&apikey=" . $apiKey . "&r=json&plot=full";
    $response = file_get_contents($url);
    
    if ($response !== false) {
        $data = json_decode($response, true);
        
        $posterUrl = isset($data['Poster']) && $data['Poster'] != 'N/A' ? $data['Poster'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg';
        $plot = isset($data['Plot']) && $data['Plot'] != 'N/A' ? $data['Plot'] : 'Plot not available';
        
        return ['posterUrl' => $posterUrl, 'plot' => $plot];
    } else {
        return ['posterUrl' => 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg', 'plot' => 'Plot not available'];
    }
}




$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filmsPerPage = 15; 

$film = new Film($db);
$films = $film->fetchAll($page, $filmsPerPage);

$totalFilms = $film->getTotalCount(); 
$totalPages = ceil($totalFilms / $filmsPerPage);

// Vérification et ajout du poster si nécessaire
foreach ($films as &$filmItem) {
    // Vérifier si le film a déjà une URL d'image
    if ($filmItem['image_url'] == null||$filmItem['plot']) {
        // Récupérer l'URL du poster et le plot
        $filmData = getPosterAndPlot($filmItem['media_id'], $apiKey);
        $posterUrl = $filmData['posterUrl'];
        $plot = $filmData['plot'];
        
        // Mettre à jour la base de données avec l'URL du poster
        if ($posterUrl != 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg') {
            $film->addPosterUrl($filmItem['media_id'], $posterUrl);
        }
        if ($plot != 'Plot not available'){
            $film->addPlot($filmItem['media_id'],$plot);
        }
        
        // Ajouter l'URL du poster et le plot à l'objet film pour l'affichage
        $filmItem['image_url'] = $posterUrl;
        $filmItem['plot'] = $plot;
    }
}


include 'views/films_list.php';
?>
