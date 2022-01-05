<?php 
    ob_start();
?>

    <form method="POST" action="<?= URL ?>les-livres/av" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre : </label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="nbPages">Nombre de pages : </label>
            <input type="number" class="form-control" id="nbPages" name="nbPages" required>
        </div>
        <div class="form-group">
            <label for="image">Image : </label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>

<?php
    $titreH1 = "Ajout d'un livre";
    $content = ob_get_clean();
    require "template.php";
?>