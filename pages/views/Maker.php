<?php
require_once __DIR__ . '/../../class/maker.class.php';

// Au début du fichier, après les includes
$maker = new Maker($db);
$directors = $maker->getDirectors();
$writers = $maker->getWriters();
$actors = $maker->getActors();
$genres = $maker->getGenres();
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header">
                    <h2 class="text-warning mb-0">Ajouter un nouveau média</h2>
                </div>
                <div class="card-body">
                    <form action="<?= $_SERVER['PHP_SELF'] . "?element=media&action=add" ?>" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="media_id">
                        
                        <!-- Informations de base du média -->
                        <div class="card mb-4 bg-dark border-secondary">
                            <div class="card-header">
                                <h5 class="text-warning mb-0"><i class="fas fa-film me-2"></i>Informations générales</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="primaryTitle" class="form-label">Titre primaire <span class="text-danger">*</span></label>
                                        <input class="form-control bg-dark text-light border-secondary" type="text" id="primaryTitle" name="primaryTitle" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir un titre.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="startYear" class="form-label">Année de sortie <span class="text-danger">*</span></label>
                                        <select class="form-select bg-dark text-light border-secondary" id="startYear" name="startYear" required>
                                            <option value="" selected disabled>Sélectionner...</option>
                                            <?php for($i = date('Y'); $i >= 1900; $i--): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Veuillez sélectionner une année.
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="runtimeMinutes" class="form-label">Durée (min) <span class="text-danger">*</span></label>
                                        <input class="form-control bg-dark text-light border-secondary" type="number" id="runtimeMinutes" name="runtimeMinutes" min="1" max="999" required>
                                        <div class="invalid-feedback">
                                            Veuillez saisir une durée valide.
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="isAdult" class="form-label">Contenu adulte</label>
                                        <select class="form-select bg-dark text-light border-secondary" id="isAdult" name="isAdult">
                                            <option value="0" selected>Non</option>
                                            <option value="1">Oui</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Genre(s) <span class="text-danger">*</span></label>
                                        <div class="row g-3">
                                            <?php foreach($genres as $genre): ?>
                                            <div class="col-md-3">
                                                <div class="form-check genre-check">
                                                    <input class="form-check-input" type="checkbox" name="genre[]" 
                                                           value="<?= $genre['id'] ?>" id="genre-<?= $genre['id'] ?>">
                                                    <label class="form-check-label" for="genre-<?= $genre['id'] ?>">
                                                        <?= htmlspecialchars($genre['name']) ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="invalid-feedback">
                                            Veuillez sélectionner au moins un genre.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="media_URL" class="form-label">URL du média</label>
                                        <input class="form-control bg-dark text-light border-secondary" type="url" id="media_URL" name="media_URL">
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <label for="post" class="form-label">Description</label>
                                    <textarea class="form-control bg-dark text-light border-secondary" id="post" name="post" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Réalisateurs (directeurs) -->
                        <div class="card mb-4 bg-dark border-secondary">
                            <div class="card-header">
                                <h5 class="text-warning mb-0"><i class="fas fa-video me-2"></i>Réalisateurs</h5>
                            </div>
                            <div class="card-body">
                                <div id="directeurs-container">
                                    <div class="directeur-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label">Rechercher un réalisateur</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-dark text-light border-secondary directeur-search search-input" 
                                                           placeholder="Rechercher un réalisateur..." data-type="director">
                                                    <input type="hidden" name="directeur_existant[]" class="directeur-id">
                                                    <button type="button" class="btn btn-outline-secondary new-entry-btn">Nouveau</button>
                                                </div>
                                            </div>
                                            <div class="col-md-5 new-fields" style="display:none;">
                                                <label class="form-label">Nom du réalisateur</label>
                                                <input type="text" class="form-control bg-dark text-light border-secondary" name="directeur_nom[]">
                                            </div>
                                            <div class="col-md-2 align-self-end">
                                                <button type="button" class="btn btn-outline-danger remove-entry" style="display:none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary mt-2" id="add-directeur">
                                    <i class="fas fa-plus me-2"></i>Ajouter un réalisateur
                                </button>
                            </div>
                        </div>
                        
                        <!-- Scénaristes -->
                        <div class="card mb-4 bg-dark border-secondary">
                            <div class="card-header">
                                <h5 class="text-warning mb-0"><i class="fas fa-pen-fancy me-2"></i>Scénaristes</h5>
                            </div>
                            <div class="card-body">
                                <div id="scenaristes-container">
                                    <div class="scenariste-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label">Rechercher un scénariste</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-dark text-light border-secondary scenariste-search search-input" 
                                                           placeholder="Rechercher un scénariste..." data-type="writer">
                                                    <input type="hidden" name="scenariste_existant[]" class="scenariste-id">
                                                    <button type="button" class="btn btn-outline-secondary new-entry-btn">Nouveau</button>
                                                </div>
                                            </div>
                                            <div class="col-md-5 new-fields" style="display:none;">
                                                <label class="form-label">Nom du scénariste</label>
                                                <input type="text" class="form-control bg-dark text-light border-secondary" name="scenariste_nom[]">
                                            </div>
                                            <div class="col-md-2 align-self-end">
                                                <button type="button" class="btn btn-outline-danger remove-entry" style="display:none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary mt-2" id="add-scenariste">
                                    <i class="fas fa-plus me-2"></i>Ajouter un scénariste
                                </button>
                            </div>
                        </div>
                        
                        <!-- Acteurs principaux -->
                        <div class="card mb-4 bg-dark border-secondary">
                            <div class="card-header">
                                <h5 class="text-warning mb-0"><i class="fas fa-user-friends me-2"></i>Acteurs principaux</h5>
                            </div>
                            <div class="card-body">
                                <div id="acteurs-container">
                                    <div class="acteur-entry mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Rechercher un acteur</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-dark text-light border-secondary acteur-search search-input" 
                                                           placeholder="Rechercher un acteur..." data-type="actor">
                                                    <input type="hidden" name="acteur_existant[]" class="acteur-id">
                                                    <button type="button" class="btn btn-outline-secondary new-entry-btn">Nouveau</button>
                                                </div>
                                            </div>
                                            <div class="col-md-3 new-fields" style="display:none;">
                                                <label class="form-label">Nom de l'acteur</label>
                                                <input type="text" class="form-control bg-dark text-light border-secondary" name="acteur_nom[]">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Ordre</label>
                                                <input type="number" class="form-control bg-dark text-light border-secondary" name="acteur_ordre[]" min="1" value="1">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Personnage</label>
                                                <input type="text" class="form-control bg-dark text-light border-secondary" name="acteur_personnage[]">
                                            </div>
                                            <div class="col-md-1 align-self-end">
                                                <button type="button" class="btn btn-outline-danger remove-entry" style="display:none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label">Catégorie</label>
                                                <select class="form-select bg-dark text-light border-secondary" name="acteur_categorie[]">
                                                    <option value="actor" selected>Acteur</option>
                                                    <option value="actress">Actrice</option>
                                                    <option value="self">Lui-même/Elle-même</option>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Job (optionnel)</label>
                                                <input type="text" class="form-control bg-dark text-light border-secondary" name="acteur_job[]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary mt-2" id="add-acteur">
                                    <i class="fas fa-plus me-2"></i>Ajouter un acteur
                                </button>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="?element=media&action=list" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Annuler
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="confirm" class="btn btn-warning w-100">
                                    <i class="fas fa-save me-2"></i>Enregistrer
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

