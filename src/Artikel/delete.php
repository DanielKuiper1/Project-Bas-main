<?php
// auteur: studentnaam
// functie: delete class Artikel

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;

$artikel = new Artikel;

if (isset($_GET['artId']) && is_numeric($_GET['artId'])) {
    $artId = (int)$_GET['artId'];

    if ($artikel->deleteArtikel($artId)) {
        echo "Artikel met ID $artId is succesvol verwijderd.";
    } else {
        echo "Het verwijderen van artikel met ID $artId is mislukt.";
    }
} else {
    echo "Geen geldige artId opgegeven.";
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
<a href="read.php">Terug</a>
</body>
</html>