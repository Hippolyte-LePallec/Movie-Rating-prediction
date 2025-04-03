<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="text-warning mb-0">Films disponibles</h2>
                </div>

                <div class="card-body">
                    <div
                        class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                        <?php foreach ($films as $film): ?>
                            <div class="col">
                                <div
                                    class="card h-100 bg-dark text-light border-secondary shadow-lg rounded">
                                    <!-- Vérification de l'existence de l'image du film, sinon image par défaut -->
                                    <img src="<?= !empty($film['image_url']) ? $film['image_url'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg' ?>" class="card-img-top rounded" alt="Film poster">
                                    <div class="card-body">
                                        <h5 class="card-title text-warning"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                                        <p class="card-text small"><?= htmlspecialchars($film['startYear']) ?></p>

                                        <p class="card-text">
                                            <strong>Genres:</strong>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($film['genre_names']) ?></span>
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-warning text-dark">★
                                                <?= htmlspecialchars($film['averageRating'] ?? 'N/A') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <nav class="mt-4">
                        <ul
                            class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link bg-warning text-dark rounded-pill" href="index.php?element=pages&action=Film&page=<?= $page - 1 ?>">Précédent</a>
                                </li>
                            <?php endif; ?>

                            <?php if ($page > 3): ?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-light rounded-pill" href="index.php?element=pages&action=Film&page=1">1</a>
                                </li>
                                <?php if ($page > 4): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link bg-dark text-light rounded-pill">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                    <li class="page-item <?= $i === $page ? 'active' : '' ?>"> <a class="page-link <?= $i === $page ? 'bg-warning text-dark' : 'bg-dark text-light' ?> rounded-pill" href="index.php?element=pages&action=Film&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages - 2): ?>
                                <?php if ($page < $totalPages - 3): ?>
                                        <li class="page-item disabled"> <span class="page-link bg-dark text-light rounded-pill">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-light rounded-pill" href="index.php?element=pages&action=Film&page=<?= $totalPages ?>"><?= $totalPages ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link bg-warning text-dark rounded-pill" href="index.php?element=pages&action=Film&page=<?= $page + 1 ?>">Suivant</a>
                                </li>
                            <?php endif; ?>

                            <!-- Formulaire pour entrer une page manuellement -->
                            <form class="d-inline-block" method="get" action="index.php">
                                <input type="hidden" name="element" value="pages">
                                <input type="hidden" name="action" value="Film">
                                <div class="input-group mt-3">
                                    <input type="number" name="page" min="1" max="<?= $totalPages ?>" class="form-control rounded-pill" placeholder="Page" aria-label="Numéro de page" value="<?= $page ?>" style="max-width: 120px;">
                                    <button class="btn btn-warning text-dark rounded-pill" type="submit">Aller</button>
                                </div>
                            </form>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>

