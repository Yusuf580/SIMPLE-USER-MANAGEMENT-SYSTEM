<?php
require 'config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verify token
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);  // Bind the token parameter as a string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Fetch associative array

    if ($user) {
        // Update the password field (correcting 'password' to 'pass_word')
        $stmt = $conn->prepare("UPDATE users SET pass_word = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("ss", $password, $token);  // Bind parameters
        $stmt->execute();

        echo "Password reset successful. <a href='login.html'>Login</a>";
    } else {
        echo "Invalid or expired token.";
    }
}
?>
