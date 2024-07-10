<?php
session_start();
include 'DBConn.php';

if (isset($_POST['userEmail'], $_POST['message'], $_POST['itemName'])) {
    $userEmail = $_POST['userEmail'];
    $message = $_POST['message'];
    $itemName = $_POST['itemName'];
    $userID = $_SESSION['user_id'];

    $stmt = $connect->prepare("INSERT INTO tblmessages (UserID, ItemName, UserEmail, MessageText) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $userID, $itemName, $userEmail, $message);
    if ($stmt->execute()) {
        echo "Message saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $connect->close();
} else {
    echo "Invalid input.";
}
?>
