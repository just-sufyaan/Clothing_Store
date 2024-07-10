<?php
// Include the database connection file
include 'DBConn.php';

// Read the SQL file
$sql_file = 'myClothingStore.sql';
$sql_contents = file_get_contents($sql_file);

$sql_queries = explode(';', $sql_contents);

// Iterate over each query
foreach ($sql_queries as $sql_query) {
    $sql_query = trim($sql_query);
    
    if (empty($sql_query)) {
        continue;
    }
    
    // Execute the query
    if (mysqli_query($connect, $sql_query)) {

    } else {
        echo "Error executing query: $sql_query - " . mysqli_error($connect) . "<br>";
    }
}

// Close the database connection
mysqli_close($connect);

// Display success message
echo "Database structure and tables created successfully!";
?>
