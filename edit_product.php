<?php
include('connection.php');

$product_id = $_GET['id'];

// Fetch product details from the database
$sql = "SELECT id, name, description, price, quantity FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Update product details in the database
    $update_sql = "UPDATE products SET name = ?, description = ?, price = ?, quantity = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssdii", $name, $description, $price, $quantity, $product_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Product updated successfully'); window.location.href='admin_product_management.php';</script>";
    } else {
        echo "<script>alert('Error updating product');</script>";
    }

    $update_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto my-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Product</h1>
        <form action="" method="post" class="bg-white p-8 rounded shadow-md">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded">Update Product</button>
        </form>
    </div>
</body>
</html>
