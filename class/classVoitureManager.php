<?php
    class VoitureManager
    {
        const SELECT_VOITURES = "SELECT * FROM tblvoiture LEFT JOIN tblmarque ON tblvoiture.idVoiture = tblmarque.idMarque";

        private ?PDO $db;

        public function __construct($db)
        {
            $this->db = $db;
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function getVoitures(?int $id = NULL) : ?array
        {
            if (!$id) {
                $results = $this->db->query(self::SELECT_VOITURES)->fetchAll(PDO::FETCH_OBJ);
                return $results ? $results : null;
            } else {
                $query = "SELECT * from tblvoiture WHERE idVoiture = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(":id", $id);
                $stmt->execute();
                $voiture = $stmt->fetch(PDO::FETCH_OBJ);

                return $voiture ? $voiture : null;
            }
        }
    }
?>