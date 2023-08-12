<?php

$cashflows = [-2000, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90, -1999.90];
$dates = ['2021-11-22', '2021-12-20', '2022-01-20', '2022-02-21', '2022-03-21', '2022-04-20', '2022-05-22', '2022-06-20', '2022-07-20', '2022-08-22', '2022-09-21', '2022-10-20', '2022-11-21', '2022-12-20', '2023-01-20', '2023-02-21', '2023-03-20', '2023-04-22', '2023-05-20', '2023-06-20', '2023-07-22'];
$nav_values = [341.41, 324.37, 346.85, 334.2, 331.37, 333.13, 312.29, 302.52, 323.77, 340.79, 348.06, 343.58, 352.21, 357.68, 350.66, 346.41, 334.3, 342.32, 356.42, 371.31, 390.48];
$current_nav = 387.91;

function calculate_xirr($cashflows, $initial_guess = 0.1) {
    $precision = 0.000001; // Desired precision
    $max_iterations = 1000; // Maximum number of iterations
    $xirr = $initial_guess;

    for ($i = 0; $i < $max_iterations; $i++) {
        $xirr_new = $xirr - xirr_func($xirr, $cashflows) / xirr_func_derivative($xirr, $cashflows);

        if (abs($xirr_new - $xirr) < $precision) {
            return $xirr_new;
        }

        $xirr = $xirr_new;
    }

    return null; // XIRR calculation did not converge
}

function xirr_func($rate, $cashflows) {
    $result = 0.0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $result += $cashflows[$i] / pow(1 + $rate, $i);
    }
    return $result;
}

function xirr_func_derivative($rate, $cashflows) {
    $result = 0.0;
    for ($i = 0; $i < count($cashflows); $i++) {
        $result -= $i * $cashflows[$i] / pow(1 + $rate, $i + 1);
    }
    return $result;
}

$monthly_xirrs = [];

$units_sum = 0;
for ($i = 0; $i < count($cashflows); $i++) {
    if ($nav_values[$i] != 0) {
        $units = $cashflows[$i] / $nav_values[$i];
        $units_sum += $units;

        $current_price = $current_nav * $units_sum;

        $xirr = calculate_xirr([$current_price], -$cashflows[$i]);

        if ($xirr !== null) {
            $monthly_xirrs[$dates[$i]] = $xirr;
        } else {
            $monthly_xirrs[$dates[$i]] = "XIRR calculation did not converge.";
        }
    } else {
        $monthly_xirrs[$dates[$i]] = "Missing NAV value.";
    }
}

foreach ($monthly_xirrs as $date => $xirr) {
    if (is_numeric($xirr)) {
        echo "Date: $date, XIRR: " . ($xirr * 100) . "%\n";
    } else {
        echo "Date: $date, $xirr\n";
    }
}
?>