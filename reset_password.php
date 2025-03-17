<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS -->
    <style>
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
        }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>

        <?php
        session_start();
        if (isset($_SESSION['success'])) {
            echo "<div class='message success'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='message error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="process_reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <div class="form-group">
                <input type="password" name="password" required placeholder="Enter new password">
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" required placeholder="Confirm new password">
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
