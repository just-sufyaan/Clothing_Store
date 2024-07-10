<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request to Sell Clothes</title>
    <link rel="stylesheet" href="CSS/sell_clothes.css">
</head>

<body>
    <header>
        <h1>Pastimes Clothing Store</h1>
    </header>

    <main>
        <h1>Request to Sell Clothes</h1>
        <form action="process_sell_request.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" name="userID" value="<?php echo $_SESSION['user_id']; ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            </div>

            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" id="size" name="size" required>
            </div>

            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity Available:</label>
                <input type="text" id="quantity" name="quantity" required>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
            <button onclick="window.location.href='homepage.php';">Back to Homepage</button>
        </form>
    </main>
</body>

</html>