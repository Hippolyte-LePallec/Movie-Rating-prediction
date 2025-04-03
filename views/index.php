<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="text-warning mb-0">Films en vedette</h2>
                </div>
                <div class="card-body">
                    <div
                        class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4 mb-5">
                        <?php foreach ($featuredFilms as $film): ?>
                            <div class="col">
                                <div class="card h-100 bg-dark text-light border-secondary shadow-lg rounded">
                                    <img src="<?= !empty($film['image_url']) ? $film['image_url'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg' ?>" class="card-img-top rounded" alt="Film poster">
                                    <div class="card-body">
                                        <h5 class="card-title text-warning"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                                        <p class="card-text">
                                            <strong>Genres:</strong>
                                            <span
                                                class="badge bg-secondary"><?= htmlspecialchars($film['genre_names']) ?>
                                            </span>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-warning text-dark">★
                                                <?= htmlspecialchars($film['averageRating'] ?? 'N/A') ?>

                                            </span>
                                        </div>
                                        
                                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-warning mb-3">Top 10 des films les mieux notés</h2>
    <div
        class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <?php foreach ($topRatedFilmsList as $film): ?>
            <div class="col">
                <div class="card h-100 bg-dark text-light border-secondary shadow-lg rounded">
                    <img src="<?= !empty($film['image_url']) ? $film['image_url'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg' ?>" class="card-img-top rounded" alt="Film poster">
                    <div class="card-body">
                        <h5 class="card-title text-warning"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                        <p class="card-text">
                            <strong>Genres:</strong>
                            <span
                                class="badge bg-secondary"><?= htmlspecialchars($film['genre_names']) ?>
                            </span>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-warning text-dark">★
                                <?= htmlspecialchars($film['averageRating'] ?? 'N/A') ?>
                            </span>
                        </div>
                        
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="text-danger mt-5 mb-3">Top 10 des films les moins bien notés</h2>
    <div
        class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <?php foreach ($worstRatedFilmsList as $film):; ?>
            <div class="col">
                <div class="card h-100 bg-dark text-light border-secondary shadow-lg rounded">
                    <img src="<?= !empty($film['image_url']) ? $film['image_url'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg' ?>" class="card-img-top rounded" alt="Film poster">
                    <div class="card-body">
                        <h5 class="card-title text-warning"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                        <p class="card-text">
                            <strong>Genres:</strong>
                            <span
                                class="badge bg-secondary"><?= htmlspecialchars($film['genre_names']) ?>
                            </span>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-warning text-dark">★
                                <?= htmlspecialchars($film['averageRating'] ?? 'N/A') ?>
                            </span>
                        </div>
                        
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

