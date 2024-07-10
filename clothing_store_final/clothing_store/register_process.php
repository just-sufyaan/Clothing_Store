<?php
include 'DBConn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username or email already exists in the database
    $checkQuery = "SELECT * FROM tblUser WHERE Username = ? OR Email = ?";
    $stmt = $connect->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username or email already exists, display error message
        $error = "Username or email already exists. Please choose a different one.";
    } else {
        // Username and email are unique, proceed with registration
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $insertQuery = "INSERT INTO tblUser (Username, Email, Password, Status) VALUES (?, ?, ?, ?)";
        $status = "pending";
        $stmt = $connect->prepare($insertQuery);
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $status);
        if ($stmt->execute()) {
            // Registration successful, display a success message
            session_start();
            $_SESSION['success'] = "Registration successful. Your account is pending verification.";
        } else {
            // Registration failed, display an error message
            $error = "Registration failed. Please try again.";
        }
    }
}

// Close the database connection
$connect->close();

// Redirect to registration page with error message
if (!empty($error)) {
    header("Location: register.php?error=" . urlencode($error));
    exit;
} else {
    header("Location: register.php");
    exit;
}
?>
