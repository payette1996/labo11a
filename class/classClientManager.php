<?php
class ClientManager
{
    private PDO $_pdo;

    public function __construct(PDO $_pdo)
    {
        $this->_pdo = $_pdo;
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function addClient(object $clientObj)
    {
        // Extracts the street number and name from the address using Regex
        preg_match("/^(\d+)\s+(.+)$/", $clientObj->adresse, $matches);
        $clientObj->_noPorte = $matches[1];
        $clientObj->_rue = $matches[2];

        // tbladresse INSERT
        $sql1 = "
            INSERT INTO tbladresse (noPorte, rue, ville, province, codePostal, idPays)
            VALUES (:noPorte, :rue, :ville, :province, :codePostal, :idPays)
        ";

        $stmt1 = $this->_pdo->prepare($sql1);

        $values1 = [
            ":noPorte" => $clientObj->_noPorte,
            ":rue" => $clientObj->_rue,
            ":ville" => $clientObj->_ville,
            ":province" => $clientObj->_province,
            ":codePostal" => $clientObj->_codePostal,
            ":idPays" => $clientObj->_idPays,
        ];

        $stmt1->execute($values1);

        $idAdresse = $this->_pdo->lastInsertId();

        // tblpays INSERT (idPays, pays)
        $sql2 = "";

        $stmt2 = "";

        $values2 = "";

        $stmt2->execute($values2);

        $idPays = $this->_pdo->lastInsertId();


        // tbltypetel INSERT (idTypeTel, typeTel)
        $sql3 = "";

        $stmt3 = "";

        $values3 = "";

        $stmt3->execute($values3);

        $idTypeTel = $this->_pdo->lastInsertId();

        // MAIN INSERT
        $sql = "
            INSERT INTO tblclient
            VALUES (
                :prenom,
                :nom,
                :courriel,
                :mdp,
                :idAdresse,
                :idTypeTel,
                :tel,
                :idPaysDelivrance,
                :noPermis,
                :dateNaissance,
                :dateExp,
                :infolettre,
                :modalite,
                :dateCreation
            )
        ";
    }
}
?>