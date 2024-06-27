<?php

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

require '../../vendor/autoload.php';
use Bas\classes\VerkoopOrder;

$verkoopOrder = new VerkoopOrder;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"]) && $_POST["update"] == "Wzg") {
    $verkOrdId = $_GET['verkOrdId'] ?? null;
    $klantId = $_POST['klantId'] ?? null;
    $artId = $_POST['artId'] ?? null;
    $verkOrdDatum = $_POST['verkOrdDatum'] ?? null;
    $verkOrdBestAantal = $_POST['verkOrdBestAantal'] ?? null;
    $verkOrdStatus = $_POST['verkOrdStatus'] ?? null;

    if ($verkoopOrder->updateVerkoopOrder($verkOrdId, $klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus)) {
        echo "VerkoopOrder is succesvol bijgewerkt.";
    } else {
        echo "Het bijwerken van de verkooporder is mislukt.";
    }
}

// Fetch existing data for the specified verkOrdId
if (isset($_GET['verkOrdId'])) {
    $verkOrdId = $_GET['verkOrdId'];
    $verkoopOrderData = $verkoopOrder->getVerkoopOrderById($verkOrdId);
    if ($verkoopOrderData) {
        // Populate the form with existing data
        $klantId = $verkoopOrderData['klantId'] ?? '';
        $artId = $verkoopOrderData['artId'] ?? '';
        $verkOrdDatum = $verkoopOrderData['verkOrdDatum'] ?? '';
        $verkOrdBestAantal = $verkoopOrderData['verkOrdBestAantal'] ?? '';
        $verkOrdStatus = $verkoopOrderData['verkOrdStatus'] ?? '';
    } else {
        echo "Verkoopordergegevens konden niet worden opgehaald.";
    }
}

// Fetch data for dropdowns
$klanten = $verkoopOrder->getKlanten();
$artikels = $verkoopOrder->getArtikels();
$statusNames = $verkoopOrder->getStatusNames();
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
<h1>CRUD VerkoopOrder</h1>
<h2>Update</h2>
<form method="post">
    <label for="klantId">Klant:</label>
    <select name="klantId" required>
        <?php foreach ($klanten as $klant): ?>
            <option value="<?php echo $klant['klantId']; ?>" <?php echo ($klantId == $klant['klantId']) ? 'selected' : ''; ?>>
                <?php echo $klant['klantNaam']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="artId">Artikel:</label>
    <select name="artId" required>
        <?php foreach ($artikels as $artikel): ?>
            <option value="<?php echo $artikel['artId']; ?>" <?php echo ($artId == $artikel['artId']) ? 'selected' : ''; ?>>
                <?php echo $artikel['artOmschrijving']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="verkOrdDatum">Datum:</label>
    <input type="date" name="verkOrdDatum" required value="<?php echo $verkOrdDatum ?? ''; ?>"><br>

    <label for="verkOrdBestAantal">Besteld Aantal:</label>
    <input type="number" name="verkOrdBestAantal" required value="<?php echo $verkOrdBestAantal ?? ''; ?>"><br>

    <label for="verkOrdStatus">Status:</label>
    <select name="verkOrdStatus" required>
        <?php foreach ($statusNames as $statusCode => $statusName): ?>
            <option value="<?php echo $statusCode; ?>" <?php echo ($verkOrdStatus == $statusCode) ? 'selected' : ''; ?>>
                <?php echo $statusName; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" name="update" value="Wzg">
</form><br>

<a href="read.php">Terug</a>

</body>
</html>
