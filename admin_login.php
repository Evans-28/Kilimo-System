<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kilimokedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM admins WHERE email='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['id'];
            echo "<script>alert('Login successful!'); window.location.href='admin_dashboard.html';</script>";
        } else {
            echo "<script>alert('Wrong password or username!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Wrong password or username!'); window.history.back();</script>";
    }
}

$conn->close();
?>
