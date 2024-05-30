<?php
// auteur: studentnaam
// functie: update class Artikel

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;

$artikel = new Artikel;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"]) && $_POST["update"] == "Wzg") {
    $artId = $_GET['artId'] ?? null;
    $artOmschrijving = $_POST['artOmschrijving'] ?? null;
    $artInkoop = $_POST['artInkoop'] ?? null;
    $artVerkoop = $_POST['artVerkoop'] ?? null;
    $artVoorraad = $_POST['artVoorraad'] ?? null;
    $artMinVoorraad = $_POST['artMinVoorraad'] ?? null;
    $artMaxVoorraad = $_POST['artMaxVoorraad'] ?? null;
    $artLocatie = $_POST['artLocatie'] ?? null;

    if ($artikel->updateArtikel($artId, $artOmschrijving, $artInkoop, $artVerkoop, $artVoorraad, $artMinVoorraad, $artMaxVoorraad, $artLocatie)) {
        echo "Artikelgegevens zijn succesvol bijgewerkt.";
    } else {
        echo "Het bijwerken van artikelgegevens is mislukt.";
    }
}

// Fetch existing data for the specified artId
if (isset($_GET['artId'])) {
    $artId = $_GET['artId'];
    $artikelData = $artikel->getArtikel($artId); // Assuming you have a method like getArtikelById in your Artikel class
    if ($artikelData) {
        // Populate the form with existing data
        $artOmschrijving = $artikelData['artOmschrijving'] ?? '';
        $artInkoop = $artikelData['artInkoop'] ?? '';
        $artVerkoop = $artikelData['artVerkoop'] ?? '';
        $artVoorraad = $artikelData['artVoorraad'] ?? '';
        $artMinVoorraad = $artikelData['artMinVoorraad'] ?? '';
        $artMaxVoorraad = $artikelData['artMaxVoorraad'] ?? '';
        $artLocatie = $artikelData['artLocatie'] ?? '';
    } else {
        echo "Artikelgegevens konden niet worden opgehaald.";
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
<h1>CRUD Artikel</h1>
<h2>Update</h2>
<form method="post">
<input type="text" name="artOmschrijving" required placeholder="Omschrijving" value="<?php echo $artOmschrijving ?? ''; ?>"> *</br>
<input type="number" step="0.01" name="artInkoop" required placeholder="Inkoopprijs" value="<?php echo $artInkoop ?? ''; ?>"> *</br>
<input type="number" step="0.01" name="artVerkoop" required placeholder="Verkoopprijs" value="<?php echo $artVerkoop ?? ''; ?>"> *</br>
<input type="number" name="artVoorraad" required placeholder="Voorraad" value="<?php echo $artVoorraad ?? ''; ?>"> *</br>
<input type="number" name="artMinVoorraad" required placeholder="Minimale Voorraad" value="<?php echo $artMinVoorraad ?? ''; ?>"> *</br>
<input type="number" name="artMaxVoorraad" required placeholder="Maximale Voorraad" value="<?php echo $artMaxVoorraad ?? ''; ?>"> *</br>
<input type="text" name="artLocatie" required placeholder="Locatie" value="<?php echo $artLocatie ?? ''; ?>"> *</br></br>
<input type="submit" name="update" value="Wzg">
</form></br>

<a href="read.php">Terug</a>

</body>
</html>
