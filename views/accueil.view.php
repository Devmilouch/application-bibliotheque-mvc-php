<?php 
    ob_start();
?>

    <p class="text-center">Bienvenue sur la page d'accueil de la bibliothèque !</p>

<?php
    $titreH1 = "La bibliothèque";
    $content = ob_get_clean();
    require "template.php";
?>