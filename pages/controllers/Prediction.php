<?php 
// Afficher toutes les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once(__DIR__ . '/../../inc/head.php');
include_once(__DIR__ . '/../../inc/top.php');

// filepath: /var/www/html/Movie-Rating-prediction/pages/controllers/Prediction.php
require_once __DIR__ . '/../../class/personne.class.php';
require_once __DIR__ . '/../../class/genre.class.php';
require_once __DIR__ . '/../../class/rating.class.php';
require_once __DIR__ . '/../../class/user.class.php';

// Vérifier si on arrive du formulaire
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?element=pages&action=Maker');
    exit;
}

// Initialisation des objets
$personne = new Personne($db);
$genre = new Genre($db);
$actorRating = new ActorRating($db);

// Vérifier si la fonction n'existe pas déjà avant de la déclarer
if (!function_exists('calculateGlobalPrediction')) {
    function calculateGlobalPrediction($directors, $writers, $actors, $genreRating) {
        $weights = [
            'directors' => 0.25,
            'writers' => 0.20,
            'actors' => 0.30,
            'genres' => 0.20
        ];
        
        $totalWeight = 0;
        $weightedSum = 0;
        
        // Calcul pour les réalisateurs
        if (!empty($directors)) {
            $directorRating = array_sum(array_column($directors, 'rating')) / count($directors);
            $weightedSum += $directorRating * $weights['directors'];
            $totalWeight += $weights['directors'];
        }
        
        // Calcul pour les scénaristes
        if (!empty($writers)) {
            $writerRating = array_sum(array_column($writers, 'rating')) / count($writers);
            $weightedSum += $writerRating * $weights['writers'];
            $totalWeight += $weights['writers'];
        }
        
        // Calcul pour les acteurs
        if (!empty($actors)) {
            $actorRating = array_sum(array_column($actors, 'combined_rating')) / count($actors);
            $weightedSum += $actorRating * $weights['actors'];
            $totalWeight += $weights['actors'];
        }
        
        // Ajout des notes de genre et titre
        if ($genreRating > 0) {
            $weightedSum += $genreRating * $weights['genres'];
            $totalWeight += $weights['genres'];
        }
        
        // Calcul de la moyenne pondérée finale
        return ($totalWeight > 0) ? ($weightedSum / $totalWeight) : 0;
    }
}

// Vérifier si la fonction n'existe pas déjà avant de la déclarer
if (!function_exists('formatRating')) {
    function formatRating($rating) {
        if ($rating === null) return 'N/A';
        return number_format((float) $rating, 2, '.', '');
    }
    
}

if (!function_exists('implodeRecursive')) {
    function implodeRecursive($array, $separator = ",") {
        $flatIds = [];
    
        $extractId = function($item) {
            // Extraction par regex de l'ID du type "nm0000123" car on ne veut que l'id des personnes
            if (preg_match('/^(nm\d+)/', $item, $matches)) {
                return $matches[1];
            }
            return null;
        };
    
        $flatten = function($items) use (&$flatten, $extractId, &$flatIds) {
            foreach ($items as $item) {
                if (is_array($item)) {
                    $flatten($item);
                } else {
                    $id = $extractId($item);
                    if ($id !== null) {
                        $flatIds[] = $id;
                    }
                }
            }
        };
    
        $flatten($array);
    
        return implode($separator, $flatIds);
    }    
}

if (!function_exists('explodeRecursive')) {
    function explodeRecursive($string, $glue = ";", $separator = ",") {
        // Séparer la chaîne par le séparateur principal (par défaut ";")
        $array = explode($separator, $string);
        
        // Exploser chaque élément du tableau
        return array_map(function($item) use ($glue) {
            // Si l'élément contient encore le séparateur interne, on l'explose à nouveau
            if (strpos($item, $glue) !== false) {
                return explode($glue, $item);
            } else {
                return $item;
            }
        }, $array);
    }
}


// Instanciation des objets
$personne = new Personne($db);
$genre = new Genre($db);
$actorRating = new ActorRating($db);
$user = new User($db, $_SESSION['user']['rowid']);

