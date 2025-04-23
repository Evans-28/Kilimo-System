<?php
// Database connection parameters
$dbHost = 'localhost'; // Usually 'localhost' or IP address
$dbUsername = 'root'; // MySQL username
$dbPassword = ''; // MySQL password
$dbName = 'kilimokedb'; // MySQL database name

// Create connection
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate inputs (basic validation)
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        echo "Please fill in all fields.";
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if email exists in database
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        // Email not found in database
        echo "<script>alert('Email address does not exist.'); window.location = 'ChangePswd.html';</script>";
        exit;
    }

    // Update password in database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateStmt = $mysqli->prepare("UPDATE users SET password = ? WHERE email = ?");
    $updateStmt->bind_param("ss", $hashedPassword, $email);

    if ($updateStmt->execute()) {
        echo "<script>alert('Password updated successfully.'); window.location = 'Login.html';</script>";
        exit;
    } else {
        echo "Error updating password: " . $mysqli->error;
    }

    $updateStmt->close();
    $stmt->close();
}

// Close database connection
$mysqli->close();
?>
