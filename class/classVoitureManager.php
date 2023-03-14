<?php
    class VoitureManager
    {
        const SELECT_VOITURES = "SELECT * FROM tblvoiture ORDER BY idVoiture ASC";

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