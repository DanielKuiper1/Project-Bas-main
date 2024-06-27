<?php
// auteur: studentnaam
// functie: insert class VerkoopOrder

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\VerkoopOrder;

$verkoopOrder = new VerkoopOrder;

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Check if user has permission based on role
if ($username !== 'Verkoper' && $username !== 'Admin') {
    echo "Unauthorized access!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen") {
    $klantId = $_POST['klantId'];
    $artId = $_POST['artId'];
    $verkOrdDatum = $_POST['verkOrdDatum'];
    $verkOrdBestAantal = $_POST['verkOrdBestAantal'];
    $verkOrdStatus = $_POST['verkOrdStatus'];

    if ($verkoopOrder->insertVerkoopOrder($klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus)) {
        echo "Nieuwe verkooporder is succesvol toegevoegd.";
    } else {
        echo "Het toevoegen van de nieuwe verkooporder is mislukt.";
    }
}

// Fetch the lists of clients and articles for the dropdowns
$klanten = $verkoopOrder->getKlanten();
$artikels = $verkoopOrder->getArtikels();
$statusNames = $verkoopOrder->getStatusNames();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud VerkoopOrder</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<h1>CRUD VerkoopOrder</h1>
<h2>Toevoegen</h2>    
<form method="post">
    <label for="klantId">Klant:</label>
    <select name="klantId" required>
        <?php foreach ($klanten as $klant): ?>
            <option value="<?= $klant['klantId'] ?>"><?= $klant['klantNaam'] ?></option>
        <?php endforeach; ?>
    </select> *</br>
    
    <label for="artId">Artikel:</label>
    <select name="artId" required>
        <?php foreach ($artikels as $artikel): ?>
            <option value="<?= $artikel['artId'] ?>"><?= $artikel['artOmschrijving'] ?></option>
        <?php endforeach; ?>
    </select> *</br>
    
    <input type="date" name="verkOrdDatum" required placeholder="Datum"> *</br>
    <input type="number" name="verkOrdBestAantal" required placeholder="Bestel Aantal"> *</br>
    <label for="verkOrdStatus">Status:</label>
    <select name="verkOrdStatus" required>
        <?php foreach ($statusNames as $statusCode => $statusName): ?>
            <option value="<?= $statusCode ?>"><?= $statusName ?></option>
        <?php endforeach; ?>
    </select> *</br></br>
    <input type="submit" name="insert" value="Toevoegen">
</form></br>

<a href="read.php">Terug</a>

</body>
</html>
