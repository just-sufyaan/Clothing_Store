<?php
session_start();

// Include DB connection
include 'DBConn.php';

// Get input data from the form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$registration_date = $_POST['registration_date'];

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert the new customer into the database
$query = "INSERT INTO tblUser (Username, Email, Password, RegistrationDate, Status) VALUES (?, ?, ?, ?, 'pending')";
$stmt = $connect->prepare($query);
$stmt->bind_param("ssss", $username, $email, $hashedPassword, $registration_date);
$stmt->execute();

// Redirect back to admin dashboard
header("Location: admin_dashboard.php");
exit;
?>
