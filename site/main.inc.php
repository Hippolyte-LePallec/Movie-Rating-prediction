<?php
ob_start();
session_start();
include dirname(__FILE__) . "/inc/head.php";
?>
<div class="maincontent d-flex justify-content-center align-items-center">
    <?php
        include dirname(__FILE__) . "/inc/content.php";
    ?>
</div>
<?php
include dirname(__FILE__) . "/inc/footer.php";
ob_end_flush();