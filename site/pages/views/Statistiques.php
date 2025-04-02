<?php include('../../inc/head.php'); ?>
<?php include('../../inc/top.php'); ?>

<div class="dtitle w3-container w3-teal">
    <h2><?= "Statistiques des Films" ?></h2>
</div>
<div class="w3-container" style="max-width: 1000px; margin: auto;">

    <h3 class="w3-center">Analyse des performances par réalisateur et genre</h3>

    <div class="w3-row-padding">
        <div class="w3-half">
            <h4>Top Réalisateurs (par note moyenne)</h4>
            <div id="chart-realisateurs" style="width: 100%; height: 300px;"></div>
        </div>
        <div class="w3-half">
            <h4>Répartition par Genre</h4>
            <div id="chart-genres" style="width: 100%; height: 300px;"></div>
        </div>
    </div>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-full">
            <h4>Evolution du nombre de films par année</h4>
            <div id="chart-evolution" style="width: 100%; height: 300px;"></div>
        </div>
    </div>
</div>

<?php include('../../inc/footer.php'); ?>
