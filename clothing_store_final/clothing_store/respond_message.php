<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

include 'DBConn.php';

if (isset($_POST['message_id'], $_POST['response'])) {
    $messageID = $_POST['message_id'];
    $response = $_POST['response'];

    $stmt = $connect->prepare("UPDATE tblMessages SET ResponseText = ?, Status = 'Responded' WHERE MessageID = ?");
    $stmt->bind_param("si", $response, $messageID);
    $stmt->execute();
    $stmt->close();
    $connect->close();

    header("Location: admin_messages.php");
} else {
    echo "Invalid input.";
}
?>
