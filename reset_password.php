<?php
session_start();
include "config.php";

if (isset($_POST['reset'])) {
    $email = $_SESSION['reset_email'];
    $new_password = $_POST['new_password'];

    // Update the user's password in the database (you should hash the password)
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
    mysqli_query($conn, $sql);

    // Delete the used OTP token
    $sql = "DELETE FROM password_reset_tokens WHERE email = '$email'";
    mysqli_query($conn, $sql);

    // Redirect the user to the login page or a success page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post" action="">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit" name="reset">Reset Password</button>
    </form>
</body>
</html>
