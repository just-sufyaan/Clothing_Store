<?php
session_start();
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <script src="formValidation.js"></script>
</head>

<body>
    <div class="container">
        <h2>Registration</h2>
        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)) : ?>
            <p class="success"><?php echo $success; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <form action="register_process.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required pattern="[a-zA-Z0-9]+" title="Username must contain only letters and numbers">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>
            <button type="submit" class="btn">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>

</html>