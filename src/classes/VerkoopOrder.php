<?php
// auteur: studentnaam
// functie: definitie class VerkoopOrder
namespace Bas\classes;

use Bas\classes\Database;
use PDO;
use PDOException;

include_once "functions.php";

class VerkoopOrder extends Database{
    public $verkOrdId;
    public $klantId;
    public $artId;
    public $verkOrdDatum;
    public $verkOrdBestAantal;
    public $verkOrdStatus;
    private $table_name = "VerkoopOrder";    

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
    function getVerkoopOrder($order = NULL, $direction = 'ASC')
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
        $lijst = $query->fetchAll(PDO::FETCH_ASSOC);
    
        return $lijst;
    }

    /**
     * Summary of dropDownVerkoopOrder
     * @param int $row_selected
     * @return void
     */
    public function dropDownVerkoopOrder($row_selected = -1){
    
        // Haal alle verkooporders op uit de database mbv de method getVerkoopOrder()
        $lijst = $this->getVerkoopOrder();
        
        echo "<label for='VerkoopOrder'>Choose a verkooporder:</label>";
        echo "<select name='verkOrdId'>";
        foreach ($lijst as $row){
            if($row_selected == $row["verkOrdId"]){
                echo "<option value='{$row['verkOrdId']}' selected='selected'> {$row['verkOrdDatum']} {$row['verkOrdBestAantal']}</option>\n";
            } else {
                echo "<option value='{$row['verkOrdId']}'> {$row['verkOrdDatum']} {$row['verkOrdBestAantal']}</option>\n";
            }
        }
        echo "</select>";
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
        $txt .= getTableHeader($lijst[0]);

        foreach($lijst as $row){
            $txt .= "<tr>";
            $txt .=  "<td>" . $row["verkOrdId"] . "</td>";
            $txt .=  "<td>" . $row["klantId"] . "</td>";
            $txt .=  "<td>" . $row["artId"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdDatum"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdBestAantal"] . "</td>";
            $txt .=  "<td>" . $row["verkOrdStatus"] . "</td>";
            
            //Update
            // Wijzig knopje
            $txt .=  "<td>";
            $txt .= " 
            <form method='post' action='update.php?verkOrdId={$row['verkOrdId']}' >       
                <button name='update'>Wzg</button>     
            </form> </td>";

            //Delete
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

    // Delete verkooporder
    /**
     * Summary of deleteVerkoopOrder
     * @param int $verkOrdId
     * @return bool
     */
    public function deleteVerkoopOrder(int $verkOrdId) : bool {
        $conn = $this->getConnection();

        $sql = "DELETE FROM verkooporder WHERE verkOrdId = :verkOrdId";
        $query = $conn->prepare($sql);
        $query->bindParam(':verkOrdId', $verkOrdId, PDO::PARAM_INT);
        try {
            return $query->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Summary of updateVerkoopOrder
     * @param int $verkOrdId
     * @param int $klantId
     * @param int $artId
     * @param string $verkOrdDatum
     * @param int $verkOrdBestAantal
     * @param int $verkOrdStatus
     * @return bool
     */
    public function updateVerkoopOrder(int $verkOrdId, int $klantId, int $artId, string $verkOrdDatum, int $verkOrdBestAantal, int $verkOrdStatus) : bool {
        $conn = $this->getConnection();
        $sql = "UPDATE verkooporder 
        SET 
        klantId = :klantId, 
        artId = :artId, 
        verkOrdDatum = :verkOrdDatum, 
        verkOrdBestAantal = :verkOrdBestAantal, 
        verkOrdStatus = :verkOrdStatus
        WHERE verkOrdId = :verkOrdId";
        $query = $conn->prepare($sql);
        $query->bindParam(':klantId', $klantId, PDO::PARAM_INT);
        $query->bindParam(':artId', $artId, PDO::PARAM_INT);
        $query->bindParam(':verkOrdDatum', $verkOrdDatum, PDO::PARAM_STR);
        $query->bindParam(':verkOrdBestAantal', $verkOrdBestAantal, PDO::PARAM_INT);
        $query->bindParam(':verkOrdStatus', $verkOrdStatus, PDO::PARAM_INT);
        $query->bindParam(':verkOrdId', $verkOrdId, PDO::PARAM_INT);
        return $query->execute();
    }

    /**
     * Summary of insertVerkoopOrder
     * @param int $klantId
     * @param int $artId
     * @param string $verkOrdDatum
     * @param int $verkOrdBestAantal
     * @param int $verkOrdStatus
     * @return bool
     */
    public function insertVerkoopOrder(int $klantId, int $artId, string $verkOrdDatum, int $verkOrdBestAantal, int $verkOrdStatus) : bool {
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
    
    /**
     * Summary of BepMaxVerkOrdId
     * @return int
     */
	private function BepMaxVerkOrdId() : int {
		$conn = $this->getConnection();
		$sql = "SELECT MAX(verkOrdId)+1 FROM {$this->table_name}";
		return (int) $conn->query($sql)->fetchColumn();
	}
}
?>