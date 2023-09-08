<?php
session_start();
include "config.php";

if (isset($_POST['verify'])) {
    $email = $_SESSION['reset_email'];
    $otp_entered = $_POST['otp'];

    // Check if the OTP matches
    $sql = "SELECT * FROM password_reset_tokens WHERE email = '$email' AND otp = '$otp_entered' AND expiry_time >= NOW()";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Redirect the user to the password reset page
        header("Location: reset_password.php");
        exit();
    } else {
        // Invalid OTP
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <h2>OTP Verification</h2>
    <form method="post" action="">
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" required>
        <button type="submit" name="verify">Verify OTP</button>
    </form>
</body>
</html>
