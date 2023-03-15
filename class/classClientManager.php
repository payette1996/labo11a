<?php
class ClientManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function addClient(object $clientObj)
    {
        // Extracts the street number and name from the address using Regex
        preg_match("/^(\d+)\s+(.+)$/", $clientObj->adresse, $matches);
        $clientObj->noPorte = $matches[1];
        $clientObj->rue = $matches[2];

        // tbladresse INSERT
        $sql1 = "
            INSERT INTO tbladresse (noPorte, rue, ville, province, codePostal, idPays)
            VALUES (:noPorte, :rue, :ville, :province, :codePostal, :idPays)
        ";

        $stmt1 = $this->pdo->prepare($sql1);

        $values1 = [
            ":noPorte" => $clientObj->noPorte,
            ":rue" => $clientObj->rue,
            ":ville" => $clientObj->ville,
            ":province" => $clientObj->province,
            ":codePostal" => $clientObj->codePostal,
            ":idPays" => $clientObj->idPays,
        ];

        $stmt1->execute($values1);

        $idAdresse = $this->pdo->lastInsertId();

        // tblpays INSERT (idPays, pays)
        $sql2 = "";

        $stmt2 = "";

        $values2 = "";

        $stmt2->execute($values2);

        $idPays = $this->pdo->lastInsertId();


        // tbltypetel INSERT (idTypeTel, typeTel)
        $sql3 = "";

        $stmt3 = "";

        $values3 = "";

        $stmt3->execute($values3);

        $idTypeTel = $this->pdo->lastInsertId();

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