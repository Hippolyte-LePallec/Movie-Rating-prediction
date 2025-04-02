<?php
// Ne pas inclure les en-têtes ici car ils sont déjà inclus dans inc/content.php
?>

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
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-film fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Films</h5>
                    <p class="card-text display-4 text-warning">1,254</p>
                    <p class="card-text text-muted">Depuis le début</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Note moyenne</h5>
                    <p class="card-text display-4 text-warning">7.4</p>
                    <p class="card-text text-muted">Sur 10 étoiles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Réalisateurs</h5>
                    <p class="card-text display-4 text-warning">328</p>
                    <p class="card-text text-muted">Différents</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-eye fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Vues</h5>
                    <p class="card-text display-4 text-warning">4.2M</p>
                    <p class="card-text text-muted">Ce mois-ci</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Graphiques détaillés -->
    <div class="row">
        <!-- Répartition par genre -->
        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="fas fa-chart-pie me-2"></i>Répartition par Genre</h5>
                </div>
                <div class="card-body">
                    <div id="chart-genres" style="width: 100%; height: 300px; position: relative;">
                        <!-- Placeholder pour le graphique réel -->
                        <div class="placeholder-chart">
                            <div class="chart-container" style="position: relative; width: 100%; height: 100%;">
                                <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <div class="text-center">
                                        <div class="spinner-border text-warning mb-3" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p>Chargement du graphique...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Réalisateurs -->
        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="fas fa-crown me-2"></i>Top Réalisateurs (par note moyenne)</h5>
                </div>
                <div class="card-body">
                    <div id="chart-realisateurs" style="width: 100%; height: 300px;">
                        <!-- Placeholder pour le graphique réel -->
                        <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center">
                                <div class="spinner-border text-warning mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p>Chargement du graphique...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Évolution du nombre de films par année -->
        <div class="col-12 mb-4">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="fas fa-chart-line me-2"></i>Évolution du nombre de films par année</h5>
                </div>
                <div class="card-body">
                    <div id="chart-evolution" style="width: 100%; height: 300px;">
                        <!-- Placeholder pour le graphique réel -->
                        <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center">
                                <div class="spinner-border text-warning mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p>Chargement du graphique...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section des détails supplémentaires -->
    <div class="row">
        <!-- Statistiques des notes -->
        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="fas fa-star-half-alt me-2"></i>Distribution des Notes</h5>
                </div>
                <div class="card-body">
                    <div id="chart-ratings" style="width: 100%; height: 300px;">
                        <!-- Placeholder pour le graphique réel -->
                        <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center">
                                <div class="spinner-border text-warning mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p>Chargement du graphique...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Durée moyenne des films par décennie -->
        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-light border-secondary h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="fas fa-clock me-2"></i>Durée Moyenne par Décennie</h5>
                </div>
                <div class="card-body">
                    <div id="chart-duree" style="width: 100%; height: 300px;">
                        <!-- Placeholder pour le graphique réel -->
                        <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center">
                                <div class="spinner-border text-warning mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p>Chargement du graphique...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tableau des films récemment ajoutés -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="fas fa-plus-circle me-2"></i>Films Récemment Ajoutés</h5>
                    <a href="films.php" class="btn btn-sm btn-outline-warning">Voir tous les films</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Réalisateur</th>
                                    <th scope="col">Année</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Date d'ajout</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dune: Deuxième Partie</td>
                                    <td>Denis Villeneuve</td>
                                    <td>2024</td>
                                    <td>Science-Fiction</td>
                                    <td>8.7</td>
                                    <td>01/04/2025</td>
                                </tr>
                                <tr>
                                    <td>The Batman</td>
                                    <td>Matt Reeves</td>
                                    <td>2022</td>
                                    <td>Action</td>
                                    <td>8.2</td>
                                    <td>28/03/2025</td>
                                </tr>
                                <tr>
                                    <td>Everything Everywhere All at Once</td>
                                    <td>Daniel Kwan, Daniel Scheinert</td>
                                    <td>2022</td>
                                    <td>Science-Fiction</td>
                                    <td>8.9</td>
                                    <td>27/03/2025</td>
                                </tr>
                                <tr>
                                    <td>Challengers</td>
                                    <td>Luca Guadagnino</td>
                                    <td>2023</td>
                                    <td>Drame</td>
                                    <td>7.8</td>
                                    <td>25/03/2025</td>
                                </tr>
                                <tr>
                                    <td>Oppenheimer</td>
                                    <td>Christopher Nolan</td>
                                    <td>2023</td>
                                    <td>Biographie</td>
                                    <td>9.1</td>
                                    <td>23/03/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour initialiser les graphiques -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Les scripts d'initialisation des graphiques seront chargés ici
        // Utilisation d'une bibliothèque comme Chart.js ou ApexCharts
        
        console.log('Initialisation des graphiques de statistiques...');
        
        // À remplacer par l'implémentation réelle des graphiques
        setTimeout(function() {
            // Simuler le chargement des graphiques
            console.log('Graphiques chargés');
        }, 1500);
    });
</script>