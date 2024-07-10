<?php
session_start();
include 'DBConn.php';

function calculateTotalAmount($cartItems)
{
    $totalAmount = 0;
    foreach ($cartItems as $item) {
        $totalAmount += floatval($item['price']) * $item['quantity'];
    }
    return $totalAmount;
}

$cart_items = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
$totalAmount = calculateTotalAmount($cart_items);

$order_id = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);

$session_id = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
$_SESSION['custom_session_id'] = $session_id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link rel="stylesheet" href="CSS/order_page_styles.css">
    <script src="order_page.js" defer></script>
    <script>
        const orderId = "<?php echo htmlspecialchars($order_id); ?>";
        const sessionId = "<?php echo htmlspecialchars($session_id); ?>";
    </script>
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

    <section class="order-summary">
        <h2>Your Order Summary</h2>
        <div class="order-items">
            <?php if (!empty($cart_items)) : ?>
                <?php foreach ($cart_items as $item) : ?>
                    <div class="order-item">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <span class="item-price">Price: <?php echo htmlspecialchars($item['price']); ?></span>
                            <span class="item-quantity">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Your order is empty.</p>
            <?php endif; ?>
        </div>
        <div class="total">
            <span class="total-label">Total:</span>
            <span class="total-amount">R<?php echo htmlspecialchars($totalAmount); ?></span>
        </div>
        <button type="button" class="place-order-button">Place Order</button>
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

    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Checkout</h2>
            <form id="paymentForm">
                <div class="form-group">
                    <label>Order ID:</label>
                    <span id="orderId"></span>
                </div>

                <div class="form-group">
                    <label>Session ID:</label>
                    <span id="sessionId"></span>
                </div>

                <div class="form-group">
                    <label for="cardName">Name on Card:</label>
                    <input type="text" id="cardName" name="cardName" required>
                </div>

                <div class="form-group">
                    <label for="cardNumber">Card Number:</label>
                    <input type="text" id="cardNumber" name="cardNumber" required>
                </div>

                <div class="form-group">
                    <label for="expiryDate">Expiry Date:</label>
                    <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                </div>

                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required>
                </div>

                <button type="submit" class="btn-confirm">Confirm Payment</button>
            </form>
        </div>
    </div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("orderId").textContent = orderId;
        document.getElementById("sessionId").textContent = sessionId;

        var modal = document.getElementById("paymentModal");
        var btn = document.querySelector(".place-order-button");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.getElementById("paymentForm").addEventListener("submit", function(event) {
            event.preventDefault();

            var cardName = document.getElementById("cardName").value;
            var cardNumber = document.getElementById("cardNumber").value;
            var expiryDate = document.getElementById("expiryDate").value;
            var cvv = document.getElementById("cvv").value;

            var cartItems = JSON.parse(sessionStorage.getItem("cart")) || [];

            alert("Payment Successful!");

            fetch("place_order.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        cardName: cardName,
                        cardNumber: cardNumber,
                        expiryDate: expiryDate,
                        cvv: cvv,
                        cartItems: cartItems
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        sessionStorage.removeItem("cart");

                        window.location.href = "register.php";
                    } else {
                        alert("Failed to place order. Please try again.");
                    }
                });
        });
    });
</script>

</html>