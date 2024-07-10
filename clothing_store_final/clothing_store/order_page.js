document.addEventListener("DOMContentLoaded", function () {
  function calculateTotal() {
    var total = 0;
    var items = document.querySelectorAll(".order-item");

    items.forEach(function (item) {
      var priceText = item.querySelector(".item-price").textContent;
      var quantityText = item.querySelector(".item-quantity").textContent;

      var price = parseFloat(priceText.replace("Price: R", "").trim());
      var quantity = parseInt(quantityText.replace("Quantity: ", "").trim());

      if (!isNaN(price) && !isNaN(quantity)) {
        total += price * quantity;
      }
    });

    document.querySelector(".total-amount").textContent =
      "R" + total.toFixed(2);
  }

  calculateTotal();

  var modal = document.getElementById("paymentModal");

  var btn = document.querySelector(".place-order-button");

  var span = document.getElementsByClassName("close")[0];

  btn.onclick = function () {
    modal.style.display = "block";
  };

  span.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  document
    .getElementById("paymentForm")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      var cardName = document.getElementById("cardName").value;
      var cardNumber = document.getElementById("cardNumber").value;
      var expiryDate = document.getElementById("expiryDate").value;
      var cvv = document.getElementById("cvv").value;

      alert("Payment Successful!");

      fetch("place_order.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          cardName: cardName,
          cardNumber: cardNumber,
          expiryDate: expiryDate,
          cvv: cvv,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            window.location.href = "order_success.php";
          } else {
            alert("Failed to place order. Please try again.");
          }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
  function initializeCart() {
    var cartItems = JSON.parse(sessionStorage.getItem("cart")) || [];
    var cartItemsContainer = document.querySelector(".cart-items");

    if (cartItems.length > 0) {
      cartItems.forEach((item) => {});
    } else {
      cartItemsContainer.innerHTML = "<p>Your shopping cart is empty.</p>";
    }

    updateTotalPrice();
  }

  initializeCart();

  document
    .querySelector(".checkout-button")
    .addEventListener("click", function () {
      var cartItems = JSON.parse(sessionStorage.getItem("cart")) || [];

      fetch("store_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ cart_items: cartItems }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            sessionStorage.setItem("order_placed", true);
            window.location.href = "order_page.php";
          } else {
            alert("Failed to proceed to checkout.");
          }
        });
    });
});
