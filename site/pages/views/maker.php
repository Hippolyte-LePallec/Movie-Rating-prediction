<?php include('../../inc/head.php'); ?>
<?php include('../../inc/top.php'); ?>

<div class="dtitle w3-container w3-teal">
    <h2><?= "Film Maker" ?></h2>
</div>
<div class="w3-container" style="max-width: 1000px; margin: auto;">
    <form action="<?= $_SERVER['PHP_SELF'] . "?element=films&action=add" ?>" method="post" class="w3-container w3-card-4 w3-light-grey">
        <input type="hidden" name="film_id">
        <h3 class="w3-center">Veuillez remplir les informations ci-dessous</h3>

        <fieldset class="w3-margin-bottom">
            <legend class="w3-text-teal"><strong>Informations du film</strong></legend>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="titre">Titre :</label>
                    <input class="w3-input w3-border" type="text" id="titre" name="titre" required>
                </div>
                <div class="w3-half">
                    <label for="realisateur">Réalisateur :</label>
                    <input class="w3-input w3-border" type="text" id="realisateur" name="realisateur" required>
                </div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="date_sortie">Date de sortie :</label>
                    <input class="w3-input w3-border" type="date" id="date_sortie" name="date_sortie" required>
                </div>
                <div class="w3-half">
                    <label for="genre">Genre :</label>
                    <input class="w3-input w3-border" type="text" id="genre" name="genre" required>
                </div>
            </div>
        </fieldset>

        <fieldset class="w3-margin-bottom">
            <legend class="w3-text-teal"><strong>Synopsis</strong></legend>
            <div class="w3-row-padding">
                <div class="w3-full">
                    <label for="synopsis">Résumé :</label>
                    <textarea class="w3-input w3-border" id="synopsis" name="synopsis" required></textarea>
                </div>
            </div>
        </fieldset>

        <div class="w3-center">
            <input class="w3-button w3-teal" type="submit" name="confirm">
        </div>

    </form>
</div>

<?php include('../../inc/footer.php'); ?>
