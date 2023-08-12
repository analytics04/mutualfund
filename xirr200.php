<?php
// Define your input data
$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22'];
$nav_values = [341.41, 324.37, 346.85, 334.2, 331.37, 333.13, 312.29, 302.52, 323.77, 340.79, 348.06, 343.58, 352.21, 357.68, 350.66, 346.41, 334.3, 342.32, 356.42, 371.31, 390.48];
$current_nav = 387.91;

// Function to calculate the current_price
function calculateCurrentPrice($units) {
    global $current_nav;
    return $current_nav * array_sum($units);
}

// Function to calculate the present value of cashflows at a given rate and time difference
function presentValue($cashflows, $rate, $days) {
    $result = 0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $result += $cashflows[$i] / pow(1 + $rate, $days[$i] / 365);
    }
    return $result;
}

// Function to calculate the derivative of the present value function at a given rate and time difference
function derivativePresentValue($cashflows, $rate, $days) {
    $result = 0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $result += -$days[$i] * $cashflows[$i] / (365 * pow(1 + $rate, ($days[$i] + 365) / 365));
    }
    return $result;
}

// Function to calculate the XIRR using the Newton-Raphson method
function calculateXIRR($cashflows, $nav_values) {
    global $dates; // Import the $dates variable

    $cashflowsWithPrice = $cashflows;
    $cashflowsWithPrice[] = -calculateCurrentPrice($cashflows);

    $datesWithToday = array_merge($dates, [date('Y-m-d')]);
    $daysDiff = array_map(
        function ($date) {
            return (strtotime($date) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
        },
        $datesWithToday
    );

    $guess = 0.1;
    $tolerance = 1e-6;
    $rate = $guess;

    do {
        $rate_prev = $rate;
        $numerator = presentValue($cashflowsWithPrice, $rate_prev, $daysDiff);
        $denominator = derivativePresentValue($cashflowsWithPrice, $rate_prev, $daysDiff);
        $rate = $rate_prev - ($numerator / $denominator);
    } while (abs($rate - $rate_prev) > $tolerance);

    return $rate;
}

// Loop through each period and calculate the XIRR
for ($i = 1; $i <= count($cashflows); $i++) {
    $xirr = calculateXIRR(array_slice($cashflows, 0, $i), array_slice($nav_values, 0, $i));
    echo "XIRR for {$i} months: {$xirr}\n";
}
?>

