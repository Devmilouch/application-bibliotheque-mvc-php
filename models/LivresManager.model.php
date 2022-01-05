<?php
    require_once "PDOAccess.model.php";
    require_once "Livre.model.php";

    class LivresManager extends PDOAccess {
        private $tabLivres;

        function ajoutLivreDansTab($livre) {
            $this->tabLivres[] = $livre;
        }

        function getLivres() {return $this->tabLivres;}

        function chargementLivres() {
            $req = $this->getAccessBDD()->prepare("SELECT * FROM livres");
            $req->execute();
            $livres = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            foreach ($livres as $livre) {
                $l = new Livre($livre["id"], $livre["titre"], $livre["nbPages"], $livre["image"]);
                $this->ajoutLivreDansTab($l);
            }
        }

        function getLivreById($id) {
            for ($i = 0 ; count($this->tabLivres) ; $i++) {
                if ($this->tabLivres[$i]->getId() === $id) {
                    return $this->tabLivres[$i];
                }
            }
        }

        function ajoutLivreBDDetTab($titre, $nbPages, $image) {
            $req = "
            INSERT INTO livres (titre, nbPages, image)
            values (:titre, :nbPages, :image)";
            $stmt = $this->getAccessBDD()->prepare($req);
            $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
            $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
            $stmt->bindValue(":image", $image, PDO::PARAM_STR);
            $resultat = $stmt->execute();
            $stmt->closeCursor();

            if ($resultat > 0) {
                $livre = new Livre($this->getAccessBDD()->lastInsertId(), $titre, $nbPages, $image);
                $this->ajoutLivreDansTab($livre);

                $_SESSION["alert"] = [
                    "type" => "success",
                    "msg" => "Ajout réalisé !"
                ];
            }
        }

        function supprimerLivreBDDetTab($id) {
            $req = "
            Delete from livres where id = :idLivre
            ";
            $stmt = $this->getAccessBDD()->prepare($req);
            $stmt->bindValue(":idLivre", $id, PDO::PARAM_INT);
            $resultat = $stmt->execute();
            $stmt->closeCursor();
            if ($resultat > 0) {
                $nomImage = $this->getLivreById($id)->getImage();
                unlink("public/images/" . $nomImage);
                $livre = $this->getLivreById($id);
                unset($livre);

                $_SESSION["alert"] = [
                    "type" => "success",
                    "msg" => "Suppression réalisée !"
                ];
            }
        }

        function modificationLivreBDDetTab($id, $titre, $nbPages, $image) {
            $req = "
            Update livres
            set titre = :titre, nbPages = :nbPages, image = :image
            where id = :id
            ";
            $stmt = $this->getAccessBDD()->prepare($req);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
            $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
            $stmt->bindValue(":image", $image, PDO::PARAM_STR);
            $resultat = $stmt->execute();
            $stmt->closeCursor();

            if ($resultat > 0) {
                $this->getLivreById($id)->setTitre($titre);
                $this->getLivreById($id)->setNbPages($nbPages);
                $this->getLivreById($id)->setImage($image);

                $_SESSION["alert"] = [
                    "type" => "success",
                    "msg" => "Modification réalisée !"
                ];
            }
        }
    }
?>