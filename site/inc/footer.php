</div>
<div style="clear:both;"></div>
<?php
if (isset($db)) {
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

<!-- Pied de page -->
<footer class="footer mt-auto py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="text-white">CinéCritique</h5>
                <p class="text-white-50">Votre plateforme d'évaluation de films et séries.</p>
                <div class="mt-2">
                    <a href="#" class="btn btn-sm btn-outline-light me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light me-2"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-3 mb-md-0">
                <h5 class="text-white">Explorer</h5>
                <ul class="list-unstyled">
                    <li><a href="?page=films" class="text-white-50">Films</a></li>
                    <li><a href="?page=series" class="text-white-50">Séries</a></li>
                    <li><a href="?page=statistiques" class="text-white-50">Statistiques</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-3 mb-md-0">
                <h5 class="text-white">Compte</h5>
                <ul class="list-unstyled">
                    <?php if (isset($_SESSION['utilisateur'])): ?>
                        <li><a href="?page=profil" class="text-white-50">Mon profil</a></li>
                        <li><a href="?deconnexion=1" class="text-white-50">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#connexionModal" class="text-white-50">Connexion</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#inscriptionModal" class="text-white-50">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-white">À propos</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50">Qui sommes-nous</a></li>
                    <li><a href="#" class="text-white-50">Mentions légales</a></li>
                    <li><a href="#" class="text-white-50">Politique de confidentialité</a></li>
                    <li><a href="#" class="text-white-50">Nous contacter</a></li>
                </ul>
            </div>
        </div>
        <hr class="border-light">
        <div class="text-center text-white-50">
            <small>&copy; 2025 CinéCritique - Tous droits réservés</small>
        </div>
    </div>
</footer>


</body>

</html>
