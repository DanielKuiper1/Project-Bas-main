<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Check if user has permission based on role
if ($username !== 'klanten' && $username !== 'Admin') {
    echo "Unauthorized access!";
    exit();
}

// auteur: studentnaam
// functie: insert class Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen") {
    $klantnaam = $_POST['klantnaam'];
    $klantemail = $_POST['klantemail'];
    $klantAdres = $_POST['klantAdres'];
    $klantPostcode = $_POST['klantPostcode'];
    $klantwoonplaats = $_POST['klantwoonplaats'];

    if ($klant->insertKlant($klantemail, $klantnaam, $klantAdres, $klantPostcode, $klantwoonplaats)) {
        echo "Nieuwe klant is succesvol toegevoegd.";
    } else {
        echo "Het toevoegen van de nieuwe klant is mislukt.";
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
<h2>Toevoegen</h2>	
<form method="post">
<input type="text" name="klantnaam" required placeholder="Naam"> *</br>
<input type="email" name="klantemail" required placeholder="Email"> *</br>
<input type="text" name="klantAdres" required placeholder="Adres"> *</br>
<input type="text" name="klantPostcode" required placeholder="Postcode"> *</br>
<input type="text" name="klantwoonplaats" required placeholder="Woonplaats"> *</br></br>
<input type="submit" name="insert" value="Toevoegen">
</form></br>

<a href="read.php">Terug</a>

</body>
</html>
