<?php
session_start();
require 'config.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    
    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
        
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
        // Store token in the database
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expiry) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token=?, expiry=?");
        $stmt->bind_param("issss", $user_id, $token, $expiry, $token, $expiry);
        $stmt->execute();
        
        // Send email with reset link
        $reset_link = "http://yourwebsite.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n" . $reset_link;
        $headers = "From: no-reply@yourwebsite.com";
        
        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Failed to send reset email. Please try again.";
        }
    } else {
        echo "No account found with that email.";
    }
    
    $stmt->close();
    $conn->close();
}
