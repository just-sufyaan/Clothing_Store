<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

include 'DBConn.php';

$query = "SELECT * FROM tblMessages WHERE Status = 'Pending'";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
    <link rel="stylesheet" href="CSS/messages_styles.css">
</head>
<body>
    <h2>Admin Messages</h2>
    <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>Message ID</th>
                <th>User Email</th>
                <th>Item Name</th>
                <th>Message</th>
                <th>Response</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['MessageID']; ?></td>
                    <td><?php echo $row['UserEmail']; ?></td>
                    <td><?php echo $row['ItemName']; ?></td>
                    <td><?php echo $row['MessageText']; ?></td>
                    <td>
                        <form action="respond_message.php" method="post">
                            <input type="hidden" name="message_id" value="<?php echo $row['MessageID']; ?>">
                            <textarea name="response" required></textarea>
                            <button type="submit">Send</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$connect->close();
?>
