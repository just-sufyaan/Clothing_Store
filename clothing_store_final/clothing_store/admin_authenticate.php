<?php
session_start();

// Include DB connection
include 'DBConn.php';

// Get admin credentials from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Retrieve admin details from the database based on the provided username
$query = "SELECT * FROM tblAdmin WHERE Username = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Admin found, verify password
    $admin = $result->fetch_assoc();
    $hashedPasswordFromDB = $admin['Password'];
    if (password_verify($password, $hashedPasswordFromDB)) {
        // Password is correct, set session variable and redirect to admin dashboard
        $_SESSION['admin'] = $admin['Username'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Password is incorrect, redirect back to admin login with error message
        header("Location: admin_login.php?error=Incorrect username or password");
        exit;
    }
} else {
    // Admin not found, redirect back to admin login with error message
    header("Location: admin_login.php?error=Admin not found");
    exit;
}
?>
