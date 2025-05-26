<?php
// Initialize variables
$error = '';
$email = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get database connection
        $database = require 'db.php';

        // Sanitize and validate email
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Get password (don't sanitize passwords, we'll hash it)
        $password = $_POST['password'] ?? '';
        if (empty($password)) {
            throw new Exception("Password is required");
        }

        // Secure query with prepared statement
        $stmt = $database->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User not found");
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            throw new Exception("Incorrect password");
        }

        // Login successful - start session
        session_start();
        $_SESSION['user_id'] = $user['id'];

        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="Enter Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="signup.html">Create an account</a>.</p>
        <p>lost password? <a href="forgot-password.php">Reset</a></p>

    </div>
</body>

</html>