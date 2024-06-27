<?php
session_start();

// Validate username and password (this is a basic example)
$username = $_POST['username'];
$password = $_POST['password'];

// Example hardcoded users (in a real system, use a database)
$users = [
    'klanten' => 'passwordK',
    'magazijn' => 'passwordM',
    'Verkoper' => 'passwordV',
    'Admin' => 'passwordA'
];

// Check if the user exists and password matches
if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['username'] = $username; // Store username in session
    header('Location: index.php'); // Redirect to main page after login
    exit();
} else {
    echo "Invalid username or password. <a href='login.php'>Try again</a>.";
}
?>
