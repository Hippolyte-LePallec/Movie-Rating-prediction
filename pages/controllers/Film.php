<?php
require_once(dirname(__FILE__) . '/../../class/film.class.php');

$apiKey = '51ca03d6'; // Votre clé API OMDb

// Fonction pour récupérer l'URL du poster d'un film par son titre
function getPosterUrl($title, $apiKey) {
    //$url = "http://www.omdbapi.com/?t=" . urlencode($title) . "&apikey=" . $apiKey . "&r=json";
    //$response = file_get_contents($url);
    $response=false;
    
    if ($response !== false) {
        $data = json_decode($response, true);
        
        if (isset($data['Poster']) && $data['Poster'] != 'N/A') {
            return $data['Poster'];
        } else {
            return 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg'; 
        }
    } else {
        return 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg'; 
    }
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filmsPerPage = 10; 

$film = new Film($db);
$films = $film->fetchAll($page, $filmsPerPage);

$totalFilms = $film->getTotalCount(); 
$totalPages = ceil($totalFilms / $filmsPerPage);

// Vérification et ajout du poster si nécessaire
foreach ($films as &$filmItem) {

    // Vérifier si le film a déjà une URL d'image
    if (empty($filmItem['media_URL'])) {
        // Si l'URL est vide, appeler l'API pour obtenir l'URL du poster
        $posterUrl = getPosterUrl($filmItem['primaryTitle'], $apiKey);
        
        // Mettre à jour la base de données avec l'URL du poster
        if($filmItem['media_URL']==null && $posterUrl='https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg'){
        $film->addPosterUrl($filmItem['media_id'], $posterUrl);
    }
        
        
        // Ajouter l'URL du poster à l'objet film pour l'affichage
        $filmItem['imageUrl'] = $posterUrl;
    } else {
        // Si l'URL existe déjà, l'utiliser
        $filmItem['imageUrl'] = $filmItem['media_URL'];
        
    }
}

include 'views/films_list.php';
?>
