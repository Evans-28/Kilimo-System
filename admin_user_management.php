<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Management</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your common stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

    <!-- Navigation Panel -->
    <nav class="bg-green-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="admin_dashboard.html" class="text-white text-2xl font-bold">Admin Dashboard</a>
            <div>
                <a href="logout.php" class="text-white ml-4">Log Out</a>
            </div>
        </div>
    </nav>

    <!-- User Management -->
    <div class="container mx-auto my-12">
        <h1 class="text-3xl font-bold text-green-500 text-center mb-8">User Management</h1>
        
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kilimokedb";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, name, email, phone, address FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='min-w-full bg-gray-800'>";
            echo "<thead class='bg-green-800 text-white'>";
            echo "<tr>";
            echo "<th class='w-1/5 px-6 py-3'>Name</th>";
            echo "<th class='w-1/5 px-6 py-3'>Email</th>";
            echo "<th class='w-1/5 px-6 py-3'>Phone</th>";
            echo "<th class='w-1/5 px-6 py-3'>Address</th>";
            echo "<th class='w-1/5 px-6 py-3'>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody class='text-gray-300'>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['address']) . "</td>";
                echo "<td class='px-6 py-4'>";
                echo "<a href='edit_user.php?id=" . $row['id'] . "' class='text-blue-400 hover:text-blue-600'>Edit</a> | ";
                echo "<a href='delete_user.php?id=" . $row['id'] . "' class='text-red-400 hover:text-red-600' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='text-center text-gray-500'>No users found</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 flex flex-wrap justify-between">
          <!-- Footer Content -->
        </div>
        <div class="bg-gray-900 py-4 mt-8">
          <div class="container mx-auto px-4 flex flex-wrap justify-between items-center">
            <p class="text-sm">&copy; 2024 KilimoKe. All Rights Reserved.</p>
            <div class="flex space-x-4 text-sm">
            <a href="Home.html" class="hover:underline">Home</a>
            <a href="ViewCart.html" class="hover:underline">ViewCart</a>
            <a href="Login.html" class="hover:underline">Login</a>
            <a href="ContactUs.html" class="hover:underline">Contact Us</a>
            <a href="AboutUs.html" class="hover:underline">About Us</a>
            </div>
          </div>
        </div>
      </footer>

</body>
</html>
