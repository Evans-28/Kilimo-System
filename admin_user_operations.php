<?php
include('connection.php');

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully'); window.location.href='admin_user_management.html';</script>";
    } else {
        echo "<script>alert('Error deleting user'); window.location.href='admin_user_management.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
