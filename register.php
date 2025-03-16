<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $image_name = null;
    if (!empty($_FILES['profile_picture']['name'])) {
        $image = $_FILES['profile_picture'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];

        if ($image['size'] > 5 * 1024 * 1024) {
            die("File too large. Max 5MB allowed.");
        }

        if (!in_array($image['type'], $allowed_types)) {
            die("Invalid file format. Only JPG, JPEG, PNG allowed.");
        }

        $image_name = time() . "_" . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], "uploads/" . $image_name);
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, pass_word, profile_pic) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $image_name);
    
    if ($stmt->execute()) {
        header("Location: login.html?registered=success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
