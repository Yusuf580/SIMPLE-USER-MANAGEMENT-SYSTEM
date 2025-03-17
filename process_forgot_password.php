<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

require 'config.php'; // Database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Save the token in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'yusufandrew580@gmail.com';
            $mail->Password = 'dsxu skgo ozou rypi';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email Settings
            $mail->setFrom('your-email@gmail.com', 'Your Website');
            $mail->addAddress($email);
            $mail->Subject = "Password Reset Request";
            $mail->isHTML(true);
            $mail->Body = "Click the link below to reset your password:<br><br>
                           <a href='http://localhost/SIMPLE-USER-MANAGEMENT-SYSTEM/reset_password.php?token=$token'>Reset Password</a>";

            $mail->send();
            header("Location: forgot_password.php?status=success");
            exit();
        } catch (Exception $e) {
            header("Location: forgot_password.php?status=failed");
            exit();
        }
    } else {
        header("Location: forgot_password.php?status=error");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
