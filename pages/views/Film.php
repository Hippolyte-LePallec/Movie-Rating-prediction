<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="text-warning mb-0">Films disponibles</h2>
                </div>

                <div
                    class="card-body">

                    <div
                        class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                        <?php foreach ($films as $film): ?>
                            <div class="col">
                                <div class="card h-100 bg-dark text-light border-secondary">
                                    <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                                        <p class="card-text small"><?= htmlspecialchars($film['startYear']) ?></p>

                                        <p class="card-text">
                                            <strong>Genres:</strong>
                                            <?= htmlspecialchars($film['genre_names']) ?>
                                        </p>


                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-warning text-dark">
                                                ★</span>
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
                                    <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1" aria-disabled="true">Précédent</a>
                                </li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

