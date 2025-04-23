<?php
include_once 'connection.php';

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid product ID.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product - <?php echo htmlspecialchars($product['name']); ?></title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function addToCart(product) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingProduct = cart.find(item => item.id === product.id);
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                product.quantity = 1;
                cart.push(product);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            alert(`${product.name} has been added to your cart.`);
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navigation -->
    <nav class="bg-green-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="Home.html" class="text-white text-2xl font-bold">KilimoKe</a>
            <div class="space-x-4">
                <a href="Home.html" class="text-white hover:underline">Home</a>
                <a href="ViewCart.html" class="text-white hover:underline">View Cart</a>
                <a href="Login.html" class="text-white hover:underline">Login</a>
                <a href="ContactUs.html" class="text-white hover:underline">Contact Us</a>
                <a href="AboutUs.html" class="text-white hover:underline">About Us</a>
            </div>
        </div>
    </nav>

    <!-- Product Details -->
    <div class="container mx-auto my-12 p-6 bg-white rounded shadow">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
        <div class="flex flex-col md:flex-row">
            <!-- Product Image -->
            <div class="w-full md:w-1/2">
                <?php if (!empty($product['image'])): ?>
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-auto rounded shadow">
                <?php else: ?>
                    <img src="images/default-image.jpg" alt="Default Image" class="w-full h-auto rounded shadow">
                <?php endif; ?>
            </div>
            <!-- Product Info -->
            <div class="w-full md:w-1/2 md:ml-6">
                <p class="text-gray-600 mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p class="text-green-600 font-bold text-xl mb-4">Kshs. <?php echo number_format($product['price'], 2); ?></p>
                <p class="text-gray-600 mb-4">Quantity Available: <?php echo htmlspecialchars($product['quantity']); ?></p>
                <button onclick='addToCart({id: <?php echo $product["id"]; ?>, name: "<?php echo htmlspecialchars($product["name"]); ?>", price: <?php echo $product["price"]; ?>, image: "<?php echo htmlspecialchars($product["image"]); ?>"})' class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add to Cart</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 KilimoKe. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
