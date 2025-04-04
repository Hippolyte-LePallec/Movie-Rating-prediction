<?php
require_once __DIR__ . '/../../class/personne.class.php';
require_once __DIR__ . '/../../class/genre.class.php';
require_once __DIR__ . '/../../class/rating.class.php';

// Afficher toutes les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Vérifier si la fonction n'existe pas déjà avant de la déclarer
if (!function_exists('calculateGlobalPrediction')) {
    function calculateGlobalPrediction($directors, $writers, $actors, $genreRating, $titleRating) {
        $weights = [
            'directors' => 0.30,  // 30% pour les réalisateurs
            'writers' => 0.20,    // 20% pour les scénaristes
            'actors' => 0.25,     // 25% pour les acteurs
            'genres' => 0.15,     // 15% pour les genres
            'title' => 0.10       // 10% pour le titre
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
        
        if ($titleRating > 0) {
            $weightedSum += $titleRating * $weights['title'];
            $totalWeight += $weights['title'];
        }
        
        // Calcul de la moyenne pondérée finale
        return ($totalWeight > 0) ? ($weightedSum / $totalWeight) : 0;
    }
}

// Vérifier si la fonction n'existe pas déjà avant de la déclarer
if (!function_exists('formatRating')) {
    function formatRating($rating) {
        return number_format($rating, 2, '.', '');
    }
}

// Vérifier si la fonction n'existe pas déjà avant de la déclarer
if (!function_exists('getRatingColorClass')) {
    function getRatingColorClass($rating) {
        if ($rating >= 8.5) return 'text-success';
        if ($rating >= 7.0) return 'text-warning';
        if ($rating >= 5.5) return 'text-info';
        if ($rating >= 4.0) return 'text-secondary';
        return 'text-danger';
    }
}

// Vérifier si la fonction n'existe pas déjà avant de la déclarer
if (!function_exists('getRatingDescription')) {
    function getRatingDescription($rating) {
        if ($rating >= 8.5) return 'Excellent';
        if ($rating >= 7.0) return 'Très bon';
        if ($rating >= 5.5) return 'Bon';
        if ($rating >= 4.0) return 'Moyen';
        if ($rating >= 3.0) return 'Passable';
        return 'Faible';
    }
}

// Instanciation des objets
$personne = new Personne($db);
$genre = new Genre($db);
$actorRating = new ActorRating($db);

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
    
    // Prédiction basée sur le titre
    $titleRating = $actorRating->predictRatingByPartialTitle($title);
    
    // Prédiction basée sur les genres
    $genreRating = $actorRating->predictCombinedGenreRating($genres);
    
    // Calcul de la prédiction globale
    $globalPrediction = calculateGlobalPrediction($directors, $writers, $actors, $genreRating, $titleRating);
} else {
    // Rediriger vers la page de formulaire si accès direct à cette page
    header('Location: ?element=pages&action=Maker');
    exit;
}
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-light">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="text-warning mb-0">Prédiction de note pour "<?= htmlspecialchars($title) ?>"</h3>
                    <span class="badge bg-warning text-dark fs-4"><?= formatRating($globalPrediction) ?>/10</span>
                </div>
                <div class="card-body">
                    <!-- Informations générales -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-dark border-warning">
                                <div class="card-header bg-dark text-warning">
                                    <h4 class="mb-0">Information sur le média</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>Année:</strong> <?= htmlspecialchars($year) ?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Durée:</strong> <?= htmlspecialchars($runtime) ?> min</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Film pour adulte:</strong> <?= $isAdult ? 'Oui' : 'Non' ?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Appréciation:</strong> <span class="<?= getRatingColorClass($globalPrediction) ?>"><?= getRatingDescription($globalPrediction) ?></span></p>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($genres)): ?>
                                        <div class="mt-3">
                                            <p><strong>Genres:</strong></p>
                                            <div>
                                                <?php 
                                                $genreNames = [];
                                                foreach ($genres as $genreId) {
                                                    foreach ($genre->fetchAll() as $g) {
                                                        if ($g['genre_id'] == $genreId) {
                                                            $genreNames[] = $g['genre_name'];
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?php foreach ($genreNames as $genreName): ?>
                                                    <span class="badge bg-warning text-dark me-1"><?= htmlspecialchars($genreName) ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($description)): ?>
                                        <div class="mt-3">
                                            <p><strong>Description:</strong></p>
                                            <p><?= nl2br(htmlspecialchars($description)) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Facteurs de prédiction -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-dark border-warning">
                                <div class="card-header bg-dark text-warning">
                                    <h4 class="mb-0">Facteurs de prédiction</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Facteur</th>
                                                    <th class="text-end">Note prédite</th>
                                                    <th class="text-center">Influence</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($directors)): ?>
                                                    <tr>
                                                        <td>Réalisateurs</td>
                                                        <td class="text-end"><?= formatRating(array_sum(array_column($directors, 'rating')) / count($directors)) ?></td>
                                                        <td class="text-center">
                                                            <div class="progress bg-dark">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                                    Élevée
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($writers)): ?>
                                                    <tr>
                                                        <td>Scénaristes</td>
                                                        <td class="text-end"><?= formatRating(array_sum(array_column($writers, 'rating')) / count($writers)) ?></td>
                                                        <td class="text-center">
                                                            <div class="progress bg-dark">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                    Moyenne
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($actors)): ?>
                                                    <tr>
                                                        <td>Acteurs</td>
                                                        <td class="text-end"><?= formatRating(array_sum(array_column($actors, 'combined_rating')) / count($actors)) ?></td>
                                                        <td class="text-center">
                                                            <div class="progress bg-dark">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                                    Élevée
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                
                                                <tr>
                                                    <td>Genres</td>
                                                    <td class="text-end"><?= formatRating($genreRating) ?></td>
                                                    <td class="text-center">
                                                        <div class="progress bg-dark">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                                Moyenne
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Titre similaire</td>
                                                    <td class="text-end"><?= formatRating($titleRating) ?></td>
                                                    <td class="text-center">
                                                        <div class="progress bg-dark">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                                Faible
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Détails des personnes -->
                    <div class="row">
                        <!-- Réalisateurs -->
                        <?php if (!empty($directors)): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card bg-dark border-warning h-100">
                                    <div class="card-header bg-dark text-warning">
                                        <h5 class="mb-0">Réalisateurs</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <?php foreach ($directors as $director): ?>
                                                <li class="list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center">
                                                    <span><?= htmlspecialchars($director['name']) ?></span>
                                                    <span class="badge bg-warning text-dark"><?= formatRating($director['rating']) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Scénaristes -->
                        <?php if (!empty($writers)): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card bg-dark border-warning h-100">
                                    <div class="card-header bg-dark text-warning">
                                        <h5 class="mb-0">Scénaristes</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <?php foreach ($writers as $writer): ?>
                                                <li class="list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center">
                                                    <span><?= htmlspecialchars($writer['name']) ?></span>
                                                    <span class="badge bg-warning text-dark"><?= formatRating($writer['rating']) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Acteurs -->
                        <?php if (!empty($actors)): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card bg-dark border-warning h-100">
                                    <div class="card-header bg-dark text-warning">
                                        <h5 class="mb-0">Acteurs</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <?php foreach ($actors as $actor): ?>
                                                <li class="list-group-item bg-dark text-light border-secondary">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span><?= htmlspecialchars($actor['name']) ?></span>
                                                        <span class="badge bg-warning text-dark"><?= formatRating($actor['combined_rating']) ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between small">
                                                        <span>Base: <?= formatRating($actor['basic_rating']) ?></span>
                                                        <span>Genres: <?= formatRating($actor['genre_rating']) ?></span>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <a href="?element=media&action=list" class="btn btn-secondary w-100">Retour à la liste</a>
                        </div>
                        <div class="col-md-6">
                            <a href="?element=pages&action=Maker" class="btn btn-warning w-100">Nouvelle prédiction</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Style général */
