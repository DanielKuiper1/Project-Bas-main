<!--
    Auteur: Studentnaam
    Function: home page CRUD Klant
-->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <h1>CRUD Klant</h1>
    <nav>
        <a href='../index.html'>Home</a><br>
        <a href='insert.php'>Toevoegen nieuwe klant</a><br><br>
    </nav>

    <form method="post">
        <label for="searchTerm">Zoeken:</label>
        <input type="text" name="searchTerm" placeholder="Voer klantnaam in">
        <input type="submit" name="search" value="Zoeken">
    </form>
    <br>

<?php

// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\Klant;

// Maak een object Klant
$klant = new Klant;

// Handle search if a search term is provided
$searchResults = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["search"]) && !empty($_POST["searchTerm"])) {
    $searchTerm = $_POST['searchTerm'];
    $searchResults = $klant->searchKlantByName($searchTerm);
}

// Fetch the full list if no search term is provided or no search results are found
if (empty($searchResults)) {
    $searchResults = $klant->getKlant();
}

// Start CRUD
$klant->showTable($searchResults);

?>
</body>
</html>
