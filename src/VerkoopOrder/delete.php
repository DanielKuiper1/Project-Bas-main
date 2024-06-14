<?php
// auteur: studentnaam
// functie: delete class VerkoopOrder

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\VerkoopOrder;

$verkoopOrder = new VerkoopOrder();

if (isset($_GET['verkOrdId']) && is_numeric($_GET['verkOrdId'])) {
    $verkOrdId = (int)$_GET['verkOrdId'];

    if ($verkoopOrder->deleteVerkoopOrder($verkOrdId)) {
        echo "Verkooporder met ID $verkOrdId is succesvol verwijderd.";
    } else {
        echo "Het verwijderen van Verkooporder met ID $verkOrdId is mislukt.";
    }
} else {
    echo "Geen geldige verkOrdId opgegeven.";
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
<h1>CRUD VerkoopOrder</h1>
<a href="read.php">Terug</a>
</body>
</html>
