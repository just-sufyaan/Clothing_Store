<?php
session_start();
include 'DBConn.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: User is not logged in.";
    exit();
}

// Retrieve user ID from session
$userID = $_SESSION['user_id'];

// Query the database to retrieve messages for the user
$query = "SELECT * FROM tblMessages WHERE UserID = ?";
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
    <title>Your Messages</title>
    <link rel="stylesheet" href="CSS/messages_styles.css">
</head>
<body>
    <h1>Your Messages</h1>
    <a href="homepage.php" class="back-link">Back to Homepage</a>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Message</th>
                <th>Response</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['ItemName']; ?></td>
                    <td><?php echo $row['MessageText']; ?></td>
                    <td><?php echo $row['ResponseText']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
