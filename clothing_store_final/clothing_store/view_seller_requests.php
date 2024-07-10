<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Include DB connection
include 'DBConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['item_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $updateQuery = "UPDATE tblsellerrequests SET ApprovalStatus = 'Approved' WHERE RequestID = ?";
    } elseif ($action === 'reject') {
        $updateQuery = "UPDATE tblsellerrequests SET ApprovalStatus = 'Rejected' WHERE RequestID = ?";
    }

    $stmtUpdate = $connect->prepare($updateQuery);
    if (!$stmtUpdate) {
        die("Preparation failed: " . $connect->error);
    }
    $stmtUpdate->bind_param('i', $itemId);
    $stmtUpdate->execute();

    header("Location: view_seller_requests.php");
    exit();
}

$query = "SELECT RequestID, Title, Description, Size, Brand, Price, QuantityAvailable, ImageURL, ApprovalStatus FROM tblsellerrequests";
$result = $connect->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Seller Requests</title>
    <link rel="stylesheet" href="CSS/admin_styles.css">
    <link rel="stylesheet" href="CSS/admin_dashboard_styles.css">
</head>

<body>
    <div class="container">
        <h2>All Seller Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Quantity Available</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['Size']; ?></td>
                        <td><?php echo $row['Brand']; ?></td>
                        <td><?php echo $row['Price']; ?></td>
                        <td><?php echo $row['QuantityAvailable']; ?></td>
                        <td><img src="<?php echo $row['ImageURL']; ?>" alt="Clothing Image" style="width: 100px; height: auto;"></td>
                        <td><?php echo $row['ApprovalStatus']; ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="item_id" value="<?php echo $row['RequestID']; ?>">
                                <button type="submit" name="action" value="approve">Approve</button>
                                <button type="submit" name="action" value="reject">Reject</button>
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
