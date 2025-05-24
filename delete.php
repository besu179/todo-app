<?php
// delete.php - Simple deletion handler

// Check if ID exists
if (isset($_GET['id'])) {
    // Database connection
    $host = "localhost";
    $dbname = "todo_app";
    $username = "root";
    $password = "";
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        $id = $_GET['id'];
        
        $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
        $stmt->execute([$id]);
        
    } catch (PDOException $e) {
    }
}

header("Location: index.php");
exit;
?>