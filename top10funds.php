SELECT fund_name, return_percentage
FROM funds
ORDER BY return_percentage DESC
LIMIT 10;

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

// Retrieving top 10 funds by return
$sql = "SELECT fund_name, return_percentage
        FROM funds
        ORDER BY return_percentage DESC
        LIMIT 10";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Fund Name</th><th>Return Percentage</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["fund_name"] . "</td><td>" . $row["return_percentage"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No funds found.";
}

$conn->close();
?>
