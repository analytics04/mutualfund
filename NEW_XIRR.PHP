<?PHP

$calculator = new FinancialCalculator();

// Define your custom cash flows and corresponding dates
$values = array(-1000, 200, 300, 400, 500, 600); // Cash flows
$dates = array(
    mktime(0, 0, 0, 1, 1, 2020), // Dates corresponding to cash flows
    mktime(0, 0, 0, 4, 15, 2020),
    mktime(0, 0, 0, 8, 30, 2020),
    mktime(0, 0, 0, 1, 15, 2021),
    mktime(0, 0, 0, 6, 1, 2022),
    mktime(0, 0, 0, 12, 31, 2022)
);

// Calculate XIRR using the defined cash flows and dates
$xirr = $calculator->XIRR($values, $dates, 0.1);

// Output the result
echo 'XIRR: ' . $xirr . "\n";

?>
