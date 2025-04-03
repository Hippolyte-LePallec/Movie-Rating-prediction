<?php
require_once __DIR__ . '/../../class/maker.class.php';

// Au début du fichier, après les includes
$maker = new Maker($db);
$genres = $maker->getGenres();
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light">
                <div class="card-header">
                    <h3 class="text-warning mb-0">Ajouter un média</h3>
                </div>
                <div class="card-body">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>?element=media&action=add" method="post" class="needs-validation" novalidate>
                        <!-- Informations de base -->
                        <div class="mb-3">
                            <label for="primaryTitle" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="primaryTitle" name="primaryTitle" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="startYear" class="form-label">Année <span class="text-danger">*</span></label>
                                <select class="form-select bg-dark text-light" id="startYear" name="startYear" required>
                                    <option value="">Sélectionner...</option>
                                    <?php for($i = date('Y'); $i >= 1900; $i--): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="runtimeMinutes" class="form-label">Durée (min) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control bg-dark text-light" id="runtimeMinutes" name="runtimeMinutes" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="isAdult" class="form-label">Contenu adulte</label>
                                <select class="form-control bg-dark text-light" id="isAdult" name="isAdult">
                                    <option value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>
                            </div>
                        </div>

                        <!-- Genres -->
                        <div class="mb-3">
                            <label class="form-label">Genres <span class="text-danger">*</span></label>
                            <div class="row">
                                <?php foreach($genres as $genre): ?>
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="genres[]" value="<?= $genre['id'] ?>" id="genre<?= $genre['id'] ?>">
                                            <label class="form-check-label text-light" for="genre<?= $genre['id'] ?>">
                                                <?= htmlspecialchars($genre['name']) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Réalisateur -->
                        <div class="mb-3">
                            <label for="director" class="form-label">Réalisateur <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="director" name="director" required>
                            <input type="hidden" name="director_id" id="director_id">
                        </div>

                        <!-- Scénariste -->
                        <div class="mb-3">
                            <label for="writer" class="form-label">Scénariste <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="writer" name="writer" required>
                            <input type="hidden" name="writer_id" id="writer_id">
                        </div>

                        <!-- Acteur principal -->
                        <div class="mb-3">
                            <label for="actor" class="form-label">Acteur principal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="actor" name="actor" required>
                            <input type="hidden" name="actor_id" id="actor_id">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control bg-dark text-light" id="description" name="description" rows="3"></textarea>
                        </div>

                        <!-- Boutons -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="?element=media&action=list" class="btn btn-secondary w-100">Annuler</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning w-100">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Configuration de l'autocomplétion
    function setupAutocomplete(inputId, type) {
        $(inputId).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: 'ajax/search_persons.php',
                    dataType: 'json',
                    data: { term: request.term, type: type },
                    success: function(data) {
                        response(data.map(function(item) {
                            return {
                                label: item.name,
                                value: item.id
                            };
                        }));
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item.label);
                $(this).siblings('input[type="hidden"]').val(ui.item.value);
            }
        });
    }

    // Initialisation des autocompletions
    setupAutocomplete('#director', 'director');
    setupAutocomplete('#writer', 'writer');
    setupAutocomplete('#actor', 'actor');

    // Validation du formulaire
    $('form').on('submit', function(e) {
        if (!$('input[name="genres[]"]:checked').length) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un genre');
        }
    });
});
</script>

<style>
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    background-color: #343a40;
    border: 1px solid #495057;
}

.ui-menu-item {
    padding: 5px 10px;
    color: #fff;
    cursor: pointer;
}

.ui-menu-item:hover {
    background-color: #495057;
}

.form-check-input:checked + .form-check-label {
    color: #ffc107;
}
</style>