<?php
// auteur: studentnaam
// functie: insert class Artikel

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;

$artikel = new Artikel;

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Check if user has permission based on role
if ($username !== 'magazijn' && $username !== 'Admin') {
    echo "Unauthorized access!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen") {
    $artOmschrijving = $_POST['artOmschrijving'];
    $artInkoop = $_POST['artInkoop'];
    $artVerkoop = $_POST['artVerkoop'];
    $artVoorraad = $_POST['artVoorraad'];
    $artMinVoorraad = $_POST['artMinVoorraad'];
    $artMaxVoorraad = $_POST['artMaxVoorraad'];
    $artLocatie = $_POST['artLocatie'];

    if ($artikel->insertArtikel($artOmschrijving, $artInkoop, $artVerkoop, $artVoorraad, $artMinVoorraad, $artMaxVoorraad, $artLocatie)) {
        echo "Nieuw artikel is succesvol toegevoegd.";
    } else {
        echo "Het toevoegen van het nieuwe artikel is mislukt.";
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
<h2>Toevoegen</h2>    
<form method="post">
    <input type="text" name="artOmschrijving" required placeholder="Omschrijving"> *</br>
    <input type="number" step="0.01" name="artInkoop" required placeholder="Inkoopprijs"> *</br>
    <input type="number" step="0.01" name="artVerkoop" required placeholder="Verkoopprijs"> *</br>
    <input type="number" name="artVoorraad" required placeholder="Voorraad"> *</br>
    <input type="number" name="artMinVoorraad" required placeholder="Minimale Voorraad"> *</br>
    <input type="number" name="artMaxVoorraad" required placeholder="Maximale Voorraad"> *</br>
    <input type="text" name="artLocatie" required placeholder="Locatie"> *</br></br>
    <input type="submit" name="insert" value="Toevoegen">
</form></br>

<a href="read.php">Terug</a>

</body>
</html>
