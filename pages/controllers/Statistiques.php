<?php

// Afficher toutes les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(dirname(__FILE__) . '/../../class/statistiques.class.php');

$statModel = new Stat($db);


$filmStats = $statModel->getFilmStats();
$genreDistribution = $statModel->getGenreDistribution();
$topDirectors = $statModel->getTopDirectors();
$filmsEvolution = $statModel->getFilmsEvolution();
$ratingsDistribution = $statModel->getRatingsDistribution();
$averageDuration = $statModel->getAverageDurationByDecade();
?>
