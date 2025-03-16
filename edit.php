<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT username, email, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'];
$email = $user['email'];
$profile_picture = $user['profile_pic'] ?: "default.png";  // Default profile image
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to CSS -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <hr class="separator">
            <ul>
                <li><a href="dashboard.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="edit.php" class="nav-link active"><i class="fas fa-edit"></i> Edit</a></li>
                <li><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <li><a href="delete.php" class="nav-link"><i class="fas fa-trash-alt"></i> Delete Account</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1>Edit Profile</h1>
            <form action="update_profile.php" method="post" enctype="multipart/form-data" class="profile-form">
                <!-- Profile Picture Preview -->
                <div class="form-group profile-pic-container">
                    <img id="profilePreview" src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture">
                </div>

                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username:</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="form-group">
                    <label for="profile_picture"><i class="fas fa-image"></i> Profile Picture:</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="form-group">
                    <button type="submit" name="update"><i class="fas fa-save"></i> Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Image Preview -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const profilePreview = document.getElementById('profilePreview');
                profilePreview.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Highlight active page in sidebar
        document.addEventListener("DOMContentLoaded", function () {
            let currentPage = window.location.pathname.split("/").pop();
            let navLinks = document.querySelectorAll(".nav-link");

            navLinks.forEach(link => {
                if (link.getAttribute("href") === currentPage) {
                    link.classList.add("active");
                }
            });
        });
    </script>
</body>
</html>
