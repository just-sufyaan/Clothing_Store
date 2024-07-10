<?php
session_start();

// Include DB connection
include 'DBConn.php';

// Get input data from the form
$customer_id = $_POST['customer_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$status = $_POST['status'];

// Hash the password if provided
if (!empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
}

// Update the customer details in the database
$query = "UPDATE tblUser SET Username = ?, Email = ?, Password = ?, Status = ? WHERE UserID = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("ssssi", $username, $email, $password, $status, $customer_id);
$stmt->execute();

// Redirect back to admin dashboard
header("Location: admin_dashboard.php");
exit;
?>
