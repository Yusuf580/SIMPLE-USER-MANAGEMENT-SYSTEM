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

// Query to fetch the username, email, and profile picture for the logged-in user
$query = "SELECT username, email, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);  // Bind the logged-in user ID to the query
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();  // Fetch the data as an associative array

// Check if user exists
if ($user) {
    $username = $user['username'];
    $profile_picture = $user['profile_pic'];
    $email = $user['email'];  // Fetch the email
} else {
    echo "User not found.";
    exit;
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
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        .popup button {
            margin-top: 10px;
            padding: 10px;
            width: 100px;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-button {
            background-color: rgb(196, 168, 90);
            color: white;
        }

        .cancel-button {
            background-color: rgb(132, 159, 177);
            color: white;
        }

        .logout-container {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Dashboard</h2>
            <hr class="separator">
            <ul>
                <li><a href="dashboard.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="edit.php" class="nav-link"><i class="fas fa-edit"></i> Edit</a></li>
                <li><a href="#" id="logoutBtn" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <!-- Add delete account button with an ID for JS -->
                <li><a href="#" id="deleteAccountBtn" class="nav-link"><i class="fas fa-trash-alt"></i> Delete Account</a></li>
            </ul>
        </div>

        <div class="content">
            <h1>Welcome Back, <?php echo htmlspecialchars($username); ?>!</h1>
            <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture">
            <p><i class="fas fa-envelope"></i> <?php echo $email; ?></p>
        </div>
    </div>

    <!-- Pop-up Confirmation for Logout -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <h3>Are you sure you want to log out?</h3>
            <button class="confirm-button" id="confirmLogout">Yes</button>
            <button class="cancel-button" id="cancelLogout">No</button>
        </div>
    </div>

    <!-- Pop-up Confirmation for Delete Account -->
    <div id="popupDelete" class="popup">
        <div class="popup-content">
            <h3>Are you sure you want to delete your account?</h3>
            <button class="confirm-button" id="confirmDelete">Yes</button>
            <button class="cancel-button" id="cancelDelete">No</button>
        </div>
    </div>

    <script>
        // Highlight the active page in the dashboard
        document.addEventListener("DOMContentLoaded", function () {
            let currentPage = window.location.pathname.split("/").pop(); // Get the current page filename
            let navLinks = document.querySelectorAll(".nav-link");

            navLinks.forEach(link => {
                // Compare href attribute with current page's filename
                if (link.getAttribute("href").split("/").pop() === currentPage) {
                    link.classList.add("active"); // Add 'active' class to the current page link
                }
            });
        });

        // Show the pop-up when clicking the logout button
        document.getElementById('logoutBtn').onclick = function(event) {
            event.preventDefault();  // Prevent the default action (redirect to logout.php)
            document.getElementById('popup').style.display = 'flex';  // Show the pop-up for logout
        };

        // Show the pop-up for deleting account when clicking the delete account button
        document.getElementById('deleteAccountBtn').onclick = function(event) {
            event.preventDefault();  // Prevent the default action (redirect to delete.php)
            document.getElementById('popupDelete').style.display = 'flex';  // Show the pop-up for delete account
        };

        // Cancel logout (hide the pop-up)
        document.getElementById('cancelLogout').onclick = function() {
            document.getElementById('popup').style.display = 'none';  // Hide the logout pop-up
        };

        // Cancel delete account (hide the pop-up)
        document.getElementById('cancelDelete').onclick = function() {
            document.getElementById('popupDelete').style.display = 'none';  // Hide the delete pop-up
        };

        // Confirm logout and redirect to logout.php
        document.getElementById('confirmLogout').onclick = function() {
            window.location.href = "logout.php";  // Redirect to logout.php
        };

        // Confirm delete and redirect to delete.php
        document.getElementById('confirmDelete').onclick = function() {
            window.location.href = "delete.php";  // Redirect to delete.php
        };

    </script>

</body>
</html>
