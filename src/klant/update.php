<?php
// auteur: studentnaam
// functie: update class Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"]) && $_POST["update"] == "Wzg") {
    $klantId = $_GET['klantId'] ?? null;
    $klantnaam = $_POST['klantNaam'] ?? null; // Changed to match class property
    $klantemail = $_POST['klantEmail'] ?? null; // Changed to match class property
    $klantAdres = $_POST['klantAdres'] ?? null;
    $klantPostcode = $_POST['klantPostcode'] ?? null;
    $klantwoonplaats = $_POST['klantWoonplaats'] ?? null;

    if ($klant->updateKlant($klantId, $klantemail, $klantnaam, $klantAdres, $klantPostcode, $klantwoonplaats)) {
        echo "Klantgegevens zijn succesvol bijgewerkt.";
    } else {
        echo "Het bijwerken van klantgegevens is mislukt.";
    }
}

// Fetch existing data for the specified klantId
if (isset($_GET['klantId'])) {
    $klantId = $_GET['klantId'];
    $klantData = $klant->getKlant($klantId); // Assuming you have a method like getKlantById in your Klant class
    if ($klantData) {
        // Populate the form with existing data
        $klantnaam = $klantData['klantNaam'] ?? '';
        $klantemail = $klantData['klantEmail'] ?? '';
        $klantAdres = $klantData['klantAdres'] ?? '';
        $klantPostcode = $klantData['klantPostcode'] ?? '';
        $klantwoonplaats = $klantData['klantWoonplaats'] ?? '';
    } else {
        echo "Klantgegevens konden niet worden opgehaald.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<h1>CRUD Klant</h1>
<h2>Update</h2>
<form method="post">
<input type="text" name="klantNaam" required placeholder="Naam" value="<?php echo $klantnaam ?? ''; ?>"> *</br> <!-- Changed to match class property -->
<input type="email" name="klantEmail" required placeholder="Email" value="<?php echo $klantemail ?? ''; ?>"> *</br> <!-- Changed to match class property -->
<input type="text" name="klantAdres" required placeholder="Adres" value="<?php echo $klantAdres ?? ''; ?>"> *</br>
<input type="text" name="klantPostcode" required placeholder="Postcode" value="<?php echo $klantPostcode ?? ''; ?>"> *</br>
<input type="text" name="klantWoonplaats" required placeholder="Woonplaats" value="<?php echo $klantwoonplaats ?? ''; ?>"> *</br></br>
<input type="submit" name="update" value="Wzg">
</form></br>

<a href="read.php">Terug</a>

</body>
</html>
