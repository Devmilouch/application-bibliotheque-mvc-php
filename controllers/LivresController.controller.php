<?php
    require_once "models/LivresManager.model.php";

    class LivresController {
        private $livresManager;

        function __construct() {
            $this->livresManager = new LivresManager();
            $this->livresManager->chargementLivres();
        }

        function viewAfficherLesLivres() {
            $livres = $this->livresManager->getLivres();
            require "views/lesLivres.view.php";
            unset($_SESSION["alert"]);
        }

        function viewAfficherUnLivre($id) {
            $livre = $this->livresManager->getLivreById($id);
            require "views/afficherUnLivre.view.php";
        }
        
        function viewAjoutLivre() {
            require "views/ajoutLivre.view.php";
        }

        function ajoutLivreValidation() {
            $file = $_FILES["image"];
            $repertoire = "public/images/";
            $nomImage = $this->stockImageEtRetourneSonNom($file, $repertoire);
            $this->livresManager->ajoutLivreBDDetTab($_POST["titre"], $_POST["nbPages"], $nomImage);

            header('Location: '. URL . "les-livres");
        }

        private function stockImageEtRetourneSonNom($file, $dir){
            if(!isset($file['name']) || empty($file['name']))
                throw new Exception("Vous devez indiquer une image");
        
            if(!file_exists($dir)) mkdir($dir, 0777);
        
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $random = rand(0, 99999);
            $target_file = $dir.$random."_".$file['name'];
            
            if(!getimagesize($file["tmp_name"]))
                throw new Exception("Le fichier n'est pas une image");
            if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
                throw new Exception("L'extension du fichier n'est pas reconnu");
            if(file_exists($target_file))
                throw new Exception("Le fichier existe déjà");
            if($file['size'] > 500000)
                throw new Exception("Le fichier est trop gros");
            if(!move_uploaded_file($file['tmp_name'], $target_file))
                throw new Exception("l'ajout de l'image n'a pas fonctionné");
            else return ($random."_".$file['name']);
        }

        function supprimerLivre($id) {
            $this->livresManager->supprimerLivreBDDetTab($id);

            header('Location: '. URL . "les-livres");
        }

        function viewModificationLivre($id) {
            $livre = $this->livresManager->getLivreById($id);
            
            require "views/modifierLivre.view.php";
        }

        function modificationLivreValidation() {
            $nomImageActuelle = $this->livresManager->getLivreById($_POST["identifiant"])->getImage();
            $file = $_FILES["image"];

            if ($file["size"] > 0) {
                unlink("public/images/" . $nomImageActuelle);
                $repertoire = "public/images/";
                $nomNouvelleImage = $this->stockImageEtRetourneSonNom($file, $repertoire);
            } else {
                $nomNouvelleImage = $nomImageActuelle;
            }
            $this->livresManager->modificationLivreBDDetTab($_POST["identifiant"], $_POST["titre"], $_POST["nbPages"], $nomNouvelleImage);

            header('Location: '. URL . "les-livres");
        }
    }
?>