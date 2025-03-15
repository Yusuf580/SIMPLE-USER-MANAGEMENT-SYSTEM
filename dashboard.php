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
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to external CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
    <div class="sidebar">
        <h2>Dashboard</h2>
        <hr class="separator">
        <ul>
            <li><a href="dashboard.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="edit.php" class="nav-link"><i class="fas fa-edit"></i> Edit</a></li>
            <li><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <li><a href="delete.php" class="nav-link"><i class="fas fa-trash-alt"></i> Delete Account</a></li>
        </ul>
    </div>


        <div class="content">
            <h1>Welcome Back, <?php echo htmlspecialchars($username); ?>!</h1>
            <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture">
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let currentPage = window.location.pathname.split("/").pop(); // Get current page filename
        let navLinks = document.querySelectorAll(".nav-link");

        navLinks.forEach(link => {
            if (link.getAttribute("href") === currentPage) {
                link.classList.add("active"); // Add 'active' class to current page link
            }
        });
    });
</script>

</html>
