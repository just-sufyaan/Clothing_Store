<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect admin to login page if not logged in
    header("Location: admin_login.php");
    exit;
}

// Include DB connection
include 'DBConn.php';

// Handle form submission to update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Update the status of the order in the database
    $updateQuery = "UPDATE tblaorder SET Status = ? WHERE OrderID = ?";
    $stmtUpdate = $connect->prepare($updateQuery);
    $stmtUpdate->bind_param('si', $newStatus, $orderId);
    $stmtUpdate->execute();
    $stmtUpdate->close();
}

// Retrieve all orders
$query = "SELECT * FROM tblaorder";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="CSS/admin_styles.css">
    <link rel="stylesheet" href="CSS/admin_dashboard_styles.css">
</head>

<body>
    <div class="container">
        <h2>All Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['OrderID']; ?></td>
                        <td><?php echo $row['UserID']; ?></td>
                        <td><?php echo $row['OrderDate']; ?></td>
                        <td><?php echo $row['TotalAmount']; ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="order_id" value="<?php echo $row['OrderID']; ?>">
                                <select name="status">
                                    <option value="Processing" <?php echo ($row['Status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                    <option value="Delivered" <?php echo ($row['Status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="dashboard-link">Back to Dashboard</a>
    </div>
</body>

</html>

<?php $connect->close(); ?>
