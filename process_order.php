<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\PHPMailer.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\Exception.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\SMTP.php';

// Database config
$host = 'localhost';
$db   = 'kilimokedb';
$user = 'root';
$pass = ''; // update if needed
$conn = new mysqli($host, $user, $pass, $db);

// Check DB connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Retrieve and decode the JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['user'], $data['cart'], $data['subtotal'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid order data']);
    exit;
}

$cart = $data['cart'];
$subtotal = floatval($data['subtotal']);
$userName = $conn->real_escape_string($data['user']['name']);
$userEmail = $conn->real_escape_string($data['user']['email']);
$payment_method = 'Mpesa'; // static for now
$shipping_address = ''; // optional

$conn->begin_transaction();

try {
    // Insert into customers
    $conn->query("INSERT INTO customers (name, email) VALUES ('$userName', '$userEmail')");
    $customer_id = $conn->insert_id;

    // Insert into orders
    $conn->query("INSERT INTO orders (customer_id, status, total_amount, payment_method, shipping_address)
                  VALUES ($customer_id, 'pending', $subtotal, '$payment_method', '$shipping_address')");
    $order_id = $conn->insert_id;

    // Insert into order_items
    foreach ($cart as $item) {
        $product_name = $conn->real_escape_string($item['name']);
        $price = floatval($item['price']);
        $quantity = isset($item['quantity']) ? intval($item['quantity']) : 1;

        $conn->query("INSERT INTO order_items (order_id, product_name, price, quantity)
                      VALUES ($order_id, '$product_name', $price, $quantity)");
    }

    $conn->commit();

    // ==== EMAIL TO USER ====
    $userMail = new PHPMailer(true);
    try {
        $userMail->isSMTP();
        $userMail->Host = 'smtp.gmail.com';
        $userMail->SMTPAuth = true;
        $userMail->Username = 'evandroonyango28@gmail.com';
        $userMail->Password = 'rcodbeeykgopykuq';
        $userMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $userMail->Port = 587;

        $userMail->setFrom('evandroonyango28@gmail.com', 'KilimoKe');
        $userMail->addAddress($userEmail, $userName);
        $userMail->isHTML(true);
        $userMail->Subject = 'Order Confirmation';

        $userMail->Body = "<h1>Order Confirmation</h1>
                           <p>Dear $userName,</p>
                           <p>Thank you for your order! Here are the details:</p>
                           <table border='1' cellpadding='5' cellspacing='0'>
                               <tr><th>Product</th><th>Price</th></tr>";

        foreach ($cart as $item) {
            $userMail->Body .= "<tr><td>{$item['name']}</td><td>KES {$item['price']}</td></tr>";
        }

        $userMail->Body .= "</table>
                            <p>Cart Subtotal: KES $subtotal</p>
                            <p>Thank you for shopping with us!</p>";

        $userMail->send();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to send order confirmation to user']);
        exit;
    }

    // ==== EMAIL TO ADMIN ====
    $adminMail = new PHPMailer(true);
    try {
        $adminMail->isSMTP();
        $adminMail->Host = 'smtp.gmail.com';
        $adminMail->SMTPAuth = true;
        $adminMail->Username = 'evandroonyango28@gmail.com';
        $adminMail->Password = 'rcodbeeykgopykuq';
        $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $adminMail->Port = 587;

        $adminMail->setFrom('your-email@example.com', 'KilimoKe');
        $adminMail->addAddress('evandroonyango28@gmail.com');
        $adminMail->isHTML(true);
        $adminMail->Subject = 'New Order Received';

        $adminMail->Body = "<h1>New Order Received</h1>
                            <p>Order Details:</p>
                            <table border='1' cellpadding='5' cellspacing='0'>
                                <tr><th>Product</th><th>Price</th></tr>";

        foreach ($cart as $item) {
            $adminMail->Body .= "<tr><td>{$item['name']}</td><td>KES {$item['price']}</td></tr>";
        }

        $adminMail->Body .= "</table>
                             <p>Cart Subtotal: KES $subtotal</p>
                             <p>Order placed by: $userName (Email: $userEmail)</p>";

        $adminMail->send();

        echo json_encode(['success' => true, 'message' => 'Order processed and emails sent']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to send order notification to admin']);
    }

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Order failed: ' . $e->getMessage()]);
}

$conn->close();
