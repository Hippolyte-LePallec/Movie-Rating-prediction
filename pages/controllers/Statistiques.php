<?php
// Inclure les fichiers nécessaires
require_once(dirname(__FILE__) . '/../../class/statistiques.class.php');
// Créer une instance de Stat avec la connexion DB
$statModel = new Stat($db);

// Récupérer les statistiques
$filmStats = $statModel->getFilmStats();
$genreDistribution = $statModel->getGenreDistribution();
$topDirectors = $statModel->getTopDirectors();
$filmsEvolution = $statModel->getFilmsEvolution();
$ratingsDistribution = $statModel->getRatingsDistribution();
$averageDuration = $statModel->getAverageDurationByDecade();

// Passer ces données à la vue
include('path/to/statistiquesView.php');
?>