if (isset($_POST['submitForm']) && $_POST['submitForm'] === 'ajouter') {
    // Validation des données
    if (!empty($_POST['primaryTitle']) && !empty($_POST['genres'])) {
        $primaryTitle = $_POST['primaryTitle'];
        $isAdult = $_POST['isAdult'];
        $startYear = $_POST['startYear'];
        $runtimeMinutes = $_POST['runtimeMinutes'];
        $plot = $_POST['plot'];

        // Convertir genres en un tableau d'entiers
        $genres = explode(",", $_POST['genres']);
        $genres = array_map('intval', $genres);  // Convertir les genres en entiers
 
        // Formatage pour PostgreSQL : tableau d'entiers
        $genresFormatted = "{" . implode(",", $genres) . "}";  // Format PostgreSQL : {1,2,3}

        $id_directeurs = $_POST['id_directeurs'];
        $id_writers = $_POST['id_writers'];
        $id_actors = explodeRecursive($_POST['id_actors']);

        // Ajout du film
        $resultat = $user->addFilm($primaryTitle, $isAdult, $startYear, $runtimeMinutes, "", $plot, $genresFormatted, $id_directeurs, $id_writers, $id_actors);

        header("Location: http://localhost/Movie-Rating-prediction/index.php?element=pages&action=User");
        exit;
    } else {
        echo "ERREUR : Le titre du film ou les genres sont manquants.";
    }
}

// Vérifier si le formulaire a été soumis avec les données requises
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['primaryTitle'])) {
    
    // Récupération des données du formulaire
    $title = $_POST['primaryTitle'];
    $year = $_POST['startYear'];
    $runtime = $_POST['runtimeMinutes'];
    $isAdult = isset($_POST['isAdult']) ? 1 : 0;
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $genres = isset($_POST['genres']) ? $_POST['genres'] : [];
    
    // Récupération des personnes
    $directors = [];
    $writers = [];
    $actors = [];
    
    // Traitement des directeurs
    if (isset($_POST['directors']) && is_array($_POST['directors'])) {
        foreach ($_POST['directors'] as $directorData) {
            list($directorId, $directorName) = explode('|', $directorData);
            $directors[] = [
                'id' => $directorId,
                'name' => $directorName,
                'rating' => $actorRating->predictDirectorRatingWithGenres($directorId, $genres)
            ];
        }
    }
    
    // Traitement des scénaristes
    if (isset($_POST['writers']) && is_array($_POST['writers'])) {
        foreach ($_POST['writers'] as $writerData) {
            list($writerId, $writerName) = explode('|', $writerData);
            $writers[] = [
                'id' => $writerId,
                'name' => $writerName,
                'rating' => $actorRating->predictWriterRatingWithGenres($writerId, $genres)
            ];
        }
    }
    
    // Traitement des acteurs
    if (isset($_POST['actors']) && is_array($_POST['actors'])) {
        foreach ($_POST['actors'] as $actorData) {
            list($actorId, $actorName) = explode('|', $actorData);
            
            // Récupération des différentes notes de prédiction
            $basicRating = $actorRating->predictActorRating($actorId);
            $genreRating = $actorRating->predictActorRatingWithGenres($actorId, $genres);
            $combinedRating = $actorRating->predictCombinedActorRating($actorId, $genres);
            
            $actors[] = [
                'id' => $actorId,
                'name' => $actorName,
                'basic_rating' => $basicRating,
                'genre_rating' => $genreRating,
                'combined_rating' => $combinedRating
            ];
        }
    }

    // Prédiction basée sur les genres
    $genreRating = $actorRating->predictCombinedGenreRating($genres);
    
    // Calcul de la prédiction globale
    $globalPrediction = calculateGlobalPrediction($directors, $writers, $actors, $genreRating);
} else {
    // Rediriger vers la page de formulaire si accès direct à cette page
    header('Location: ?element=pages&action=Maker');
    exit;
}


?>