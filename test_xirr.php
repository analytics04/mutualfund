<?php

$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90,47761.81];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22','2023-08-04'];
$nav_values = [341.41, 324.37, 346.85, 334.2, 331.37, 333.13, 312.29, 302.52, 323.77, 340.79, 348.06, 343.58, 352.21, 357.68, 350.66, 346.41, 334.3, 342.32, 356.42, 371.31, 390.48];
$current_nav = 387.91;
$current_date = '2023-08-04';
$units = $casflows/$nav_values;
function cashflows_increment($cashflows,$units,$current_nav){

}
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