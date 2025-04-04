<?php include('../../inc/head.php'); ?>
<?php include('../../inc/top.php'); ?>

<?php
// filepath: /var/www/html/Movie-Rating-prediction/pages/controllers/Prediction.php
require_once __DIR__ . '/../../class/personne.class.php';
require_once __DIR__ . '/../../class/genre.class.php';
require_once __DIR__ . '/../../class/rating.class.php';

// Vérifier si on arrive du formulaire
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?element=pages&action=Maker');
    exit;
}

// Initialisation des objets
$personne = new Personne($db);
$genre = new Genre($db);
$actorRating = new ActorRating($db);

// Inclure la vue
include __DIR__ . '/../views/Prediction.php';

// Utiliser le chemin absolu pour le footer
include __DIR__ . '/../../inc/footer.php';
?>