<?php
session_start();

$cart_items = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes - Buy and Sell Used Clothing</title>
    <link rel="stylesheet" href="CSS/cart_page.css">
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
            <?php if (isset($_SESSION['username'])) : ?>
                <span>User <?php echo htmlspecialchars($_SESSION['username']); ?> is logged in</span>
            <?php endif; ?>
        </div>
    </header>

    <section class="hero">
        <h1>Discover Your Next Favorite Wardrobe Piece</h1>
    </section>

    <section class="cart">
        <h2>Your Shopping Cart</h2>
        <div class="cart-items">
        </div>

        <div class="total">
            <span>Total: </span><span class="total-amount"></span>
        </div>

        <button class="checkout-button">Proceed to Checkout</button>
        <a href="homepage.php" class="continue-shopping checkout-button">Continue shopping</a>
    </section>

    <section class="testimonials">
        <h2>What Our Customers Say</h2>
        <div class="testimonial">
            <p>"I love shopping on Pastimes! They have the best selection of used clothing items."</p>
            <cite>- Phenyo M.</cite>
        </div>
        <div class="testimonial">
            <p>"I love shopping on Pastimes! They have the best selection of used clothing items."</p>
            <cite>- Sufy C.</cite>
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
        document.addEventListener("DOMContentLoaded", function() {
            var cartItems = JSON.parse(sessionStorage.getItem("cart")) || [];
            var cartItemsContainer = document.querySelector(".cart-items");

            if (cartItems.length > 0) {
                cartItems.forEach(item => {
                    var cartItemHTML = `
                        <div class="cart-item">
                            <img src="${item.image}" alt="${item.name}">
                            <div class="item-details">
                                <h3>${item.name}</h3>
                                <span>Price: ${item.price}</span>
                            </div>
                            <div class="item-quantity">
                                <button class="quantity-btn increment">+</button>
                                <span class="quantity">${item.quantity}</span>
                                <button class="quantity-btn decrement">-</button>
                            </div>
                            <button class="remove-item">Remove Item</button>
                        </div>`;
                    cartItemsContainer.innerHTML += cartItemHTML;
                });
            } else {
                cartItemsContainer.innerHTML = "<p>Your shopping cart is empty.</p>";
            }

            updateTotalPrice();

            document.querySelector(".checkout-button").addEventListener("click", function() {
                var cartItems = JSON.parse(sessionStorage.getItem("cart")) || [];
                fetch("store_cart.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            cart_items: cartItems
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "order_page.php";
                        } else {
                            alert("Failed to proceed to checkout.");
                        }
                    });
            });
        });

        function updateTotalPrice() {
            var total = 0;
            var cartItems = JSON.parse(sessionStorage.getItem("cart")) || [];
            cartItems.forEach(item => {
                var price = parseFloat(item.price.replace(/[^\d.]/g, ''));
                var quantity = parseInt(item.quantity);

                if (!isNaN(price) && !isNaN(quantity)) {
                    total += price * quantity;
                }
            });

            document.querySelector(".total-amount").textContent = "R" + total.toFixed(2);
        }
    </script>
</body>

</html>