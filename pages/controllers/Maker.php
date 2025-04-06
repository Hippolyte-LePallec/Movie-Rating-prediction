<?php 
include('../../inc/head.php');
include('../../inc/top.php'); 
require_once __DIR__ . '/../../class/personne.class.php';
require_once __DIR__ . '/../../class/genre.class.php';

// Afficher toutes les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Instanciation des objets
$personne = new Personne($db);
$genre = new Genre($db);
$genres = $genre->fetchAll();

// Initialisation des tableaux pour stocker les personnes sélectionnées
$selectedDirectors = isset($_POST['directors']) ? $_POST['directors'] : [];
$selectedWriters = isset($_POST['writers']) ? $_POST['writers'] : [];
$selectedActors = isset($_POST['actors']) ? $_POST['actors'] : [];

// Traitement de la recherche
$searchResult = [];
$showSearchResults = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_term']) && !empty($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];
    $type = $_POST['search_type'];
    $searchResult = $personne->searchPersons($searchTerm);
    $showSearchResults = true;
    
    // Conserver toutes les données soumises dans le formulaire
    $formData = $_POST;
} else {
    $formData = $_POST;
}
?>