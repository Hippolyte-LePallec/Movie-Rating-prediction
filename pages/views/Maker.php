<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10"> <!-- Augmenté la largeur pour donner plus d'espace -->
            <div class="card bg-dark text-light">
                <div class="card-header">
                    <h3 class="text-warning mb-0">Ajouter un média</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?element=pages&action=Prediction" method="POST" class="needs-validation" novalidate id="mediaForm">
                        <!-- Informations de base -->
                        <div class="mb-3">
                            <label for="primaryTitle" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="primaryTitle" name="primaryTitle" value="<?= isset($formData['primaryTitle']) ? htmlspecialchars($formData['primaryTitle']) : '' ?>" required>
                        </div>

                        <div class="row">
                            <!-- Sélection de l'année -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startYear" class="form-label">Année <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control bg-dark text-light" id="startYear" name="startYear" min="1900" max="<?= date('Y') ?>" value="<?= isset($formData['startYear']) ? htmlspecialchars($formData['startYear']) : '' ?>" required>
                                </div>
                            </div>

                            <!-- Sélection de la durée -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="runtimeMinutes" class="form-label">Durée (min) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control bg-dark text-light" id="runtimeMinutes" name="runtimeMinutes" min="1" max="600" value="<?= isset($formData['runtimeMinutes']) ? htmlspecialchars($formData['runtimeMinutes']) : '' ?>" required>
                                    <small class="text-muted">Durée en minutes (max 600 minutes)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Film pour adulte (Switch) - Style simplifié -->
                        <div class="mb-3">
                            <div class="card bg-dark border-warning mb-3">
                                <div class="card-body py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="text-warning mb-0">Film pour adulte</h5>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="isAdult" name="isAdult" value="1" <?= isset($formData['isAdult']) ? 'checked' : '' ?>>
                                            <label class="form-check-label text-light ms-2" for="isAdult">Contenu réservé aux adultes</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Genres - Style amélioré -->
                        <div class="mb-3">
                            <label class="form-label">Genres <span class="text-danger">*</span></label>
                            <div class="card bg-dark border-warning">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($genres as $genre): ?>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="genres[]" value="<?= $genre['genre_id'] ?>" id="genre<?= $genre['genre_id'] ?>"
                                                    <?= isset($formData['genres']) && in_array($genre['genre_id'], $formData['genres']) ? 'checked' : '' ?>>
                                                    <label class="form-check-label text-light" for="genre<?= $genre['genre_id'] ?>">
                                                        <?= htmlspecialchars($genre['genre_name']) ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section commune pour la recherche de personnes -->
                        <div class="mb-4">
                            <div class="card bg-dark border-warning">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="text-warning mb-0">Recherche de personnes</h5>
                                    <?php if ($showSearchResults): ?>
                                        <button type="button" id="hideSearchResults" class="btn btn-sm btn-outline-warning">Masquer les résultats</button>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <input type="text" id="searchPersonInput" name="search_term" class="form-control bg-dark text-light" placeholder="Rechercher une personne" value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>">
                                        <select class="form-select bg-dark text-light" name="search_type" id="searchType">
                                            <option value="director" <?= isset($_POST['search_type']) && $_POST['search_type'] == 'director' ? 'selected' : '' ?>>Réalisateur</option>
                                            <option value="writer" <?= isset($_POST['search_type']) && $_POST['search_type'] == 'writer' ? 'selected' : '' ?>>Scénariste</option>
                                            <option value="actor" <?= isset($_POST['search_type']) && $_POST['search_type'] == 'actor' ? 'selected' : '' ?>>Acteur</option>
                                        </select>
                                        <button type="button" class="btn btn-warning" id="searchPersonBtn">Rechercher</button>
                                    </div>

                                    <!-- Résultats de recherche -->
                                    <div id="searchResultsContainer" class="<?= $showSearchResults ? '' : 'd-none' ?>">
                                        <?php if (!empty($searchResult)): ?>
                                            <div class="search-results p-2 mb-3 border border-warning rounded">
                                                <h5 class="text-warning">Résultats de la recherche</h5>
                                                <ul class="list-group">
                                                    <?php foreach ($searchResult as $person): ?>
                                                        <li class="list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center">
                                                            <span class="text-truncate me-2"><?= htmlspecialchars($person['primaryName']) ?></span>
                                                            <button type="button" class="btn btn-sm btn-outline-warning add-person" 
                                                                data-id="<?= $person['perso_id'] ?>" 
                                                                data-name="<?= htmlspecialchars($person['primaryName']) ?>" 
                                                                data-type="<?= isset($_POST['search_type']) ? $_POST['search_type'] : 'director' ?>">
                                                                +
                                                            </button>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sections pour les personnes sélectionnées -->
                        <div class="row mb-3">
                            <!-- Réalisateurs -->
                            <div class="col-md-4">
                                <div class="card bg-dark border-warning h-100">
                                    <div class="card-header bg-dark text-warning">
                                        <h5 class="mb-0">Réalisateurs</h5>
                                    </div>
                                    <div class="card-body p-2">
                                        <ul class="list-group selected-directors-list">
                                            <?php if (isset($selectedDirectors) && !empty($selectedDirectors)): ?>
                                                <?php foreach ($selectedDirectors as $index => $directorData): ?>
                                                    <?php
                                                    list($directorId, $directorName) = explode('|', $directorData);
                                                    ?>
                                                    <li class="list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center">
                                                        <span class="text-truncate me-2"><?= htmlspecialchars($directorName) ?></span>
                                                        <input type="hidden" name="directors[]" value="<?= $directorId ?>|<?= htmlspecialchars($directorName) ?>">
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-person">×</button>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Scénaristes -->
                            <div class="col-md-4">
                                <div class="card bg-dark border-warning h-100">
                                    <div class="card-header bg-dark text-warning">
                                        <h5 class="mb-0">Scénaristes</h5>
                                    </div>
                                    <div class="card-body p-2">
                                        <ul class="list-group selected-writers-list">
                                            <?php if (isset($selectedWriters) && !empty($selectedWriters)): ?>
                                                <?php foreach ($selectedWriters as $index => $writerData): ?>
                                                    <?php
                                                    list($writerId, $writerName) = explode('|', $writerData);
                                                    ?>
                                                    <li class="list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center">
                                                        <span class="text-truncate me-2"><?= htmlspecialchars($writerName) ?></span>
                                                        <input type="hidden" name="writers[]" value="<?= $writerId ?>|<?= htmlspecialchars($writerName) ?>">
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-person">×</button>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Acteurs -->
                            <div class="col-md-4">
                                <div class="card bg-dark border-warning h-100">
                                    <div class="card-header bg-dark text-warning">
                                        <h5 class="mb-0">Acteurs</h5>
                                    </div>
                                    <div class="card-body p-2">
                                        <ul class="list-group selected-actors-list">
                                            <?php if (isset($selectedActors) && !empty($selectedActors)): ?>
                                                <?php foreach ($selectedActors as $index => $actorData): ?>
                                                    <?php
                                                    list($actorId, $actorName) = explode('|', $actorData);
                                                    ?>
                                                    <li class="list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center">
                                                        <span class="text-truncate me-2"><?= htmlspecialchars($actorName) ?></span>
                                                        <input type="hidden" name="actors[]" value="<?= $actorId ?>|<?= htmlspecialchars($actorName) ?>">
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-person">×</button>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control bg-dark text-light" id="description" name="description" rows="3"><?= isset($formData['description']) ? htmlspecialchars($formData['description']) : '' ?></textarea>
                        </div>

                        <!-- Boutons - Taille réduite -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="?element=media&action=list" class="btn btn-secondary w-100">Annuler</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning w-100">Prédire</button>
                            </div>
                        </div>

                        <!-- Champ caché pour maintenir la position de la page -->
                        <input type="hidden" name="scrollPosition" id="scrollPosition" value="0">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Restaurer la position de défilement
    if ('<?= isset($_POST['scrollPosition']) ?>') {
        window.scrollTo(0, <?= isset($_POST['scrollPosition']) ? intval($_POST['scrollPosition']) : 0 ?>);
    }
    
    // Enregistrer la position de défilement avant la soumission du formulaire
    document.getElementById('mediaForm').addEventListener('submit', function() {
        document.getElementById('scrollPosition').value = window.pageYOffset || document.documentElement.scrollTop;
    });
    
    // Masquer les résultats de recherche
    const hideSearchBtn = document.getElementById('hideSearchResults');
    if (hideSearchBtn) {
        hideSearchBtn.addEventListener('click', function() {
            document.getElementById('searchResultsContainer').classList.add('d-none');
            this.classList.add('d-none');
        });
    }
    
    // Fonction pour vérifier si une personne existe déjà dans une liste
    function personExistsInList(personId, listSelector) {
        const existingInputs = document.querySelectorAll(`${listSelector} input[type="hidden"]`);
        for (let input of existingInputs) {
            const value = input.value;
            const id = value.split('|')[0];
            if (id === personId) {
                return true;
            }
        }
        return false;
    }
    
    // Gestionnaire pour la recherche de personnes
    document.getElementById('searchPersonBtn').addEventListener('click', function() {
        const searchTerm = document.getElementById('searchPersonInput').value;
        const searchType = document.getElementById('searchType').value;
        
        // Créer les données du formulaire
        const formData = new FormData();
        formData.append('search_term', searchTerm);
        formData.append('search_type', searchType);
        
        // Envoyer la requête AJAX
        fetch('index.php?element=pages&action=Maker', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            // Créer un DOM temporaire pour extraire les résultats
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const searchResults = doc.querySelector('#searchResultsContainer');
            
            if (searchResults) {
                // Mettre à jour les résultats de recherche
                document.getElementById('searchResultsContainer').innerHTML = searchResults.innerHTML;
                document.getElementById('searchResultsContainer').classList.remove('d-none');
                
                // Réattacher les écouteurs d'événements aux nouveaux boutons
                attachAddPersonListeners();
            }
        })
        .catch(error => console.error('Erreur:', error));
    });

    // Fonction pour attacher les écouteurs d'événements aux boutons d'ajout
    function attachAddPersonListeners() {
        document.querySelectorAll('.add-person').forEach(function(button) {
            button.addEventListener('click', function() {
                let personId = this.getAttribute('data-id');
                let personName = this.getAttribute('data-name');
                let personType = this.getAttribute('data-type');
                let listContainer;
                let listSelector;
                
                // Sélectionner la liste appropriée en fonction du type
                if (personType === 'director') {
                    listContainer = document.querySelector('.selected-directors-list');
                    listSelector = '.selected-directors-list';
                } else if (personType === 'writer') {
                    listContainer = document.querySelector('.selected-writers-list');
                    listSelector = '.selected-writers-list';
                } else if (personType === 'actor') {
                    listContainer = document.querySelector('.selected-actors-list');
                    listSelector = '.selected-actors-list';
                }
                
                // Vérifier si la personne existe déjà dans la liste
                if (personExistsInList(personId, listSelector)) {
                    alert('Cette personne est déjà ajoutée à la liste !');
                    return;
                }
                
                // Créer un nouvel élément de liste pour la personne
                let listItem = document.createElement('li');
                listItem.className = 'list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center';
                
                // Créer un span pour le nom avec text-truncate pour gérer les noms longs
                let nameSpan = document.createElement('span');
                nameSpan.className = 'text-truncate me-2';
                nameSpan.textContent = personName;
                
                // Créer l'input caché
                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = personType + 's[]';
                hiddenInput.value = personId + '|' + personName;
                
                // Créer le bouton de suppression
                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-sm btn-outline-danger remove-person';
                removeButton.textContent = '×';
                
                // Ajouter les éléments à l'élément de liste
                listItem.appendChild(nameSpan);
                listItem.appendChild(hiddenInput);
                listItem.appendChild(removeButton);
                
                // Ajouter l'élément à la liste
                listContainer.appendChild(listItem);
                
                // Ajouter un gestionnaire d'événements pour le bouton de suppression
                removeButton.addEventListener('click', function() {
                    listItem.remove();
                });
            });
        });
    }
    
    // Recherche de personne - ajouter au formulaire sans recharger
    document.querySelectorAll('.add-person').forEach(function(button) {
        button.addEventListener('click', function() {
            let personId = this.getAttribute('data-id');
            let personName = this.getAttribute('data-name');
            let personType = this.getAttribute('data-type');
            let listContainer;
            let listSelector;
            
            // Sélectionner la liste appropriée en fonction du type
            if (personType === 'director') {
                listContainer = document.querySelector('.selected-directors-list');
                listSelector = '.selected-directors-list';
            } else if (personType === 'writer') {
                listContainer = document.querySelector('.selected-writers-list');
                listSelector = '.selected-writers-list';
            } else if (personType === 'actor') {
                listContainer = document.querySelector('.selected-actors-list');
                listSelector = '.selected-actors-list';
            }
            
            // Vérifier si la personne existe déjà dans la liste
            if (personExistsInList(personId, listSelector)) {
                alert('Cette personne est déjà ajoutée à la liste !');
                return;
            }
            
            // Créer un nouvel élément de liste pour la personne
            let listItem = document.createElement('li');
            listItem.className = 'list-group-item bg-dark text-light border-secondary d-flex justify-content-between align-items-center';
            
            // Créer un span pour le nom avec text-truncate pour gérer les noms longs
            let nameSpan = document.createElement('span');
            nameSpan.className = 'text-truncate me-2';
            nameSpan.textContent = personName;
            
            // Créer l'input caché
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = personType + 's[]';
            hiddenInput.value = personId + '|' + personName;
            
            // Créer le bouton de suppression
            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-sm btn-outline-danger remove-person';
            removeButton.textContent = '×';
            
            // Ajouter les éléments à l'élément de liste
            listItem.appendChild(nameSpan);
            listItem.appendChild(hiddenInput);
            listItem.appendChild(removeButton);
            
            // Ajouter l'élément à la liste
            listContainer.appendChild(listItem);
            
            // Ajouter un gestionnaire d'événements pour le bouton de suppression
            removeButton.addEventListener('click', function() {
                listItem.remove();
            });
        });
    });
    
    // Supprimer une personne de la liste
    document.querySelectorAll('.remove-person').forEach(function(button) {
        button.addEventListener('click', function() {
            this.closest('li').remove();
        });
    });
});

