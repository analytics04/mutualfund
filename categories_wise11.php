<?php
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieving funds by category
$sql = "SELECT c.category_name, f.fund_name, f.amount FROM categories c
        JOIN funds f ON c.category_id = f.category_id
        ORDER BY c.category_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Category: " . $row["category_name"] . " - Fund: " . $row["fund_name"] . " - Amount: " . $row["amount"] . "<br>";
    }
} else {
    echo "No funds found.";
}

$conn->close();
?>
