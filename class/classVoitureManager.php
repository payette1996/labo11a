<?php
    class VoitureManager
    {
        const SELECT_VOITURES = "
            SELECT * FROM tblvoiture
            LEFT JOIN tblmarque ON tblvoiture.idMarque = tblmarque.idMarque
            LEFT JOIN tblcategorie ON tblvoiture.idCategorie = tblcategorie.Categorie
        ";

        private ?PDO $_pdo;

        public function __construct($_pdo)
        {
            $this->_pdo = $_pdo;
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function getVoiture(?int $id = NULL) : null|array|object
        {
            if (!$id) {
                $results = $this->_pdo->query(self::SELECT_VOITURES)->fetchAll(PDO::FETCH_OBJ);
                return $results ? $results : null;
            } else {
                $query = self::SELECT_VOITURES . "WHERE idVoiture = :id";
                $stmt = $this->_pdo->prepare($query);
                $stmt->bindValue(":id", $id);
                $stmt->execute();
                $voiture = $stmt->fetch(PDO::FETCH_OBJ);

                return $voiture ? $voiture : null;
            }
        }
    }
?>