<!-- Page d'accueil -->
<div class="container mt-4">

    <!-- Films en vedette -->
    <h1 class="text-warning mb-3">Films en vedette</h1>
    <div class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <?php foreach($featuredFilms as $film): ?>
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <!-- Poster du film, utilise le poster URL récupéré depuis la base de données -->
                <img src="<?= $film['image_url'] ?>" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                    <p class="card-text small">
                        <?= htmlspecialchars($film['genre_names']) ?><br>
                        Note :  ★
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Section des films les mieux notés -->
    <h2 class="text-warning mb-3">Top 10 des films les mieux notés</h2>
    <div class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <?php foreach($topRatedFilms as $film): ?>
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="<?= $film['poster_url'] ?>" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                    <p class="card-text small">Note : <?= number_format($film['averageRating'], 1) ?> ★</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Films les moins bien notés -->
    <h2 class="text-danger mt-5 mb-3">Top 10 des films les moins bien notés</h2>
    <div class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <?php foreach($worstRatedFilms as $film): ?>
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="<?= $film['poster_url'] ?? '/api/placeholder/185/278' ?>" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
                    <p class="card-text small">Note :★ </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
