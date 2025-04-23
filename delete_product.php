<?php
include('connection.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully'); window.location.href='admin_product_management.php';</script>";
    } else {
        echo "<script>alert('Error deleting product'); window.location.href='admin_product_management.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
