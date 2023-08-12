<?php

// Provided data
$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22'];
$nav_values = [341.41, 324.37, 346.85, 334.2, 331.37, 333.13, 312.29, 302.52, 323.77, 340.79, 348.06, 343.58, 352.21, 357.68, 350.66, 346.41, 334.3, 342.32, 356.42, 371.31, 390.48];
$current_nav = 387.91;

// Function to calculate XIRR using Newton-Raphson method
function calculateXIRR($cashflows, $dates, $nav_values, $guess = 0.1) {
    $x0 = $guess;
    $epsilon = 1e-6;
    $maxIterations = 100;

    for ($i = 0; $i < $maxIterations; $i++) {
        $f = 0.0;
        $fprime = 0.0;

        foreach ($cashflows as $j => $cashflow) {
            if (isset($nav_values[$j]) && $nav_values[$j] != 0) {
                $days = (strtotime($dates[$j]) - strtotime($dates[0])) / (60 * 60 * 24);
                $f += $cashflow / pow(1 + $x0, $days / 365.0);
                $fprime -= ($days / 365.0) * $cashflow / pow(1 + $x0, ($days / 365.0) + 1);
            }
        }

        $x1 = $x0 - $f / $fprime;

        if (abs($x1 - $x0) < $epsilon) {
            return $x1;
        }

        $x0 = $x1;
    }

    return null; // Return null if no convergence
}

// Calculate XIRR for different periods
$xirr_values = [];
for ($i = 0; $i < count($cashflows); $i++) {
    $cashflows_i = array_slice($cashflows, 0, $i + 1);
    $dates_i = array_slice($dates, 0, $i + 1);
    $xirr = calculateXIRR($cashflows_i, $dates_i, $nav_values);
    $xirr_values[] = $xirr;
}

// Print XIRR values for each period
foreach ($dates as $i => $date) {
    printf("XIRR for %s: %.6f\n", $date, $xirr_values[$i]);
}

?>



