<?php
// auteur: studentnaam
// functie: definitie class Artikel
namespace Bas\classes;

use Bas\classes\Database;
use PDO;
use PDOException;

include_once "functions.php";

class Artikel extends Database{
    public $artId;
    public $artOmschrijving;
    public $artInkoop;
    public $artVerkoop;
    public $artVoorraad;
    public $artMinVoorraad;
    public $artMaxVoorraad;
    public $artLocatie;
    private $table_name = "Artikel";    

    // Methods
    
    /**
     * Summary of crudArtikel
     * @return void
     */
    public function crudArtikel() : void {
        // Haal alle artikelen op uit de database mbv de method getArtikel()
        $lijst = $this->getArtikel();

        // Print een HTML tabel van de lijst    
        $this->showTable($lijst);
    }

    /**
     * Summary of getArtikel
     * @return mixed
     */
    function getArtikel($order = NULL, $direction = 'ASC')
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
     * Summary of dropDownArtikel
     * @param int $row_selected
     * @return void
     */
    public function dropDownArtikel($row_selected = -1){
    
        // Haal alle artikelen op uit de database mbv de method getArtikel()
        $lijst = $this->getArtikel();
        
        echo "<label for='Artikel'>Choose an artikel:</label>";
        echo "<select name='artId'>";
        foreach ($lijst as $row){
            if($row_selected == $row["artId"]){
                echo "<option value='{$row['artId']}' selected='selected'> {$row['artOmschrijving']} {$row['artInkoop']}</option>\n";
            } else {
                echo "<option value='{$row['artId']}'> {$row['artOmschrijving']} {$row['artInkoop']}</option>\n";
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
            echo "Geen artikelen gevonden.";
            return;
        }

        $txt = "<table>";

        // Voeg de kolomnamen boven de tabel
        $txt .= getTableHeader($lijst[0]);

        foreach($lijst as $row){
            $txt .= "<tr>";
            $txt .=  "<td>" . $row["artId"] . "</td>";
            $txt .=  "<td>" . $row["artOmschrijving"] . "</td>";
            $txt .=  "<td>" . $row["artInkoop"] . "</td>";
            $txt .=  "<td>" . $row["artVerkoop"] . "</td>";
            $txt .=  "<td>" . $row["artVoorraad"] . "</td>";
            $txt .=  "<td>" . $row["artMinVoorraad"] . "</td>";
            $txt .=  "<td>" . $row["artMaxVoorraad"] . "</td>";
            $txt .=  "<td>" . $row["artLocatie"] . "</td>";
            
            //Update
            // Wijzig knopje
            $txt .=  "<td>";
            $txt .= " 
            <form method='post' action='update.php?artId={$row['artId']}' >       
                <button name='update'>Wzg</button>     
            </form> </td>";

            //Delete
            $txt .=  "<td>";
            $txt .= " 
            <form method='post' action='delete.php?artId={$row['artId']}' >       
                <button name='verwijderen'>Verwijderen</button>     
            </form> </td>";    
            $txt .= "</tr>";
        }
        $txt .= "</table>";
        echo $txt;
    }

    // Delete artikel
    /**
     * Summary of deleteArtikel
     * @param int $artId
     * @return bool
     */
    public function deleteArtikel(int $artId) : bool {
        $conn = $this->getConnection();

        $sql = "DELETE FROM artikel WHERE artId = :artId";
        $query = $conn->prepare($sql);
        $query->bindParam(':artId', $artId, PDO::PARAM_INT);
        try {
            return $query->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Summary of updateArtikel
     * @param int $artId
     * @param string $artOmschrijving
     * @param float $artInkoop
     * @param float $artVerkoop
     * @param int $artVoorraad
     * @param int $artMinVoorraad
     * @param int $artMaxVoorraad
     * @param string $artLocatie
     * @return bool
     */
    public function updateArtikel(int $artId, string $artOmschrijving, float $artInkoop, float $artVerkoop, int $artVoorraad, int $artMinVoorraad, int $artMaxVoorraad, string $artLocatie) : bool {
        $conn = $this->getConnection();
        $sql = "UPDATE artikel 
        SET 
        artOmschrijving = :artOmschrijving, 
        artInkoop = :artInkoop, 
        artVerkoop = :artVerkoop, 
        artVoorraad = :artVoorraad, 
        artMinVoorraad = :artMinVoorraad, 
        artMaxVoorraad = :artMaxVoorraad, 
        artLocatie = :artLocatie
        WHERE artId = :artId";
        $query = $conn->prepare($sql);
        $query->bindParam(':artOmschrijving', $artOmschrijving, PDO::PARAM_STR);
        $query->bindParam(':artInkoop', $artInkoop, PDO::PARAM_STR);
        $query->bindParam(':artVerkoop', $artVerkoop, PDO::PARAM_STR);
        $query->bindParam(':artVoorraad', $artVoorraad, PDO::PARAM_INT);
        $query->bindParam(':artMinVoorraad', $artMinVoorraad, PDO::PARAM_INT);
        $query->bindParam(':artMaxVoorraad', $artMaxVoorraad, PDO::PARAM_INT);
        $query->bindParam(':artLocatie', $artLocatie, PDO::PARAM_STR);
        $query->bindParam(':artId', $artId, PDO::PARAM_INT);
        return $query->execute();
    }

    /**
     * Summary of insertArtikel
     * @param string $artOmschrijving
     * @param float $artInkoop
     * @param float $artVerkoop
     * @param int $artVoorraad
     * @param int $artMinVoorraad
     * @param int $artMaxVoorraad
     * @param string $artLocatie
     * @return bool
     */
    public function insertArtikel(string $artOmschrijving, float $artInkoop, float $artVerkoop, int $artVoorraad, int $artMinVoorraad, int $artMaxVoorraad, string $artLocatie) : bool {
        $conn = $this->getConnection();
        $sql = "INSERT INTO {$this->table_name} (artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad, artMaxVoorraad, artLocatie) 
                VALUES (:artOmschrijving, :artInkoop, :artVerkoop, :artVoorraad, :artMinVoorraad, :artMaxVoorraad, :artLocatie)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':artOmschrijving', $artOmschrijving);
        $stmt->bindParam(':artInkoop', $artInkoop);
        $stmt->bindParam(':artVerkoop', $artVerkoop);
        $stmt->bindParam(':artVoorraad', $artVoorraad);
        $stmt->bindParam(':artMinVoorraad', $artMinVoorraad);
        $stmt->bindParam(':artMaxVoorraad', $artMaxVoorraad);
        $stmt->bindParam(':artLocatie', $artLocatie);
        return $stmt->execute();
    }
    
    /**
     * Summary of BepMaxArtId
     * @return int
     */
	private function BepMaxArtId() : int {
		$conn = $this->getConnection();
		$sql = "SELECT MAX(artId)+1 FROM {$this->table_name}";
		return (int) $conn->query($sql)->fetchColumn();
	}
}
?>
