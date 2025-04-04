<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$db = require(dirname(__FILE__) . '/lib/mypdo.php');
require_once(dirname(__FILE__) . '/class/user.class.php');


$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];

    if ($db) {
        $user = new User($db, null);
        $result = $user->createUser($username, $password, $firstname, $lastname);

        if ($result === "Utilisateur créé avec succès.") {
            $_SESSION['mesgs']['confirm'][] = $result;
            header("Location: login.php");
            exit;
        } else {
            $message = $result;
        }
    } else {
        $message = "Erreur de connexion à la base de données.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinéma Portal - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
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
                <p class="tagline mb-0">Rejoignez votre univers cinématographique</p>
            </div>
            
            <div class="card-body">
                <h2 class="h5 mb-4">Inscription</h2>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user-circle"></i> Nom d'utilisateur
                        </label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="firstname" class="form-label">
                            <i class="fas fa-id-card"></i> Prénom
                        </label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label">
                            <i class="fas fa-id-card-alt"></i> Nom de famille
                        </label>
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-key"></i> Mot de passe
                        </label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i> S'inscrire
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="text-muted">Déjà un compte? Connectez-vous</a>
                </div>

                <div class="stars-container mt-3">
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