// Validation du formulaire avant soumission
document.getElementById('mediaForm').addEventListener('submit', function(event) {
    let form = event.target;
    
    // Vérifier si les champs requis sont remplis
    if (!form.primaryTitle.value || 
        !form.startYear.value ||
        !form.runtimeMinutes.value) {
        event.preventDefault();
        alert('Veuillez remplir tous les champs obligatoires');
        return;
    }

    // Vérifier qu'au moins un genre est sélectionné
    let genres = form.querySelectorAll('input[name="genres[]"]:checked');
    if (genres.length === 0) {
        event.preventDefault(); 
        alert('Veuillez sélectionner au moins un genre');
        return;
    }
});
</script>

<style>
/* Style de base pour le formulaire */
.card {
    border-radius: 8px;
}

.card-header {
    border-bottom: 1px solid rgba(255, 193, 7, 0.3);
}

/* Style simplifié pour le switch */
.form-switch .form-check-input {
    width: 2.5em;
    height: 1.2em;
    margin-top: 0.25rem;
    background-color: #495057;
    border-color: #6c757d;
    cursor: pointer;
}

.form-switch .form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

/* Style amélioré pour la sélection des genres */
.form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

/* Style pour les bordures */
.border-secondary {
    border-color: rgba(255, 193, 7, 0.5) !important;
}

