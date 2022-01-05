<?php
    abstract class PDOAccess {
        private static $pdo;

        private function setAccessBDD() {
            self::$pdo = new PDO("mysql:host=localhost;dbname=app_biblio;charset=utf8;", "root", "");
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }

        protected function getAccessBDD() {
            if(self::$pdo === null) {
                $this->setAccessBDD();
            }
            return self::$pdo;
        }
    }
?>