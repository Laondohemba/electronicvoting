<?php

$host = "localhost";
$dbname = "electronicvoting";
$dbusername = "root";
$dbpassword = "";
$port = 3307;

try {
    // Create a new PDO instance
    $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";port=" . $port;
    $pdo = new PDO($dsn, $dbusername, $dbpassword);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Output a more descriptive error message
    die("Connection failed: " . $e->getMessage());
}