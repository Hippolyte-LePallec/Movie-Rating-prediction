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
      <h5 class="text-warning">Film & Style</h5>
      <p class="text-white-50">Votre plateforme d'évaluation de films</p>
  </div>
</footer>

</body>

</html>
