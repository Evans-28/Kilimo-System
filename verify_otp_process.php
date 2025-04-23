<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];

    if ($otp == $_SESSION['otp']) {
        // OTP is correct, redirect to Home page
        header("Location: Home.php");
        exit();
    } else {
        // OTP is incorrect
        echo '<script>alert("Invalid OTP. Please try again."); window.location.href = "verify_otp.php";</script>';
        exit();
    }
}
?>
