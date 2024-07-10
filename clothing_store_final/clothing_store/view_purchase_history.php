<?php
session_start();
include 'DBConn.php';

// Retrieve purchase history
$userID = $_SESSION['user_id'];
$query = "SELECT * FROM tblaorder WHERE UserID = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="CSS/purchase_history_styles.css">
</head>

<body>
    <section class="purchase-history">
        <h2>Purchase History</h2>
        <a href="homepage.php" class="back-button">Back to Homepage</a>
        <?php if ($result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Order Time</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['OrderID']); ?></td>
                            <td><?php echo htmlspecialchars($row['OrderDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['OrderTime']); ?></td>
                            <td>R<?php echo htmlspecialchars($row['TotalAmount']); ?></td>
                            <td style="color: <?php echo $row['Status'] === 'Delivered' ? 'green' : 'red'; ?>">
                                <?php echo htmlspecialchars($row['Status']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No purchase history available.</p>
        <?php endif; ?>
        <?php
        $totalPurchaseAmount = 0;
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            $totalPurchaseAmount += $row['TotalAmount'];
        }
        ?>
        <div class="total-purchase-amount">
            <span>Total Purchase Amount: R<?php echo htmlspecialchars($totalPurchaseAmount); ?></span>
        </div>
    </section>
</body>

</html>
