<?php
session_start();  // Start the session to access the session variables
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your profile.";
    exit;  // Stop the script if the user is not logged in
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Query to fetch the username and profile picture for the logged-in user
$query = "SELECT username, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);  // Bind the logged-in user ID to the query
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();  // Fetch the data as an associative array

// Check if user exists
if ($user) {
    $username = $user['username'];
    $profile_picture = $user['profile_pic'];
} else {
    // Handle case where no user is found (Optional: Redirect or show a message)
    echo "User not found.";
    exit;  // Exit if the user is not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    
    <!-- Display Username -->
    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>

    <!-- Display Profile Picture -->
    <?php if ($profile_picture): ?>
        <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" width="200">
    <?php else: ?>
        <p>No profile picture available.</p>
    <?php endif; ?>
    <br>
    <br>
    <!-- button to delete user account-->
    <button onclick="confirmDelete()">Delete Account</button>
    <script src="delete.js"></script>
</body>
</html>
