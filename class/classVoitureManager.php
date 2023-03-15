<?php
    class VoitureManager
    {
        const SELECT_VOITURES = "
            SELECT * FROM tblvoiture
            LEFT JOIN tblmarque ON tblvoiture.idMarque = tblmarque.idMarque
            LEFT JOIN tblcategorie ON tblvoiture.idCategorie = tblcategorie.Categorie
        ";

        private ?PDO $db;

        public function __construct($db)
        {
            $this->db = $db;
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function getVoiture(?int $id = NULL) : null|array|object
        {
            if (!$id) {
                $results = $this->db->query(self::SELECT_VOITURES)->fetchAll(PDO::FETCH_OBJ);
                return $results ? $results : null;
            } else {
                $query = self::SELECT_VOITURES . "WHERE idVoiture = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":id", $id);
                $stmt->execute();
                $voiture = $stmt->fetch(PDO::FETCH_OBJ);

                return $voiture ? $voiture : null;
            }
        }
    }
?>