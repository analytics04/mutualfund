<?php

$cashflows = [-2000, 2272.38];
$dates = ['2021-11-22','2023-08-04'];

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
    echo "XIRR: " . ($xirr*100) . "\n";
} else {
    echo "XIRR calculation did not converge.\n";
}
?>