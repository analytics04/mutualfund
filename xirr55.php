<?php

$cashflows = [-2000, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90, 1999.90];
$dates = ['2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-21', '2023-04-20', '2023-05-22', '2023-06-20', '2023-07-20', '2023-08-22', '2023-09-21', '2023-10-20', '2023-11-21', '2023-12-20', '2024-01-20', '2024-02-21', '2024-03-20', '2024-04-22', '2024-05-20', '2024-06-20', '2024-07-22'];

function xirr_func($rate, $cashflows, $dates) {
    $result = 0.0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
        $result += $cashflows[$i] / pow(1 + $rate, $time_diff);
    }
    return $result;
}

function calculate_xirr($cashflows, $dates) {
    $xirr = 0.1; // Initial guess for the rate
    $precision = 0.000001; // Desired precision
    $max_iterations = 1000; // Maximum number of iterations

    for ($i = 0; $i < $max_iterations; $i++) {
        $xirr_new = $xirr - xirr_func($xirr, $cashflows, $dates) / xirr_func_derivative($xirr, $cashflows, $dates);
        
        if (abs($xirr_new - $xirr) < $precision) {
            return $xirr_new;
        }

        $xirr = $xirr_new;
    }

    return null; // XIRR calculation did not converge
}

function xirr_func_derivative($rate, $cashflows, $dates) {
    $result = 0.0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $time_diff = (strtotime($dates[$i]) - strtotime($dates[0])) / (365 * 24 * 60 * 60);
        $result -= $time_diff * $cashflows[$i] / pow(1 + $rate, $time_diff + 1);
    }
    return $result;
}

$xirr = calculate_xirr($cashflows, $dates);
if ($xirr !== null) {
    echo "XIRR: " . $xirr . "\n";
} else {
    echo "XIRR calculation did not converge.\n";
}
?>