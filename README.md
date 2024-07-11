# Clothing Store|Pastimes

**Description**
Pastimes is an online web application that allows users to buy and sell used clothing items. It provides a platform for users to browse, add items to their cart, create a wishlist, and inquire about items' availability.

**Installation**

**Prerequisites:**
- PHP (version 7.4 or higher)
- MySQL (version 5.7 or higher)
- A web server (e.g., Wamp Server)
- A web browser (Microsoft Edge, Chrome)

**Steps:**
1. Download the project files from the provided source.
2. Unzip and extract the files to your web server's directory, which should be under the Wamp server.
3. Set up the database:
   - Open any SQL application (like phpMyAdmin).
   - Create a new database in MySQL named `clothingstore`.
   - Import the provided SQL file `myClothingStore.sql` (this file should be in the folder structure) to set up the necessary tables.
4. Update the database connection settings in `DBConn.php` to use your settings or use the connection already provided.
5. Run the Wamp server or your server of choice.
6. Open your preferred browser and navigate to `http://localhost/clothingstore/register.php` to see the registration page of the application.

**User Usage**

1. **Registering an Account:**
   - Open your web browser and navigate to `localhost/clothingstore/register.php`
   - Fill in the required fields, such as username, email, and password.
   - Click on the "Register" button to create a new account.

2. **Logging In:**
   - Navigate to `localhost/clothingstore/login.php` or click on the login button to go to the login page.
   - Enter your registered username, email, and password.
   - Click on the "Login" button to access your account and login to the application.

3. **Browsing Items:**
   - Once logged in, you will be redirected to the homepage or can manually type it in the browser as `localhost/clothingstore/homepage.php`
   - Browse through the list of available clothing items displayed and view all their details on the item.

4. **Adding Items to Cart:**
   - On the homepage, there will be an "Add to Cart" button.
   - Once clicked, a confirmation message will appear indicating the item has been added to your cart.

5. **Creating a Wishlist:**
   - While browsing items on the homepage, click the "Add to Wishlist" button for the items you want to save.
   - A confirmation message will appear indicating the item has been added to your wishlist.

6. **Inquiring about Items:**
   - On the homepage, click the inquiry icon or "Click to Inquire" link.
   - A popup form will appear.
   - Fill in your email address and a message, then click "Send".
   - A confirmation message will appear indicating your inquiry has been sent.

7. **Placing Orders:**
   - Navigate to your cart by clicking "View Cart" in the navigation menu.
   - Review the items in your cart and adjust quantities or remove items as needed.
   - Click the "Proceed to Checkout" button to proceed to the payment and order confirmation page.
   - Fill in your payment details and place your order.

8. **Viewing Purchase History:**
   - Navigate to "View Purchase History" in the "More Options" dropdown menu.
   - You will see a list of all your past orders, including order details and status.

9. **Viewing Sent Messages:**
   - Navigate to "Messages" in the "More Options" dropdown menu.
   - You will see a list of your messages sent to inquire about clothing items and whether they have been replied to or are still pending.

10. **Logout:**
    - Navigate to "Logout" in the "More Options" dropdown menu.
    - By clicking this, you will successfully log out of the application.

**Admin Usage**

1. **Logging In as an Admin:**
   - Admin users can log in using a separate login page accessed through the admin login button on the login page at `localhost/clothingstore/login.php`.
   - Enter your admin credentials to access the admin functionalities. The admin credentials used are `admin@gmail.com` for the username and `admin123` for the password.

2. **Managing Users:**
   - Once logged in, you will be directed to the admin dashboard for managing users (`http://localhost/clothingstore/admin_dashboard.php`).
   - You will be able to approve or reject users from accessing the website.
   - View the list of registered users.
   - Add, edit, or remove users as necessary.

3. **Managing Listings:**
   - View, approve, or reject clothing items submitted by sellers in the "Manage Listings" section.
   - Edit or remove existing listings.

4. **Viewing and Managing Orders:**
   - Access the "Manage Orders" section to view all customer orders.
   - Update order statuses (e.g., pending, delivered).

5. **Messaging Users:**
   - Use the messaging system to communicate directly with users.
   - Respond to user inquiries about the availability of certain clothing items.

6. **Logout:**
   - Navigate to the "Logout" button on the admin dashboard to log out of the application.

**Features**
- **User Authentication:** Secure user login and registration.
- **Product Browsing:** Browse available clothing items with images, descriptions, and prices.
- **Shopping Cart:** Add items to a cart and manage them.
- **Wishlist:** Save items to a wishlist for future reference.
- **Inquiries:** Inquire about item availability.
- **Sell Clothing:** Submit requests to sell clothing items on the platform.
- **Order Management:** View and manage past orders.
- **Messaging System:** Users can communicate with admins and vice versa.
- **Admin Dashboard:** Admin interface for managing users, listings, and orders.
