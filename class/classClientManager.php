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

        try {
            $this->_pdo->beginTransaction();

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

            // tblpays : get country ID or insert the country and get ID
            $sql2 = "SELECT idPays from tblPays WHERE pays = :pays";
            $stmt2 = $this->_pdo->prepare($stmt1);
            $stmt2->bindValue(":pays", $clientObj->_pays);
            $stmt2->execute();

            if ($stmt2->rowCount() > 0) {
                $idPays = $stmt2->fetchColumn();
            } else {
                $sql = "INSERT INTO tblpays (pays) VALUES :pays";
                $stmt = $this->_pdo->prepare($sql);
                $stmt->bindValue(":pays", $clientObj->_pays);
                $stmt->execute();
                $idPays = $this->_pdo->lastInsertId();
            }

            // tbltypetel INSERT (idTypeTel, typeTel)
            $sql3 = "SELECT id FROM tbltypetel WHERE typeTel = :typetel";
            $stmt3 = $this->_pdo->prepare($sql3);
            $stmt3->execute();

            $idTypeTel = $stmt3->fetchColumn();

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

            $this->_pdo->commit();
            
        } catch(PDOException $error) {
            $this->_pdo->rollBack();
            throw new Exception($error);
        }
    }
}
?>