// Validation personnalisée pour les cases à cocher des genres
document.querySelector('form').addEventListener('submit', function(event) {
    const genreCheckboxes = document.querySelectorAll('input[name="genre[]"]');
    const checked = Array.from(genreCheckboxes).some(cb => cb.checked);
    if (!checked) {
        event.preventDefault();
        event.stopPropagation();
        document.querySelector('#genre-action').closest('.col-md-12').classList.add('was-validated');
    }
});

$(document).ready(function() {
    // Fonction pour gérer l'ajout d'entrées
    function setupAddButton(addButtonId, containerClass, entryClass) {
        $(addButtonId).click(function() {
            const container = $(containerClass);
            const firstEntry = container.find(entryClass).first();
            const newEntry = firstEntry.clone();
            
            // Réinitialiser les valeurs
            newEntry.find('input[type="text"]').val('');
            newEntry.find('input[type="hidden"]').val('');
            newEntry.find('input[type="number"]').val('1');
            
            // Afficher le bouton de suppression
            const removeButton = newEntry.find('.remove-entry');
            removeButton.show();
            removeButton.click(function() {
                $(this).closest(entryClass).remove();
            });
            
            // Masquer les champs "nouveau"
            newEntry.find('.new-fields').hide();
            
            // Réinitialiser les sélecteurs
            newEntry.find('select').prop('selectedIndex', 0);
            
            // Réappliquer l'autocomplétion
            setupAutocomplete(newEntry.find('.search-input'));
            
            container.append(newEntry);
        });
    }

    // Configuration de l'autocomplétion
    function setupAutocomplete(selector) {
        selector.autocomplete({
            source: function(request, response) {
                const type = selector.data('type');
                $.ajax({
                    url: 'ajax/search_persons.php',
                    dataType: 'json',
                    data: {
                        term: request.term,
                        type: type
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
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

    // Initialisation des boutons d'ajout
    setupAddButton('#add-directeur', '#directeurs-container', '.directeur-entry');
    setupAddButton('#add-scenariste', '#scenaristes-container', '.scenariste-entry');
    setupAddButton('#add-acteur', '#acteurs-container', '.acteur-entry');

    // Configuration des boutons "Nouveau"
    $('.new-entry-btn').click(function() {
        $(this).closest('.entry').find('.new-fields').show();
        $(this).closest('.entry').find('.search-input').val('');
        $(this).closest('.entry').find('input[type="hidden"]').val('');
    });

    // Style des genres
    $('.form-check-label').addClass('text-light');
    $('.form-check-input').addClass('me-2');
    
    // Amélioration du style des cases à cocher des genres
    $('.form-check').addClass('mb-2 p-2').css({
        'background-color': '#2c3034',
        'border-radius': '5px',
        'border': '1px solid #6c757d'
    });

    // Initialisation de l'autocomplétion existante
    $('.search-input').each(function() {
        setupAutocomplete($(this));
    });
});
</script>