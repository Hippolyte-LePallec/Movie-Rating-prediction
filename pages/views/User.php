<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil Utilisateur</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-dark text-light">
        <div class="container-fluid mt-5">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header">
                    <h2 class="text-warning">Mon Profil</h2>
                </div>
                <div class="card-body">
                    <h5>
                        <strong>Nom d'utilisateur:</strong>
                        <?= htmlspecialchars($_SESSION['user']['username']) ?>
                    </h5>
                    <h5>
                        <strong>Prénom:</strong>
                        <?= htmlspecialchars($_SESSION['user']['firstname']) ?>
                    </h5>
                    <h5>
                        <strong>Nom:</strong>
                        <?= htmlspecialchars($_SESSION['user']['lastname']) ?>
                    </h5>

                    <h1 class="mt-4 text-warning">Films créés par l'utilisateur</h1>

                    <?php if (count($filmDetails) > 0): ?>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                            <?php foreach ($filmDetails as $film): ?>
                                <div class="col">
                                <div class="card h-100 bg-dark text-light border-secondary shadow-lg rounded cursor-pointer" onclick="window.location.href='./index.php?element=pages&action=Card&id=<?= urlencode($film['media_id']); ?>'">

<img src="<?= !empty($film['image_url']) ? $film['image_url'] : 'https://m.media-amazon.com/images/M/MV5BYzZlMjE5ZTgtNDU4Yi00NWE0LWIzN2UtZDI5OTc3ZjRiYmYyXkEyXkFqcGc@._V1_SX300.jpg' ?>" class="card-img-top rounded fixed-size-image" alt="Film poster">
<div class="card-body">
    <h5 class="card-title text-warning"><?= htmlspecialchars($film['primaryTitle']) ?></h5>
    <?php if ($film['isAdult'] == 1): ?>
        <span class="text-danger" title="Contenu Adulte">🔞</span>
    <?php endif; ?>
    <p class="card-text small"><?= htmlspecialchars($film['startYear']) ?></p>

    <p class="card-text">
        <strong>Genres:</strong>
        <span class="badge bg-secondary"><?= htmlspecialchars($film['genre_names']) ?></span>
    </p>

    <div class="d-flex justify-content-between align-items-center">
        <span class="badge bg-warning text-dark">★
            <?= htmlspecialchars($film['averageRating'] ?? 'N/A') ?>
        </span>
    </div>
</div>
</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>Aucun film créé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
