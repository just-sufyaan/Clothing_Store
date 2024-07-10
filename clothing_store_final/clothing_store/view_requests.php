<?php
session_start();
include 'DBConn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['user_id'];

$query = "SELECT * FROM tblsellerrequests WHERE UserID = ?";
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
    <title>View Your Clothes Requests</title>
    <link rel="stylesheet" href="CSS/view_requests.css">
</head>

<body>
    <div class="container">
        <h2>Your Clothes Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Quantity Available</th>
                    <th>Image</th>
                    <th>Approval Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['RequestID']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['Size']; ?></td>
                        <td><?php echo $row['Brand']; ?></td>
                        <td><?php echo $row['Price']; ?></td>
                        <td><?php echo $row['QuantityAvailable']; ?></td>
                        <td><img src="<?php echo $row['ImageURL']; ?>" alt="Image" width="100"></td>
                        <td><?php echo $row['ApprovalStatus']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="homepage.php" class="back-link">Back to Homepage</a>
    </div>
</body>

</html>

<?php
$stmt->close();
$connect->close();
?>