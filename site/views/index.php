<!-- Page d'accueil -->
<div class="container mt-4">

    <!-- Film à l'affiche -->
    <h1 class="text-warning mb-3">Films en vedette</h1>
    <div class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <!-- Exemple de carte de film -->
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title">Titre du film</h5>
                    <p class="card-text small">2023 • Action, Aventure</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning text-dark">8.5 ★</span>
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Répétition de cartes pour la mise en page -->
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title">Interstellar</h5>
                    <p class="card-text small">2014 • Sci-Fi, Drame</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning text-dark">9.1 ★</span>
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title">Inception</h5>
                    <p class="card-text small">2010 • Action, Sci-Fi</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning text-dark">8.8 ★</span>
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title">Pulp Fiction</h5>
                    <p class="card-text small">1994 • Crime, Drame</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning text-dark">8.9 ★</span>
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title">The Dark Knight</h5>
                    <p class="card-text small">2008 • Action, Crime</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning text-dark">9.0 ★</span>
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des films les mieux notés -->
    <h2 class="text-warning mb-3">Top 10 des films les mieux notés</h2>
    <div class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <!-- Films mieux notés -->
        <?php for($i = 0; $i < 10; $i++): ?>
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title">Film populaire <?= $i+1 ?></h5>
                    <p class="card-text small">2023 • Genre, Genre</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning text-dark"><?= number_format(9.5 - ($i * 0.1), 1) ?> ★</span>
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>

    <!-- Section des films les moins bien notés -->
    <h2 class="text-danger mt-5 mb-3">Top 10 des films les moins bien notés</h2>
    <div class="row row-cols-1 row-cols-md-5 g-4 mb-5">
        <!-- Films moins bien notés -->
        <?php for($i = 0; $i < 10; $i++): ?>
        <div class="col">
            <div class="card h-100 bg-dark text-light border-secondary">
                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                <div class="card-body">
                    <h5 class="card-title">Film impopulaire <?= $i+1 ?></h5>
                    <p class="card-text small">2023 • Genre, Genre</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-danger text-light"><?= number_format(3.5 - ($i * 0.3), 1) ?> ★</span>
                        <a href="#" class="btn btn-sm btn-outline-light">Détails</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>