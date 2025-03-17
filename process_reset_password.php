<?php
require 'config.php'; // Include database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php?token=$token");
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verify token validity
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Update password and clear the token
        $stmt = $conn->prepare("UPDATE users SET pass_word = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("ss", $hashed_password, $token);
        $stmt->execute();

        $_SESSION['success'] = "Password reset successful. You can now <a href='login.html' style='display: inline-block; padding: 5px 10px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; transition: background-color 0.3s ease;'>login</a>.";
        header("Location: reset_password.php?token=$token");
        exit();
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: reset_password.php?token=$token");
        exit();
    }
}
?>
