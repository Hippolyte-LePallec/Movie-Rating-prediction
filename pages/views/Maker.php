<?php
// Ne pas inclure les en-têtes ici car ils sont déjà inclus dans inc/content.php
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header">
                    <h2 class="text-warning mb-0">Ajouter un nouveau film</h2>
                </div>
                <div class="card-body">
                    <form action="<?= $_SERVER['PHP_SELF'] . "?element=films&action=add" ?>" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="film_id">
                        
                        <!-- Informations générales -->
                        <div class="card mb-4 bg-dark border-secondary">
                            <div class="card-header">
                                <h5 class="text-warning mb-0"><i class="fas fa-film me-2"></i>Informations générales</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                        <input class="form-control bg-dark text-light border-secondary" type="text" id="titre" name="titre" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir un titre.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="titre_original" class="form-label">Titre original</label>
                                        <input class="form-control bg-dark text-light border-secondary" type="text" id="titre_original" name="titre_original">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="realisateur" class="form-label">Réalisateur <span class="text-danger">*</span></label>
                                        <input class="form-control bg-dark text-light border-secondary" type="text" id="realisateur" name="realisateur" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir un réalisateur.
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_sortie" class="form-label">Année de sortie <span class="text-danger">*</span></label>
                                        <select class="form-select bg-dark text-light border-secondary" id="date_sortie" name="date_sortie" required>
                                            <option value="" selected disabled>Sélectionner...</option>
                                            <?php for($i = date('Y'); $i >= 1900; $i--): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Veuillez sélectionner une année.
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="duree" class="form-label">Durée (min) <span class="text-danger">*</span></label>
                                        <input class="form-control bg-dark text-light border-secondary" type="number" id="duree" name="duree" min="1" max="999" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir une durée valide.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="genre" class="form-label">Genre(s) <span class="text-danger">*</span></label>
                                        <select class="form-select bg-dark text-light border-secondary" id="genre" name="genre[]" multiple required>
                                            <option value="action">Action</option>
                                            <option value="aventure">Aventure</option>
                                            <option value="animation">Animation</option>
                                            <option value="biographie">Biographie</option>
                                            <option value="comedie">Comédie</option>
                                            <option value="crime">Crime</option>
                                            <option value="documentaire">Documentaire</option>
                                            <option value="drame">Drame</option>
                                            <option value="famille">Famille</option>
                                            <option value="fantastique">Fantastique</option>
                                            <option value="histoire">Histoire</option>
                                            <option value="horreur">Horreur</option>
                                            <option value="musique">Musique</option>
                                            <option value="mystere">Mystère</option>
                                            <option value="romance">Romance</option>
                                            <option value="sciencefiction">Science-Fiction</option>
                                            <option value="thriller">Thriller</option>
                                            <option value="guerre">Guerre</option>
                                            <option value="western">Western</option>
                                        </select>
                                        <div class="form-text text-muted">
                                            Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs genres.
                                        </div>
                                        <div class="invalid-feedback">
                                            Veuillez sélectionner au moins un genre.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pays" class="form-label">Pays de production</label>
                                        <input class="form-control bg-dark text-light border-secondary" type="text" id="pays" name="pays">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Synopsis et détails -->
                        <div class="card mb-4 bg-dark border-secondary">
                            <div class="card-header">
                                <h5 class="text-warning mb-0"><i class="fas fa-align-left me-2"></i>Synopsis et détails</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="synopsis" class="form-label">Synopsis <span class="text-danger">*</span></label>
                                    <textarea class="form-control bg-dark text-light border-secondary" id="synopsis" name="synopsis" rows="5" required></textarea>
                                    <div class="invalid-feedback">
                                        Veuillez saisir un synopsis.
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="casting" class="form-label">Acteurs principaux</label>
                                    <textarea class="form-control bg-dark text-light border-secondary" id="casting" name="casting" rows="3" placeholder="Un acteur par ligne"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Médias -->
                        <div class="card mb-4 bg-dark border-secondary">
                            <div class="card-header">
                                <h5 class="text-warning mb-0"><i class="fas fa-image me-2"></i>Médias</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="affiche" class="form-label">URL de l'affiche</label>
                                    <input class="form-control bg-dark text-light border-secondary" type="url" id="affiche" name="affiche">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="trailer" class="form-label">URL de la bande-annonce (YouTube)</label>
                                    <input class="form-control bg-dark text-light border-secondary" type="url" id="trailer" name="trailer" placeholder="https://www.youtube.com/watch?v=...">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="?element=pages&action=Film" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Annuler
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="confirm" class="btn btn-warning w-100">
                                    <i class="fas fa-save me-2"></i>Enregistrer le film
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Script pour activer la validation des formulaires Bootstrap
(function() {
  'use strict';
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function(form) {
    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>