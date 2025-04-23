<?php
include_once 'connection.php';

// Add a new product
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'add_product' ] ) ) {
    $name = $_POST[ 'name' ];
    $description = $_POST[ 'description' ];
    $price = $_POST[ 'price' ];
    $quantity = $_POST[ 'quantity' ];

    // Handle file upload
    $image = $_FILES[ 'image' ][ 'name' ];
    if ( $image ) {
        $target_dir = 'images/';
        $target_file = $target_dir . basename( $image );
        move_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ], $target_file );
    } else {
        $image = '';
        // Set a default or empty value if no image is uploaded
    }

    $sql = 'INSERT INTO products (name, description, price, quantity, image) VALUES (?, ?, ?, ?, ?)';
    $stmt = $conn->prepare( $sql );
    $stmt->bind_param( 'ssdis', $name, $description, $price, $quantity, $image );
    $stmt->execute();
    $stmt->close();
}

// Edit a product
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'edit_product' ] ) ) {
    $id = $_POST[ 'id' ];
    $name = $_POST[ 'name' ];
    $description = $_POST[ 'description' ];
    $price = $_POST[ 'price' ];
    $quantity = $_POST[ 'quantity' ];

    $image = $_FILES[ 'image' ][ 'name' ];
    if ( $image ) {
        $target_dir = 'images/';
        $target_file = $target_dir . basename( $image );
        move_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ], $target_file );
        $sql = 'UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, image = ? WHERE id = ?';
        $stmt = $conn->prepare( $sql );
        $stmt->bind_param( 'ssdisi', $name, $description, $price, $quantity, $image, $id );
    } else {
        $sql = 'UPDATE products SET name = ?, description = ?, price = ?, quantity = ? WHERE id = ?';
        $stmt = $conn->prepare( $sql );
        $stmt->bind_param( 'ssdis', $name, $description, $price, $quantity, $id );
    }
    $stmt->execute();
    $stmt->close();
}

// Delete a product
if ( isset( $_GET[ 'delete_id' ] ) ) {
    $id = intval( $_GET[ 'delete_id' ] );
    $sql = 'DELETE FROM products WHERE id = ?';
    $stmt = $conn->prepare( $sql );
    $stmt->bind_param( 'i', $id );
    $stmt->execute();
    $stmt->close();
}

// Fetch products
$sql = 'SELECT * FROM products';
$result = $conn->query( $sql );
?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Admin Product Management</title>
<link href = 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel = 'stylesheet'>
</head>
<body class = 'bg-gray-900 text-white'>

<div class = 'container mx-auto p-6'>
<h1 class = 'text-2xl font-bold mb-4 text-green-500'>Manage Products</h1>

<!-- Add Product Form -->
<form action = '' method = 'post' enctype = 'multipart/form-data' class = 'mb-8 bg-gray-800 p-6 rounded shadow-md'>
<h2 class = 'text-xl font-semibold mb-2 text-green-400'>Add New Product</h2>
<div class = 'mb-4'>
<label for = 'name' class = 'block text-sm font-medium text-gray-300'>Product Name</label>
<input type = 'text' name = 'name' id = 'name' class = 'mt-1 block w-full border border-gray-600 bg-gray-700 text-white rounded-md shadow-sm' required>
</div>
<div class = 'mb-4'>
<label for = 'description' class = 'block text-sm font-medium text-gray-300'>Description</label>
<textarea name = 'description' id = 'description' rows = '3' class = 'mt-1 block w-full border border-gray-600 bg-gray-700 text-white rounded-md shadow-sm' required></textarea>
</div>
<div class = 'mb-4'>
<label for = 'price' class = 'block text-sm font-medium text-gray-300'>Price</label>
<input type = 'number' name = 'price' id = 'price' class = 'mt-1 block w-full border border-gray-600 bg-gray-700 text-white rounded-md shadow-sm' step = '0.01' required>
</div>
<div class = 'mb-4'>
<label for = 'quantity' class = 'block text-sm font-medium text-gray-300'>Quantity</label>
<input type = 'number' name = 'quantity' id = 'quantity' class = 'mt-1 block w-full border border-gray-600 bg-gray-700 text-white rounded-md shadow-sm' required>
</div>
<div class = 'mb-4'>
<label for = 'image' class = 'block text-sm font-medium text-gray-300'>Image</label>
<input type = 'file' name = 'image' id = 'image' class = 'mt-1 block w-full border border-gray-600 bg-gray-700 text-white rounded-md shadow-sm'>
</div>
<button type = 'submit' name = 'add_product' class = 'bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700'>Add Product</button>
</form>

<!-- Product List -->
<h2 class = 'text-xl font-semibold mb-2 text-green-400'>Product List</h2>
<table class = 'min-w-full bg-gray-800 border border-gray-700'>
<thead>
<tr>
<th class = 'py-2 px-4 border-b border-gray-700'>ID</th>
<th class = 'py-2 px-4 border-b border-gray-700'>Name</th>
<th class = 'py-2 px-4 border-b border-gray-700'>Description</th>
<th class = 'py-2 px-4 border-b border-gray-700'>Price</th>
<th class = 'py-2 px-4 border-b border-gray-700'>Quantity</th>
<th class = 'py-2 px-4 border-b border-gray-700'>Image</th>
<th class = 'py-2 px-4 border-b border-gray-700'>Actions</th>
</tr>
</thead>
<tbody>
<?php while ( $product = $result->fetch_assoc() ): ?>
<tr>
<td class = 'py-2 px-4 border-b border-gray-700'><?php echo htmlspecialchars( $product[ 'id' ] );
?></td>
<td class = 'py-2 px-4 border-b border-gray-700'><?php echo htmlspecialchars( $product[ 'name' ] );
?></td>
<td class = 'py-2 px-4 border-b border-gray-700'><?php echo htmlspecialchars( $product[ 'description' ] );
?></td>
<td class = 'py-2 px-4 border-b border-gray-700'>Kshs. <?php echo number_format( $product[ 'price' ], 2 );
?></td>
<td class = 'py-2 px-4 border-b border-gray-700'><?php echo htmlspecialchars( $product[ 'quantity' ] );
?></td>
<td class = 'py-2 px-4 border-b border-gray-700'>
<?php if ( $product[ 'image' ] ): ?>
<img src = "images/<?php echo htmlspecialchars($product['image']); ?>" alt = "<?php echo htmlspecialchars($product['name']); ?>" class = 'w-16 h-16 object-cover'>
<?php endif;
?>
</td>
<td class = 'py-2 px-4 border-b border-gray-700'>
<a href = "?edit_id=<?php echo $product['id']; ?>" class = 'text-blue-400 hover:underline'>Edit</a> |
<a href = "?delete_id=<?php echo $product['id']; ?>" class = 'text-red-400 hover:underline' onclick = "return confirm('Are you sure you want to delete this product?')">Delete</a>
</td>
</tr>
<?php endwhile;
?>
</tbody>
</table>
</div>

</body>
</html>

<?php
$conn->close();
?>
