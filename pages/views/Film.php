<?php
// Ne pas inclure les en-têtes ici car ils sont déjà inclus dans inc/content.php
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-light border-secondary mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="text-warning mb-0">Films disponibles</h2>
                    <a href="?element=pages&action=Maker" class="btn btn-warning">
                        <i class="fas fa-plus-circle"></i> Ajouter un film
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Filtres -->
                    <div class="mb-4">
                        <form class="row g-3">
                            <div class="col-md-3">
                                <label for="genre" class="form-label">Genre</label>
                                <select class="form-select bg-dark text-light border-secondary" id="genre">
                                    <option value="" selected>Tous les genres</option>
                                    <option value="action">Action</option>
                                    <option value="comedy">Comédie</option>
                                    <option value="drama">Drame</option>
                                    <option value="horror">Horreur</option>
                                    <option value="sci-fi">Science Fiction</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="year" class="form-label">Année</label>
                                <select class="form-select bg-dark text-light border-secondary" id="year">
                                    <option value="" selected>Toutes les années</option>
                                    <?php for($i = date('Y'); $i >= 1980; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="rating" class="form-label">Note minimum</label>
                                <select class="form-select bg-dark text-light border-secondary" id="rating">
                                    <option value="" selected>Toutes les notes</option>
                                    <?php for($i = 9; $i >= 1; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?>+ ★</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-filter"></i> Filtrer
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Liste des films -->
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                        <?php for($i = 1; $i <= 15; $i++): ?>
                        <div class="col">
                            <div class="card h-100 bg-dark text-light border-secondary">
                                <img src="/api/placeholder/185/278" class="card-img-top" alt="Film poster">
                                <div class="card-body">
                                    <h5 class="card-title">Titre du film <?= $i ?></h5>
                                    <p class="card-text small">2023 • Action, Aventure</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-warning text-dark"><?= number_format(rand(50, 95) / 10, 1) ?> ★</span>
                                        <div>
                                            <a href="#" class="btn btn-sm btn-outline-info" title="Éditer">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>