<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: homepage.php");
    exit;
}

// Initialize error and success messages
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$submittedUsername = isset($_POST['username']) ? $_POST['username'] : '';
$submittedEmail = isset($_POST['email']) ? $_POST['email'] : '';

// Include DB connection file
include 'DBConn.php';

// Process form submission
if (isset($_POST['submit'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to check if a user with the provided username exists
    $query = "SELECT UserID, Password, Status FROM tblUser WHERE Username = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, retrieve hashed password and status from database
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];
        $userStatus = $row['Status'];
        $userId = $row['UserID']; // Retrieve user ID

        // Check user status
        if ($userStatus === 'pending') {
            // User account is pending verification, display message
            $error = "Your account is pending verification. You cannot log in yet.";
        } elseif ($userStatus === 'approved') {
            // User account is approved, proceed with login
            // Verify password and set session if successful
            if (password_verify($password, $hashedPassword)) {
                // Passwords match, login successful
                session_start();
                $_SESSION['user_id'] = $userId; // Set user ID in session
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "Login successful.";
                header("Location: startup_page.php"); // Redirect to startup page
                exit;
            } else {
                // Passwords do not match, display error message
                $error = "Incorrect password. Please try again.";
            }
        }
    } else {
        // User does not exist, display error message
        $error = "User not found. Please register or try again.";
    }
}

// Close the database connection
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <script src="formValidation.js"></script>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)) : ?>
            <p class="success"><?php echo $success; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <form action="login.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required value="<?php echo htmlentities($submittedUsername); ?>" pattern="[a-zA-Z0-9]+" title="Username must contain only letters and numbers">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlentities($submittedEmail); ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>
            <button type="submit" class="btn" name="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>

        <!-- Admin login button -->
        <form action="admin_login.php" method="post">
            <button type="submit" class="btn admin-btn">Admin Login</button>
        </form>
    </div>
</body>

</html>