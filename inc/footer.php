</div>
<div style="clear:both;"></div>
<?php
if (isset($db)) {
    $db = NULL;
    
}
if (isset($_SESSION['confirm'])) : ?>
    <div class="alert alert-success">
        <?= $_SESSION['confirm']; ?>
    </div>
    <?php unset($_SESSION['confirm']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['errors'])) : ?>
    <div class="alert alert-danger">
        <?php foreach ($_SESSION['errors'] as $error) : ?>
            <?= $error ?><br>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

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

<!-- Footer -->
<footer class="footer mt-auto py-4 bg-dark text-light">
  <div class="container">
    <div class="row">
      <!-- Section 1: Logo et description -->
      <div class="col-md-4 mb-3">
        <h5 class="text-warning">Film & Style</h5>
        <p class="text-white-50">Votre plateforme d'évaluation de films et séries.</p>
      </div>

      <!-- Section 2: Explorer -->
      <div class="col-md-2 mb-3">
        <h5 class="text-white">Explorer</h5>
        <ul class="list-unstyled">
          <li><a href="?page=films" class="text-white-50">Films</a></li>
          <li><a href="?page=series" class="text-white-50">Séries</a></li>
          <li><a href="?page=statistiques" class="text-white-50">Statistiques</a></li>
        </ul>
      </div>

      <!-- Section 3: Compte -->
      <div class="col-md-2 mb-3">
        <h5 class="text-white">Compte</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white-50">Connexion</a></li>
          <li><a href="#" class="text-white-50">Inscription</a></li>
        </ul>
      </div>

      <!-- Section 4: À propos -->
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
