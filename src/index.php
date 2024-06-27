<!-- index.php -->
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bas Boodschappenservice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
    <nav>
        <?php if ($username === 'klanten' or $username === 'Admin'): ?>
            <a href="klant/read.php">CRUD klant</a>
        <?php endif; ?>
        <?php if ($username === 'magazijn' or $username === 'Admin'): ?>
            <a href="artikel/read.php">CRUD artikel</a>
        <?php endif; ?>
        <?php if ($username === 'Verkoper' or $username === 'Admin'): ?>
            <a href="VerkoopOrder/read.php">CRUD verkoopOrder</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>