.list-group-item {
    margin-bottom: 4px;
    padding: 0.5rem 0.75rem;
    font-size: 0.95rem;
    border-radius: 4px !important;
    border-color: rgba(255, 193, 7, 0.5) !important;
}

.form-control, .form-select {
    border-color: rgba(255, 193, 7, 0.5);
}

.input-group .form-control,
.input-group .btn,
.input-group .form-select {
    display: flex;
    align-items: center;
    margin: 0;
    border-radius: 0;
    border-color: rgba(255, 193, 7, 0.5);
}

/* Style pour les listes de personnes */
.list-group-item {
    margin-bottom: 4px;
    padding: 0.5rem 0.75rem;
    font-size: 0.95rem;
    border-radius: 4px !important;
}

/* Style pour les boutons d'ajout et de suppression */
.remove-person, .add-person {
    padding: 0 6px;
    font-size: 14px;
    line-height: 1;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Style pour les boutons */
.btn {
    font-size: 0.95rem;
    padding: 0.375rem 0.75rem;
    border-radius: 4px;
}

.btn-sm {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

/* Style pour le focus des inputs */
.form-control:focus, .form-select:focus, .form-check-input:focus {
    border-color: rgba(255, 193, 7, 0.5);
    box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
}

/* Amélioration des cartes pour les personnes */
.card-header.bg-dark {
    background-color: #1a1a1a !important;
}

.border-warning {
    border-color: rgba(255, 193, 7, 0.5) !important;
}

/* Style pour les textes d'aide */
.text-muted {
    color: #adb5bd !important;
    font-size: 0.8rem;
}

/* Style pour le select et l'input group */
.input-group {
    align-items: center;
}

.input-group > * {
    height: 36px !important;
    line-height: 1;
}

.form-select {
    width: auto;
    min-width: 120px;
    font-size: 0.9rem;
    padding: 0.375rem 2rem 0.375rem 0.75rem;
}

.input-group .form-control,
.input-group .btn,
.input-group .form-select {
    display: flex;
    align-items: center;
    margin: 0;
    border-radius: 0;
}

.input-group .form-control:first-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.input-group .btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

/* Ajuster la taille de l'input group */
.input-group {
    align-items: stretch;
}

.input-group .form-control,
.input-group .btn {
    height: calc(1.8rem + 2px);
    font-size: 0.9rem;
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
}
</style>