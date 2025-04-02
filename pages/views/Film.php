<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="text-warning mb-0">Films disponibles</h2>
                </div>

                <div class="card-body">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                        <?php foreach ($films as $film): ?>
                            <div class="col">
                                <div class="card h-100 bg-dark text-light border-secondary shadow-sm">
                                    <img src="/api/placeholder/185/278" class="card-img-top rounded" alt="Film poster">
                                    <div class="card-body">
                                        <h5 class="card-title text-warning"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                                        <p class="card-text small text-muted"><?= htmlspecialchars($film['startYear']) ?></p>

                                        <p class="card-text">
                                            <strong>Genres:</strong>
                                            <span class="badge bg-secondary">
                                                <?= htmlspecialchars($film['genre_names']) ?>
                                            </span>
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-warning text-dark">★</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-4">
    <ul class="pagination justify-content-center">

        <!-- Page précédente -->
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link bg-warning text-dark" href="index.php?element=pages&action=Film&page=<?= $page - 1 ?>">Précédent</a>
            </li>
        <?php endif; ?>

        <!-- Première page toujours affichée -->
        <?php if ($page > 3): ?>
            <li class="page-item">
                <a class="page-link bg-dark text-light" href="index.php?element=pages&action=Film&page=1">1</a>
            </li>
            <?php if ($page > 4): ?>
                <li class="page-item disabled">
                    <span class="page-link bg-dark text-light">...</span>
                </li>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Pages proches de la page courante -->
        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link <?= $i === $page ? 'bg-warning text-dark' : 'bg-dark text-light' ?>" href="index.php?element=pages&action=Film&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Dernière page toujours affichée -->
        <?php if ($page < $totalPages - 2): ?>
            <?php if ($page < $totalPages - 3): ?>
                <li class="page-item disabled">
                    <span class="page-link bg-dark text-light">...</span>
                </li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link bg-dark text-light" href="index.php?element=pages&action=Film&page=<?= $totalPages ?>"><?= $totalPages ?></a>
            </li>
        <?php endif; ?>

        <!-- Page suivante -->
        <?php if ($page < $totalPages): ?>
            <li class="page-item">
                <a class="page-link bg-warning text-dark" href="index.php?element=pages&action=Film&page=<?= $page + 1 ?>">Suivant</a>
            </li>
        <?php endif; ?>

    </ul>
</nav>

                </div>
            </div>
        </div>
    </div>
</div>
