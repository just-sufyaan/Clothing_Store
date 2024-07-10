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

// Handle form submission for adding clothing
$success = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_clothing'])) {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // File upload handling
    $image = $_FILES['image']['name'];
    $target_dir = "Images/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate form data
    if (empty($title) || empty($description) || empty($size) || empty($brand) || empty($price) || empty($quantity)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($price) || !is_numeric($quantity)) {
        $error = "Price and quantity must be numeric values.";
    } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
    } else {
        // Check if the target directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Prepare SQL statement to prevent SQL injection
            $stmt = $connect->prepare("INSERT INTO tblclothes (Title, Description, Size, Brand, Price, QuantityAvailable, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssdis", $title, $description, $size, $brand, $price, $quantity, $target_file);

            // Execute query
            if ($stmt->execute()) {
                $success = "Clothing item added successfully.";
            } else {
                $error = "Error adding clothing item: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            $error = "Error uploading image.";
        }
    }
}

// Fetch all clothing items
$query = "SELECT * FROM tblclothes";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Clothing</title>
    <link rel="stylesheet" href="CSS/admin_dashboard_styles.css">
    <link rel="stylesheet" href="CSS/admin_styles.css">
    <script>
        function hideMessage() {
            var successMessage = document.getElementById("successMessage");
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = "none";
                }, 3000);
            }
        }
        window.onload = hideMessage;
    </script>
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>

        <!-- Display Existing Clothing Items -->
        <h3>All Clothing Items</h3>
        <?php if (isset($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success) : ?>
            <p id="successMessage" style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <table>
            <!-- Table for all clothing items -->
            <thead>
                <tr>
                    <th>ClothingID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Quantity Available</th>
                    <th>ImageURL</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['ClothingID']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['Size']; ?></td>
                        <td><?php echo $row['Brand']; ?></td>
                        <td><?php echo $row['Price']; ?></td>
                        <td><?php echo $row['QuantityAvailable']; ?></td>
                        <td><img src="<?php echo $row['ImageURL']; ?>" alt="<?php echo $row['Title']; ?>" style="width: 50px; height: 50px;"></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_logout.php" class="logout-btn">Logout</a>
    </div>

    <a href="admin_dashboard.php" class="dashboard-link">Back to Dashboard</a>

    <!-- Add Clothing Section -->
    <div class="form-container">
        <h3>Add Clothing</h3>
        <form action="admin_clothing.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="add_clothing" value="1">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description"><br>
            <label for="size">Size:</label>
            <input type="text" id="size" name="size"><br>
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand"><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price"><br>
            <label for="quantity">Quantity Available:</label>
            <input type="number" id="quantity" name="quantity"><br>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*"><br>
            <button type="submit">Add Clothing</button>
        </form>
    </div>

    <!-- Update Clothing Section -->
    <div id="editForm" style="display: none;">
        <h3>Edit Clothing</h3>
        <form action="update_clothing.php" method="post">
            <label for="clothing_id">Clothing ID:</label>
            <input type="number" id="clothing_id" name="clothing_id" required><br>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title"><br>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description"><br>
            <label for="size">Size:</label>
            <input type="text" id="size" name="size"><br>
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand"><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price"><br>
            <label for="quantity">Quantity Available:</label>
            <input type="number" id="quantity" name="quantity"><br>
            <button type="submit">Update Clothing</button>
        </form>
    </div>

    <!-- Edit Clothing Section -->
    <div class="form-container">
        <h3>Edit Clothing</h3>
        <form action="edit_clothing.php" method="post">
            <label for="edit_clothing_id">Enter the Clothing ID:</label>
            <input type="number" id="edit_clothing_id" name="edit_clothing_id" required><br>
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Delete Clothing Section -->
    <div class="form-container">
        <h3>Delete Clothing</h3>
        <form action="delete_clothing.php" method="post" onsubmit="return confirm('Are you sure you want to delete this item?');">
            <label for="delete_clothing_id">Enter the Clothing ID:</label>
            <input type="number" id="delete_clothing_id" name="delete_clothing_id" required><br>
            <button type="submit">Delete</button>
        </form>
    </div>

    <script>
        function confirmDelete() {
            var result = confirm("Are you sure you want to delete this item?");
            if (result) {
                // User clicked OK, submit the form
                document.querySelector("form").submit();
            } else {
                // User clicked Cancel, do nothing
            }
        }
    </script>

</body>

</html>
<?php $connect->close(); ?>