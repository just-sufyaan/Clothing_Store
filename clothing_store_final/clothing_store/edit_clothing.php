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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_clothing_id'])) {
    // Get the clothing ID to edit
    $edit_clothing_id = $_POST['edit_clothing_id'];

    // Fetch the clothing item details from the database
    $query = "SELECT * FROM tblclothes WHERE ClothingID = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $edit_clothing_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the clothing item exists
    if ($result->num_rows === 1) {
        $clothing = $result->fetch_assoc();
    } else {
        // Redirect to admin dashboard with error message if clothing item does not exist
        header("Location: admin_dashboard.php?error=Clothing item not found.");
        exit;
    }

    // Close statement
    $stmt->close();
} else {
    // Redirect to admin dashboard if accessed without proper form submission
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Clothing Item</title>
    <link rel="stylesheet" href="CSS/edit_clothing_styles.css">
</head>

<body>
    <div class="container">
        <h2>Edit Clothing Item</h2>
        <?php if (isset($_GET['error'])) : ?>
            <p style="color: red;"><?php echo $_GET['error']; ?></p>
        <?php endif; ?>
        <form action="update_clothing.php" method="post">
            <input type="hidden" name="edit_clothing_id" value="<?php echo $edit_clothing_id; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $clothing['Title']; ?>" required><br>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="<?php echo $clothing['Description']; ?>"><br>
            <label for="size">Size:</label>
            <input type="text" id="size" name="size" value="<?php echo $clothing['Size']; ?>"><br>
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" value="<?php echo $clothing['Brand']; ?>"><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $clothing['Price']; ?>"><br>
            <label for="quantity">Quantity Available:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $clothing['QuantityAvailable']; ?>"><br>
            <label for="current_image">Current Image:</label><br>
            <img src="<?php echo $clothing['ImageURL']; ?>" alt="Current Image" style="max-width: 200px;"><br>
            <label for="image">New Image:</label>
            <input type="file" id="image" name="image" accept="Images/*"><br>
            <button type="submit">Update Clothing</button>
        </form>
        <a href="admin_clothing.php" class="back-link">Back</a>
    </div>
</body>

</html>

