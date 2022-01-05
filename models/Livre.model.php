<?php
    class Livre {
        private $id;
        private $titre;
        private $nbPages;
        private $image;

        function __construct($id, $titre, $nbPages, $image) {
            $this->id = $id;
            $this->titre = $titre;
            $this->nbPages = $nbPages;
            $this->image = $image;
        }

        function getId() {return $this->id;}
        function setId($id) {$this->id = $id;}

        function getTitre() {return $this->titre;}
        function setTitre($titre) {$this->titre = $titre;}

        function getNbPages() {return $this->nbPages;}
        function setNbPages($nbPages) {$this->nbPages = $nbPages;}

        function getImage() {return $this->image;}
        function setImage($image) {$this->image = $image;}
    }
?>