<?php
// auteur: studentnaam
// functie: delete class Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant;

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Check if user has permission based on role
if ($username !== 'Admin') {
    echo "Unauthorized access!";
    exit();
}

if (isset($_GET['klantId']) && is_numeric($_GET['klantId'])) {
    $klantId = (int)$_GET['klantId'];

    if ($klant->deleteKlant($klantId)) {
        echo "Klant met ID $klantId is succesvol verwijderd.";
    } else {
        echo "Het verwijderen van klant met ID $klantId is mislukt.";
    }
} else {
    echo "Geen geldige klantId opgegeven.";
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
<a href="read.php">Terug</a>
</body>
</html>
