<?php

// Include the database connection file
include 'DBConn.php';

try {
    // Drop the tblUser table if it exists
    $connect->query("DROP TABLE IF EXISTS tblUser");
    echo "Table 'tblUser' was dropped successfully." . "<br>";

    // Create tblUser table
    $createTableQuery = "
    CREATE TABLE tblUser (
        UserID INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(50) NOT NULL,
        Email VARCHAR(100) NOT NULL,
        Password VARCHAR(255) NOT NULL,
        RegistrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    if ($connect->query($createTableQuery) === TRUE) {
        echo "Table 'tblUser' was created successfully." . "<br>";

        // Open the userData.txt file
        $userDataFile = fopen('userData.txt', 'r');

        // Check if file opened successfully
        if ($userDataFile) {
            // Loop through each line in the file
            while (($line = fgets($userDataFile)) !== false) {
                // Split the line into an array using the comma separator
                $data = explode(', ', $line);
                // Assign values to variables
                $username = $data[0];
                $email = $data[1];
                $password = $data[2];

                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert data into tblUser
                $insertQuery = "INSERT INTO tblUser (Username, Email, Password) 
                VALUES ('$username', '$email', '$hashedPassword')";

                // Execute the query
                if ($connect->query($insertQuery) !== TRUE) {
                    echo "Error loading data: " . $connect->error;
                    exit;
                }
            }
            // Close the file
            fclose($userDataFile);

            echo "All data was loaded successfully into the table 'tblUser'. ";
        } else {
            echo "Error opening file";
            exit;
        }
    } else {
        echo "Error creating table: " . $connect->error;
        exit;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$connect->close();
?>
