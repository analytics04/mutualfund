<?php
function getTopFundsByReturn() {
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
    $funds = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $funds[] = $row;
        }
    }

    $conn->close();

    return $funds;
}

// Call the function to get top 10 funds
$topFunds = getTopFundsByReturn();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Top 10 Funds by Return</title>
</head>
<body>
    <h1>Top 10 Funds by Return</h1>
    <table>
        <tr>
            <th>Fund Name</th>
            <th>Return Percentage</th>
        </tr>
        <?php foreach ($topFunds as $fund) { ?>
            <tr>
                <td><?php echo $fund["fund_name"]; ?></td>
                <td><?php echo $fund["return_percentage"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
