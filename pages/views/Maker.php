<?php
require_once __DIR__ . '/../../class/personne.class.php';
require_once __DIR__ . '/../../class/genre.class.php';

// Afficher toutes les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Instanciation des objets
$personne = new Personne($db);
$genre = new Genre($db);
$genres = $genre->fetchAll();

// Traitement de la recherche
$searchResult = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];
    $type = $_POST['search_type'];

    // Recherche en fonction du type
    switch ($type) {
        case 'director':
            $searchResult = $personne->searchPersons($searchTerm);  // Search directors by name
            break;
        case 'writer':
            $searchResult = $personne->searchPersons($searchTerm);  // Search writers by name
            break;
        case 'actor':
            $searchResult = $personne->searchPersons($searchTerm);  // Search actors by name
            break;
    }
}
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light">
                <div class="card-header">
                    <h3 class="text-warning mb-0">Ajouter un média</h3>
                </div>
                <div class="card-body">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>?element=pages&action=Maker" method="post" class="needs-validation" novalidate>
                        <!-- Informations de base -->
                        <div class="mb-3">
                            <label for="primaryTitle" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="primaryTitle" name="primaryTitle" required>
                        </div>

                        <!-- Sélection de l'année -->
                        <div class="mb-3">
                            <label for="startYear" class="form-label">Année <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-dark text-light" id="startYear" name="startYear" min="1900" max="<?= date('Y') ?>" required>
                        </div>

                        <!-- Sélection de la durée -->
                        <div class="mb-3">
                            <label for="runtimeMinutes" class="form-label">Durée (min) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-dark text-light" id="runtimeMinutes" name="runtimeMinutes" min="1" max="600" required>
                            <small class="text-light">Durée en minutes (max 600 minutes)</small>
                        </div>

                        <!-- Genres -->
                        <div class="mb-3">
                            <label class="form-label">Genres <span class="text-danger">*</span></label>
                            <div class="row">
                                <?php foreach ($genres as $genre): ?>
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="genres[]" value="<?= $genre['genre_id'] ?>" id="genre<?= $genre['genre_id'] ?>">
                                            <label class="form-check-label text-light" for="genre<?= $genre['genre_id'] ?>">
                                                <?= htmlspecialchars($genre['genre_name']) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Réalisateur -->
                        <div class="mb-3">
                            <label for="director" class="form-label">Réalisateur <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="director" name="director" value="<?= isset($_POST['director']) ? htmlspecialchars($_POST['director']) : '' ?>" required>
                            <input type="hidden" name="director_id" id="director_id" value="<?= isset($_POST['director_id']) ? $_POST['director_id'] : '' ?>">

                            <!-- Recherche pour le réalisateur -->
                            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?element=pages&action=Maker">
                                <input type="text" name="search_term" class="form-control bg-dark text-light" placeholder="Rechercher un réalisateur">
                                <input type="hidden" name="search_type" value="director">
                                <button type="submit" class="btn btn-secondary">Rechercher</button>
                            </form>
                            <?php if ($searchResult && $_POST['search_type'] == 'director'): ?>
                                <ul class="list-group mt-2">
                                    <?php foreach ($searchResult as $person): ?>
                                        <li class="list-group-item">
                                            <a href="javascript:void(0);" onclick="document.getElementById('director').value = '<?= htmlspecialchars($person['primaryName']) ?>'; document.getElementById('director_id').value = '<?= $person['perso_id'] ?>';">
                                                <?= htmlspecialchars($person['primaryName']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Scénariste -->
                        <div class="mb-3">
                            <label for="writer" class="form-label">Scénariste <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="writer" name="writer" value="<?= isset($_POST['writer']) ? htmlspecialchars($_POST['writer']) : '' ?>" required>
                            <input type="hidden" name="writer_id" id="writer_id" value="<?= isset($_POST['writer_id']) ? $_POST['writer_id'] : '' ?>">

                            <!-- Recherche pour le scénariste -->
                            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?element=pages&action=Maker">
                                <input type="text" name="search_term" class="form-control bg-dark text-light" placeholder="Rechercher un scénariste">
                                <input type="hidden" name="search_type" value="writer">
                                <button type="submit" class="btn btn-secondary">Rechercher</button>
                            </form>
                            <?php if ($searchResult && $_POST['search_type'] == 'writer'): ?>
                                <ul class="list-group mt-2">
                                    <?php foreach ($searchResult as $person): ?>
                                        <li class="list-group-item">
                                            <a href="javascript:void(0);" onclick="document.getElementById('writer').value = '<?= htmlspecialchars($person['primaryName']) ?>'; document.getElementById('writer_id').value = '<?= $person['perso_id'] ?>';">
                                                <?= htmlspecialchars($person['primaryName']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Acteur principal -->
                        <div class="mb-3">
                            <label for="actor" class="form-label">Acteur principal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-light" id="actor" name="actor" value="<?= isset($_POST['actor']) ? htmlspecialchars($_POST['actor']) : '' ?>" required>
                            <input type="hidden" name="actor_id" id="actor_id" value="<?= isset($_POST['actor_id']) ? $_POST['actor_id'] : '' ?>">

                            <!-- Recherche pour l'acteur -->
                            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?element=pages&action=Maker">
                                <input type="text" name="search_term" class="form-control bg-dark text-light" placeholder="Rechercher un acteur">
                                <input type="hidden" name="search_type" value="actor">
                                <button type="submit" class="btn btn-secondary">Rechercher</button>
                            </form>
                            <?php if ($searchResult && $_POST['search_type'] == 'actor'): ?>
                                <ul class="list-group mt-2">
                                    <?php foreach ($searchResult as $person): ?>
                                        <li class="list-group-item">
                                            <a href="javascript:void(0);" onclick="document.getElementById('actor').value = '<?= htmlspecialchars($person['primaryName']) ?>'; document.getElementById('actor_id').value = '<?= $person['perso_id'] ?>';">
                                                <?= htmlspecialchars($person['primaryName']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
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
