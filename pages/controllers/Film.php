<?php
require_once(dirname(__FILE__) . '/../../class/film.class.php');


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filmsPerPage = 10; 


$film = new Film($db);


$films = $film->fetchAll($page, $filmsPerPage);

$totalFilms = $film->getTotalCount(); 
$totalPages = ceil($totalFilms / $filmsPerPage);

include 'views/films_list.php';
?>
