<?php
    session_start();

    define("URL", str_replace("index.php", "", (isset($_SERVER["HTTPS"]) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

    require_once "controllers/LivresController.controller.php";
    $livresController = new LivresController();

    try {
        if (empty($_GET["page"])) {
            require "views/accueil.view.php";
        } else {
            $url = explode("/", filter_var($_GET["page"]), FILTER_SANITIZE_URL);
    
            switch($url[0]) {
                case "accueil": require "views/accueil.view.php";
                break;
                case "les-livres":
                    if (empty($url[1])) {
                        $livresController->viewAfficherLesLivres();
                    } else if ($url[1] === "l" && isset($url[2])) {
                        $livresController->viewAfficherUnLivre($url[2]);
                    } else if ($url[1] === "a") {
                        $livresController->viewAjoutLivre();
                    } else if ($url[1] === "m" && isset($url[2])) {
                        $livresController->viewModificationLivre($url[2]);
                    } else if ($url[1] === "s" && isset($url[2])) {
                        $livresController->supprimerLivre($url[2]);
                    } else if ($url[1] === "av") {
                        $livresController->ajoutLivreValidation();
                    } else if ($url[1] === "mv") {
                        $livresController->modificationLivreValidation();
                    } else {
                        throw new Exception("La page n'existe pas !");
                    }
                break;
                default: throw new Exception("La page n'existe pas !");
            }
        }
    }
    catch(Exception $e) {
        $msg = $e->getMessage();
        require "views/errorPage.view.php";
    }
?>