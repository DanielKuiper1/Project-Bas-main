<?php
// auteur: studentnaam
// functie: definitie class VerkoopOrder

namespace Bas\classes;

use PDO;
use PDOException;

class VerkoopOrder extends Database {
    public $verkOrdId;
    public $klantId;
    public $artId;
    public $verkOrdDatum;
    public $verkOrdBestAantal;
    public $verkOrdStatus;
    private $table_name = "VerkoopOrder";
    
    private $statusNames = [
        0 => 'In behandeling',
        1 => 'Verzonden',
        2 => 'Geleverd',
        3 => 'Geannuleerd'
    ];

    // Methods
    
    /**
     * Summary of crudVerkoopOrder
     * @return void
     */
    public function crudVerkoopOrder() : void {
        // Haal alle verkooporders op uit de database mbv de method getVerkoopOrder()
        $lijst = $this->getVerkoopOrder();

        // Print een HTML tabel van de lijst    
        $this->showTable($lijst);
    }

    /**
     * Summary of getVerkoopOrder
     * @return mixed
     */
    public function getVerkoopOrder($order = NULL, $direction = 'ASC')
    {
        // Connect database
        $conn = $this->getConnection();
    
        $sql = "SELECT * FROM {$this->table_name}";
        if ($order) {
            $sql .= " ORDER BY $order $direction";
        }
    
        // Select data uit de opgegeven table methode prepare
        $query = $conn->prepare($sql);
        $query->execute();
        $lijst = $query->fetchAll();
    
        return $lijst;
    }

    /**
     * Summary of showTable
     * @param mixed $lijst
     * @return void
     */
    public function showTable($lijst) : void {
        if (empty($lijst)) {
            echo "Geen verkooporders gevonden.";
            return;
        }

        $txt = "<table>";

        // Voeg de kolomnamen boven de tabel
        $txt .= $this->getTableHeader($lijst[0]);

        foreach($lijst as $row){
            $txt .= "<tr>";
            $txt .=  "<td>" . $row["verkOrdId"] . "</td>";
            $txt .=  "<td>" . $row["klantId"] . "</td>";
            $txt .=  "<td>" . $row["artId"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdDatum"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdBestAantal"] . "</td>";
            $txt .=  "<td>" . $this->getStatusName($row["verkOrdStatus"]) . "</td>";
            
            // Update
            // Wijzig knopje
            $txt .=  "<td>";
            $txt .= " 
            <form method='post' action='update.php?verkOrdId={$row['verkOrdId']}' >       
                <button name='update'>Wzg</button>     
            </form> </td>";

            // Delete
            $txt .=  "<td>";
            $txt .= " 
            <form method='post' action='delete.php?verkOrdId={$row['verkOrdId']}' >       
                <button name='verwijderen'>Verwijderen</button>     
            </form> </td>";    
            $txt .= "</tr>";
        }
        $txt .= "</table>";
        echo $txt;
    }

    public function getStatusNames() {
        return $this->statusNames;
    }

    public function getStatusName($statusCode) {
        return $this->statusNames[$statusCode] ?? 'Onbekend';
    }

    public function insertVerkoopOrder($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus) {
        $conn = $this->getConnection();
        $sql = "INSERT INTO {$this->table_name} (klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus)
                VALUES (:klantId, :artId, :verkOrdDatum, :verkOrdBestAantal, :verkOrdStatus)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':klantId', $klantId);
        $stmt->bindParam(':artId', $artId);
        $stmt->bindParam(':verkOrdDatum', $verkOrdDatum);
        $stmt->bindParam(':verkOrdBestAantal', $verkOrdBestAantal);
        $stmt->bindParam(':verkOrdStatus', $verkOrdStatus);
        return $stmt->execute();
    }

    public function updateVerkoopOrder($verkOrdId, $klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus) {
        $conn = $this->getConnection();
        $sql = "UPDATE {$this->table_name} 
                SET klantId = :klantId, artId = :artId, verkOrdDatum = :verkOrdDatum, verkOrdBestAantal = :verkOrdBestAantal, verkOrdStatus = :verkOrdStatus
                WHERE verkOrdId = :verkOrdId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':klantId', $klantId);
        $stmt->bindParam(':artId', $artId);
        $stmt->bindParam(':verkOrdDatum', $verkOrdDatum);
        $stmt->bindParam(':verkOrdBestAantal', $verkOrdBestAantal);
        $stmt->bindParam(':verkOrdStatus', $verkOrdStatus);
        $stmt->bindParam(':verkOrdId', $verkOrdId);
        return $stmt->execute();
    }

    public function deleteVerkoopOrder($verkOrdId) {
        $conn = $this->getConnection();
        $sql = "DELETE FROM {$this->table_name} WHERE verkOrdId = :verkOrdId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':verkOrdId', $verkOrdId, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Summary of getKlanten
     * @return mixed
     */
    public function getKlanten()
    {
        $conn = $this->getConnection();
        $sql = "SELECT klantId, klantNaam FROM Klant";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of getArtikels
     * @return mixed
     */
    public function getArtikels()
    {
        $conn = $this->getConnection();
        $sql = "SELECT artId, artOmschrijving FROM Artikel";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of getVerkoopOrderById
     * @param mixed $verkOrdId
     * @return mixed
     */
    public function getVerkoopOrderById($verkOrdId)
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM {$this->table_name} WHERE verkOrdId = :verkOrdId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':verkOrdId', $verkOrdId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of getTableHeader
     * @param mixed $row
     * @return string
     */
    private function getTableHeader($row) {
        $txt = "<tr>";
        foreach ($row as $key => $value) {
            $txt .= "<th>" . htmlspecialchars($key) . "</th>";
        }
        $txt .= "<th>Acties</th></tr>";
        return $txt;
    }
}
?>
