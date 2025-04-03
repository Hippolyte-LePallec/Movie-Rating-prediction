<?php
require_once(dirname(__FILE__) . '/../class/film.class.php');


$featuredFilmIds = ['tt0358082', 'tt1014672', 'tt0312004', 'tt15391004', 'tt15846788'];


$film = new Film($db);


function getFeaturedFilms($filmIds) {
    global $film;
    $featuredFilms = [];

    foreach ($filmIds as $id) {

        $filmDetails = $film->getFilmById($id);
        
        if ($filmDetails['image_url']!=null) {
            $featuredFilms[] = $filmDetails;
        } else {
            $filmData = $film->getPosterAndPlot($id);


            if ($filmData['posterUrl'] != 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg') {
                $film->addPosterUrl($id, $filmData['posterUrl']);
            }
            if ($filmData['plot'] != 'Plot not available') {
                $film->addPlot($id, $filmData['plot']);
            }

            $featuredFilms[] = [
                'media_id' => $id,
                'image_url' => $filmData['posterUrl'],
                'plot' => $filmData['plot']
            ];
        }
    }
    return $featuredFilms;
}

$featuredFilms = getFeaturedFilms($featuredFilmIds);

?>
