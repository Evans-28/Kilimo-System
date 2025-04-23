<?php
include('connection.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully'); window.location.href='admin_user_management.php';</script>";
    } else {
        echo "<script>alert('Error deleting user'); window.location.href='admin_user_management.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
