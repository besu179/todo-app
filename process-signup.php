<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
        die('All fields are required');
    }
    if (strlen($_POST['user_name']) < 4) {
        die('Username must be at least 4 characters long');
    }
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*?&]).{8,}$/', $_POST['password'])) {
        die('Password must contain:
        - At least 8 characters
        - 1 uppercase letter (A-Z)
        - 1 lowercase letter (a-z) 
        - 1 number (0-9)
        - 1 special character (@$!%*?&)');
    }
    if (!($_POST['password'] == $_POST['confirm_password'])) {
        die('password dont match');
    }

    if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die('invalid email');
    }

    $name = $_POST['user_name'];
    $email = ($_POST['email']);

    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $database = require 'db.php';

    try {
        $stmt = $database->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);

        echo "✅ registered successfully! <a href='login.php'>Login</a>";
    } catch (PDOException $e) {
        die("❌ Registration failed: " . $e->getMessage());
    }

    echo '<h1>signup successfully</h1>';
}
