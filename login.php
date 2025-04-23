<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // default username for WAMP
$password = ""; // default password for WAMP is empty
$dbname = "kilimokedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include PHPMailer
require 'C:\wamp64\www\KilimoKe 3rd Trial\send_otp_email.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Securely query the database using email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("s", $email);

    // Execute statement
    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    // Get result
    $result = $stmt->get_result();

    // Check if there is a user with the provided email
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, generate OTP and send it
            $otp = rand(100000, 999999); // Generate a 6-digit OTP
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_email'] = $email;

            // Send OTP via email using PHPMailer
            sendOtpEmail($email, $otp);

            // Redirect to OTP verification page
            header("Location: verify_otp.php");
            exit();
        } else {
            // Invalid password, set a session variable for displaying an error message
            $_SESSION['login_error'] = true;
            echo '<script>alert("Invalid credentials. Please try again."); window.location.href = "Login.html";</script>';
            exit();
        }
    } else {
        // No user found with that email, set a session variable for displaying an error message
        $_SESSION['login_error'] = true;
        echo '<script>alert("No user found with that email. Please try again."); window.location.href = "Login.html";</script>';
        exit();
    }

    // Close statement
    if ($stmt instanceof mysqli_stmt) {
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
