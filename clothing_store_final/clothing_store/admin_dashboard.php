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

// Retrieve pending registrations
$query = "SELECT * FROM tblUser WHERE Status = 'pending'";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/admin_dashboard_styles.css">
    <link rel="stylesheet" href="CSS/admin_styles.css">
    <style>
        .dashboard-link {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .dashboard-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
        <h3>Pending Registrations</h3>
        <table>
            <!-- Table for pending registrations -->
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['UserID']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td>
                            <form action="verify_registration.php" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $row['UserID']; ?>">
                                <button type="submit" name="approve">Approve</button>
                                <button type="submit" name="reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="dashboard-item">
            <h3>View Seller Requests</h3>
            <p>Click here to view seller requests.</p>
            <a href="view_seller_requests.php" class="dashboard-link">View Seller Requests</a>
        </div>

        <div class="dashboard-item">
            <h3>Manage Clothing</h3>
            <p>Click here to manage clothing items.</p>
            <a href="admin_clothing.php" class="dashboard-link">Manage Clothing</a>
        </div>

        <div class="dashboard-item">
            <h3>Messages</h3>
            <p>Click here to check all messages.</p>
            <a href="admin_messages.php" class="dashboard-link">Manage Messages</a>
        </div>

        <div class="dashboard-item">
            <h3>User Order Status</h3>
            <p>Click here to see the status of all the users orders.</p>
            <a href="admin_orders.php" class="dashboard-link">Manage Orders</a>
        </div>

        <h3>All Users</h3>
        <table>
            <!-- Table for all users -->
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all users
                $query = "SELECT * FROM tblUser";
                $result = $connect->query($query);
                while ($row = $result->fetch_assoc()) :
                ?>
                    <tr>
                        <td><?php echo $row['UserID']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Add Customer Section -->
    <div class="form-container">
        <h3>Add Customer</h3>
        <form action="add_customer.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="hidden" id="registration_date" name="registration_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <button type="submit">Add Customer</button>
        </form>
    </div>

    <!-- Update Customer Section -->
    <div class="form-container">
        <h3>Update Customer</h3>
        <form action="update_customer.php" method="post">
            <label for="customer_id">Customer ID:</label>
            <input type="number" id="customer_id" name="customer_id" required><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br>
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
            </select><br>
            <button type="submit">Update Customer</button>
        </form>
    </div>

    <!-- Delete Customer Section -->
    <h3>Delete Customer</h3>
    <form action="delete_customer.php" method="post" id="deleteForm">
        <label for="customer_id">Customer ID:</label>
        <input type="number" id="customer_id" name="customer_id" required><br>
        <button type="button" onclick="confirmDelete()">Delete Customer</button>
    </form>
    </div>
    <script>
        function confirmDelete() {
            var confirmation = confirm("Are you sure you want to delete this user?");
            if (confirmation) {
                document.getElementById("deleteForm").submit();
            } else {}
        }
    </script>
</body>

</html>
<?php $connect->close(); ?>