.card {
    border-radius: 8px;
}

.card-header {
    border-bottom: 1px solid rgba(255, 193, 7, 0.3);
}

/* Style pour les bordures */
.border-warning {
    border-color: rgba(255, 193, 7, 0.5) !important;
}

.border-secondary {
    border-color: rgba(255, 193, 7, 0.5) !important;
}

/* Style pour les items de liste */
.list-group-item {
    margin-bottom: 4px;
    padding: 0.5rem 0.75rem;
    font-size: 0.95rem;
    border-radius: 4px !important;
}

/* Style pour le tableau */
.table-dark {
    --bs-table-bg: transparent;
    border-color: rgba(255, 193, 7, 0.3);
}

.table-dark th, .table-dark td {
    border-color: rgba(255, 193, 7, 0.3);
}

.table-dark.table-striped > tbody > tr:nth-of-type(odd) > * {
    --bs-table-accent-bg: rgba(255, 255, 255, 0.05);
}

/* Style pour les badges */
.badge {
    padding: 0.4em 0.6em;
    font-weight: normal;
}

/* Style pour les progress bars */
.progress {
    height: 20px;
    border-radius: 10px;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

.progress-bar {
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: bold;
}

/* Couleurs pour les notes */
.text-success {
    color: #28a745 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-info {
    color: #17a2b8 !important;
}

.text-secondary {
    color: #6c757d !important;
}

.text-danger {
    color: #dc3545 !important;
}
</style>