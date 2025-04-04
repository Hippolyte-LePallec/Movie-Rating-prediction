<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light border-secondary shadow-lg">
                <div class="card-header text-warning">
                    <h2><?= htmlspecialchars($filmDetails['primaryTitle']) ?> (<?= htmlspecialchars($filmDetails['startYear']) ?>)</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?= !empty($filmDetails['image_url']) ? $filmDetails['image_url'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg' ?>" class="rounded fixed-size-image" alt="Poster du film">
                    </div>
                    <p><strong>Résumé :</strong> <?= htmlspecialchars($filmDetails['plot'] ?? 'Résumé non disponible') ?></p>
                    <p><strong>Genres :</strong> <?= htmlspecialchars($filmDetails['genre_names']) ?></p>
                    <p><strong>Note :</strong> <?= htmlspecialchars($filmDetails['averageRating'] ?? 'N/A') ?> ★</p>
                    <p><strong>Votes :</strong> <?= htmlspecialchars($filmDetails['numVotes'] ?? 'N/A') ?></p>
                    <a href="index.php?element=pages&action=Film" class="btn btn-warning text-dark">Retour à la liste</a>
                </div>
            </div>
        </div>
    </div>
</div>
