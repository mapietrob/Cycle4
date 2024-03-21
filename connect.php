<?php
// Database configuration
$host = 'localhost';
$dbname = 'csci375fa23';
$user = 'csci375fa23';
$pass = 'csci375fa23!';
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// Create a connection
try {
    $pdo = new PDO($dsn, $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
