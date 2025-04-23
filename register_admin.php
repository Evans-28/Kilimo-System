<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kilimokedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO admins (name, email, phone, password) VALUES ('$fullname', '$email', '$phone', '$hashed_password')";


        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='Login.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
