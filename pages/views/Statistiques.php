<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header">
                    <h2 class="text-warning mb-0"><i class="fas fa-chart-pie me-2"></i>Statistiques des Films</h2>
                </div>
                <div class="card-body">
                    <p class="lead">Explorez les statistiques complètes de notre collection de films.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques rapides -->
    <div class="row mb-3">
        <div class="col-md-4 mb-3"> 
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-film fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Films</h5>
                    <p class="card-text display-4 text-warning"><?= $filmStats['totalFilms'] ?></p>
                    <p class="card-text">Depuis le début</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3"> 
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Note moyenne</h5>
                    <p class="card-text display-4 text-warning"><?= number_format($filmStats['avgRating'], 1) ?></p>
                    <p class="card-text">Sur 10 étoiles</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3"> 
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Réalisateurs</h5>
                    <p class="card-text display-4 text-warning"><?= $filmStats['directorsCount'] ?></p>
                    <p class="card-text">Différents</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques détaillés -->
    <div class="row">
        <!-- Répartition par genre -->
        <div class="col-md-12 mb-4">
            <div class="card bg-dark text-light border-secondary h-100 large-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="fas fa-chart-pie me-2"></i>Répartition par Genre</h5>
                </div>
                <div class="card-body">
                    <canvas id="chart-genres" width="100%" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const genreData = {
        labels: <?= json_encode(array_column($genreDistribution, 'genre_name')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($genreDistribution, 'genre_count')) ?>,
            backgroundColor: ['#FF6347', '#FFD700', '#32CD32', '#1E90FF', '#8A2BE2', '#FF4500', '#DA70D6'],
            hoverOffset: 4
        }]
    };


    const genreConfig = {
        type: 'pie',
        data: genreData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    };


    const genreChart = new Chart(document.getElementById('chart-genres'), genreConfig);

</script>
