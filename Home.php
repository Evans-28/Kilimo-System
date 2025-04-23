<?php
include_once 'connection.php';

// Fetch products
$sql = 'SELECT * FROM products WHERE quantity > 0';
$result = $conn->query( $sql );
?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Home - KilimoKe</title>
<link href = 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel = 'stylesheet'>
<script>

function addToCart( product ) {
    console.log( 'Adding to cart:', product );
    let cart = JSON.parse( localStorage.getItem( 'cart' ) ) || [];
    const existingProduct = cart.find( item => item.id === product.id );
    if ( existingProduct ) {
        existingProduct.quantity += 1;
    } else {
        product.quantity = 1;
        cart.push( product );
    }
    localStorage.setItem( 'cart', JSON.stringify( cart ) );
    alert( `$ {
        product.name}
        has been added to your cart.` );
    }
    </script>
    </head>
    <body class = 'bg-gray-900 text-gray-200'>

    <!-- Navigation -->
    <nav class = 'bg-green-800 p-4'>
    <div class = 'container mx-auto flex justify-between items-center'>
    <a href = 'Home.php' class = 'text-white text-2xl font-bold'>KilimoKe</a>
    <div class = 'space-x-4'>
    <a href = 'Home.php' class = 'text-gray-300 hover:text-white hover:underline'>Home</a>
    <a href = 'ViewCart.html' class = 'text-gray-300 hover:text-white hover:underline'>View Cart</a>
    <a href = 'Login.html' class = 'text-gray-300 hover:text-white hover:underline'>Login</a>
    <a href = 'ContactUs.html' class = 'text-gray-300 hover:text-white hover:underline'>Contact Us</a>
    <a href = 'AboutUs.html' class = 'text-gray-300 hover:text-white hover:underline'>About Us</a>
    </div>
    </div>
    </nav>

    <!-- Product Listings -->
    <div class = 'container mx-auto my-12 p-6 bg-gray-800 rounded shadow'>
    <h1 class = 'text-3xl font-bold text-gray-100 mb-4'>Available Products</h1>
    <div class = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
    <?php while ( $product = $result->fetch_assoc() ): ?>
    <div class = 'bg-gray-700 rounded shadow p-6'>
    <img src = "images/<?php echo htmlspecialchars($product['image']); ?>" alt = "<?php echo htmlspecialchars($product['name']); ?>" class = 'w-full h-48 object-cover rounded mb-4'>
    <h2 class = 'text-xl font-semibold mb-2'><?php echo htmlspecialchars( $product[ 'name' ] );
    ?></h2>
    <p class = 'text-gray-300 mb-4'><?php echo nl2br( htmlspecialchars( $product[ 'description' ] ) );
    ?></p>
    <p class = 'text-green-400 font-bold mb-4'>Kshs. <?php echo number_format( $product[ 'price' ], 2 );
    ?></p>
    <button onclick = 'addToCart({id: <?php echo $product["id"]; ?>, name: "<?php echo htmlspecialchars($product["name"]); ?>", price: <?php echo $product["price"]; ?>, image: "images/<?php echo htmlspecialchars($product["image"]); ?>"})' class = 'bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700'>Add to Cart</button>
    </div>
    <?php endwhile;
    ?>
    </div>
    </div>

    <!-- Footer -->
    <footer class = 'bg-gray-800 text-white py-8'>
    <div class = 'container mx-auto px-4 flex flex-wrap justify-between'>
    <div class = 'w-full md:w-1/4 mb-8 md:mb-0'>
    <h2 class = 'text-xl font-bold mb-4'>About Us</h2>
    <img src = 'Images/16cb1ad44488d21a13f74756c54d655d.jpg' alt = 'KilimoKe Logo' class = 'mb-1' />
    <p class = 'font-semibold'>KilimoKe</p>
    <p>P.O. Box 14133 - 00800 Nairobi, Kenya</p>
    <div class = 'flex space-x-4 mt-4'>
    <a href = 'https://web.facebook.com/?_rdc=1&_rdr' aria-label = 'Facebook'><img src = 'Images/660bcb3e9408cfa1747d2d6e4c8c4526.png' alt = 'Facebook' /></a>
    <a href = 'https://x.com/?lang=en' aria-label = 'Twitter'><img src = 'Images/F1x5VdQX0AA9Sgt.jpeg' alt = 'Twitter' /></a>
    <a href = 'https://www.instagram.com/' aria-label = 'Instagram'><img src = 'Images/Instagram_logo_2016.svg.png' alt = 'Instagram' /></a>
    <a href = 'https://ke.linkedin.com/' aria-label = 'LinkedIn'><img src = 'Images/linkedin-400850_640-1.webp' alt = 'LinkedIn' /></a>
    </div>
    </div>

    <div class = 'w-full md:w-1/4 mb-8 md:mb-0'>
    <h2 class = 'text-xl font-bold mb-4'>Latest Tweets</h2>
    <p>- Tupigie rununu, we are ready to take your farming to another level.</p>
    <p>- Products zetu ni legit.</p>
    <p>- We do deliveries all over the country.</p>
    </div>

    <div class = 'w-full md:w-1/4 mb-8 md:mb-0'>
    <h2 class = 'text-xl font-bold mb-4'>Latest Posts</h2>
    <p>- Flooding in the western region of the country.</p>
    <p>- Imported Fertilizer from Russia goes missing.</p>
    <p>- Farmers in Central Kenya expected to have a bumper harvest this season.</p>
    <p>- Irrigation schemes become a norm in the North Eastern regions of Kenya.</p>
    </div>

    <div class = 'w-full md:w-1/4 mb-8 md:mb-0'>
    <h2 class = 'text-xl font-bold mb-4'>Gallery Photos</h2>
    <div class = 'grid grid-cols-3 gap-2'>
    <img src = 'Images/15d25769c49bc0005a214faa5a0554bd.jpg' alt = 'Product 1' />
    <img src = 'Images/54f649a309b58113c781e966e74c88da.jpg' alt = 'Product 2' />
    <img src = 'Images/MF1800-E-Series-01-scaled.jpg' alt = 'Product 3' />
    <img src = 'Images/7b529efbd2c3de7a800a0890d53cca99.jpg' alt = 'Product 4' />
    <img src = 'Images/10f30cdafd43e8389175b0d010e50df9.jpg' alt = 'Product 5' />
    <img src = 'Images/e4f5e44062f41e94bd44c19bb4469414.jpg' alt = 'Product 6' />
    </div>
    </div>
    </div>
    <div class = 'bg-gray-900 py-4 mt-8'>
    <div class = 'container mx-auto px-4 flex flex-wrap justify-between items-center'>
    <p class = 'text-sm'>&copy;
    2024 KilimoKe. All Rights Reserved.</p>
    <div class = 'flex space-x-4 text-sm'>
    <a href = 'Home.php' class = 'hover:underline'>Home</a>
    <a href = 'ViewCart.html' class = 'hover:underline'>View Cart</a>
    <a href = 'Login.html' class = 'hover:underline'>Login</a>
    <a href = 'ContactUs.html' class = 'hover:underline'>Contact Us</a>
    <a href = 'AboutUs.html' class = 'hover:underline'>About Us</a>
    </div>
    </div>
    </div>
    </footer>

    <?php
    $conn->close();
    ?>
    </body>
    </html>
