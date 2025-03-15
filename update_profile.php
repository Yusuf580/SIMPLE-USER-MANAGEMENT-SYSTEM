<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Profile picture handling
    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = basename($_FILES['profile_picture']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $profile_picture;

        // Move uploaded file
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            // Update user info with new profile picture
            $query = "UPDATE users SET username = ?, email = ?, profile_pic = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $username, $email, $profile_picture, $user_id);
        } else {
            echo "Error uploading profile picture.";
            exit;
        }
    } else {
        // Update user info without changing profile picture
        $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $username, $email, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating profile.";
    }
}
?>
