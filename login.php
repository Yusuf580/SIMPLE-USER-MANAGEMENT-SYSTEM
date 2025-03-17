<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $conn->prepare("SELECT id, username, pass_word FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If user exists, fetch details
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            if ($remember) {
                setcookie("user_email", $email, time() + (86400 * 30), "/");
            }

            header("Location: dashboard.php");
            exit();
        }
    }

    // Redirect to login with an error message
    header("Location: login.html?error=invalid");
    exit();
}
?>
