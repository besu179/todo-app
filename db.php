<?php
// db.php - Database connection file

// Database configuration
$host = 'localhost';
$dbname = 'todo_app';
$username = 'root';
$password = '';

try {
    // Create connection
    $connection = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode (optional but recommended)
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $connection;

} catch (PDOException $e) {

    error_log("Database connection failed: " . $e->getMessage());
    die("We encountered problem");
}
