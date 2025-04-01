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
    <title>Connexion</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>
</head>

<body>
    <div class="maincontent w3-display-container w3-center">
        <div class="dtitle w3-container w3-teal">
            <h1>Bienvenue sur le portail de votre projet !</h1>
        </div>

        <h1>Connexion</h1>
        <form action="check_login.php" method="POST">
            <div class="container">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <br>
                <?php if (is_null($db)) { ?>
                    <button type="submit" disabled>Impossible de Se connecter</button>
                <?php } else { ?>
                    <button type="submit">Se connecter</button>
                <?php } ?>
            </div>
        </form>
    </div>
    <div style="clear:both;"></div>
    <?php
    if ($db) {
        $db = NULL;
    }
    if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['confirm'])) {
        foreach ($_SESSION['mesgs']['confirm'] as $mesg) {
    ?>
            <div class="alertbox messagebox">
                <span class="closebtn">&times;</span>
                <?= $mesg; ?>
            </div>
        <?php
        }
        unset($_SESSION['mesgs']['confirm']);
    }
    if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['errors'])) {
        foreach ($_SESSION['mesgs']['errors'] as $err) {
        ?>
            <div class="alertbox errorbox">
                <span class="closebtn">&times;</span>
                <?= $err; ?>
            </div>
    <?php
        }
        unset($_SESSION['mesgs']['errors']);
    }
    ?>

    <script>
        // Get all elements with class="closebtn"
        var close = document.getElementsByClassName("closebtn");
        var i;

        // Loop through all close buttons
        for (i = 0; i < close.length; i++) {
            // When someone clicks on a close button
            close[i].onclick = function() {

                // Get the parent of <span class="closebtn"> (<div class="alert">)
                var div = this.parentElement;

                // Set the opacity of div to 0 (transparent)
                div.style.opacity = "0";

                // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
                setTimeout(function() {
                    div.style.display = "none";
                }, 600);
            }
        }
    </script>
    <footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
        <i class="fab fa-facebook w3-hover-opacity" aria-hidden="true"></i>
        <i class="fab fa-instagram w3-hover-opacity" aria-hidden="true"></i>
        <i class="fab fa-snapchat w3-hover-opacity" aria-hidden="true"></i>
        <i class="fab fa-pinterest-p w3-hover-opacity" aria-hidden="true"></i>
        <i class="fab fa-twitter w3-hover-opacity" aria-hidden="true"></i>
        <i class="fab fa-linkedin w3-hover-opacity" aria-hidden="true"></i>
        <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </footer>

</body>

</html>