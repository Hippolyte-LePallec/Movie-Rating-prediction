<?php
require_once(dirname(__FILE__) . '/../../inc/head.php'); // Inclure le header global
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light">
                <div class="card-header">
                    <h3 class="text-warning mb-0">Créer une nouvelle personne</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= strpos($message, 'Erreur') === false ? 'alert-success' : 'alert-danger' ?>">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <!-- Nom principal -->
                        <div class="mb-3">
                            <label for="primaryName" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="primaryName" name="primaryName" required>
                            <div class="invalid-feedback">
                                Veuillez entrer un nom.
                            </div>
                        </div>

                        <!-- Année de naissance -->
                        <div class="mb-3">
                            <label for="birthYear" class="form-label">Année de naissance</label>
                            <input type="number" class="form-control bg-dark text-light" id="birthYear" name="birthYear" min="1800" max="<?= date('Y') ?>">
                            <small class="text-muted">Laissez vide si inconnu.</small>
                        </div>

                        <!-- Année de décès -->
                        <div class="mb-3">
                            <label for="deathYear" class="form-label">Année de décès</label>
                            <input type="number" class="form-control bg-dark text-light" id="deathYear" name="deathYear" min="1800" max="<?= date('Y') ?>">
                            <small class="text-muted">Laissez vide si la personne est encore en vie.</small>
                        </div>
                        <!-- Boutons -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="index.php" class="btn btn-secondary w-100">Annuler</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning w-100">Créer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation du formulaire côté client
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php
require_once(dirname(__FILE__) . '/../../inc/footer.php'); // Inclure le footer global
?>