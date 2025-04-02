<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$db = require(dirname(__FILE__) . '/lib/mypdo.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinéma Portal - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style_login.css">
</head>
<body>
    <!-- Bordures film stylisées -->
    <div class="film-edge film-edge-left"></div>
    <div class="film-edge film-edge-right"></div>
    
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header text-white">
                <h1 class="h4">
                    <i class="fas fa-film me-2"></i>
                    Cinéma Portal
                </h1>
                <p class="tagline mb-0">L'accès privilégié à votre univers cinématographique</p>
            </div>
            
            <div class="card-body">
                <h2 class="h5 mb-4">Connexion</h2>
                
                <form action="check_login.php" method="POST">
                    <div class="mb-3">
                        <label for="uname" class="form-label">
                            <i class="fas fa-user-circle"></i>
                            Nom d'utilisateur
                        </label>
                        <input type="text" id="username" name="uname" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="psw" class="form-label">
                            <i class="fas fa-key"></i>
                            Mot de passe
                        </label>
                        <input type="password" id="password" name="psw" class="form-control" required>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <?php if (is_null($db)) { ?>
                            <button type="submit" class="btn btn-secondary" disabled>
                                <i class="fas fa-lock me-2"></i>Connexion indisponible
                            </button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Connexion
                            </button>
                        <?php } ?>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <a href="#" class="text-muted">Mot de passe oublié?</a>
                </div>
                
                <div class="stars-container">
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    if ($db) {
        $db = NULL;
    }
    if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['confirm'])) {
        foreach ($_SESSION['mesgs']['confirm'] as $mesg) {
    ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $mesg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
        unset($_SESSION['mesgs']['confirm']);
    }
    if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['errors'])) {
        foreach ($_SESSION['mesgs']['errors'] as $err) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $err; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php
        }
        unset($_SESSION['mesgs']['errors']);
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>