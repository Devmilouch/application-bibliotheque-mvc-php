<?php
    ob_start(); 
?>
    <?php if(!empty($_SESSION["alert"])) : ?>
        <div class="alert alert-<?= $_SESSION["alert"]["type"] ?>" role="alert">
            <?= $_SESSION["alert"]["msg"] ?>
        </div>
    <?php endif; ?>

    <table class="table text-center">
        <tr class="table-dark">
            <th>Image</th>
            <th>Titre</th>
            <th>Nombre de pages</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php for ($i = 0 ; $i < count($livres) ; $i++) : ?>
        <tr>
            <td class="align-middle"><img src="public/images/<?=  $livres[$i]->getImage() ?>" alt="La couverture du livre" width="60px"/></td>
            <td class="align-middle"><a href="<?= URL ?>les-livres/l/<?= $livres[$i]->getId(); ?>"><?=  $livres[$i]->getTitre() ?></a></td>
            <td class="align-middle"><?=  $livres[$i]->getNbPages() ?></td>
            <td class="align-middle"><a href="<?= URL ?>les-livres/m/<?= $livres[$i]->getId(); ?>" class="btn btn-warning">Modifier</a></td>
            <td class="align-middle">
                <form method="POST" action="<?= URL ?>les-livres/s/<?= $livres[$i]->getId(); ?>" onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                    <button class="btn btn-danger" type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endfor; ?>
    </table>
    <a href="<?= URL ?>les-livres/a" class="btn btn-success d-block">Ajouter</a>

<?php
    $titreH1 = "Les livres de la bibliothèque";
    $content = ob_get_clean();
    require "template.php";
?>