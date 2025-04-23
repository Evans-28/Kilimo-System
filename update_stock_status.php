<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $stock_status = $_POST['stock_status'];

    $query = "UPDATE products SET stock_status = '$stock_status' WHERE id = $product_id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Stock status updated successfully'); window.location.href='admin_product_management.php';</script>";
    } else {
        echo "<script>alert('Error updating stock status'); window.location.href='admin_product_management.php';</script>";
    }
}

mysqli_close($conn);
?>
