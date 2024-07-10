<?php
session_start();

// Include DB connection
include 'DBConn.php';

// Get input data from the form
$customer_id = $_POST['customer_id'];

// Delete the customer from the database
$query = "DELETE FROM tblUser WHERE UserID = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();

// Redirect back to admin dashboard
header("Location: admin_dashboard.php");
exit;
?>
