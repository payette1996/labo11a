<?php
    class VoitureManager
    {
        const SELECT_VOITURES = "SELECT marque, modele FROM tblvoiture LEFT JOIN tblmarque ON tblvoiture.idVoiture = tblmarque.idMarque";

        private ?PDO $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        public function getVoitures($db) : ?array
        {
            return $this->db->query(self::SELECT_VOITURES)->fetchAll();
        }
    }
?>