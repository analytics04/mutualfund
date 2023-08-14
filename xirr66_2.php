<?php

function xirr_func($rate, $cashflows, $dates, $nav_values, $units) {
    $result = 0.0;

    for ($i = 0; $i < count($cashflows); $i++) {
        $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);

        // Calculate the present value of the inflow
        $present_value = $nav_values[$i] * $units[$i] / pow(1 + $rate, $time_diff);

        // Subtract the present value of the outflow (cashflow)
        $result -= $cashflows[$i] + $present_value;
    }

    return $result;
}

function xirr_func_derivative($rate, $cashflows, $dates, $nav_values, $units) {
    $result = 0.0;

    for ($i = 0; $i < count($cashflows); $i++) {
        $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);

        // Calculate the present value of the inflow
        $present_value = $nav_values[$i] * $units[$i] / pow(1 + $rate, $time_diff);

        // Calculate the derivative component for the present value of the inflow
        $result -= $time_diff * $present_value / (1 + $rate + 0.000001); // Adding a small constant to prevent division by zero
    }

    return $result;
}

function calculate_xirr($cashflows, $dates, $nav_values, $units) {
    $xirr = 0.1; // Initial guess for the rate
    $precision = 0.000001; // Desired precision
    $max_iterations = 1000; // Maximum number of iterations

    for ($i = 0; $i < $max_iterations; $i++) {
        $xirr_new = $xirr - xirr_func($xirr, $cashflows, $dates, $nav_values, $units) / xirr_func_derivative($xirr, $cashflows, $dates, $nav_values, $units);

        if (abs($xirr_new - $xirr) < $precision) {
            return $xirr_new;
        }

        $xirr = $xirr_new;
    }

    return null; // XIRR calculation did not converge
}

$cashflows = [-2000, -1999.90, -1999.90];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20'];
$nav_values = [341.41, 324.37, 346.85];
$units = [5.858, 6.165, 5.766];

$xirr = calculate_xirr($cashflows, $dates, $nav_values, $units);

if ($xirr !== null) {
    echo "XIRR: " . ($xirr * 100) . "%\n";
} else {
    echo "XIRR calculation did not converge or result is undefined.\n";
}
?>
