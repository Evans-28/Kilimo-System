<?php
// Database connection parameters
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'kilimokedb';

// Create connection
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $phone = $_POST['country-code'] . $_POST['phone'];
    $address = $_POST['address'];

    // Perform basic validation
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($phone) || empty($address)) {
        echo "<script>alert('Please fill in all fields.'); history.back();</script>";
        exit;
    }

    // Password matching validation
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); history.back();</script>";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashedPassword, $phone, $address);

    if ($stmt->execute()) {
        // Registration success
        echo "<script>alert('Registration successful. Please login.'); window.location = 'Login.html';</script>";
        exit;
    } else {
        echo "Error: " . $mysqli->error;
    }

    $stmt->close();
}

// Close database connection
$mysqli->close();
?>
