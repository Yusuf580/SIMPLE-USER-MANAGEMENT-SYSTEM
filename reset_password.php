<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS -->
</head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>
        <form action="process_reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
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
