<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary shadow-lg w-100">
                <div class="card-header text-warning text-center">
                    <h2><?= htmlspecialchars($filmDetails['primaryTitle']) ?> (<?= htmlspecialchars($filmDetails['startYear']) ?>)</h2>
                </div>
                <div class="card-body">
                <div class="mb-3 text-center">
                        <img src="<?= !empty($filmDetails['image_url']) ? $filmDetails['image_url'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg' ?>" 
                             class="rounded" alt="Poster du film" style="max-width: 300px; max-height: 450px; object-fit: cover;">
                    </div>
                    
                    <table class="table table-dark table-striped table-bordered mt-3">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center text-warning">Informations sur le Film</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Résumé :</strong></td>
                                <td><?= htmlspecialchars($filmDetails['plot'] ?? 'Résumé non disponible') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Genres :</strong></td>
                                <td><?= htmlspecialchars($filmDetails['genre_names']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Note :</strong></td>
                                <td><?= htmlspecialchars($filmDetails['averageRating'] ?? 'N/A') ?>/10★</td>
                            </tr>
                            <tr>
                                <td><strong>Votes :</strong></td>
                                <td><?= htmlspecialchars($filmDetails['numVotes'] ?? 'N/A') ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Table des Réalisateurs -->
                    <table class="table table-dark table-striped table-bordered mt-3">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center text-warning">Réalisateur(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Réalisateur(s) :</strong></td>
                                <td>
                                    <?php 
                                    $directors = [];
                                    foreach ($crewMembers as $member) {
                                        if (strpos($member['primaryProfession'], 'director') !== false) {
                                            $directors[] = htmlspecialchars($member['primaryName']);
                                        }
                                    }
                                    echo $directors ? implode(", ", $directors) : 'N/A'; 
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Table des Scénaristes -->
                    <table class="table table-dark table-striped table-bordered mt-3">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center text-warning">Scénariste(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Scénariste(s) :</strong></td>
                                <td>
                                    <?php 
                                    $writers = [];
                                    foreach ($crewMembers as $member) {
                                        if (strpos($member['job'], 'screenplay') !== false) {
                                            $writers[] = htmlspecialchars($member['primaryName']);
                                        }
                                    }
                                    echo $writers ? implode(", ", $writers) : 'N/A'; 
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Table des Acteurs -->
                    <table class="table table-dark table-striped table-bordered mt-3">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center text-warning">Acteurs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $actors = [];
                            foreach ($crewMembers as $member) {
                                if (strpos($member['primaryProfession'], 'actor') !== false) {
                                    $characters = json_decode($member['characters'], true);
                                    $characterList = $characters ? implode(", ", $characters) : 'N/A';
                                    $actors[] = "<strong>" . htmlspecialchars($member['primaryName']) . "</strong> (" . $characterList . ")";
                                }
                            }
                            if ($actors) {
                                foreach ($actors as $actor) {
                                    echo "<tr><td colspan='2'>$actor</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>N/A</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <a href="index.php?element=pages&action=Film" class="btn btn-warning text-dark mt-3">Retour à la liste</a>
                </div>
            </div>
        </div>
    </div>
</div>
