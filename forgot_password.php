<?php
session_start();
include "config.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Generate a random OTP (you can define your OTP generation logic)
        $otp = rand(100000, 999999);

        // Store OTP and its expiration time in the database
        $expiry_time = time() + (15 * 60); // OTP is valid for 15 minutes
        $sql = "INSERT INTO password_reset_tokens (email, otp, expiry_time) VALUES ('$email', '$otp', '$expiry_time')";
        mysqli_query($conn, $sql);

        // Send the OTP to the user's email (you can use your sendMail function)
        sendMail($email, "Password Reset OTP", "Your OTP is: $otp");

        // Redirect the user to the OTP verification page
        header("Location: otp_verification.php");
        exit();
    } else {
        // Email not found in the database
        echo "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <button type="submit" name="submit">Send OTP</button>
    </form>
</body>
</html>
