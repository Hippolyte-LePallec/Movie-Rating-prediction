<?php

require_once(dirname(__FILE__) . '/../../class/statistiques.class.php');

$statModel = new Stat($db);


$filmStats = $statModel->getFilmStats();
$genreDistribution = $statModel->getGenreDistribution();
$topDirectors = $statModel->getTopDirectors();
$filmsEvolution = $statModel->getFilmsEvolution();
$ratingsDistribution = $statModel->getRatingsDistribution();
$averageDuration = $statModel->getAverageDurationByDecade();


include('path/to/statistiquesView.php');
?>
