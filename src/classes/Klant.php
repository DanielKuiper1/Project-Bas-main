<?php
// auteur: studentnaam
// functie: definitie class Klant
namespace Bas\classes;

use Bas\classes\Database;
use PDO;
use PDOException;

include_once "functions.php";

class Klant extends Database{
	public $klantId;
	public $klantEmail;
	public $klantNaam;
	public $klantAdres;
	public $klantPostcode;
	public $klantWoonplaats;
	private $table_name = "Klant";	

	// Methods
	
	/**
	 * Summary of crudKlant
	 * @return void
	 */
	public function crudKlant() : void {
		// Haal alle klant op uit de database mbv de method getKlant()
		$lijst = $this->getKlant();

		// Print een HTML tabel van de lijst	
		$this->showTable($lijst);
	}

	/**
	 * Summary of getKlant
	 * @return mixed
	 */
	function getKlant($order = NULL, $direction = 'ASC')
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
  * Summary of getKlant
  * @param int $klantId
  * @return mixed
  */
	
	public function dropDownKlant($row_selected = -1){
	
		// Haal alle klanten op uit de database mbv de method getKlanten()
		$lijst = $this->getKlant();
		
		echo "<label for='Klant'>Choose a klant:</label>";
		echo "<select name='klantId'>";
		foreach ($lijst as $row){
			if($row_selected == $row["klantId"]){
				echo "<option value='$row[klantId]' selected='selected'> $row[klantnaam] $row[klantemail]</option>\n";
			} else {
				echo "<option value='$row[klantId]'> $row[klantnaam] $row[klantemail]</option>\n";
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

		$txt = "<table>";

		// Voeg de kolomnamen boven de tabel
		$txt .= getTableHeader($lijst[0]);

		foreach($lijst as $row){
			$txt .= "<tr>";
			$txt .=  "<td>" . $row["klantId"] . "</td>";
			$txt .=  "<td>" . $row["klantNaam"] . "</td>";
			$txt .=  "<td>" . $row["klantEmail"] . "</td>";
			$txt .=  "<td>" . $row["klantAdres"] . "</td>";
			$txt .=  "<td>" . $row["klantPostcode"] . "</td>";
			$txt .=  "<td>" . $row["klantWoonplaats"] . "</td>";
			
			//Update
			// Wijzig knopje
        	$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='update.php?klantId=$row[klantId]' >       
                <button name='update'>Wzg</button>	 
            </form> </td>";

			//Delete
			$txt .=  "<td>";
			$txt .= " 
            <form method='post' action='delete.php?klantId=$row[klantId]' >       
                <button name='verwijderen'>Verwijderen</button>	 
            </form> </td>";	
			$txt .= "</tr>";
		}
		$txt .= "</table>";
		echo $txt;
	}

	public function searchKlantByName(string $searchTerm) {
		$conn = $this->getConnection();
		$sql = "SELECT * FROM {$this->table_name} WHERE klantNaam LIKE :searchTerm";
		$query = $conn->prepare($sql);
		$searchTerm = "%$searchTerm%";
		$query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	

	// Delete klant
 /**
  * Summary of deleteKlant
  * @param int $klantId
  * @return bool
  */
  public function deleteKlant(int $klantId) : bool {
	$conn = $this->getConnection();

	$sql = "DELETE FROM klant WHERE klantId = :klantId";
	$query = $conn->prepare($sql);
	$query->bindParam(':klantId', $klantId, PDO::PARAM_INT);
	try {
		return $query->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		return false;
	}
}

public function updateKlant(int $klantId, string $klantemail, string $klantnaam, string $klantAdres, string $klantPostcode, string $klantwoonplaats) : bool {
	$conn = $this->getConnection();
 	$sql = "UPDATE klant 
	SET 
	klantemail = :klantemail, 
	klantnaam = :klantnaam, 
	klantAdres = :klantAdres, 
	klantPostcode = :klantPostcode, 
	klantwoonplaats = :klantwoonplaats
	WHERE klantId = :klantId";
	$query = $conn->prepare($sql);
	$query->bindParam(':klantemail', $klantemail, PDO::PARAM_STR);
	$query->bindParam(':klantnaam', $klantnaam, PDO::PARAM_STR);
	$query->bindParam(':klantAdres', $klantAdres, PDO::PARAM_STR);
	$query->bindParam(':klantPostcode', $klantPostcode, PDO::PARAM_STR);
	$query->bindParam(':klantwoonplaats', $klantwoonplaats, PDO::PARAM_STR);
	$query->bindParam(':klantId', $klantId, PDO::PARAM_INT);
	return $query->execute();
}

public function insertKlant(string $klantemail, string $klantnaam, string $klantAdres, string $klantPostcode, string $klantwoonplaats) : bool {
	$conn = $this->getConnection();
	$sql = "INSERT INTO {$this->table_name} (klantemail, klantnaam, klantAdres, klantPostcode, klantwoonplaats) 
			VALUES (:klantemail, :klantnaam, :klantAdres, :klantPostcode, :klantwoonplaats)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':klantemail', $klantemail);
	$stmt->bindParam(':klantnaam', $klantnaam);
	$stmt->bindParam(':klantAdres', $klantAdres);
	$stmt->bindParam(':klantPostcode', $klantPostcode);
	$stmt->bindParam(':klantwoonplaats', $klantwoonplaats);
	return $stmt->execute();
}
	
	/**
	 * Summary of BepMaxKlantId
	 * @return int
	 */
	private function BepMaxKlantId() : int {
		$conn = $this->getConnection();
		$sql = "SELECT MAX(klantId)+1 FROM {$this->table_name}";
		return (int) $conn->query($sql)->fetchColumn();
	}
}
?>