<?php 
    ob_start();
?>

    <p class="text-center"><?= $msg ?></p>

<?php
    $titreH1 = "Erreur 404 !";
    $content = ob_get_clean();
    require "template.php";
?>