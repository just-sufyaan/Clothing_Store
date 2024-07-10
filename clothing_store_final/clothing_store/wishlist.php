<?php
session_start();
include 'DBConn.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your wishlist.";
    exit();
}

$userID = $_SESSION['user_id'];

$queryWishlist = "SELECT tblclothes.* 
                  FROM tblwishlist 
                  JOIN tblclothes ON tblwishlist.ClothingID = tblclothes.ClothingID 
                  WHERE tblwishlist.UserID = '$userID'";
$resultWishlist = $connect->query($queryWishlist);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="CSS/wishlist_styles.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="Images/Pastimes Logo.png" alt="Pastimes Logo">
        </div>
        <nav>
            <ul>
                <li><a href="startup_page.php">Startup Page</a></li>
                <li><a href="homepage.php">Homepage</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="order_page.php">Order page</a></li>
                <li><a href="cart_page.php">View cart</a></li>
                <li class="dropdown">
                    <button class="dropbtn">More Options</button>
                    <div class="dropdown-content">
                        <a href="view_purchase_history.php">View Purchase History</a>
                        <a href="view_requests.php">View Clothes Requests</a>
                        <a href="messages.php">Messages</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="user-actions">
            <!-- Display username if logged in -->
            <?php if (isset($_SESSION['username'])) : ?>
                <span>User <?php echo $_SESSION['username']; ?> is logged in</span>
            <?php endif; ?>
        </div>
    </header>

    <section class="wishlist">
        <h2>Your Wishlist</h2>
        <div class="listings-container">
            <?php if ($resultWishlist->num_rows > 0) : ?>
                <?php while ($row = $resultWishlist->fetch_assoc()) : ?>
                    <div class="listing" id="item<?php echo $row['ClothingID']; ?>">
                        <img src="<?php echo $row['ImageURL']; ?>" alt="<?php echo $row['Title']; ?>" class="item-image">
                        <h3><?php echo $row['Title']; ?></h3>
                        <p><?php echo $row['Description']; ?></p>
                        <p>Quantity: <?php echo $row['QuantityAvailable']; ?></p>
                        <span class="price">R<?php echo $row['Price']; ?></span>
                        <button class="remove-btn" onclick="removeItem('item<?php echo $row['ClothingID']; ?>')">Remove Item</button>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No items in your wishlist.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <div class="contact-info card">
                <h3>Contact Us</h3>
                <p>Email: info@pastimes.com</p>
                <p>Phone: 123-456-7890</p>
            </div>
            <div class="footer-links card">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="social-media card">
                <h3>Connect With Us</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <script>
        function removeItem(itemId) {
            const item = document.getElementById(itemId);
            if (item) {
                item.remove();
            }
        }
    </script>
</body>

</html>