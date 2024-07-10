<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Include DB connection
include 'DBConn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_clothing_id'])) {
    // Get form data
    $edit_clothing_id = $_POST['edit_clothing_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Check if a new image file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
        // File upload handling
        $image = $_FILES['image']['name'];
        $target_dir = "Images/";
        $target_file = $target_dir . basename($image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate uploaded file
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Move uploaded file to the target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Update clothing item with new image URL
                $query = "UPDATE tblclothes SET Title=?, Description=?, Size=?, Brand=?, Price=?, QuantityAvailable=?, ImageURL=? WHERE ClothingID=?";
                $stmt = $connect->prepare($query);
                $stmt->bind_param("ssssdssi", $title, $description, $size, $brand, $price, $quantity, $target_file, $edit_clothing_id);
            } else {
                $error = "Error uploading image.";
            }
        }
    } else {
        // Update clothing item without changing image URL
        $query = "UPDATE tblclothes SET Title=?, Description=?, Size=?, Brand=?, Price=?, QuantityAvailable=? WHERE ClothingID=?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ssssdii", $title, $description, $size, $brand, $price, $quantity, $edit_clothing_id);
    }
    // Execute SQL statement
    if (!isset($error) && $stmt->execute()) {
        // Clothing item updated successfully
        $success = "Clothing item updated successfully.";
    } elseif (!isset($error)) {
        // Error updating clothing item
        $error = "Error updating clothing item: " . $stmt->error;
    }

    // Close statement and connection
    if (isset($stmt)) {
        $stmt->close();
    }
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
