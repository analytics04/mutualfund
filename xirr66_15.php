<?php
// Given data
$dates = ["2021-11-22", "2021-12-20", "2022-01-20", "2023-08-04"];
$investments = [-2000, -1999.90, -1999.90, 6900.531];
$navs = [341.41, 324.37, 346.85];
$units = [5.858, 6.165, 5.766];
$current_nav = 387.91;
$sum_units = 17.789;

// Calculate cash flows for each investment
$cash_flows = [];
foreach ($investments as $index => $investment) {
    $cash_flows[$index] = $investment + $units[$index] * $navs[$index];
}
$cash_flows[] = -$current_nav * $sum_units;  // Add the withdrawal at the end

// Convert dates to days since the first date
$base_date = strtotime($dates[0]);
$days_since_base = [];
foreach ($dates as $date) {
    $days_since_base[] = (strtotime($date) - $base_date) / (60 * 60 * 24);
}
$days_since_base[] = (strtotime("2023-08-04") - $base_date) / (60 * 60 * 24);

// Define the XIRR function
function xirr($rate, $cash_flows, $days_since_base) {
    $result = 0;
    for ($i = 0; $i < count($cash_flows); $i++) {
        $result += $cash_flows[$i] / pow(1 + $rate, $days_since_base[$i] / 365);
    }
    return $result;
}

// Find the XIRR using the Newton-Raphson method
$initial_guess = 0.1;  // Initial guess for the discount rate
$xirr_result = $initial_guess;
$epsilon = 1e-6; // Tolerance for the Newton-Raphson method

do {
    $xirr_previous = $xirr_result;
    $f = xirr($xirr_result, $cash_flows, $days_since_base);
    $f_prime = (xirr($xirr_result + $epsilon, $cash_flows, $days_since_base) - $f) / $epsilon;
    $xirr_result = $xirr_result - $f / $f_prime;
} while (abs($xirr_result - $xirr_previous) > $epsilon);

echo "XIRR: " . $xirr_result . "\n";
?>
