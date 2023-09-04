<?php
// Establish the database connection (replace with your connection details)
$connection = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Calculate start and end dates
$endDate = date("Y-m-d");  // Current date
$startDate = date("Y-m-d", strtotime("-6 months"));  // Six months ago

// Build and execute the SQL query
$query = "SELECT * FROM sales WHERE order_date >= '$startDate' AND order_date <= '$endDate'";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "Order Date: " . $row["order_date"] . " - Amount: " . $row["amount"] . "<br>";
    }
} else {
    echo "No results found.";
}

// Close the database connection
$connection->close();
?>
