<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Include DB connection
include 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        // Approve the registration
        $user_id = $_POST['user_id'];
        $approve_query = "UPDATE tblUser SET Status = 'approved' WHERE UserID = ?";
        $stmt = $connect->prepare($approve_query);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "User registration approved.";
        } else {
            $_SESSION['error'] = "Error approving user registration.";
        }
    } elseif (isset($_POST['reject'])) {
        $user_id = $_POST['user_id'];
        $reject_query = "DELETE FROM tblUser WHERE UserID = ?";
        $stmt = $connect->prepare($reject_query);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "User registration rejected.";
        } else {
            $_SESSION['error'] = "Error rejecting user registration.";
        }
    }
}

header("Location: admin_dashboard.php");
exit;

?>
