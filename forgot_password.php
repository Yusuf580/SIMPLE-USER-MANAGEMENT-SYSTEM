<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS -->
</head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>
        <form action="process_forgot_password.php" method="post">
            <div class="form-group">
                <input type="email" name="email" required placeholder="Enter your email">
            </div>
            <button type="submit">Send Reset Link</button>
        </form>
        <p class="login-link"><a href="login.html">Back to Login</a></p>
    </div>
</body>
</html>
