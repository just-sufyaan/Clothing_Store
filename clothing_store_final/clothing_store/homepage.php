<?php
session_start();
include 'DBConn.php';

// Fetch all clothing items from the tblclothes table
$queryClothes = "SELECT * FROM tblclothes";
$resultClothes = $connect->query($queryClothes);

// Fetch approved items from the tblsellerrequests table
$queryApprovedItems = "SELECT * FROM tblsellerrequests WHERE ApprovalStatus = 'Approved'";
$resultApprovedItems = $connect->query($queryApprovedItems);

$mergedResults = array();
while ($row = $resultClothes->fetch_assoc()) {
    $row['source'] = 'tblclothes'; // Mark this row as from tblclothes
    $mergedResults[] = $row;
}
while ($row = $resultApprovedItems->fetch_assoc()) {
    $row['source'] = 'tblsellerrequests'; // Mark this row as from tblsellerrequests
    $row['ClothingID'] = $row['RequestID']; // Use RequestID as ClothingID for seller requests
    $mergedResults[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $clothingID = $_POST['clothing_id'];
    $userID = $_SESSION['user_id'];

    $queryAddToWishlist = "INSERT INTO tblwishlist (UserID, ClothingID) VALUES ('$userID', '$clothingID')";
    if ($connect->query($queryAddToWishlist) === TRUE) {
        echo "Item added to wishlist!";
    } else {
        echo "Error: " . $queryAddToWishlist . "<br>" . $connect->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes - Buy and Sell Used Clothing</title>
    <link rel="stylesheet" href="CSS/homepage_styles.css">
    <script src="cart_page.js" defer></script>
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

    <section class="hero">
        <h1>Discover Your Next Favorite Wardrobe Piece</h1>
    </section>
    <section class="featured-listings">
        <h2>Featured Listings</h2>
        <div class="listings-container">
            <?php foreach ($mergedResults as $row) : ?>
                <div class="listing">
                    <img src="<?php echo $row['ImageURL']; ?>" alt="<?php echo $row['Title']; ?>" class="item-image">
                    <div class="inquiry-icon">
                        <p>Click to Inquire</p>
                    </div>
                    <h3><?php echo $row['Title']; ?></h3>
                    <p><?php echo $row['Description']; ?></p>
                    <p>Quantity: <?php echo $row['QuantityAvailable']; ?></p>
                    <span class="price">R<?php echo $row['Price']; ?></span>
                    <div class="buttons">
                        <button class="add-to-cart-button" data-clothing-id="<?php echo $row['ClothingID']; ?>">Add to Cart</button>
                        <form method="POST" class="wishlist-form">
                            <input type="hidden" name="clothing_id" value="<?php echo $row['ClothingID']; ?>">
                            <button type="submit" name="add_to_wishlist" class="wishlist-button">Add to Wishlist</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="request-to-sell">
        <div class="container">
            <h2>Want to Sell Your Clothes?</h2>
            <p>Click below to submit a request to sell your clothes on our platform.</p>
            <a href="sell_clothes.php" class="request-button">Request to Sell Clothes</a>
        </div>
    </section>

    <section class="testimonials">
        <h2>What Our Customers Say</h2>
        <div class="testimonial">
            <p>"I love shopping on Pastimes! They have the best selection of used clothing items."</p>
            <cite>- phenyo m.</cite>
        </div>
        <div class="testimonial">
            <p>"My shopping experience was easy and straightforward"</p>
            <cite>- Sufy c.</cite>
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

    <div id="availabilityPopup" class="popup">
        <span class="close">&times;</span>
        <form id="availabilityForm" method="post">
            <h3>Item Availability</h3>
            <p id="popupItemName"></p>
            <label for="userEmail">Your Email:</label>
            <input type="email" id="userEmail" name="userEmail" required>
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="3" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast" class="toast">Item added to cart!</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popup = document.getElementById("availabilityPopup");
            const span = document.getElementsByClassName("close")[0];
            const availabilityForm = document.getElementById("availabilityForm");

            document.querySelectorAll(".inquiry-icon").forEach(icon => {
                icon.addEventListener("click", function(event) {
                    event.stopPropagation();
                    const listing = icon.closest(".listing");
                    const itemName = listing.querySelector("h3").innerText;
                    document.getElementById("popupItemName").innerText = "Item: " + itemName;

                    const rect = icon.getBoundingClientRect();
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

                    popup.style.top = rect.top + scrollTop + "px";
                    popup.style.left = rect.left + scrollLeft + "px";
                    popup.style.display = "block";
                });
            });

            span.onclick = function() {
                popup.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == popup) {
                    popup.style.display = "none";
                }
            }

            availabilityForm.addEventListener("submit", function(event) {
                event.preventDefault();
                const userEmail = document.getElementById("userEmail").value;
                const message = document.getElementById("message").value;
                const itemName = document.getElementById("popupItemName").innerText.split(":")[1].trim(); // Extract item name

                // Send data using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "save_message.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert(xhr.responseText); // Display response from save_message.php
                        popup.style.display = "none";
                        availabilityForm.reset();
                    }
                };
                xhr.send(`userEmail=${userEmail}&message=${message}&itemName=${itemName}`);
            });
        });

        const toast = document.getElementById("toast");

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add("show");
            setTimeout(() => {
                toast.classList.remove("show");
            }, 3000);
        }

        // Add to Cart Button Functionality
        document.querySelectorAll(".add-to-cart-button").forEach(button => {
            button.addEventListener("click", function() {
                const clothingID = this.getAttribute("data-clothing-id");

                showToast("Item added to cart!");
            });
        });
    </script>
</body>

</html>