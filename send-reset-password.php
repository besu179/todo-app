<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];



    $token = bin2hex(random_bytes(16));
    $token_hash = hash('sha256', $token);
    $expiry = date('Y-m-d H:i:s', time() + 60 * 30); // 30 minutes expiry

    // Connect to database
    $connection = require 'db.php';

    try {
        $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            die("Email not found in our system");
        }

        // Update user with reset token
        $stmt = $connection->prepare("
            UPDATE users 
            SET reset_token_hash = ?,
                unique_token_expires_at = ? 
            WHERE email = ?
        ");
        $stmt->execute([$token_hash, $expiry, $email]);

        // Send email with reset link (implementation depends on your mailer)
        $reset_link = "https://yourdomain.com/reset_password_form.php?token=$token";

        // For testing, you can output the link:
        echo "Reset link: $reset_link";

        // In production, you would actually send an email:
        // mail($email, "Password Reset", "Click here to reset: $reset_link");

        echo "Password reset link has been sent to your email";
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
