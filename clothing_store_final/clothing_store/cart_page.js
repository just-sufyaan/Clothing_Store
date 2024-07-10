document.addEventListener("DOMContentLoaded", function () {
  console.log("DOMContentLoaded event fired");

  function addItemToCart(item) {
    console.log("Adding item to cart:", item);
    var cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    var existingItemIndex = cart.findIndex(
      (cartItem) => cartItem.clothingID === item.clothingID
    );
    if (existingItemIndex !== -1) {
      cart[existingItemIndex].quantity += 1;
    } else {
      item.quantity = 1;
      cart.push(item);
    }
    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateCartDisplay(cart.length);
    updateTotalPrice();
  }

  function updateCartDisplay(cartItemCount) {
    console.log("Updating cart display. Cart item count:", cartItemCount);
    document.querySelector(".cart-count").textContent = cartItemCount;
  }

  function updateTotalPrice() {
    var total = 0;
    var cartItems = JSON.parse(sessionStorage.getItem("cart")) || [];

    cartItems.forEach(function (cartItem) {
      var priceString = cartItem.price;
      var price = parseFloat(priceString.replace("R", "").trim());
      var quantity = cartItem.quantity;

      if (!isNaN(price) && !isNaN(quantity)) {
        total += price * quantity;
      }
    });

    document.querySelector(".total-amount").textContent =
      "R" + total.toFixed(2);
  }

  function updateItemQuantity(itemName, newQuantity) {
    console.log("Updating item quantity:", itemName, newQuantity);
    var cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    var itemToUpdate = cart.find((cartItem) => cartItem.name === itemName);
    if (itemToUpdate) {
      itemToUpdate.quantity = newQuantity;
    }
    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateTotalPrice();
  }

  function removeItemFromCart(itemName) {
    console.log("Removing item from cart:", itemName);
    var cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    var updatedCart = cart.filter((cartItem) => cartItem.name !== itemName);
    sessionStorage.setItem("cart", JSON.stringify(updatedCart));
    updateCartDisplay(updatedCart.length);

    var cartItemsContainer = document.querySelector(".cart-items");
    var cartItemToRemove = cartItemsContainer.querySelector(
      `.cart-item[data-name="${itemName}"]`
    );
    if (cartItemToRemove) {
      cartItemToRemove.remove();
    }

    updateTotalPrice();
  }

  function initializeCart() {
    console.log("Initializing cart");
    var cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    updateCartDisplay(cart.length);
    updateTotalPrice();
  }

  var addToCartButtons = document.querySelectorAll(".add-to-cart-button");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      var item = {
        clothingID: button.getAttribute("data-clothing-id"),
        name: button.parentElement.parentElement.querySelector("h3")
          .textContent,
        description:
          button.parentElement.parentElement.querySelector("p").textContent,
        price:
          button.parentElement.parentElement.querySelector("span.price")
            .textContent,
        image: button.parentElement.parentElement.querySelector("img").src,
      };
      addItemToCart(item);
      showToast("Item added to cart!");
    });
  });

  var cartItemsContainer = document.querySelector(".cart-items");
  cartItemsContainer.addEventListener("click", function (event) {
    if (event.target.classList.contains("quantity-btn")) {
      var cartItem = event.target.closest(".cart-item");
      var itemName = cartItem.querySelector(".item-details h3").textContent;
      var quantityElement = cartItem.querySelector(".quantity");
      var currentQuantity = parseInt(quantityElement.textContent);

      if (event.target.classList.contains("increment")) {
        quantityElement.textContent = currentQuantity + 1;
      } else if (
        event.target.classList.contains("decrement") &&
        currentQuantity > 1
      ) {
        quantityElement.textContent = currentQuantity - 1;
      }
      updateItemQuantity(itemName, parseInt(quantityElement.textContent));
    }

    if (event.target.classList.contains("remove-item")) {
      var cartItem = event.target.closest(".cart-item");
      var itemName = cartItem.querySelector(".item-details h3").textContent;
      removeItemFromCart(itemName);
    }
  });

  function showToast(message) {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.classList.add("show");
    setTimeout(() => {
      toast.classList.remove("show");
    }, 3000);
  }

  initializeCart();
});
