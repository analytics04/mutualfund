<?php
// Establish the database connection (replace with your connection details)
$connection = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Assuming you have received the input date in the format 'YYYY-MM-DD'
$inputDate = $_POST['input_date']; // Change to appropriate input method

// Calculate the end date (six months from the input date)
$endDate = date("Y-m-d", strtotime("+6 months", strtotime($inputDate)));

// Build and execute the SQL query
$query = "SELECT * FROM nav_2004 WHERE nav_date >= '$inputDate' AND nav_date <= '$endDate'";
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
