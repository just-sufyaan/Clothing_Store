<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect admin to login page if not logged in
    header("Location: admin_login.php");
    exit;
}

// Include DB connection
include 'DBConn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_clothing_id'])) {
    // Get the clothing ID to delete
    $delete_clothing_id = $_POST['delete_clothing_id'];

    // Prepare and execute SQL statement to delete the clothing item
    $query = "DELETE FROM tblclothes WHERE ClothingID = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $delete_clothing_id);
    
    if ($stmt->execute()) {
        // Clothing item deleted successfully
        $success = "Clothing item deleted successfully.";
    } else {
        // Error deleting clothing item
        $error = "Error deleting clothing item: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $connect->close();

    // Redirect back to admin dashboard with success/error message
    if (isset($success)) {
        header("Location: admin_clothing.php?success=" . urlencode($success));
    } else {
        header("Location: admin_clothing.php?error=" . urlencode($error));
    }
} else {
    // Redirect to admin dashboard if accessed without proper form submission
    header("Location: admin_clothing.php");
    exit;
}
?>
