<?php
session_start();  // Start the session to access the session variables
require 'config.php';  // Include your database configuration

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to delete your account.";
    exit;  // Stop the script if the user is not logged in
}

$user_id = $_SESSION['user_id'];

// Query to get the user's profile picture path from the database
$query = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();  // Fetch the user data

if ($user) {
    $profile_picture = $user['profile_pic'];

    // Delete the user from the database
    $delete_query = "DELETE FROM users WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $user_id);
    if ($delete_stmt->execute()) {
        // Remove the user's profile picture from the server
        $profile_picture_path = "uploads/" . $profile_picture;
        if (file_exists($profile_picture_path)) {
            unlink($profile_picture_path);  // Delete the profile picture file
        }

        // Destroy the session to log the user out
        session_destroy();
        header("Location: register.html");  // Redirect to a goodbye page
        exit;
    } else {
        echo "Error deleting account.";
    }
} else {
    echo "User not found.";
}
?>
