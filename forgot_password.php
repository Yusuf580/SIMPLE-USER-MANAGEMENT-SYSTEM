<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgot_password.css"> <!-- Link to external CSS -->
</head>
<body>

    <div class="container">
        <div class="form-box">
            <h2>Reset Password</h2>
            <?php
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                if ($status == "success") {
                    echo "<div class='alert success'>A password reset link has been sent to your email.</div>";
                } elseif ($status == "error") {
                    echo "<div class='alert error'>No account found with that email.</div>";
                } elseif ($status == "failed") {
                    echo "<div class='alert error'>Failed to send email. Please try again later.</div>";
                }
            }
            ?>
            <form action="process_forgot_password.php" method="post">
                <div class="form-group">
                    <input type="email" name="email" required placeholder="Enter your email">
                </div>
                <button type="submit">Send Reset Link</button>
            </form>
            <p class="login-link"><a href="login.html">Back to Login</a></p>
        </div>
    </div>

</body>
</html>
