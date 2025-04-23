<?php
include_once 'connection.php';

// Export to Excel if requested
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=orders_report.xls");

    echo "Order ID\tCustomer Name\tOrder Date\tStatus\tAmount (Kshs)\tPayment Method\tShipping Address\n";

    $export_sql = 'SELECT o.order_id, c.name AS customer_name, o.order_date, o.status, o.total_amount, o.payment_method, o.shipping_address
                   FROM orders o
                   JOIN customers c ON o.customer_id = c.customer_id
                   ORDER BY o.order_date DESC';
    $export_result = $conn->query($export_sql);

    while ($order = $export_result->fetch_assoc()) {
        echo $order['order_id'] . "\t" .
             $order['customer_name'] . "\t" .
             $order['order_date'] . "\t" .
             $order['status'] . "\t" .
             number_format($order['total_amount'], 2) . "\t" .
             $order['payment_method'] . "\t" .
             $order['shipping_address'] . "\n";
    }
    exit;
}

// Fetch orders for display
$sql = 'SELECT o.order_id, c.name AS customer_name, o.order_date, o.status, o.total_amount, o.payment_method, o.shipping_address
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        ORDER BY o.order_date DESC';
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-900 text-white">
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-green-500">Manage Orders</h1>

    <a href="?export=excel" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block mb-4">Download Excel Report</a>

    <table class="min-w-full bg-gray-800 border border-gray-700">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b border-gray-700">Order ID</th>
          <th class="py-2 px-4 border-b border-gray-700">Customer</th>
          <th class="py-2 px-4 border-b border-gray-700">Date</th>
          <th class="py-2 px-4 border-b border-gray-700">Status</th>
          <th class="py-2 px-4 border-b border-gray-700">Amount (Kshs)</th>
          <th class="py-2 px-4 border-b border-gray-700">Payment Method</th>
          <th class="py-2 px-4 border-b border-gray-700">Shipping Address</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($order = $result->fetch_assoc()): ?>
          <tr>
            <td class="py-2 px-4 border-b border-gray-700"><?php echo $order['order_id']; ?></td>
            <td class="py-2 px-4 border-b border-gray-700"><?php echo htmlspecialchars($order['customer_name']); ?></td>
            <td class="py-2 px-4 border-b border-gray-700"><?php echo $order['order_date']; ?></td>
            <td class="py-2 px-4 border-b border-gray-700"><?php echo $order['status']; ?></td>
            <td class="py-2 px-4 border-b border-gray-700"><?php echo number_format($order['total_amount'], 2); ?></td>
            <td class="py-2 px-4 border-b border-gray-700"><?php echo $order['payment_method']; ?></td>
            <td class="py-2 px-4 border-b border-gray-700"><?php echo htmlspecialchars($order['shipping_address']); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

<?php $conn->close(); ?>
