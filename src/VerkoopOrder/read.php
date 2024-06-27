<!--
    Auteur: Daniel
    Function: home page CRUD VerkoopOrder
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
    <h1>CRUD VerkoopOrder</h1>
    <nav>
        <a href='../index.php'>Home</a><br>
        <a href='insert.php'>Toevoegen nieuwe verkooporder</a><br><br>
    </nav>
    
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
// Autoloader classes via composer
require '../../vendor/autoload.php';

use Bas\classes\VerkoopOrder;

// Maak een object VerkoopOrder
$verkoopOrder = new VerkoopOrder;

// Start CRUD
$verkoopOrder->crudVerkoopOrder();

?>
</body>
</html>