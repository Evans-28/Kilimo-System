<?php
// Include the database connection file
include 'connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);
    $delivery_address = mysqli_real_escape_string($conn, $_POST['delivery_address']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the order details in the database
    $query = "UPDATE orders SET 
              quantity = '$quantity', 
              total_price = '$total_price', 
              delivery_address = '$delivery_address', 
              status = '$status' 
              WHERE id = $order_id";

    if (mysqli_query($conn, $query)) {
        // Redirect to the order management page with a success message
        header("Location: admin_order_management.php?success=Order+updated+successfully");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
