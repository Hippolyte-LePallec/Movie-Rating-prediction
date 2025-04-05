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
                                <div class="card-body text-white">
                                    <table class="table table-dark table-borderless table-striped mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="w-30">Année :</th>
                                                <td><?= htmlspecialchars($year) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Durée :</th>
                                                <td><?= htmlspecialchars($runtime) ?> min</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Film pour adulte :</th>
                                                <td><?= $isAdult ? 'Oui' : 'Non' ?></td>
                                            </tr>

                                            <?php if (!empty($genres)): ?>
                                                <?php 
                                                // Récupération de tous les genres une seule fois
                                                $allGenres = $genre->fetchAll();
                                                $genreNames = [];

                                                // Mapping des IDs reçus vers les noms
                                                foreach ($genres as $genreId) {
                                                    foreach ($allGenres as $g) {
                                                        if ($g['genre_id'] == $genreId) {
                                                            $genreNames[] = $g['genre_name'];
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <th scope="row">Genres :</th>
                                                    <td>
                                                        <?php foreach ($genreNames as $genreName): ?>
                                                            <span class="badge bg-warning text-dark me-1"><?= htmlspecialchars($genreName) ?></span>
                                                        <?php endforeach; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php if (!empty($description)): ?>
                                                <tr>
                                                    <th scope="row">Description :</th>
                                                    <td><?= nl2br(htmlspecialchars($description)) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
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
                                                    <th class="text-center">Note prédite</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($directors)): ?>
                                                    <tr>
                                                        <td>Réalisateurs</td>
                                                        <td class="text-center"><?= formatRating(array_sum(array_column($directors, 'rating')) / count($directors)) ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($writers)): ?>
                                                    <tr>
                                                        <td>Scénaristes</td>
                                                        <td class="text-center"><?= formatRating(array_sum(array_column($writers, 'rating')) / count($writers)) ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($actors)): ?>
                                                    <tr>
                                                        <td>Acteurs</td>
                                                        <td class="text-center"><?= formatRating(array_sum(array_column($actors, 'combined_rating')) / count($actors)) ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                
                                                <tr>
                                                    <td>Genres</td>
                                                    <td class="text-center"><?= formatRating($genreRating) ?></td>
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
                            <!-- Bouton de retour au Maker -->
                            <button type="button" class="btn w-100" onclick="document.getElementById('hiddenForm').submit();">Retour au Maker</button>
                        </div>
                        <div class="col-md-6">
                            <!-- Bouton pour ajouter le film -->
                            <button type="button" class="btn btn-warning w-100" onclick="document.getElementById('hiddenFormAddFilm').querySelector('button[type=submit]').click();">Ajouter le film</button>
                        </div>
                    </div>

                    <!-- Formulaire caché -->
                    <form method="POST" action="?element=pages&action=Maker" id="hiddenForm" style="display: none;">
                        <input type="hidden" name="primaryTitle" value="<?= htmlspecialchars($title) ?>">
                        <input type="hidden" name="startYear" value="<?= htmlspecialchars($year) ?>">
                        <input type="hidden" name="runtimeMinutes" value="<?= htmlspecialchars($runtime) ?>">
                        <input type="hidden" name="isAdult" value="<?= $isAdult ? 1 : 0 ?>">

                        <!-- Envoi des genres sous forme de tableau -->
                        <?php if (!empty($genres)): ?>
                            <?php foreach ($genres as $genre): ?>
                                <input type="hidden" name="genres[]" value="<?= htmlspecialchars($genre) ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Réalisateurs -->
                        <?php if (isset($directors) && !empty($directors)): ?>
                            <?php foreach ($directors as $director): ?>
                                <input type="hidden" name="directors[]" value="<?= htmlspecialchars($director['id']) ?>|<?= htmlspecialchars($director['name']) ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Scénaristes -->
                        <?php if (isset($writers) && !empty($writers)): ?>
                            <?php foreach ($writers as $writer): ?>
                                <input type="hidden" name="writers[]" value="<?= htmlspecialchars($writer['id']) ?>|<?= htmlspecialchars($writer['name']) ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Acteurs -->
                        <?php if (isset($actors) && !empty($actors)): ?>
                            <?php foreach ($actors as $actor): ?>
                                <input type="hidden" name="actors[]" value="<?= htmlspecialchars($actor['id']) ?>|<?= htmlspecialchars($actor['name']) ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <input type="hidden" name="description" value="<?= htmlspecialchars($description) ?>">
                    </form>

                    <!-- Formulaire caché pour ajouter le film -->
                    <form id="hiddenFormAddFilm" method="POST" action="?element=pages&action=Prediction" style="display: none;">
                        <input type="hidden" name="primaryTitle" value="<?= htmlspecialchars($title) ?>">
                        <input type="hidden" name="isAdult" value="<?= $isAdult ? 1 : 0 ?>">
                        <input type="hidden" name="startYear" value="<?= htmlspecialchars($year) ?>">
                        <input type="hidden" name="runtimeMinutes" value="<?= htmlspecialchars($runtime) ?>">
                        <input type="hidden" name="plot" value="<?= htmlspecialchars($description) ?>">
                        <input type="hidden" name="genres" value="<?= implode(",", $genres) ?>">
                        <input type="hidden" name="id_directeurs" value="<?= implodeRecursive($directors)?>">
                        <input type="hidden" name="id_writers" value="<?= implodeRecursive($writers) ?>">
                        <input type="hidden" name="id_actors" value="<?= implodeRecursive($actors) ?>">

                        <button type="submit" name="submitForm" value="ajouter" style="display: none;"></button>
                    </form>
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